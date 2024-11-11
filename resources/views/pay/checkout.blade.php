<!DOCTYPE html>
<html>

<head>
    <title>Razorpay Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>

<body>
    <h1>Complete your payment</h1>
    <form action="{{ route('pay.capturePayment') }}" method="POST">
        @csrf
        <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ $data['key'] }}"
            data-amount="{{ $data['amount'] }}" data-currency="INR" data-order_id="{{ $data['order_id'] }}"
            data-buttontext="Pay with Razorpay" data-name="{{ $data['name'] }}" data-description="{{ $data['description'] }}"
            data-prefill.name="{{ $data['prefill']['name'] }}" data-prefill.email="{{ $data['prefill']['email'] }}"
            data-prefill.contact="{{ $data['prefill']['contact'] }}" data-theme.color="#F37254"></script>
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    </form>
</body>

</html>
