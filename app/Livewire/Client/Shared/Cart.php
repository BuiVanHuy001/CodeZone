<?php

namespace App\Livewire\Client\Shared;

use App\Models\Course;
use App\Models\Order;
use App\Services\Cart\CartService;
use App\Traits\WithSwal;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class Cart extends Component
{
    public Order|null $cart = null;
    public Collection $items;
    public string $totalPrice = '0₫';
    private CartService $cartService;
    public bool $isOpen = false;

    public function boot(): void
    {
        $this->cartService = app(CartService::class);
    }

    public function mount(): void
    {
        if (auth()->check()) {
            $this->cart = $this->cartService->getCart(auth()->user());
            $this->totalPrice = $this->cartService->formatPrice($this->cart->total_price ?? 0);
            $this->items = collect($this->cart?->items);
        }
    }

    #[On('add-to-cart')]
    public function addToCart(string $courseId): void
    {
        $result = $this->cartService->addItem($this->cart, $courseId);

        switch ($result['status']) {
            case 'added_to_cart':
                $this->refreshCart($result['order']);
                $this->swal(title: 'Course added to cart');
                break;
            case 'already_in_cart':
                $this->swal(title: 'Course already in cart', icon: 'warning');
                break;
            case 'item_not_found':
                $this->swal(title: 'Course not found', icon: 'warning');
                break;
            default:
                $this->swal(title: 'Something went wrong', text: 'Please try again', icon: 'error');
                break;
        }
    }

    public function removeFromCart(string $courseId): void
    {
        $result = $this->cartService->removeItem($this->cart, $courseId);

        match ($result['status']) {
            'item_removed' => $this->handleItemRemoved($result['order']),

            'cart_empty' => $this->handleCartEmpty(),

            'item_not_found' => $this->swal(title: 'Item not found in cart', icon: 'warning'),

            'unauthorized' => $this->swal(title: 'You are not authorized to perform this action', icon: 'error'),

            default => $this->swal(title: 'Something went wrong', text: 'Please try again', icon: 'error')
        };
    }

    public function checkOut(): Redirector
    {
        return redirect(route('cart.index'));
    }

    private function refreshCart(Order $order): void
    {
        $this->cart = $order;
        $this->totalPrice = $this->cartService->formatPrice($this->cart->total_price ?? 0);
        $this->items = collect($this->cart?->items);
    }

    private function handleItemRemoved(Order $order): void
    {
        $this->refreshCart($order);
        $this->swal(title: 'Course removed from cart');
    }

    private function handleCartEmpty(): void
    {
        $this->cart = null;
        $this->items = collect();
        $this->reset('totalPrice');
        $this->swal(title: 'Course removed from cart');
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.shared.cart');
    }
}
