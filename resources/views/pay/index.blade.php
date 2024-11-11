<!DOCTYPE html>
<html>

<head>
    <title>Pay with Razorpay</title>
</head>

<script>
    function checkFieldsAndSubmit() {
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const contact = document.getElementById('contact').value.trim();

        // Check if all fields are filled
        if (name && email && contact) {
            // payButton.click();
        }
    }

    // Attach event listeners to detect when the user has filled in the fields
    window.onload = function() {
        const inputs = document.querySelectorAll('input[required]');
        inputs.forEach(input => {
            input.addEventListener('input', checkFieldsAndSubmit);
        });
    };
    const payButton = document.getElementById('submit');
    payButton.click();
</script>

<body>
    @php
        if (!isset($name)) {
            $name = '';
        }
        if (!isset($email)) {
            $email = '';
        }
        if (!isset($contact)) {
            $contact = '';
        }
        if (!isset($amount)) {
            $amount = '';
        }
    @endphp
    <h1>Redirect To Payment Page </h1>
    <form action="{{ route('pay.createOrder') }}" method="POST">
        @csrf
        <input type="text" id="name" name="name" value="{{ $name }}" placeholder="Enter your name"
            required>
        <input type="email" id="email" name="email" value="{{ $email }}" placeholder="Enter your email"
            required>
        <input type="number" id="amount" name="amount" value="{{ $amount }}" placeholder="Enter your email"
            required>
        <input type="text" name="contact" value="{{ $contact }}" placeholder="Enter your contact number"
            required>
        <button type="submit" id="submit">Pay Now</button>
    </form>
    @if (Session::has('success'))
        <p style="color: green;">{{ Session::get('success') }}</p>
    @endif
    @if (Session::has('error'))
        <p style="color: red;">{{ Session::get('error') }}</p>
    @endif
</body>

</html>
