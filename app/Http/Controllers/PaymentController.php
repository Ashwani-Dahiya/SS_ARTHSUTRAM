<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{

    private $razorpayId = "rzp_live_W4bZvunU9ojQmd";
    private $razorpayKey = "ttyzW9V1lkdu9OaHVgkke12Y";

    public function __construct()
    {
        // $this->razorpayId =  config('services.razorpay.key');
        // $this->razorpayKey = config('services.razorpay.secret');
    }

    public function index(Request $request)
    {
        $name = $request->first_name . ' ' . $request->last_name;
        $email = $request->email;
        $contact = $request->phone;
        $amount = $request->amount;
        return view('pay.index', compact('name', 'email', 'contact', 'amount'));
    }

    public function createOrder(Request $request)
    {
        $api = new Api($this->razorpayId, $this->razorpayKey);
        // dd($this->razorpayId, $this->razorpayKey);
        $orderData = [
            'receipt'         => $request->order_id,
            'amount'          => (string)($request->amount * 100), // amount in the smallest currency unit (paise)
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];

        $razorpayOrder = $api->order->create($orderData);
        $order_id = $razorpayOrder['id'];

        $data = [
            "key"               => $this->razorpayId,
            "amount"            => $orderData['amount'],
            "name"              => "SHUBHZZ PAYMENT TECHNOLOGIES PRIVATE LIMITED",
            "description"       => $razorpayOrder['receipt'],
            "prefill"           => [
                "name"              => $request->name,
                "email"             => $request->email,
                "contact"           => $request->contact,
            ],
            "order_id"          => $order_id,
        ];

        return view('pay.checkout', compact('data'));
    }

    public function capturePayment(Request $request)
    {
        $api = new Api($this->razorpayId, $this->razorpayKey);

        $payment = $api->payment->fetch($request->razorpay_payment_id);

        // echo "Error Code Full " . (isset($payment['error_code']) && $payment['error_code'] == null) . "---";
        // echo "Error Code null " . ($payment['error_code'] == null) . "---";
        // echo "Error Code isset " . (isset($payment['error_code'])) . "---";
        // dd($payment);
        $order_id = "";
        if ($payment['error_code'] == null) {
            // Payment was successful, capture the payment

            $order_id = $payment['order_id'];
            // Handle post-payment logic here
            Session::flash('success', 'Payment captured successfully');
            Session::flash('order_id', $payment['description']);
        } else {
            Session::flash('error', 'Payment failed. Please try again.');
        }
        return  redirect()->route('thankyou', ['order_id' =>  $order_id]);
        // return redirect()->route('pay.index');
    }
}
