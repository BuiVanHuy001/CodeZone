<?php

namespace App\Livewire\Client\Cart;

use App\Models\Order;
use App\Services\Cart\CartService;
use App\Services\Course\Catalog\CourseDecorator;
use App\Services\Course\CourseService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class Index extends Component
{
    private CartService $cartService;
    private CourseDecorator $courseDecorator;
    public ?Order $order;
    public string $totalPrice = '0';
    public string $paymentMethod = 'momo';
    public array|Collection $items = [];

    public function boot(): void
    {
        $this->cartService = app(CartService::class);
        $this->courseDecorator = app(CourseDecorator::class);
    }

    public function mount(): Redirector|null
    {
        $this->order = $this->cartService->getCart(auth()->user());
        if ($this->order) {
            $this->totalPrice = $this->cartService->formatPrice($this->order->total_price);
            $this->items = $this->order->items->map(fn($item) => $this->courseDecorator->decorateForCartItem($item->course));

            return null;
        }

        return redirect()->route('page.home')->with('swal', [
            'icon' => 'info',
            'title' => 'Your cart is empty!',
            'text' => 'Please add some courses to your cart before proceeding to checkout.',
        ]);
    }

    public function checkOut(): Redirector|null
    {
        if (!$this->order) {
            return redirect()->route('page.home')->with('swal', [
                'icon' => 'info',
                'title' => 'Your cart is empty!',
                'text' => 'Please add some courses to your cart before proceeding to checkout.',
            ]);
        }
        $this->cartService->checkout($this->order, $this->paymentMethod);
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.cart.index')->layout('components.layouts.index');
    }
}
