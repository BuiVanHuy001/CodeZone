<?php

namespace App\Livewire\Client\Cart;

use App\Models\Order;
use App\Services\Cart\CartService;
use App\Services\Course\Catalog\CourseDecorator;
use App\Services\Course\CourseService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Livewire\Component;

class Index extends Component
{
    private CartService $cartService;
    private CourseDecorator $courseDecorator;
    public ?Order $order;
    public string $totalPrice = '0';
    public string $paymentMethod = 'momo';
    public array|Collection $items = [];

    public function __construct()
    {
        $this->cartService = app(CartService::class);
        $this->courseDecorator = app(CourseDecorator::class);
    }

    public function mount(): void
    {
        $this->order = $this->cartService->getCart(auth()->user());
        if ($this->order) {
            $this->totalPrice = $this->cartService->formatPrice($this->order->total_price);
            $this->items = $this->order->items->map(fn($item) => $this->courseDecorator->decorateForCartItem($item->course));
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
