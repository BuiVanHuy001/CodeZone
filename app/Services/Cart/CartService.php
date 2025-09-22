<?php

namespace App\Services\Cart;

use App\Models\Course;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Livewire\Features\SupportRedirects\Redirector;

class CartService
{
    public function getCart(User $user): Collection|Order|null
    {
        return $user->orders()->where('status', 'cart')->latest()->first();
    }

    public function addItem(?Order $order, int|string $itemId): array
    {
        $course = Course::findOrFail($itemId);
        if (is_null($course)) {
            return $this->makeResult($order, 'item_not_found');
        }

        if (is_null($order)) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'status' => 'cart',
                'total_price' => 0,
            ]);
        } elseif ($order->items->contains('course_id', $itemId)) {
            return $this->makeResult($order, 'already_in_cart');
        }

        $order->items()->create([
            'course_id' => $course->id,
            'current_price' => $course->price,
        ]);

        $order->increment('total_price', $course->price);
        return $this->makeResult($order, 'added_to_cart');
    }

    public function removeItem(Order $order, string|int $itemId): array
    {
        if ($order->user_id !== auth()->id()) {
            return $this->makeResult($order, 'unauthorized');
        }

        $item = $order->items()->where('id', $itemId)->first();
        if (!$item) {
            return $this->makeResult($order, 'item_not_found');
        }

        $order->decrement('total_price', $item->current_price);
        $item->delete();

        if ($order->items()->count() === 0) {
            $order->delete();
            return $this->makeResult(null, 'cart_empty');
        }

        return $this->makeResult($order, 'item_removed');
    }

    private function makeResult(?Order $order, string $status): array
    {
        return [
            'order' => $order?->loadMissing('items'),
            'status' => $status,
        ];
    }

    public function checkout(Order $order, string $method = 'vnpay'): RedirectResponse|Redirector
    {
        if ($order->total_price === 0) {
            return $this->processFreeOrder($order);
        }

        return redirect()->route('payment', [
            'order' => $order,
            'method' => $method,
        ]);
    }

    private function processFreeOrder(Order $order): RedirectResponse|Redirector
    {
        $order->update(['status' => 'completed']);

        return redirect()->route('page.home')->with('swal', [
            'icon' => 'success',
            'title' => 'Order completed successfully',
            'text' => sprintf(
                'You have enrolled in %d %s successfully.',
                $order->items->count(),
                Str::plural('course', $order->items->count())
            ),
        ]);
    }
}
