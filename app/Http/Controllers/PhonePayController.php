<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class PhonePayController extends Controller
{
    public function phonepay(Request $request, $orderID, $amount)
    {

        $redirectUrl = route('phonepay.response', ['orderID' => $orderID]);

        // dd($orderID,$amount);
        $amount = $request->amount;
        if ($amount == null) {
            return redirect()->back()->with('error', 'Please enter amount');
        }
        $data = [
            "merchantId" => "PGTESTPAYUAT86",
            "merchantTransactionId" => "MT7850590068188104",
            "merchantUserId" => "MUID123",
            "amount" => $amount * 100,
            "redirectUrl" => $redirectUrl,
            "redirectMode" => "REDIRECT",
            "callbackUrl" => $redirectUrl,
            "mobileNumber" => "9999999999",
            "paymentInstrument" => [
                "type" => "PAY_PAGE"
            ]
        ];
        $encode = base64_encode(json_encode($data));

        $saltKey = '96434309-7796-489d-8924-ab56988a6076';
        $saltIndex = 1;

        $string = $encode . '/pg/v1/pay' . $saltKey;
        $sha256 = hash('sha256', $string);

        $finalXHeader = $sha256 . '###' . $saltIndex;
        $response = Curl::to('https://api-preprod.phonepe.com/apis/merchant-simulator/pg/v1/pay')
            ->withHeader('Content-Type:application/json')
            ->withHeader('X-VERIFY:' . $finalXHeader)
            ->withData(json_encode(['request' => $encode]))
            ->post();
        $rData = json_decode($response);
        session()->put('phonepe_response', $rData);

        // dd($rData);
        // dd($response);
        return redirect()->to($rData->data->instrumentResponse->redirectInfo->url);


    }
    public function phonepay_response(Request $request, $orderID)
    {
        // Retrieve data from session
        $session = session()->get('phonepe_response');
        $merchantId = $session->data->merchantId;
        $transactionId = $session->data->merchantTransactionId;
        $saltKey = '96434309-7796-489d-8924-ab56988a6076';
        $saltIndex = 1;

        // Calculate X-VERIFY header
        $finalXHeader = hash('sha256', '/pg/v1/status/' . $merchantId . '/' . $transactionId . $saltKey) . '###' . $saltIndex;



        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://api-preprod.phonepe.com/apis/merchant-simulator/pg/v1/status/' . $merchantId . '/' . $transactionId,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'accept: application/json',
                    'X-VERIFY: ' . $finalXHeader,
                    'X-MERCHANT-ID: ' . $transactionId
                ),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);

        $array = json_decode($response, true);
        // $response = json_decode($response);
        // $array = $response->json();
        if (isset($array)) {
            $merchantId=$array['data']['merchantId'];
            $merchantTransactionId=$array['data']['merchantTransactionId'];
            $transactionId = $array['data']['transactionId'];
            $amount = $array['data']['amount'];
            $state = $array['data']['state'];
            $responseCode= $array['data']['responseCode'];
            $paymentInstrument = $array['data']['paymentInstrument']['type'];
            $pgTransactionId=$array['data']['paymentInstrument']['pgTransactionId'];
            // $pgServiceTransactionId=$array['data']['paymentInstrument']['pgServiceTransactionId'];
            $bankTransactionId=$array['data']['paymentInstrument']['bankTransactionId'];
            $bankId=$array['data']['paymentInstrument']['bankId'];
            $arn=$array['data']['paymentInstrument']['arn'];
            $orderID=base64_decode($orderID);

            $order=OrderModel::findOrFail($orderID);
            $order->update([
                'payment_status'=>$state,
                'payment_info'=>$response,
            ]);
            $orderID=base64_encode($orderID);
            return redirect()->route('thankyou',['order_id'=>$orderID]);
        }
        // flash(translate('Your order has been placed successfully. Please submit payment information from purchase history'))->success();
        // return redirect()->route('order_confirmed');
    }


    public function refundProcess($tra_id)
    {
        $payload = [
            'merchantId' => 'MERCHANTUAT',
            'merchantUserId' => 'MUID123',
            'merchantTransactionId' => ($tra_id),
            'originalTransactionId' => strrev($tra_id),
            'amount' => 5000,
            'callbackUrl' => route('response'),
        ];

        $encode = base64_encode(json_encode($payload));

        $saltKey = '96434309-7796-489d-8924-ab56988a6076';
        $saltIndex = 1;

        $string = $encode . '/pg/v1/refund' . $saltKey;
        $sha256 = hash('sha256', $string);

        $finalXHeader = $sha256 . '###' . $saltIndex;

        $response = Curl::to('https://api-preprod.phonepe.com/apis/merchant-simulator/pg/v1/refund')
            ->withHeader('Content-Type:application/json')
            ->withHeader('X-VERIFY:' . $finalXHeader)
            ->withData(json_encode(['request' => $encode]))
            ->post();

        $rData = json_decode($response);



        $finalXHeader1 = hash('sha256', '/pg/v1/status/' . 'MERCHANTUAT' . '/' . $tra_id . $saltKey) . '###' . $saltIndex;

        $responsestatus = Curl::to('https://api-preprod.phonepe.com/apis/merchant-simulator/pg/v1/status/' . 'MERCHANTUAT' . '/' . $tra_id)
            ->withHeader('Content-Type:application/json')
            ->withHeader('accept:application/json')
            ->withHeader('X-VERIFY:' . $finalXHeader1)
            ->withHeader('X-MERCHANT-ID:' . $tra_id)
            ->get();

        dd(json_decode($response), json_decode($responsestatus));
        // dd($rData);
    }
}
