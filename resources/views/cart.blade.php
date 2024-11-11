@extends('layouts.header')
@section('content')
@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

@if(session('success-delete'))
<div class="cr-wish-notify" id="wishNotification">
    <p class="wish-note">Product Deleted Successfully!</p>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $("#wishNotification").fadeOut(300);
        }, 2000);
    });

</script>
@endif



@php
$totalPrice=0;
@endphp
<main class="main__content_wrapper">

    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">Shopping Cart</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items"><a class="text-white"
                                    href="{{ route('home.page') }}">Home</a></li>
                            <li class="breadcrumb__content--menu__items"><span class="text-white">Shopping
                                    Cart</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- cart section start -->
    @isset($carts)
    @if($carts->isNotEmpty())
    <section class="cart__section section--padding">
        <div class="container-fluid">

            <div class="cart__section--inner">
                <form action="#">
                    <h2 class="cart__title mb-40">Shopping Cart</h2>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="cart__table">
                                <table class="cart__table--inner">
                                    <thead class="cart__table--header">
                                        <tr class="cart__table--header__items">
                                            <th class="cart__table--header__list">Product</th>
                                            <th class="cart__table--header__list">Price</th>
                                            <th class="cart__table--header__list">Quantity</th>
                                            <th class="cart__table--header__list">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="cart__table--body">
                                        @foreach ($carts as $cart)
                                        <tr class="cart__table--body__items">
                                            @if($cart->product)
                                            <td class="cart__table--body__list">
                                                <div class="cart__product d-flex align-items-center">
                                                    <a href="{{ route('delete.card.item', ['id' => $cart->id]) }}"
                                                        class="cart__remove--btn" aria-label="Remove from cart">
                                                        <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 24 24" width="16px" height="16px">
                                                            <path
                                                                d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z" />
                                                        </svg>
                                                    </a>
                                                    <div class="cart__thumbnail">
                                                        <a
                                                            href="{{ route('product.detail.page',['id'=>$cart->product->id]) }}"><img
                                                                class="border-radius-5"
                                                                src="{{ asset('uploads/Products Images/'.$cart->product->image) }}"
                                                                alt="cart-product"></a>
                                                    </div>
                                                    <div class="cart__content">
                                                        <h4 class="cart__content--title"><a
                                                                href="{{ route('product.detail.page',['id'=>$cart->product->id]) }}z">{{
                                                                $cart->product->name }}</a></h4>
                                                        <span class="cart__content--variant">COLOR: {{ $cart->product->colors }}</span>
                                                        <span class="cart__content--variant">SIZE: {{ $cart->size }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="cart__table--body__list">
                                                <span class="cart__price">₹{{ $cart->product->discounted_price }}</span>
                                            </td>
                                            <td class="cart__table--body__list">
                                                <div class="quantity__box">
                                                    <button type="button"
                                                        class="quantity__value quickview__value--quantity newminus"
                                                        aria-label="Decrease Quantity" value="Decrease Value"
                                                        data-cart-id="{{ $cart->id }}"
                                                        data-product-id="{{ $cart->product->id }}">-</button>
                                                    <label>
                                                        <input type="number"
                                                            class="quantity__number quickview__value--number"
                                                            id="quantity_{{ $cart->id }}" value="{{ $cart->times }}"
                                                            data-counter readonly />
                                                    </label>
                                                    <button type="button"
                                                        class="quantity__value quickview__value--quantity newplus"
                                                        aria-label="Increase Quantity" value="Increase Value"
                                                        data-cart-id="{{ $cart->id }}"
                                                        data-product-id="{{ $cart->product->id }}">+</button>
                                                </div>
                                            </td>
                                            @php
                                            $totalPrice += $cart->times * $cart->product->discounted_price;
                                            @endphp
                                            <td class="cart__table--body__list">
                                                <span class="cart__price end cr-cart-subtotal"
                                                    id="subtotal_{{ $cart->id }}">₹{{
                                                    $cart->times *
                                                    $cart->product->discounted_price }}</span>
                                            </td>

                                            @else
                                            <td colspan="7">Product not found</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="continue__shopping d-flex justify-content-between">
                                    <a class="continue__shopping--link" href="{{ route('shop.page') }}">Continue
                                        shopping</a>
                                    <a class="continue__shopping--clear" href="{{ route('clear.cart') }}">Clear Cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="cart__summary border-radius-10">
                                {{-- <div class="coupon__code mb-30">
                                    <h3 class="coupon__code--title">Coupon</h3>
                                    <p class="coupon__code--desc">Enter your coupon code if you have one.</p>
                                    <div class="coupon__code--field d-flex">
                                        <label>
                                            <input class="coupon__code--field__input border-radius-5"
                                                placeholder="Coupon code" type="text">
                                        </label>
                                        <button class="coupon__code--field__btn primary__btn" type="submit">Apply
                                            Coupon</button>
                                    </div>
                                </div> --}}
                                {{-- <div class="cart__note mb-20">
                                    <h3 class="cart__note--title">Note</h3>
                                    <p class="cart__note--desc">Add special instructions for your seller...</p>
                                    <textarea class="cart__note--textarea border-radius-5"></textarea>
                                </div> --}}
                                <div class="cart__summary--total mb-20">
                                    <table class="cart__summary--total__table">
                                        <tbody>
                                            <tr class="cart__summary--total__list">
                                                <td class="cart__summary--total__title text-left">SUBTOTAL</td>
                                                <td class="cart__summary--amount text-right cr-cart-total" id="hideen">
                                                    ₹{{ $totalPrice }}</td>
                                                <td class="cart__summary--amount text-right cr-cart-total d-none"
                                                    id="finalprice"></td>


                                            </tr>
                                            <tr class="cart__summary--total__list">
                                                <td class="cart__summary--total__title text-left">GRAND TOTAL</td>
                                                <td class="cart__summary--amount text-right cr-cart-total2" id="hideen2">
                                                    ₹{{ $totalPrice }}</td>
                                                <td class="cart__summary--amount text-right cr-cart-total2 d-none"
                                                    id="finalprice2"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="cart__summary--footer">
                                    <p class="cart__summary--footer__desc">Shipping & taxes calculated at checkout</p>
                                    <ul class="d-flex justify-content-between">
                                        <li><button class="cart__summary--footer__btn primary__btn cart"
                                                type="submit">Update Cart</button></li>
                                        <li><a class="cart__summary--footer__btn primary__btn checkout"
                                                href="{{ route('checkout.page') }}">Check Out</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </section>
    @else
    <div class="row m-4 p-4">
        <div class="col-lg-12">
            <h6 class="display-6">No items in the cart</h6>
            <div class="cr-cart-update-bottom d-flex justify-content-end">
                <a href="{{ route('home') }}" class="cr-links">Continue Shopping</a>
            </div>
        </div>
    </div>
    @endif

    @endisset
    @if($carts == null)
    <div class="row m-4 p-4">
        <div class="col-lg-12">
            <h6 class="display-6">No items in the cart</h6>
            <div class="cr-cart-update-bottom d-flex justify-content-end">
                <a href="{{ route('home') }}" class="cr-links">Continue Shopping</a>
            </div>
        </div>
    </div>
    @endif

    <!-- cart section end -->

    <!-- Start product section -->
    @if ($recommendedProducts != null && count($recommendedProducts) > 0)
    <section class="product__section section--padding pt-0">
        <div class="container-fluid">
            <div class="section__heading text-center mb-50">
                <h2 class="section__heading--maintitle">Recommended Productss</h2>
            </div>
            <div class="product__section--inner product__swiper--activation swiper">
                <div class="swiper-wrapper">
                    @foreach ($recommendedProducts as $items)
                    <div class="swiper-slide">
                        <div class="product__items ">
                            <div class="product__items--thumbnail">
                                <a class="produSct__items--link"
                                href="{{ route('product.detail.page', ['id' => $items->id]) }}">
                                <img class="product__items--img product__primary--img"
                                    src="{{ asset('uploads/Products Images/' . $items->image) }}"
                                    alt="product-img">
                                <img class="product__items--img product__secondary--img"
                                    src="{{ asset('uploads/Products Images/' . $items->image2) }}"
                                    alt="product-img">
                            </a>
                                <div class="product__badge">
                                    <span class="product__badge--items sale">Sale</span>
                                </div>
                            </div>
                            <div class="product__items--content">
                                <span class="product__items--content__subtitle">
                                    {{ $items->categories ? $items->categories->name : 'Uncategorized' }}
                                </span>
                                <h3 class="product__items--content__title h4"><a
                                        href="{{ route('product.detail.page', ['id' => $items->id]) }}">{{ $items->name }}</a>
                                </h3>
                                <div class="product__items--price">
                                    <span class="current__price">₹{{ $items->discounted_price }}</span>
                                    <span class="price__divided"></span>
                                    <span class="old__price">₹{{ $items->price }}</span>
                                </div>

                                <ul class="product__items--action d-flex">
                                    <li class="product__items--action__list">
                                        <a class="product__items--action__btn"
                                            href="{{ route('product.detail.page', ['id' => $items->id]) }}">
                                            <svg class="product__items--action__btn--svg"
                                                xmlns="http://www.w3.org/2000/svg" width="22.51"
                                                height="20.443" viewBox="0 0 14.706 13.534">
                                                <g transform="translate(0 0)">
                                                    <g>
                                                        <path data-name="Path 16787"
                                                            d="M4.738,472.271h7.814a.434.434,0,0,0,.414-.328l1.723-6.316a.466.466,0,0,0-.071-.4.424.424,0,0,0-.344-.179H3.745L3.437,463.6a.435.435,0,0,0-.421-.353H.431a.451.451,0,0,0,0,.9h2.24c.054.257,1.474,6.946,1.555,7.33a1.36,1.36,0,0,0-.779,1.242,1.326,1.326,0,0,0,1.293,1.354h7.812a.452.452,0,0,0,0-.9H4.74a.451.451,0,0,1,0-.9Zm8.966-6.317-1.477,5.414H5.085l-1.149-5.414Z"
                                                            transform="translate(0 -463.248)"
                                                            fill="currentColor">
                                                        </path>
                                                        <path data-name="Path 16788"
                                                            d="M5.5,478.8a1.294,1.294,0,1,0,1.293-1.353A1.325,1.325,0,0,0,5.5,478.8Zm1.293-.451a.452.452,0,1,1-.431.451A.442.442,0,0,1,6.793,478.352Z"
                                                            transform="translate(-1.191 -466.622)"
                                                            fill="currentColor">
                                                        </path>
                                                        <path data-name="Path 16789"
                                                            d="M13.273,478.8a1.294,1.294,0,1,0,1.293-1.353A1.325,1.325,0,0,0,13.273,478.8Zm1.293-.451a.452.452,0,1,1-.431.451A.442.442,0,0,1,14.566,478.352Z"
                                                            transform="translate(-2.875 -466.622)"
                                                            fill="currentColor">
                                                        </path>
                                                    </g>
                                                </g>
                                            </svg>
                                            <span class="add__to--cart__text">Buy Now</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper__nav--btn swiper-button-next"></div>
                <div class="swiper__nav--btn swiper-button-prev"></div>
            </div>
        </div>
    </section>
    @endif
    <!-- End product section -->




</main>
<script>
    $(document).ready(function() {
        $(".newplus, .newminus").click(function() {
            var element = $(this);
            var cartId = $(this).data("cart-id");
            var productId = $(this).data("product-id");
            var increment = $(this).hasClass("newplus") ? 1 : -1;

            // Add CSRF token to headers
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // AJAX request
            $.ajax({
                url: "{{ route('cart.update.quantity') }}"
                , type: 'put'
                , dataType: 'json'
                , data: {
                    cart_id: productId
                    , product_id: productId
                    , increment: increment
                , }
                , success: function(response) {
                    // Handle successful response
                    console.log(response);

                    // Check if the update was successful
                    if (response.success) {
                        var times = response.times;
                        var price = response.price;

                        // Update quantity input using ID
                        $('#quantity_' + cartId).val(times);

                        // Update subtotal using ID
                        $('#subtotal_' + cartId).text("₹" + (times * price));

                        // Update total price dynamically
                        updateTotalPrice();
                    } else {
                        console.error("Update quantity failed:", response.message);
                    }
                }
                , error: function(xhr, status, error) {
                    // Handle errors
                    console.error("AJAX error:", xhr.responseText);
                }
            });
        });

        // Function to update total price dynamically
        function updateTotalPrice() {
            var totalPrice = 0;
            $('.cr-cart-subtotal').each(function() {
                var subtotalValue = parseFloat($(this).text().replace('₹', ''));
                totalPrice += subtotalValue;
            });


            // Update final price element
            $('#finalprice').text( "₹ " +totalPrice);
            $('#finalprice2').text( "₹ " +totalPrice);
            // Hide the 'hideen' element
            $('#hideen').css('display', 'none');
            $('#hideen2').css('display', 'none');
            $('#finalprice').removeClass('d-none');
            $('#finalprice2').removeClass('d-none');
        }
    });

</script>
@endsection
