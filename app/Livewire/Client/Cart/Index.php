<?php

namespace App\Livewire\Client\Cart;

use App\Models\Order;
use App\Services\Cart\CartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Livewire\Component;

class Index extends Component
{
    private CartService $cartService;
    public ?Order $order;
    public string $totalPrice = '0';
    public string $paymentMethod = 'momo';
    public array|Collection $items = [];

    public function __construct()
    {
        $this->cartService = app(CartService::class);
    }

    public function mount(): void
    {
        $this->order = $this->cartService->getCart(auth()->user());
        if ($this->order) {
            $this->totalPrice = $this->cartService->formatPrice($this->order->total_price);
            $this->items = $this->order->items->map(fn($item) => [
                'id' => $item->course->id,
                'title' => $item->course->title,
                'slug' => $item->course->slug,
                'price' => $item->course->getFormattedPrice(),
                'thumbnail' => $item->course->getThumbnailPath(),
            ])->toArray();
        }
    }

    public function checkOut(): void
    {
        $this->cartService->checkout($this->order, $this->paymentMethod);
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.cart.index')->layout('components.layouts.index');
    }
}
