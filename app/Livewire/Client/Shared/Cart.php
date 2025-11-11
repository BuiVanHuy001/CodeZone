<?php

namespace App\Livewire\Client\Shared;

use App\Models\Order;
use App\Services\Cart\CartService;
use App\Services\Course\Catalog\CourseDecorator;
use App\Traits\WithSwal;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class Cart extends Component
{
    use WithSwal;

    private CourseDecorator $courseDecorator;
    private CartService $cartService;
    public ?Order $cart = null;
    public Collection $items;
    public string $totalPrice = '0₫';
    public bool $isOpen = false;

    public function boot(): void
    {
        $this->cartService = app(CartService::class);
        $this->courseDecorator = app(CourseDecorator::class);
    }

    public function mount(): void
    {
        $this->items = collect();

        if (auth()->check() && auth()->user()->hasRole('student')) {
            $this->cart = $this->cartService->getCart(auth()->user());
            $this->totalPrice = $this->cartService->formatPrice($this->cart?->total_price ?? 0);
            $this->items = $this->decorateItems($this->cart);
        }
    }

    #[On('add-to-cart')]
    public function addToCart(string $courseId): ?RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('client.login')->with('error', 'You need to log in to add courses to cart');
        }

        if (!auth()->user()->hasRole('student')) {
            $this->swalError('Only students can add courses to cart');
            return null;
        }

        $result = $this->cartService->addItem($this->cart, $courseId);

        match ($result['status']) {
            'added_to_cart' => $this->handleAddedToCart($result['order'] ?? null),
            'already_in_cart' => $this->swalWarning('Course already in cart'),
            'item_not_found' => $this->swalWarning('Course not found'),
            default => $this->swalError('Something went wrong', 'Please try again'),
        };

        return null;
    }

    public function removeFromCart(string $itemId): void
    {
        $result = $this->cartService->removeItem($this->cart, $itemId);

        match ($result['status']) {
            'item_removed' => $this->handleItemRemoved($result['order']),
            'cart_empty' => $this->handleCartEmpty(),
            'item_not_found' => $this->swalWarning('Item not found in cart'),
            'unauthorized' => $this->swalError('You are not authorized'),
            default => $this->swalError('Something went wrong', 'Please try again'),
        };
    }

    public function viewCart(): Redirector
    {
        return redirect()->route('cart.index');
    }

    private function handleAddedToCart(?Order $order): void
    {
        $this->refreshCart($order);
        $this->swal('Course added to cart');
    }

    private function refreshCart(?Order $order): void
    {
        $this->cart = $order;
        $this->totalPrice = $this->cartService->formatPrice($this->cart?->total_price ?? 0);
        $this->items = $this->decorateItems($this->cart);
    }

    private function handleItemRemoved(Order $order): void
    {
        $this->refreshCart($order);
        $this->swal('Course removed from cart');
    }

    private function handleCartEmpty(): void
    {
        $this->cart = null;
        $this->items = collect();
        $this->totalPrice = '0₫';
        $this->swal('Course removed from cart');
    }

    private function decorateItems(?Order $order): Collection
    {
        if (!$order) {
            return collect();
        }

        $order->loadMissing('items.course.author');

        return $order->items->map(function ($item) {
            $course = $this->courseDecorator->decorateForCartItem($item->course);

            return [
                'id' => $item->id,
                'title' => $course['title'] ?? '',
                'thumbnail' => $course['thumbnail'] ?? '',
                'detailsPageUrl' => $course['detailsPageUrl'] ?? '#',
                'priceFormatted' => $course['priceFormatted'] ?? '0₫',
                'authorName' => $course['authorName'] ?? ($item->course->author->name ?? ''),
            ];
        });
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.shared.cart');
    }
}
