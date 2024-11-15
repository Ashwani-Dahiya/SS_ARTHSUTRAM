@extends('layouts.header')
@section('content')
<style>
    .shipping-policy {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
    }

    .shipping-policy h2 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .shipping-policy h3 {
        font-size: 20px;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .shipping-policy p {
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 20px;
    }
    .shipping-policy ul {
        list-style: disc;
        margin: 10px 0;
        padding-left: 10px;
        color: black;
    }

    .shipping-policy li {
        margin-bottom: 10px;
    }
    /* Media Query for Mobile */
    @media (max-width: 600px) {
        .shipping-policy {
            padding: 10px;
        }
        .shipping-policy h2 {
            font-size: 20px;
        }
        .shipping-policy h3 {
            font-size: 18px;
        }
        .shipping-policy p {
            font-size: 14px;
            line-height: 1.5;
        }
    }
</style>
<div class="shipping-policy">
    <h1>Shipping Policy</h1>

    <p>Our orders are shipped through registered domestic courier companies and/or speed post services only. Orders are typically shipped within 7 days from the date of order and/or payment, or as per the agreed delivery date confirmed at the time of order. Shipment timelines are subject to the courier company or post office regulations.</p>

    <p>The Platform Owner shall not be liable for any delays in delivery caused by the courier company or postal authority.</p>

    <ul>
        <li>* All orders will be delivered to the address provided by the buyer at the time of purchase.</li>
        <li>* Delivery of services will be confirmed via the email ID specified at registration.</li>
        <li>* Any shipping costs levied by the seller or the Platform Owner, if applicable, are non-refundable.</li>
    </ul>
</div>
@endsection
