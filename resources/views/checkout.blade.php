<!doctype html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <title>{{ $comp_webtitle }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo/favlogo.png') }}">

    <!-- ======= All CSS Plugins here ======== -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/glightbox.min.css') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">

    <!-- Plugin css -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}">

    <!-- Custom Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

</head>

<body>
    @php
    $deliveryCharges=0;
    $formattedValue=0;
    @endphp
    @foreach ($carts as $cart )
    @php
    $deliveryCharges=0;
    $formattedValue = number_format($deliveryCharges, 2);
    @endphp
    @endforeach
    @if ($carts->isNotEmpty())

    <!-- Start checkout page area -->
    {{-- <form action="{{ route('test.req') }}" method="post"> --}}
        <form action="{{ route('add.to.orderItem') }}" method="POST">
            @csrf
            <div class="checkout__page--area">
                <div class="container">
                    <div class="checkout__page--inner d-flex">
                        <div class="main checkout__mian">
                            <header class="main__header checkout__mian--header mb-30">
                                <h1 class="main__logo--title"><a class="logo logo__left mb-20"
                                        href="{{ route('home') }}"><img
                                            src="{{ asset('assets/img/logo/pacific_logo.png') }}" alt="logo"
                                            style="height: 80px"></a></h1>
                                <details class="order__summary--mobile__version">
                                    <summary class="order__summary--toggle border-radius-5">
                                        <span class="order__summary--toggle__inner">
                                            <span class="order__summary--toggle__icon">
                                                <svg width="20" height="19" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M17.178 13.088H5.453c-.454 0-.91-.364-.91-.818L3.727 1.818H0V0h4.544c.455 0 .91.364.91.818l.09 1.272h13.45c.274 0 .547.09.73.364.18.182.27.454.18.727l-1.817 9.18c-.09.455-.455.728-.91.728zM6.27 11.27h10.09l1.454-7.362H5.634l.637 7.362zm.092 7.715c1.004 0 1.818-.813 1.818-1.817s-.814-1.818-1.818-1.818-1.818.814-1.818 1.818.814 1.817 1.818 1.817zm9.18 0c1.004 0 1.817-.813 1.817-1.817s-.814-1.818-1.818-1.818-1.818.814-1.818 1.818.814 1.817 1.818 1.817z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>
                                            <span class="order__summary--toggle__text show">
                                                <span>Show order summary</span>
                                                <svg width="11" height="6" xmlns="http://www.w3.org/2000/svg"
                                                    class="order-summary-toggle__dropdown" fill="currentColor">
                                                    <path
                                                        d="M.504 1.813l4.358 3.845.496.438.496-.438 4.642-4.096L9.504.438 4.862 4.534h.992L1.496.69.504 1.812z">
                                                    </path>
                                                </svg>
                                            </span>
                                            <span class="order__summary--final__price" id="finalPrice">₹{{ $totalPrice
                                                }}</span>
                                        </span>
                                    </summary>
                                    <div class="order__summary--section">
                                        <div class="cart__table checkout__product--table">
                                            <table class="summary__table">
                                                <tbody class="summary__table--body">
                                                    @foreach ($carts as $cart )


                                                    <tr class=" summary__table--items">
                                                        <td class=" summary__table--list">
                                                            <div class="product__image two  d-flex align-items-center">
                                                                <div class="product__thumbnail border-radius-5">
                                                                    <a
                                                                        href="{{ route('product.detail.page',['id'=>$cart->product->id]) }}"><img
                                                                            class="border-radius-5"
                                                                            src="{{ asset('uploads/Products Images/'.$cart->product->image) }}"
                                                                            alt="cart-product"></a>
                                                                    <span class="product__thumbnail--quantity">{{
                                                                        $cart->times }}</span>
                                                                </div>
                                                                <div class="product__description">
                                                                    <h3 class="product__description--name h4"><a
                                                                            href="{{ route('product.detail.page',['id'=>$cart->product->id]) }}">{{
                                                                            $cart->product->name }}</a>
                                                                    </h3>
                                                                    <span
                                                                        class="product__description--variant text-dark"
                                                                        style="text-transform: uppercase;">COLOR: {{
                                                                        $cart->product->colors }}</span>

                                                                   @if ($cart->product->categories->name=="Jewellery")
                                                        @else
                                                        <span class="cart__content--variant">SIZE: {{ $cart->size
                                                            }}</span>
                                                        @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class=" summary__table--list">
                                                            <span class="cart__price text-dark">₹{{
                                                                $cart->product->discounted_price }}</span>
                                                        </td>
                                                    </tr>

                                                    @endforeach

                                                </tbody>
                                            </table>
                                            @php
                                            $deliveryCharge = 0;

                                            if ($totalPrice < 500) {
                                                $deliveryCharge = $formattedValue;
                                            }

                                            $finalPrice = $totalPrice + $deliveryCharge;
                                        @endphp

                                        @if ($deliveryCharge > 0)
                                            <div>
                                                <span class="text-left">Delivery Charges</span>
                                                <span class="text-right">₹{{ $deliveryCharge }}</span>
                                            </div>
                                        @else
                                            <p class="text-success">Free Delivery</p>
                                        @endif

                                        <p class="text-success">Expected delivery within 5 days.</p>


                                        </div>
                                        {{-- <div class="checkout__discount--code">
                                            <form id="couponForm" action="{{ route('vaild.coupon') }}" method="POST"
                                                class="d-flex">
                                                @csrf
                                                <input type="hidden" name="finalPrice" id="subfinalPrice"
                                                    value="{{ $finalPrice }}">
                                                <label>
                                                    <input
                                                        class="checkout__discount--code__input--field border-radius-5"
                                                        placeholder="Gift card or discount code" type="text" id="dis"
                                                        name="code">
                                                </label>
                                                <button
                                                    class="checkout__discount--code__btn primary__btn border-radius-5"
                                                    id="coupon_btn">Apply</button>
                                            </form>
                                            <p class="text-danger d-none" id="errorcoupanmsg">Invaild Coupan Code</p>
                                        </div> --}}
                                        <div class="checkout__total">
                                            <table class="checkout__total--table">
                                                <tbody class="checkout__total--body">
                                                    <tr class="checkout__total--items">
                                                        <td class="checkout__total--title text-left">Subtotal </td>
                                                        <td class="checkout__total--amount text-right" id="finalPrice">
                                                            ₹{{ $finalPrice }}
                                                        </td>
                                                    </tr>
                                                    <tr class="checkout__total--items">
                                                        <td class="checkout__total--title text-left">Shipping</td>
                                                        <td class="checkout__total--calculated__text text-right">₹{{
                                                            $deliveryCharge }}</td>
                                                    </tr>
                                                </tbody>
                                                <tfoot class="checkout__total--footer">
                                                    <tr class="checkout__total--footer__items">
                                                        <td
                                                            class="checkout__total--footer__title checkout__total--footer__list text-left">
                                                            Total </td>
                                                        <td class="checkout__total--footer__amount checkout__total--footer__list text-right"
                                                            id="finalPrice">
                                                            ₹{{ $finalPrice }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </details>
                                <nav>
                                    <ol class="breadcrumb checkout__breadcrumb d-flex">
                                        <li
                                            class="breadcrumb__item breadcrumb__item--completed d-flex align-items-center">
                                            <a class="breadcrumb__link" href="{{ route('cart.page') }}">Cart</a>
                                            <svg class="readcrumb__chevron-icon" xmlns="http://www.w3.org/2000/svg"
                                                width="17.007" height="16.831" viewBox="0 0 512 512">
                                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="48"
                                                    d="M184 112l144 144-144 144">
                                                </path>
                                            </svg>
                                        </li>

                                        <li
                                            class="breadcrumb__item breadcrumb__item--current d-flex align-items-center">
                                            <span class="breadcrumb__text current">Information</span>
                                            <svg class="readcrumb__chevron-icon" xmlns="http://www.w3.org/2000/svg"
                                                width="17.007" height="16.831" viewBox="0 0 512 512">
                                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="48"
                                                    d="M184 112l144 144-144 144">
                                                </path>
                                            </svg>
                                        </li>
                                        <li class="breadcrumb__item breadcrumb__item--blank d-flex align-items-center">
                                            <span class="breadcrumb__text">Shipping</span>
                                            <svg class="readcrumb__chevron-icon" xmlns="http://www.w3.org/2000/svg"
                                                width="17.007" height="16.831" viewBox="0 0 512 512">
                                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="48"
                                                    d="M184 112l144 144-144 144">
                                                </path>
                                            </svg>
                                        </li>
                                        <li class="breadcrumb__item breadcrumb__item--blank">
                                            <span class="breadcrumb__text">Payment</span>
                                        </li>
                                    </ol>
                                </nav>
                            </header>
                            <main class="main__content_wrapper">
                                <p action="#">
                                <div class="checkout__content--step section__contact--information">

                                    <div class="customer__information">
                                        <div class="checkout__email--phone mb-12">
                                            <label>
                                                <input class="checkout__input--field border-radius-5"
                                                    placeholder="Enter your Email" type="email" id="email" name="email">
                                            </label>
                                        </div>
                                        <div class="checkout__checkbox">
                                            <input class="checkout__checkbox--input" id="check1" type="checkbox"
                                                name="update">
                                            <span class="checkout__checkbox--checkmark"></span>
                                            <label class="checkout__checkbox--label" for="check1">
                                                Email me with news and offers
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <div class="checkout__content--step section__shipping--address">
                                    <div class="section__header mb-25">
                                        <h3 class="section__header--title">Shipping address</h3>
                                    </div>
                                    <div class="section__shipping--address__content">
                                        <div class="row">
                                            <div class="col-lg-6 mb-12">
                                                <div class="checkout__input--list ">
                                                    <label>
                                                        <input class="checkout__input--field border-radius-5"
                                                            placeholder="First name (optional)" type="text"
                                                            name="first_name" id="first_name" required>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-12">
                                                <div class="checkout__input--list">
                                                    <label>
                                                        <input class="checkout__input--field border-radius-5"
                                                            placeholder="Last name (optional)" id="last_name"
                                                            type="text" name="last_name">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-12">
                                                <div class="checkout__input--list">
                                                    <label>
                                                        <input class="checkout__input--field border-radius-5"
                                                            placeholder="Mobile number" id="phone" type="phone"
                                                            name="phone" maxlength="10">
                                                    </label>

                                                </div>
                                            </div>

                                            <div class="col-12 mb-12">
                                                <div class="checkout__input--list">
                                                    <label>
                                                        <input class="checkout__input--field border-radius-5"
                                                            placeholder="Address1" type="text" required name="address1"
                                                            id="address1" required>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-12">
                                                <div class="checkout__input--list">
                                                    <label>
                                                        <input class="checkout__input--field border-radius-5"
                                                            placeholder="Apartment, suite, etc. (optional)" type="text"
                                                            name="address2" id="address2">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-12">
                                                <div class="checkout__input--list checkout__input--select select">
                                                    <label class="checkout__select--label"
                                                        for="country">Country/region</label>
                                                    <select class="checkout__input--select__field border-radius-5"
                                                        id="country" name="country">
                                                        <option value="India">India</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-12">
                                                <div class="checkout__input--list checkout__input--select select">
                                                    <label class="checkout__select--label" for="state">Region State<span
                                                            class="text-danger">*</span></label>
                                                    <select class="checkout__input--select__field border-radius-5"
                                                        id="state" name="state" required>
                                                        <option selected>Choose ...</option>
                                                        @foreach ($states as $state)
                                                        <option value="{{ $state->id }}">
                                                            {{ $state->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('state'))
                                                    <p class="text-danger">{{ $errors->first('state') }}</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-lg-6 mb-12">
                                                <div class="checkout__input--list checkout__input--select select">
                                                    <label class="checkout__select--label" for="city">City<span
                                                            class="text-danger">*</span></label>
                                                    <select class="checkout__input--select__field border-radius-5"
                                                        id="city" name="city" required>
                                                        <option selected>Choose ...</option>
                                                        @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}">
                                                            {{ $city->city }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('city'))
                                                    <p class="text-danger">{{ $errors->first('city') }}</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-lg-6 mb-12">
                                                <div class="checkout__input--list">
                                                    <label>
                                                        <input class="checkout__input--field border-radius-5"
                                                            placeholder="Postal code" type="text" name="post_code"
                                                            id="post_code">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="checkout__checkbox mt-4">
                                            <input class="checkout__radio--input" id="check2" type="radio">
                                            <span class="checkout__checkbox--checkmark"></span>
                                            <label class="checkout__checkbox--label" for="check2">
                                                Save this information for next time</label>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="checkout__content--step section__shipping--address pt-10">
                                    <div class="section__header mb-25">
                                        <h3 class="section__header--title">Pay Method</h3>
                                        {{-- <p class="section__header--desc">Select the address that matches your card
                                            or payment method.</p> --}}
                                    </div>
                                    <div class="checkout__content--step__inner3 border-radius-5">
                                        <div class="checkout__address--content__header"
                                            style="height:0px;overflow: hidden;padding:0px;margin:0px">
                                            <div class="shipping__contact--box__list">
                                                <div class="shipping__radio--input">
                                                    <input class="shipping__radio--input__field" id="radiobox" checked
                                                        name="paymethod" type="radio" value="cod" required>
                                                </div>
                                                <label class="shipping__radio--label" for="radiobox">
                                                    <span class="shipping__radio--label__primary">Cash On
                                                        Delivery</span>
                                                </label>
                                            </div>
                                            {{-- <div class="shipping__contact--box__list">
                                                <div class="shipping__radio--input">
                                                    <input class="shipping__radio--input__field" id="radiobox"
                                                        name="paymethod" type="radio" value="online" required>
                                                </div>
                                                <label class="shipping__radio--label" for="radiobox">
                                                    <span class="shipping__radio--label__primary">Pay Online</span>
                                                </label>
                                            </div> --}}

                                        </div>

                                    </div>
                                </div>
                                <div class="checkout__content--step__footer d-flex align-items-center">
                                    <button type="submit"
                                        class="continue__shipping--btn primary__btn border-radius-5">Pay COD</button>


                                    {{-- <form action="{{ route('razorpay.payment.store') }}" method="POST" id="form1">
                                        @csrf
                                        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                                        <div id="payBtn" class=" continue__shipping--btn primary__btn border-radius-5"
                                            style="margin-left: 10px;cursor: pointer;" form="#form1">Pay Online
                                        </div>
                                    </form>
                                    --}}


                                    <div id="pay_QR_UPI" class="continue__shipping--btn primary__btn border-radius-5 "
                                        style="margin-left: 10px;cursor: pointer;" form="#form1">Pay Online
                                    </div>

                                    {{-- <div class="btn btn-info" id="paytest">paytest</div> --}}


                                    <a class="previous__link--content" href="{{ route('cart.page') }}">Return to
                                        cart</a>
                                </div>
                            </main>
                            <footer class="main__footer checkout__footer">
                                <p class="copyright__content">Copyright © 2022 <a
                                        class="copyright__content--link text__primary" href="{{ route('home') }}">{{
                                        $comp_name }}</a> . All Rights Reserved.Design By {{ $comp_name }}</p>
                            </footer>
                        </div>
                        <aside class="checkout__sidebar sidebar">
                            <div class="cart__table checkout__product--table">
                                <table class="cart__table--inner">
                                    <tbody class="cart__table--body">
                                        @foreach ($carts as $cart )

                                        <tr class="cart__table--body__items">
                                            <td class="cart__table--body__list">
                                                <div class="product__image two  d-flex align-items-center">
                                                    <div class="product__thumbnail border-radius-5">
                                                        <a
                                                            href="{{ route('product.detail.page',['id'=>$cart->product->id]) }}"><img
                                                                class="border-radius-5"
                                                                src="{{ asset('uploads/Products Images/'.$cart->product->image) }}"
                                                                alt="cart-product"></a>
                                                        <span class="product__thumbnail--quantity">{{ $cart->times
                                                            }}</span>
                                                    </div>
                                                    <div class="product__description">
                                                        <h3 class="product__description--name h4"><a
                                                                href="{{ route('product.detail.page',['id'=>$cart->product->id]) }}">{{
                                                                $cart->product->name }}</a>
                                                        </h3>
                                                        <span class="product__description--variant text-dark"
                                                            style="text-transform: uppercase;">COLOR: {{
                                                            $cart->product->colors }}</span>
                                                        <span class="cart__content--variant">SIZE: {{ $cart->size
                                                            }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="cart__table--body__list">
                                                <span class="cart__price">₹{{ $cart->product->discounted_price }}</span>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                @php
                                $deliveryCharge = 0;

                                if ($totalPrice < 500) {
                                    $deliveryCharge = $formattedValue;
                                }

                                $finalPrice = $totalPrice + $deliveryCharge;
                            @endphp

                            @if ($deliveryCharge > 0)
                                <div>
                                    <span class="text-left">Delivery Charges</span>
                                    <span class="text-right">₹{{ $deliveryCharge }}</span>
                                </div>
                            @else
                                <p class="text-success">Free Delivery</p>
                            @endif

                            <p class="text-success">Expected delivery within 5 days.</p>


                            </div>
                            {{-- <div class="checkout__discount--code">
                                <form id="couponForm" action="{{ route('vaild.coupon') }}" method="POST" class="d-flex">
                                    @csrf
                                    <input type="hidden" name="finalPrice" id="subfinalPrice" value="{{ $finalPrice }}">
                                    <label>
                                        <input class="checkout__discount--code__input--field border-radius-5"
                                            placeholder="Gift card or discount code" type="text" id="dis" name="code">
                                    </label>
                                    <button class="checkout__discount--code__btn primary__btn border-radius-5"
                                        id="coupon_btn">Apply</button>
                                </form>
                                <p class="text-danger d-none" id="errorcoupanmsg">Invaild Coupan Code</p>
                            </div> --}}
                            <div class="checkout__total">
                                <table class="checkout__total--table">
                                    <tbody class="checkout__total--body">
                                        <tr class="checkout__total--items">
                                            <td class="checkout__total--title text-left">Subtotal </td>
                                            <td class="checkout__total--amount text-right" id="finalPrice">₹{{
                                                $finalPrice }}</td>
                                        </tr>
                                        <tr class="checkout__total--items">
                                            <td class="checkout__total--title text-left">Shipping</td>
                                            <td class="checkout__total--calculated__text text-right">₹{{ $deliveryCharge
                                                }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="checkout__total--footer">
                                        <tr class="checkout__total--footer__items">
                                            <td
                                                class="checkout__total--footer__title checkout__total--footer__list text-left">
                                                Total </td>
                                            <td class="checkout__total--footer__amount checkout__total--footer__list text-right"
                                                id="finalPrice">
                                                ₹{{ $finalPrice }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </aside>
                    </div>
                </div>
                @foreach ($carts as $cart)
                <input type="hidden" name="cart_id[]" value="{{ $cart->id }}">
                <input type="hidden" name="product_id[]" value="{{ $cart->product_id }}">
                <input type="hidden" name="total_price" value="{{ $finalPrice }}">
                <input type="hidden" name="finalPrice" value="{{ $finalPrice }}">
                @endforeach
            </div>
        </form>

        <style>
            #qr_overlay {
                display: none;
                position: fixed;
                justify-content: center;
                flex-direction: column;
                text-align: center;
                top: 0;
                width: 100%;
                height: 100vh;
                background-color: rgba(8, 8, 8, 0.356);
                justify-content: center;
                align-items: center;
                z-index: 2;
            }

            #please_Wait {
                display: none;
                position: fixed;
                justify-content: center;
                flex-direction: column;
                text-align: center;
                top: 0;
                width: 100%;
                height: 100vh;
                background-color: rgba(8, 8, 8, 0.356);
                justify-content: center;
                align-items: center;
                z-index: 2;
            }

            #qr_overlay #show_qr {

                max-width: 400px;
                width: 100%;
                padding: 10px;
                background: white;
                display: flex;
                flex-direction: column;
                text-align: center;
                justify-content: center;
                align-items: center;

            }

            #qr_overlay #show_qr #img {
                width: 100%;
                height: 100%;
                max-width: 300px;
                height: 300px;
                background: white;
            }
        </style>
        <div id="qr_overlay">

            <div id="show_qr">
                <div>Please Do not Refresh Page</div>
                <div id="qrcode" style="padding: 10px;height:auto;width:300px;"></div>
                <div class="timer text-center"></div>
            </div>
        </div>
        <div id="please_Wait">


            <div class="text-white">Please Do not Refresh Page</div>

        </div>




        <div class="upi_show">
            {{-- <img
                src="https://api.qrserver.com/v1/create-qr-code/?color=000000&amp;bgcolor=FFFFFF&amp;data=upi%3A%2F%2Fpay%3Fpa%3Dshp.shubhzz%40finobank%26pn%3DShubhzzpayment%2520TechnoPvtLtd%26mc%3D5621%26tr%3DSHB202131%26tn%3DIntent%2520Generation%26am%3D11%26cu%3DINR%26mode%3D05%26orgid%3D187064%26catagory%3D01%26url%3Dhttps%3A%2F%2Fwww.finobank.com%2F%26sign%3DMEQCIAs%2FBTY0xxFtzRi1U%2FTkyaHrWextIEwJ%2BoMQDMSc7YuVAiAQtH%2BwKkJEtGRyI%2FcUzkPMtRa8BefpU3ZxBL6I9NKFsQ%3D%3D&amp;qzone=1&amp;margin=0&amp;size=400x400&amp;ecc=L"
                alt="qr code" /> --}}
        </div>

        {{-- <div id="qrcode" style="padding: 10px;height:auto;width:400px;"></div> --}}
        {{-- Checkout --}}
        {{-- resources/views/components/razorpay-form.blade.php --}}
        {{-- RAZORPAY_KEY_ID=rzp_live_W4bZvunU9ojQmd
        RAZORPAY_KEY_SECRET=ttyzW9V1lkdu9OaHVgkke12Y --}}


        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
        <script>
            // $("#paytest").click(function(){
// var phone =  $("#phone").val();
// var email =  $("#email").val();
// var first_name =  $("#first_name").val();
// var last_name =  $("#last_name").val();
// var address1 =  $("#address1").val();
// var address2 =  $("#address2").val();
// var post_code =  $("#post_code").val();
// var country =  $("#country option:selected").val();
// var state =  $("#state option:selected").val();
// var city =  $("#city option:selected").val();




// var total_price =  {{ $finalPrice }};
// var finalPrice =  {{ $finalPrice }};
// var cart_id = [ @foreach ($carts as $cart) {{ $cart->id }}  @endforeach ];
// var product_id = [ @foreach ($carts as $cart) {{ $cart->product_id }}  @endforeach ];
// json= {  _token: "{{ csrf_token() }}", // CSRF token
//                     first_name,last_name,email,phone,total_price,finalPrice,
//                     address1,address2,country,state,city,post_code,cart_id,product_id};
//                     console.log(json);
//     $.post('/order/create',json,function(data){
//                         console.log(data);
//                     });
//                 });
// var qrcode = new QRCode(
//   "qrcode",
//   {
//     text: "sdfgdfsgfd", // you can set your QR code text
//     width: 400,
//     height: 400,
//     colorDark : "#000000",
//     colorLight : "#FFFFFF",
//     correctLevel : QRCode.CorrectLevel.M
//   }
// );


let details = navigator.userAgent;

/* Creating a regular expression
containing some mobile devices keywords
to search it in details string*/
let regexp = /android|iphone|kindle|ipad/i;

/* Using test() method to search regexp in details
it returns boolean value*/
var isMobileDevice = regexp.test(details);



function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const remainingSeconds = seconds % 60;
    return `${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
}
var isPaymentRecived = false;
function checkStatus(order_id){
    $.post(`/order/status/${order_id}`,{},function(data){
        if(data.status){
            isPaymentRecived=true;
        }
    });
}

function checkPaymentStatus(order_id) {
    // console.log(`/order/status/${order_id}`);
    $.get(`/order/status/${order_id}`,{_token: "{{ csrf_token() }}"}, function(data) {
        // console.log(`INSIDE /order/status/${order_id} ${JSON.stringify(data)}`);
        if (data.status && data.payment_received_status) {
            isPaymentRecived = true;
            $("#qr_overlay").html(`
                <div style="color:white">
                    <h2>Thank you</h2>
                    <h6>Payment Received</h6>
                </div>
            `);
            setTimeout(() => {
                window.location.href = `/thankyou/${order_id}`; // Change the URL to your actual "thank you" page
            }, 2000);
        } else {
            // If payment is not received yet, retry after 3 seconds
            // console.log(`INSIDE Start Agina`);
            setTimeout(checkPaymentStatus(order_id), 3000);
        }
    });
}


$("#paytest").click(function(){
    res={razorpay_payment_id:"pay_OsFhVyffztuMYc"};
    order_id="ORD000046";
    $.ajax({
                    url: "/payment/create",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}", // CSRF token
                        response: {
                            razorpay_payment_id: res.razorpay_payment_id,
                            order_id: order_id
                        }
                    },
                    success: function(res) {
                        console.log('Payment data sent to server', res);
                        if (res.success === true) { // Use comparison
                            // alert("Order Created: " + res.order_id);
                            // window.location.href = '/';
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error sending payment failure information:', textStatus, errorThrown);
                    }
                });
                });

                var isStoped =false;

                function fetchCheckApi(){
                    if(isStoped){
                        return
                    }
$.post('')

                }


$("#payBtn,#pay_QR_UPI").click(function(e) {
    e.preventDefault(); // Prevent the form from submitting

    var phone = $("#phone").val();
    var email = $("#email").val();
    var first_name = $("#first_name").val();
    var last_name = $("#last_name").val();
    var address1 = $("#address1").val();
    var address2 = $("#address2").val();
    var post_code = $("#post_code").val();
    var country = $("#country option:selected").val();
    var state = $("#state option:selected").val();
    var city = $("#city option:selected").val();

    var total_price = {{ $finalPrice }};
    var finalPrice = {{ $finalPrice }};
    var cart_id = [@foreach ($carts as $cart) {{ $cart->id }}, @endforeach];
    var product_id = [@foreach ($carts as $cart) {{ $cart->product_id }}, @endforeach];
    var name = `${first_name} ${last_name ?? ''}`;

    if(!phone || !email || !first_name || !address1 || !post_code || !country || !state || !city){
        alert("Please Fill all info");
        return
    }

    // Create a JSON object with your data
    var json = {
        _token: "{{ csrf_token() }}",
        phone: phone,
        email: email,
        first_name: first_name,
        last_name: last_name,
        address1: address1,
        address2: address2,
        post_code: post_code,
        country: country,
        state: state,
        city: city,
        total_price: total_price,
        cart_id: cart_id,
        product_id: product_id
    };
    var clickedId = $(this).attr('id');
    if(clickedId==="pay_QR_UPI"){
        $("#please_Wait").css({"display":"flex"});
        json.pay_QR_UPI="yes";
            $.post('/order/create', json, function(data){

            if (!data.success) {
            alert(data.msg);
            return;
        };
        console.log(`'/order/create' ${JSON.stringify(data)}`);
        if(isMobileDevice){
        location.href=data.intent;
        order_id = data.order_id;
        checkPaymentStatus(order_id)


        var  maxTime  = 150;
var  timeLeft  = maxTime;
       var interval =      setInterval(() => {

         $(".timer").text(formatTime(timeLeft));
         timeLeft--;
if(timeLeft<=1){
    $("#qr_overlay").hide();

    clearInterval(interval);
    window.location.href = `/thank-you/${order_id}`;
}

            }, 1000);

        }else{
            $("#please_Wait").hide();
            console.log(data.intent);

            var qrcode = new QRCode(
  "qrcode",
  {
    text: data.intent, // you can set your QR code text
    width: 300,
    height: 300,
    colorDark : "#000000",
    colorLight : "#FFFFFF",
    correctLevel : QRCode.CorrectLevel.M
  }
);

//             $(".upi_show").html(`<img src="https://api.qrserver.com/v1/create-qr-code/?color=000000&amp;bgcolor=FFFFFF&amp;data=${encodeURI(data.intent)}&amp;qzone=1&amp;margin=0&amp;size=400x400&amp;ecc=L" alt="qr code" />
// `);
            $("#qr_overlay").css({'display':'flex'});

var  maxTime  = 150;
var  timeLeft  = maxTime;
       var interval =      setInterval(() => {

         $(".timer").text(formatTime(timeLeft));
         timeLeft--;
if(timeLeft<=1){
    $("#qr_overlay").hide();

    clearInterval(interval);
    window.location.href = `/thank-you/${data.order_id}`;
}

            }, 1000);


            checkPaymentStatus(data.order_id);





            // // https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=upi://pay?pa=shp.shubhzz@finobank&pn=Shubhzzpayment%20TechnoPvtLtd&mc=5621&tr=SHB202131&tn=Intent%20Generation&am=10.00&cu=INR&mode=05&orgid=187064&catagory=01&url=https://www.finobank.com/&sign=MEQCIAs/BTY0xxFtzRi1U/TkyaHrWextIEwJ+oMQDMSc7YuVAiAQtH+wKkJEtGRyI/cUzkPMtRa8BefpU3ZxBL6I9NKFsQ==
            // $.get('https://api.qrserver.com/v1/create-qr-code/',{size:'150x150',data:data.intent},function(intentdata){

            // });
        }
        // return response()->json(['success' => true, 'msg' => 'Order created', "order_id" => $orderNum, 'enc' => $enCodeOrderId, 'enc_amount' => $amount]);






        });

        return;
    }

console.log(json);
    $.post('/order/create', json, function(data) {
       console.log(data);
        if (!data.success) {
            alert(data.msg);
            return;
        }

        var order_id = data.order_id;
        var options = {
            "key": "rzp_live_W4bZvunU9ojQmd",
            "amount": finalPrice * 100, // multiplied finalPrice by 100
            "name": "SHUBHZZ PAYMENT TECHNOLOGIES PRIVATE LIMITED",
            "description": "Razorpay payment",
            "image": "https://cdn.razorpay.com/logos/NSL3kbRT73axfn_medium.png",

           "receipt": order_id,
            "prefill": {
                "name": name,
                "email": email,
                "contact": phone
            },
            "theme": {
                "color": "#0F408F"
            },
            "handler": function(res) {
                console.log(res);

                $.ajax({
                    url: "/payment/create",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}", // CSRF token
                        response: {
                            razorpay_payment_id: res.razorpay_payment_id,
                            order_id: order_id
                        }
                    },
                    success: function(res) {
                        console.log('Payment data sent to server', res);
                        if (res.success === true) { // Use comparison
                            // alert("Order Created: " + res.order_id);
                            window.location.href = `/thankyou/${order_id}`;
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error sending payment failure information:', textStatus, errorThrown);
                    }
                });
            },
            "modal": {
                "ondismiss": function() {
                    window.location.href = '/'; // Redirect to your failure page
                }
            }
        };
        console.log(options);
        var rzp = new Razorpay(options);
        rzp.open();

        rzp.on('payment.failed', function(response) {
            if (response.reason === "payment_failed") { // Use comparison
                const { error, reason } = response;
                $.ajax({
                    url: "/payment/failure",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}", // CSRF token
                        response: {
                            error,
                            reason
                        }
                    },
                    success: function(response) {
                        console.log('Payment failure data sent to server', response);
                        if (response.success === true) { // Use comparison
                            window.location.href = '/402'; // payment failure
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error sending payment failure information:', textStatus, errorThrown);
                    }
                });
            }
        });
    });
});








        </script>

        {{-- Cgeckout End --}}

        @else
        <script>
            setTimeout(function() {
            window.location.href = "{{ route('home') }}";
        }, 0);

        </script>
        @endif
        <!-- End checkout page area -->

        <!-- Scroll top bar -->
        <button id="scroll__top"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48"
                    d="M112 244l144-144 144 144M256 120v292" />
            </svg></button>

        <!-- All Script JS Plugins here  -->
        <script src="{{ asset('assets/js/vendor/popper.js') }}" defer="defer"></script>
        <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}" defer="defer"></script>
        <script src="{{ asset('assets/js/plugins/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/glightbox.min.js') }}"></script>

        <!-- Customscript js -->
        <script src="{{ asset('assets/js/script.js') }}"></script>


</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('select[name="state"]').on('change', function() {
            var stateId = $(this).val();
            if (stateId) {
                $.ajax({
                    url: '/get-cities/' + stateId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="city"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="city"]').append('<option value="' + value.id + '">' + value.city + '</option>');
                        });
                    }
                });
            } else {
                $('select[name="city"]').empty();
            }
        });
    });
</script>
