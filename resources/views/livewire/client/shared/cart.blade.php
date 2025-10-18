<li class="access-icon rbt-mini-cart">
    <a class="rbt-round-btn" wire:click="$set('isOpen', true)" href="javascript:void(0)">
        <i class="feather-shopping-cart"></i>
        @if(count($items) > 0)
            <span class="rbt-cart-count">{{ count($items) }}</span>
        @endif
    </a>
    <div @class(['rbt-cart-side-menu', 'side-menu-active' => $isOpen])>
        <div class="inner-wrapper" style="background-color: #e8e8e8">
            <div class="inner-top">
                <div class="content">
                    <div class="title">
                        <h4 class="title mb--0">Shopping cart</h4>
                    </div>
                    <div class="rbt-btn-close" id="btn_sideNavClose">
                        <button class="minicart-close-button rbt-round-btn" wire:click="$set('isOpen', false)">
                            <i class="feather-x"></i></button>
                    </div>
                </div>
            </div>
            <nav class="side-nav w-100">
                <ul class="rbt-minicart-wrapper">
                    @forelse($items as $item)
                        <li class="minicart-item">
                            <div class="thumbnail">
                                <a href="{{ $item['detailsPageUrl'] }}">
                                    <img src="{{ $item['thumbnail'] }}" alt="Course thumbnail">
                                </a>
                            </div>
                            <div class="product-content">
                                <h6 class="title">
                                    <a href="{{ $item['detailsPageUrl'] }}">{{ $item['title'] }}</a>
                                </h6>
                                <p class="title">{{ $item['authorInfo']['name'] }}</p>
                                <span class="quantity">
                                    <span class="price">{{ $item['priceFormatted'] }}</span>
                                </span>
                            </div>
                            <div class="close-btn">
                                <button wire:click.prevent="removeFromCart('{{ $item['id'] }}')" class="rbt-round-btn">
                                    <i class="feather-x"></i></button>
                            </div>
                        </li>
                    @empty
                        <div class="loader"></div>
                        <h3 class="text-center mt-3">Your cart is empty.</h3>
                    @endforelse
                </ul>
            </nav>
            @if(count($items) > 0)
                <div class="rbt-minicart-footer">
                    <hr class="mb--0">
                    <div class="rbt-cart-subttotal">
                        <p class="subtotal"><strong>Subtotal:</strong></p>
                        <p class="price">{{ $totalPrice }}</p>
                    </div>
                    <hr class="mb--0">

                    <div class="rbt-minicart-bottom mt--20">
                        <div class="checkout-btn">
                            <button wire:click="viewCart" class="rbt-btn btn-gradient icon-hover w-100 text-center">
                                <span class="btn-text">Go to cart</span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</li>

@assets
<style>
    .loader {
        width: 160px;
        height: 185px;
        position: relative;
        background: #fff;
        border-radius: 100px 100px 0 0;
        margin: 0 auto;
    }

    .loader:after {
        content: "";
        position: absolute;
        width: 100px;
        height: 125px;
        left: 50%;
        top: 25px;
        transform: translateX(-50%);
        background-image: radial-gradient(circle, #000 48%, transparent 55%),
        radial-gradient(circle, #000 48%, transparent 55%),
        radial-gradient(circle, #fff 30%, transparent 45%),
        radial-gradient(circle, #000 48%, transparent 51%),
        linear-gradient(#000 20px, transparent 0),
        linear-gradient(#cfecf9 60px, transparent 0),
        radial-gradient(circle, #cfecf9 50%, transparent 51%),
        radial-gradient(circle, #cfecf9 50%, transparent 51%);
        background-repeat: no-repeat;
        background-size: 16px 16px, 16px 16px, 10px 10px, 42px 42px, 12px 3px,
        50px 25px, 70px 70px, 70px 70px;
        background-position: 25px 10px, 55px 10px, 36px 44px, 50% 30px, 50% 85px,
        50% 50px, 50% 22px, 50% 45px;
        animation: faceLift 3s linear infinite alternate;
    }

    .loader:before {
        content: "";
        position: absolute;
        width: 140%;
        height: 125px;
        left: -20%;
        top: 0;
        background-image: radial-gradient(circle, #fff 48%, transparent 50%),
        radial-gradient(circle, #fff 48%, transparent 50%);
        background-repeat: no-repeat;
        background-size: 65px 65px;
        background-position: 0px 12px, 145px 12px;
        animation: earLift 3s linear infinite alternate;
    }

    @keyframes faceLift {
        0% {
            transform: translateX(-60%);
        }

        100% {
            transform: translateX(-30%);
        }
    }

    @keyframes earLift {
        0% {
            transform: translateX(10px);
        }

        100% {
            transform: translateX(0px);
        }
    }

</style>
@endassets
