@extends('layouts.header')
@section('content')
<div class="returns-and-refunds">
    <h1>Refund and Cancellation Policy</h1>

    <h2>Introduction</h2>
    <p>This refund and cancellation policy outlines how you can cancel or seek a refund for a product/service purchased through our Platform.</p>

    <h2>Cancellation Policy</h2>
    <p>Cancellations will only be considered if requested within 7 days of placing the order. However, if the order has already been communicated to sellers/merchants listed on the Platform and they have initiated shipping, or if the product is out for delivery, cancellation requests may not be entertained. In such a case, you may choose to reject the product upon delivery.</p>

    <p>If you have complaints regarding products with a manufacturer’s warranty, please refer the issue to them directly.</p>

    <p>In the case of any refunds approved by ARTHSUTRAM SOLUTION PRIVATE LIMITED, it will take 7 days for the refund to be processed.</p>

    <h2>Return Policy</h2>
    <p>We offer refunds/exchanges within the first 30 days from the date of purchase. If 30 days have passed, we will not offer a return, exchange, or refund of any kind.</p>

    <p>To be eligible for a return or exchange, the purchased item must:</p>
    <ul>
        <li>* Be unused and in the same condition as received</li>
        <li>* Have its original packaging</li>
        <li>* Items purchased on sale may not be eligible for a return/exchange</li>
    </ul>

    <p>Only items found defective or damaged are eligible for replacement based on an exchange request.</p>
</div>


<style>
    .returns-and-refunds {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .returns-and-refunds h2 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .returns-and-refunds h3 {
        font-size: 20px;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .returns-and-refunds p {
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 20px;
    }
    .returns-and-refunds ul {
        list-style: disc;
        margin: 10px 0;
        padding-left: 10px;
        color: black;
    }

    .returns-and-refunds li {
        margin-bottom: 10px;
    }

    /* Media Query for Mobile */
    @media (max-width: 600px) {
        .returns-and-refunds {
            padding: 10px;
        }

        .returns-and-refunds h2 {
            font-size: 20px;
        }

        .returns-and-refunds h3 {
            font-size: 18px;
        }

        .returns-and-refunds p {
            font-size: 14px;
            line-height: 1.5;
        }
    }
</style>
@endsection
