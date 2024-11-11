@extends('layouts.header')

@section('content')

<main class="main__content_wrapper">

    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">Order View</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items"><a class="text-white"
                                    href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb__content--menu__items"><span class="text-white">Order View</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- Start login section  -->
    <div class="login__section section--padding">
        <div class="container">
            <form action="#">
                <div class="login__section--inner">
                    <div class="row row-cols-md-12 row-cols-1">

                        <div class="col">
                            <div class="table-responsive-md">

                                <table class="table table-striped p-4 mt-4">
                                    {{-- <h6 class="display-6">Order Detail</h6> --}}
                                    <tbody>
                                        <tr>
                                            <th scope="row">Order ID</th>
                                            <td>{{ $order->order_num }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Total Price</th>
                                            <td>Rs. {{ $order->price_after_coupon }}</td>
                                        </tr>
                                        <tr>
                                            @if($order->order_status == 'delivered' || $order->order_status ==
                                            'cancelled')
                                            <th scope="row">Estimate Date</th>
                                            <td>{{"N/A" }}</td>
                                            @else
                                            <th scope="row">Estimate Date</th>
                                            <td>{{ $order->estimate_date }}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Order Status</th>
                                            <td class="text-danger">{{ $order->order_status }} @if ($order->cancelled_by_admin)
                                                {{ "by ".$order->cancelled_by }} {{ $order->cancelled_remark }}
                                            @endif</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Created Order</th>
                                            <td>{{ \Carbon\Carbon::parse( $order->created_at)->format('h:i:s A d-m-Y')
                                                }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Updated Order</th>
                                            <td>{{ \Carbon\Carbon::parse($order->updated_at)->format('h:i:s A d-m-Y') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="cr-cart-content" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="400">
                        <div class="row">
                            <form action="#">
                                <div class="cr-table-content">
                                    <table class="account__table">
                                        <thead class="account__table--header">
                                            <tr>
                                                <th class="account__table--header__child--items">Sr.</th>
                                                <th class="account__table--header__child--items">Photo</th>
                                                <th class="account__table--header__child--items">Name</th>
                                                <th class="account__table--header__child--items">Original Price</th>
                                                <th class="account__table--header__child--items">Discounted Price</th>
                                                <th class="account__table--header__child--items">Item Count</th>
                                                <th class="account__table--header__child--items">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody class="account__table--body mobile__none">
                                            @php
                                            $i=0;
                                            @endphp
                                            @foreach ($items as $item )
                                            @php
                                            $i++;
                                            @endphp
                                            <tr class="account__table--body__child">
                                                <td class="account__table--body__child--items">{{ $i }}</td>
                                                <td class="account__table--body__child--items">
                                                    <div class="user-icon">
                                                        <img src="{{ asset('uploads/Products Images/'.$item->product->image) }}"
                                                            style="height: 50px; width: 50px;">
                                                    </div>
                                                </td>
                                                <td class="account__table--body__child--items">
                                                    @if ($item->product->name)
                                                    {{ $item->product->name ?? 'N/A' }}
                                                    @else
                                                    N/A
                                                    @endif
                                                </td>
                                                <td class="account__table--body__child--items">
                                                    @if ($item->original_price)
                                                    ₹ {{ $item->original_price ?? 'N/A' }}
                                                    @else
                                                    N/A
                                                    @endif
                                                </td>
                                                <td class="account__table--body__child--items">
                                                    @if ($item->discounted_price)
                                                    ₹ {{ $item->discounted_price ?? 'N/A' }}
                                                    @else
                                                    N/A
                                                    @endif
                                                </td>
                                                <td class="account__table--body__child--items">
                                                    @if ($item->item_count)
                                                    {{ $item->item_count ?? 'N/A' }}
                                                    @else
                                                    N/A
                                                    @endif
                                                </td>
                                                <td class="account__table--body__child--items">
                                                    @if ($item->total_price)
                                                    ₹ {{ $item->total_price ?? 'N/A' }}
                                                    @else
                                                    N/A
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                            @foreach ($items as $item )
                                            @php
                                            $i++;
                                            @endphp

                                        <tbody class="account__table--body mobile__block mt-4 border border-light p-4">

                                            <tr class="account__table--body__child">
                                                <td class="account__table--body__child--items">
                                                    <strong>Sr. No.</strong>
                                                    <span>{{ $i }}</span>
                                                </td>
                                                <td class="account__table--body__child--items">
                                                    <strong>Photo</strong>
                                                    <span>
                                                        <div class="user-icon">
                                                            <img src="{{ asset('uploads/Products Images/'.$item->product->image) }}"
                                                                style="height: 50px; width: 50px;">
                                                        </div>
                                                    </span>
                                                </td>
                                                <td class="account__table--body__child--items">
                                                    <strong>Name</strong>
                                                    <span>@if ($item->product->name)
                                                        {{ $item->product->name ?? 'N/A' }}
                                                        @else
                                                        N/A
                                                        @endif</span>
                                                </td>
                                                <td class="account__table--body__child--items">
                                                    <strong>Original Price</strong>
                                                    <span> @if ($item->original_price)
                                                        ₹ {{ $item->original_price ?? 'N/A' }}
                                                        @else
                                                        N/A
                                                        @endif</span>
                                                </td>
                                                <td class="account__table--body__child--items">
                                                    <strong>Discounted Price</strong>
                                                    <span>@if ($item->discounted_price)
                                                        ₹ {{ $item->discounted_price ?? 'N/A' }}
                                                        @else
                                                        N/A
                                                        @endif</span>
                                                </td>
                                                <td class="account__table--body__child--items">
                                                    <strong>Item Count</strong>
                                                    <span> @if ($item->item_count)
                                                        {{ $item->item_count ?? 'N/A' }}
                                                        @else
                                                        N/A
                                                        @endif</span>
                                                </td>
                                                <td class="account__table--body__child--items">
                                                    <strong>Total Price</strong>
                                                    <span> @if ($item->total_price)
                                                        ₹ {{ $item->total_price ?? 'N/A' }}
                                                        @else
                                                        N/A
                                                        @endif</span>
                                                </td>

                                            </tr>

                                        </tbody>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-4 p-4">
            <div class="row">
                <div class="col-12">
                    <div class="cr-cart-content" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="400">
                        <div class="row">

                            <div class="cr-table-content">
                                <style>
                                    table {
                                        width: 100%;
                                        border-collapse: collapse;
                                    }

                                    table,
                                    th,
                                    td {
                                        border: 1px solid black;
                                    }

                                    .th,
                                    td {
                                        padding: 8px;
                                        text-align: left;
                                    }
                                </style>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Payment Information</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>{{ "Payment Method" }}</td>
                                            <td>{{ $order->payment_method }}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ "Payment Status" }}</td>
                                            <td>{{ $order->payment_status }}</td>
                                        </tr>



                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End login section  -->



</main>







@endsection
