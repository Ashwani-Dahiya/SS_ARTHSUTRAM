@extends('layouts.header')
@section('content')
<main class="main__content_wrapper">

    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">Our Products</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items"><a class="text-white"
                                    href="{{ route('home.page') }}">Home</a></li>
                            <li class="breadcrumb__content--menu__items"><span class="text-white">Our Products</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- Start shop section -->
    <section class="shop__section section--padding">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <div class="shop__sidebar--widget widget__area d-none d-lg-block">
                        @if($catName=="jewellery")
                        @else
                        <div class="single__widget widget__bg">
                            <h2 class="widget__title h3">Categories</h2>
                            <form class="price__filter--form" action="{{ route('product.filter.post') }}" method="POST">
                                @csrf
                                <ul class="widget__form--check">
                                    @foreach ($allcategories as $allcategorie )


                                    <li class="widget__form--check__list">
                                        <label class="widget__form--check__label" for="{{ $allcategorie->name }}">{{
                                            $allcategorie->name }}</label>
                                        <input class="widget__form--check__input" id="{{ $allcategorie->name }}"
                                            type="checkbox" value="{{ $allcategorie->id }}" name="categories[]">
                                        <span class="widget__form--checkmark"></span>
                                    </li>

                                    @endforeach

                                </ul>
                        </div>
                        <div class="single__widget widget__bg">
                            <h2 class="widget__title h3">Product Size</h2>
                            <ul class="widget__form--check">
                                @php
                                $j = 38;
                                @endphp
                                @for (; $j <= 48; $j +=2) <li class="widget__form--check__list">
                                    <label class="widget__form--check__label" for="check{{ $j }}">{{ $j }}</label>
                                    <input class="widget__form--check__input" id="check{{ $j }}" type="checkbox"
                                        name="sizes[]" value="{{ $j }}">
                                    <span class="widget__form--checkmark"></span>
                                    </li>
                                    @endfor



                            </ul>
                        </div>
                        @endif

                        <div class="single__widget price__filter widget__bg">
                            <h2 class="widget__title h3">Filter By Price</h2>
                            <div class="price__filter--form__inner mb-15 d-flex align-items-center">
                                <div class="price__filter--group">
                                    <label class="price__filter--label" for="Filter-Price-GTE2">From</label>
                                    <div class="price__filter--input border-radius-5 d-flex align-items-center">
                                        <span class="price__filter--currency">₹</span>
                                        <label>
                                            <input class="price__filter--input__field border-0"
                                                name="filter.v.price.gte" type="number" placeholder="0" min="0"
                                                max="20000.00" value="0">
                                        </label>
                                    </div>
                                </div>
                                <div class="price__divider">
                                    <span>-</span>
                                </div>
                                <div class="price__filter--group">
                                    <label class="price__filter--label" for="Filter-Price-LTE2">To</label>
                                    <div class="price__filter--input border-radius-5 d-flex align-items-center">
                                        <span class="price__filter--currency">₹</span>
                                        <label>
                                            <input class="price__filter--input__field border-0"
                                                name="filter.v.price.lte" type="number" min="0" placeholder="10000.00"
                                                max="20000.00" value="20000">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button class="price__filter--btn primary__btn" type="submit">Filter</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="shop__product--wrapper">
                        <div class="tab_content">
                            <div id="product_grid" class="tab_pane active show">
                                <div class="product__section--inner product__grid--inner">
                                    <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-2 mb--n30">
                                        @foreach ($products as $product)


                                        <div class="col mb-30">
                                            <div class="product__items ">
                                                <div class="product__items--thumbnail">
                                                    <a class="product__items--link"
                                                        href="{{ route('product.detail.page',['id'=>$product->id]) }}">
                                                        <img class="product__items--img product__primary--img"
                                                            src="{{ asset('uploads/Products Images/'.$product->image) }}"
                                                            alt="product-img">
                                                        <img class="product__items--img product__secondary--img"
                                                            src="{{ asset('uploads/Products Images/'.$product->image2) }}"
                                                            alt="product-img">
                                                    </a>
                                                    <div class="product__badge">
                                                        <span class="product__badge--items sale">Sale</span>
                                                    </div>
                                                </div>
                                                <div class="product__items--content">
                                                    <span class="product__items--content__subtitle">
                                                        {{ $product->categories ? $product->categories->name : 'Uncategorized' }}
                                                    </span>
                                                    <h3 class="product__items--content__title h4"><a
                                                            href="{{ route('product.detail.page',['id'=>$product->id]) }}">{{
                                                            $product->name }}</a></h3>
                                                    <div class="product__items--price">
                                                        <span class="current__price">₹{{ $product->discounted_price
                                                            }}</span>
                                                        <span class="price__divided"></span>
                                                        <span class="old__price">₹{{ $product->price }}</span>
                                                    </div>

                                                    <ul class="product__items--action d-flex">
                                                        <li class="product__items--action__list">
                                                            <a class="product__items--action__btn"
                                                                href="{{ route('product.detail.page',['id'=>$product->id]) }}">
                                                                <svg class="product__items--action__btn--svg"
                                                                    xmlns="http://www.w3.org/2000/svg" width="22.51"
                                                                    height="20.443" viewBox="0 0 14.706 13.534">
                                                                    <g transform="translate(0 0)">
                                                                        <g>
                                                                            <path data-name="Path 16787"
                                                                                d="M4.738,472.271h7.814a.434.434,0,0,0,.414-.328l1.723-6.316a.466.466,0,0,0-.071-.4.424.424,0,0,0-.344-.179H3.745L3.437,463.6a.435.435,0,0,0-.421-.353H.431a.451.451,0,0,0,0,.9h2.24c.054.257,1.474,6.946,1.555,7.33a1.36,1.36,0,0,0-.779,1.242,1.326,1.326,0,0,0,1.293,1.354h7.812a.452.452,0,0,0,0-.9H4.74a.451.451,0,0,1,0-.9Zm8.966-6.317-1.477,5.414H5.085l-1.149-5.414Z"
                                                                                transform="translate(0 -463.248)"
                                                                                fill="currentColor"></path>
                                                                            <path data-name="Path 16788"
                                                                                d="M5.5,478.8a1.294,1.294,0,1,0,1.293-1.353A1.325,1.325,0,0,0,5.5,478.8Zm1.293-.451a.452.452,0,1,1-.431.451A.442.442,0,0,1,6.793,478.352Z"
                                                                                transform="translate(-1.191 -466.622)"
                                                                                fill="currentColor"></path>
                                                                            <path data-name="Path 16789"
                                                                                d="M13.273,478.8a1.294,1.294,0,1,0,1.293-1.353A1.325,1.325,0,0,0,13.273,478.8Zm1.293-.451a.452.452,0,1,1-.431.451A.442.442,0,0,1,14.566,478.352Z"
                                                                                transform="translate(-2.875 -466.622)"
                                                                                fill="currentColor"></path>
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
                                </div>
                            </div>
                            <div id="product_list" class="tab_pane">
                                <div class="product__section--inner">
                                    <div class="row row-cols-1 mb--n30">

                                        @foreach ($products as $product )


                                        <div class="col mb-30">
                                            <div class="product__items product__list--items d-flex">
                                                <div class="product__items--thumbnail product__list--items__thumbnail">
                                                    <a class="product__items--link"
                                                        href="{{ route('product.detail.page',['id'=>$product->id]) }}">
                                                        <img class="product__items--img product__primary--img"
                                                            src="{{ asset('uploads/Products Images/'.$product->image) }}"
                                                            alt="product-img">
                                                        <img class="product__items--img product__secondary--img"
                                                            src="{{ asset('uploads/Products Images/'.$product->image2) }}"
                                                            alt="product-img">
                                                    </a>
                                                    <div class="product__badge">
                                                        <span class="product__badge--items sale">Sale</span>
                                                    </div>
                                                </div>
                                                <div class="product__list--items__content">
                                                    <span class="product__items--content__subtitle">
                                                        {{ $product->categories ? $product->categories->name : 'Uncategorized' }}
                                                    </span>
                                                    <h3 class="product__list--items__content--title h4 mb-10"><a
                                                            href="{{ route('product.detail.page',['id'=>$product->id]) }}">{{
                                                            $product->name }}</a></h3>
                                                    <div class="product__list--items__price mb-10">
                                                        <span class="current__price">₹{{ $product->discounted_price
                                                            }}</span>
                                                        <span class="price__divided"></span>
                                                        <span class="old__price">₹{{ $product->price
                                                            }}</span>
                                                    </div>

                                                    <p
                                                        class="product__list--items__content--desc d-none d-xl-block mb-15">
                                                        {{ $product->about1 }}</p>
                                                    <ul class="product__items--action d-flex">
                                                        <li class="product__items--action__list">
                                                            <a class="product__items--action__btn"
                                                                href="{{ route('product.detail.page',['id'=>$product->id]) }}">
                                                                <svg class="product__items--action__btn--svg"
                                                                    xmlns="http://www.w3.org/2000/svg" width="22.51"
                                                                    height="20.443" viewBox="0 0 14.706 13.534">
                                                                    <g transform="translate(0 0)">
                                                                        <g>
                                                                            <path data-name="Path 16787"
                                                                                d="M4.738,472.271h7.814a.434.434,0,0,0,.414-.328l1.723-6.316a.466.466,0,0,0-.071-.4.424.424,0,0,0-.344-.179H3.745L3.437,463.6a.435.435,0,0,0-.421-.353H.431a.451.451,0,0,0,0,.9h2.24c.054.257,1.474,6.946,1.555,7.33a1.36,1.36,0,0,0-.779,1.242,1.326,1.326,0,0,0,1.293,1.354h7.812a.452.452,0,0,0,0-.9H4.74a.451.451,0,0,1,0-.9Zm8.966-6.317-1.477,5.414H5.085l-1.149-5.414Z"
                                                                                transform="translate(0 -463.248)"
                                                                                fill="currentColor"></path>
                                                                            <path data-name="Path 16788"
                                                                                d="M5.5,478.8a1.294,1.294,0,1,0,1.293-1.353A1.325,1.325,0,0,0,5.5,478.8Zm1.293-.451a.452.452,0,1,1-.431.451A.442.442,0,0,1,6.793,478.352Z"
                                                                                transform="translate(-1.191 -466.622)"
                                                                                fill="currentColor"></path>
                                                                            <path data-name="Path 16789"
                                                                                d="M13.273,478.8a1.294,1.294,0,1,0,1.293-1.353A1.325,1.325,0,0,0,13.273,478.8Zm1.293-.451a.452.452,0,1,1-.431.451A.442.442,0,0,1,14.566,478.352Z"
                                                                                transform="translate(-2.875 -466.622)"
                                                                                fill="currentColor"></path>
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                                <span class="add__to--cart__text">Buy Now</span>
                                                            </a>
                                                        </li>
                                                        <li class="product__items--action__list">
                                                            <a class="product__items--action__btn" href="wishlist.html">
                                                                <svg class="product__items--action__btn--svg"
                                                                    xmlns="http://www.w3.org/2000/svg" width="25.51"
                                                                    height="23.443" viewBox="0 0 512 512">
                                                                    <path
                                                                        d="M352.92 80C288 80 256 144 256 144s-32-64-96.92-64c-52.76 0-94.54 44.14-95.08 96.81-1.1 109.33 86.73 187.08 183 252.42a16 16 0 0018 0c96.26-65.34 184.09-143.09 183-252.42-.54-52.67-42.32-96.81-95.08-96.81z"
                                                                        fill="none" stroke="currentColor"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="32"></path>
                                                                </svg>
                                                                <span class="visually-hidden">Wishlist</span>
                                                            </a>
                                                        </li>
                                                        <li class="product__items--action__list">
                                                            <a class="product__items--action__btn" data-open="modal1"
                                                                href="javascript:void(0)">
                                                                <svg class="product__items--action__btn--svg"
                                                                    xmlns="http://www.w3.org/2000/svg" width="25.51"
                                                                    height="23.443" viewBox="0 0 512 512">
                                                                    <path
                                                                        d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z"
                                                                        fill="none" stroke="currentColor"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="32" />
                                                                    <circle cx="256" cy="256" r="80" fill="none"
                                                                        stroke="currentColor" stroke-miterlimit="10"
                                                                        stroke-width="32" />
                                                                </svg>
                                                                <span class="visually-hidden">Quick View</span>
                                                            </a>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End shop section -->

    <!-- Start shipping section -->
    <section class="shipping__section2 shipping__style3 section--padding pt-0">
        <div class="container">
            <div class="shipping__section2--inner shipping__style3--inner d-flex justify-content-between">
                <div class="shipping__items2 d-flex align-items-center">
                    <div class="shipping__items2--icon">
                        <img src="assets/img/other/shipping1.png" alt="">
                    </div>
                    <div class="shipping__items2--content">
                        <h2 class="shipping__items2--content__title h3">Shipping</h2>
                        <p class="shipping__items2--content__desc">From handpicked sellers</p>
                    </div>
                </div>
                <div class="shipping__items2 d-flex align-items-center">
                    <div class="shipping__items2--icon">
                        <img src="assets/img/other/shipping2.png" alt="">
                    </div>
                    <div class="shipping__items2--content">
                        <h2 class="shipping__items2--content__title h3">Payment</h2>
                        <p class="shipping__items2--content__desc">From handpicked sellers</p>
                    </div>
                </div>
                <div class="shipping__items2 d-flex align-items-center">
                    <div class="shipping__items2--icon">
                        <img src="assets/img/other/shipping3.png" alt="">
                    </div>
                    <div class="shipping__items2--content">
                        <h2 class="shipping__items2--content__title h3">Return</h2>
                        <p class="shipping__items2--content__desc">From handpicked sellers</p>
                    </div>
                </div>
                <div class="shipping__items2 d-flex align-items-center">
                    <div class="shipping__items2--icon">
                        <img src="assets/img/other/shipping4.png" alt="">
                    </div>
                    <div class="shipping__items2--content">
                        <h2 class="shipping__items2--content__title h3">Support</h2>
                        <p class="shipping__items2--content__desc">From handpicked sellers</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End shipping section -->

</main>
@endsection
