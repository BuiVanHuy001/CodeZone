<?php

namespace App\Livewire\Client\Cart;

use App\Models\Order;
use App\Services\Cart\CartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Index extends Component
{
    private CartService $cartService;
    public Order $order;
    public string $totalPrice = '0';
    public string $paymentMethod = 'momo';

    public function mount()
    {
        $this->cartService = app(CartService::class);
        $this->order = $this->cartService->getCart(auth()->user());
        $this->totalPrice = $this->cartService->formatPrice($this->order->total_price);
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.cart.index')->layout('components.layouts.index');
    }
}
