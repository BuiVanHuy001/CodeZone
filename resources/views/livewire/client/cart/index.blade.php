<div>
    <div class="rbt-cart-area bg-color-white py-5">
        <div class="cart_area">
            <div class="container">
                <h2 class="title">Shopping Cart</h2>
                <div class="row">
                    <p>You have <strong>{{ count($items) }} courses</strong> in Cart</p>
                    <div class="col-8">
                        <div class="cart-table table-responsive mb--60">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="pro-thumbnail">Image</th>
                                    <th class="pro-title">Product</th>
                                    <th class="pro-price">Price</th>
                                    <th class="pro-subtotal">Total</th>
                                    <th class="pro-remove">Remove</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td class="pro-thumbnail">
                                            <a href="{{ $item->detailPageUrl }}"><img src="{{ $item->thumbnail }}" alt="Product"></a>
                                        </td>
                                        <td class="pro-title">
                                            <a href="{{ $item->detailPageUrl }}">{{ $item->title }}</a>
                                        </td>
                                        <td class="pro-price"><span>{{ $item->price }}</span></td>
                                        <td class="pro-subtotal"><span>{{ $item->price }}</span></td>
                                        <td class="pro-remove"><a href="#"><i class="feather-x"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="row g-5">
                            <div class="col-12">
                                <div class="edu-bg-shade mb-3">
                                    <div class="section-title text-start">
                                        <h4 class="title mb--30">Payment Method</h4>
                                    </div>
                                    <div class="d-flex justify-content-center gap-3">
                                        <label>
                                            <input class="radio-input" type="radio" wire:model="paymentMethod" value="momo">
                                            <span class="radio-tile">
                                                <span class="radio-icon p-2">
                                                    <img src="{{ asset('images/logo/momo.webp') }}" alt="Momo"/>
                                                </span>
                                                <span class="radio-label">Momo</span>
                                            </span>
                                        </label>
                                        <label>
                                            <input class="radio-input" type="radio" wire:model="paymentMethod" value="vnpay">
                                            <span class="radio-tile">
                                                <span class="radio-icon p-2">
                                                    <img src="{{ asset('images/logo/vnpay.webp') }}" alt="VNPay"/>
                                                </span>
                                                <span class="radio-label">VNPay</span>
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="edu-bg-shade mb-3">
                                    <div class="section-title text-start">
                                        <h4 class="title mb--30">Discount Coupon Code</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb--25">
                                            <input type="text" placeholder="Coupon Code">
                                        </div>
                                        <div class="col-12 mb--25">
                                            <button class="rbt-btn btn-gradient hover-icon-reverse btn-sm">
                                                <span class="icon-reverse-wrapper">
                                                    <span class="btn-text">Apply Code</span>
                                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="cart-summary mb-3">
                                    <div class="cart-summary-wrap">
                                        <div class="section-title text-start">
                                            <h4 class="title mb--30">Cart Summary</h4>
                                        </div>
                                        <p>Original Price <span>{{ $totalPrice }}</span></p>
                                        <p>Discount <span>$00.00</span></p>
                                        <h2>Final Price <span>{{ $totalPrice }}</span></h2>
                                    </div>
                                    <button wire:click="checkOut" class="rbt-btn btn-gradient icon-hover w-100 text-center">
                                        <span class="btn-text">Proceed to Checkout</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-separator-mid">
        <div class="container">
            <hr class="rbt-separator m-0">
        </div>
    </div>

</div>
@assets
<style>
    .radio-input:checked + .radio-tile {
        border-color: #2260ff;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        color: #2260ff;
    }

    .radio-input:checked + .radio-tile .radio-icon img {
        fill: #2260ff;
    }

    .radio-input:checked + .radio-tile .radio-label {
        color: #2260ff;
    }

    .radio-input:focus + .radio-tile {
        border-color: #2260ff;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1), 0 0 0 4px #b5c9fc;
    }

    .radio-tile {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 80px;
        min-height: 80px;
        border-radius: 0.5rem;
        border: 2px solid #b5bfd9;
        background-color: #fff;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        transition: 0.15s ease;
        cursor: pointer;
        position: relative;
    }

    .radio-tile:hover {
        border-color: #2260ff;
    }

    .radio-tile:hover:before {
        transform: scale(1);
        opacity: 1;
    }

    .radio-label {
        color: #707070;
        transition: 0.375s ease;
        text-align: center;
        font-size: 13px;
    }

    .radio-input {
        clip: rect(0 0 0 0);
        -webkit-clip-path: inset(100%);
        clip-path: inset(100%);
        height: 1px;
        overflow: hidden;
        position: absolute;
        white-space: nowrap;
        width: 1px;
    }
</style>
@endassets
