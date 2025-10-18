<?php

namespace App\Livewire\Client\Shared;

use App\Models\Order;
use App\Services\Cart\CartService;
use App\Services\Course\Catalog\CourseDecorator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class Cart extends Component
{
    private CourseDecorator $courseDecorator;
    public Order|null $cart = null;
    public Collection $items;
    public string $totalPrice = '0₫';
    private CartService $cartService;
    public bool $isOpen = false;

    public function boot(): void
    {
        $this->cartService = app(CartService::class);
        $this->courseDecorator = app(CourseDecorator::class);
    }

    public function mount(): void
    {
        if (auth()->check() && auth()->user()->isStudent()) {
            $this->cart = $this->cartService->getCart(auth()->user());
            $this->totalPrice = $this->cartService->formatPrice($this->cart->total_price ?? 0);
            $this->items = $this->cart->items
                ->map(fn($item) => collect($this->courseDecorator->decorateForCartItem($item->course)));
        }
    }

    #[On('add-to-cart')]
    public function addToCart(string $courseId): void
    {
        if (auth()->check()) {
            if (auth()->user()->isStudent()) {
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
            } else {
                $this->swalError('Only students can add courses to cart');
            }
        } else {
            redirect(route('client.login'))->with('error', 'You need to log in to add courses to cart');
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

    public function viewCart(): Redirector
    {
        return redirect(route('cart.index'));
    }

    private function refreshCart(Order $order): void
    {
        $this->cart = $order;
        $this->totalPrice = $this->cartService->formatPrice($this->cart->total_price ?? 0);
        $this->items = $this->cart->items
            ->map(fn($item) => collect($this->courseDecorator->decorateForCartItem($item->course)));
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
