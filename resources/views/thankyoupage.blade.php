@extends('layouts.header')
@section('content')
    <style>
        @media only screen and (min-width: 1360px) {
            .cd__main {
                max-width: 1280px;
                margin-left: auto;
                margin-right: auto;
                padding: 24px;
            }
        }
    </style>
    @if (session('alert'))
        <script>
            window.onload = function() {
                alert("Thank you for placing the order.");
                // Remove the 'alert' session variable after displaying the alert
                {!! json_encode(session()->forget('alert')) !!};
            };
        </script>
    @endif

    <style>
        #gifDiv {
            /* border: 1px solid red; */
            /* position: relative; */
            height: 70px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .checkout__submission--icon {
            position: relative;
            /* left: 45%; */
            /* margin-top: -50px; */
            width: 4rem;
            height: 4rem;
            border: 2px solid var(--secondary-color);
            border-radius: 50%;
            text-align: center;
            line-height: 3.5rem;
            /* z-index: 10000000; */
        }
    </style>


    <div class="container mt-4 mb-4 p-2">
        <div class="jumbotron text-center">
            <div class="container " id="gifDiv">
                <div class="checkout__submission--icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28.995" height="28.979" viewBox="0 0 512 512">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="32" d="M416 128L192 384l-96-96"></path>
                    </svg>
                </div>
            </div>




            <h2 class="display-5">Hello {{ Auth::user()->username }}</h2>
            @if (isset($payment_received_status))
                @if ($payment_received_status)
                    <div>
                        <h5>Thank you for your payment!</h5>
                        <p>Your payment has been successfully received.</p>
                    </div>
                @else
                    <div>
                        <h5>Payment Pending</h5>
                        <p>Your payment has not been received yet. Please check your payment status later.</p>
                    </div>
                @endif
            @else
            @endif
            @if (Session::has('success'))
                <p class="lead"><strong>Thank you for placing the order.</strong>We will keep you informed.</p>
                <p class="" style="color: var(--secondary-color);">Expected delivery within 5 days.</p>
                <p>Your order ID is : <b style="color: var(--secondary-color);">{{ $order_id }}</b></p>
            @endif
            @if (Session::has('error'))
                <p class="lead"><strong>Payment is not done, if your payment is Deducted please conatct us</p>
            @endif
            @if (!Session::has('success'))
                <p class="lead"><strong>Thank you for placing the order.</strong>We will keep you informed.</p>
                <p class="" style="color: var(--secondary-color);">Expected delivery within 5 days.</p>
                <p>Your order ID is : <b style="color: var(--secondary-color);">{{ $order_id }}</b></p>
            @endif


            <hr>
            <p>
                Having trouble? <a href="{{ route('contact.page') }}">Contact us</a>
            </p>
            <p class="lead mt-2">
                <a class="continue__shipping--btn primary__btn border-radius-5 " href="{{ route('home') }}"
                    role="button">Continue Shopping</a>
            </p>
        </div>
    </div>
@endsection
