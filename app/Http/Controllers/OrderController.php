<?php

namespace App\Http\Controllers;

use App\Models\AddressModel;
use App\Models\BrandModel;
use App\Models\CartModel;
use App\Models\CategorieModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\ReasonModel;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Log;
use App\Models\CompanyDetailsModel;
use App\Mail\SendNewsletterSubscriptionEmail;
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\DiscountModel;
use App\Models\NewsletterModel;
use Illuminate\Http\JsonResponse;
use Razorpay\Api\Api;
use ReflectionClass;

class OrderController extends Controller
{
    private $key = 'rzp_live_W4bZvunU9ojQmd';
    private $secret = 'ttyzW9V1lkdu9OaHVgkke12Y';
    private $clientId = "ee4a4fc2-0617-4b81-b85b-c24ee1bdac46";
    private $secretKey = "dcd0aa05-8374-4946-9a4b-de563735732c";
    private $samaypeKey =  'Authorization: Bearer RvsDLwFHpgZbxYAWd-YC_DYEei8gVqLZQehdNPRMWtHMwMUFYRGHNBnExNzwvGMNVudFbns';
    public function order_page()
    {
        $user = auth()->user();
        $orders = OrderModel::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        $reasons = ReasonModel::all();
        return view('myorders', compact('orders', 'reasons'));
    }

    public function store(Request $request): JsonResponse
    {
        // return response()->json(['success' => false, 'error' => 'test'], 200);

        // dd($request);
        // return response()->json(['success' => false, 'data' => $request->phone, 'error' => 'test 2'], 200);
        try {

            $paymentResponse = $request->input('response', []);
            if (count($paymentResponse) > 0 && empty($paymentResponse['razorpay_payment_id'])) {
                return response()->json(['success' => false, 'msg' => "Payment id not found"], 200);
            }

            $api = new Api($this->key, $this->secret);

            // Fetch the payment details using Razorpay Payment ID
            $payment = $api->payment->fetch($paymentResponse['razorpay_payment_id']);
            $order = OrderModel::where('order_num', $paymentResponse['order_id'])->first();
            // Check if the payment has already been captured

            if ($order) {
                if ($payment['status'] !== 'captured') {
                    // If not captured, proceed to capture the payment

                    $response = $payment->capture(['amount' => $payment['amount']]);
                    // Handle successful capture here, e.g., updating order status

                    $reflector = new ReflectionClass($response);
                    $properties = $reflector->getProperties();

                    $responseArray = [];
                    foreach ($properties as $property) {
                        $property->setAccessible(true);
                        $responseArray[$property->getName()] = $property->getValue($response);
                    }

                    // Convert the array to JSON if needed
                    $responseJson = json_encode($responseArray);



                    $order->update([
                        "payment_info" => $responseJson,
                        "payment_status" => "COMPLETED"
                    ]);
                } else {
                    // Handle case where payment is already captured
                    // Perhaps log this info or notify the user that payment was already captured
                    // Update order status or any necessary actions if needed

                    $reflector = new ReflectionClass($payment);
                    $properties = $reflector->getProperties();

                    $paymentArray = [];
                    foreach ($properties as $property) {
                        $property->setAccessible(true);
                        $paymentArray[$property->getName()] = $property->getValue($payment);
                    }

                    $paymentJson = json_encode($paymentArray);


                    $order->update([
                        "payment_info" => $paymentJson,
                        "payment_status" => "COMPLETED"
                    ]);
                }
            } else {
                return response()->json(['success' => false, 'msg' => "order bot found"], 200);
            }

            return response()->json(['success' => true, 'msg' => "success " . $paymentResponse['razorpay_payment_id'] . " PAyment " . $payment['status']], 200);


            // if ($order) {
            //     // Update the payment information and status
            //     $order->update([
            //         "payment_info" => json_encode($response), // Assuming $response is an array or object, encode it as JSON
            //         "payment_status" => "COMPLETED"
            //     ]);
            // } else {
            //     // Handle the case where the order was not found
            //     return response()->json(['success' => false, 'error' => "Order id not found"], 200);
            // }
        } catch (\Throwable $th) {

            // dd($request->total_price);
            return response()->json(['success' => false, 'error' => "Internal Server Error  $th"], 200);
        }
    }
    public function createOrder(Request $request): JsonResponse
    {
        // return response()->json(['success' => false, 'error' => 'test'], 200);

        // dd($request);
        // return response()->json(['success' => false, 'data' => $request->phone, 'error' => 'test 2'], 200);
        try {

            if ($request->price_after_coupan) {
                $offer = DiscountModel::where('coupon_code', $request->code)->first();
                $offerName = $offer->on_festival_name;
                $offerPercentage = $offer->discount_percentage;
                $offerCode = $offer->coupon_code;
                $priceAfterCode = $request->price_after_coupan;
            } else {
                $offerName = NULL;
                $offerCode = NULL;
                $offerPercentage = NULL;
                $priceAfterCode = $request->total_price;
            }

            // echo "online_online";
            $paymethod = "online";
            $paystatus = "pending";



            // return response()->json(['success' => false, 'data' => $request->phone, 'error' => 'test 3'], 200);

            $productNames = [];
            $productQuantities = [];
            $city = CityModel::where('id', $request->city)->first();
            $cityName = $city->city;
            $state = StateModel::where('id', $request->state)->first();
            $stateName = $state->name;
            // dd($cityName,$stateName);
            $address = [
                'name' => $request->first_name . ' ' . $request->last_name,
                'address_line1' => $request->address1,
                'address_line2' => $request->address2 ?? null,
                'city' => $cityName,
                'state' => $stateName,
                'pin' => $request->post_code,
                'country' => 'India',
            ];
            $vaild = validator($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'address1' => 'required',
                'city' => 'required',
                'state' => 'required',
                'post_code' => 'required'

            ]);

            if ($vaild) {
                $add = AddressModel::create([
                    'user_id' => Auth::user()->id,
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'address_line1' => $request->address1,
                    'address_line2' => $request->address2 ?? null,
                    'city' => $request->city,
                    'state' => $request->state,
                    'pin' => $request->post_code,
                    'country' => 'India',

                ]);
                if ($add) {
                    $addressId = AddressModel::latest()->first()->id;
                    $currentDateTime = Carbon::now();
                    $estimateDate = $currentDateTime->addDays(5)->toDateString();

                    // Create order number
                    $orderNumPrefix = "ORD0000";
                    $orderID = date('Ymdhis').rand(1000, 9999); // Get the max order ID and increment by 1
                    $orderNum = $orderNumPrefix . $orderID;
                    $server_order_id = "";
                    $intent = "";
                    if (isset($request->pay_QR_UPI)) {
                        $shubzzOrder =   $this->generateIntent($priceAfterCode, $orderNum, $request->phone, $request->first_name . ' ' . $request->last_name, $request->first_name . "@gmail.com");
                        $intent =   $shubzzOrder['intent'];
                        $server_order_id =   $shubzzOrder['server_order_id'];
                    }



                    // Create the order
                    $order = OrderModel::create([
                        'user_id' => Auth::user()->id,
                        'address_id' => $addressId,
                        'phone1' => $request->phone,
                        'phone2' => $request->phone,
                        'total_price' => $request->total_price,
                        'order_status' => 'pending',
                        'estimate_date' => $estimateDate,
                        'cancelled_by' => null,
                        'order_num' => $orderNum,
                        'coupon_name' => $offerName,
                        'discount_percentage' => $offerPercentage,
                        'price_after_coupon' => $priceAfterCode,
                        'coupon_code' => $offerCode,
                        'order_id' => $server_order_id,
                        'payment_method' => $paymethod,
                        'payment_status' => "pending",
                    ]);
                }
            }
            $newsAndOffers = $request->input('update');

            if ($order) {
                $cartItems = CartModel::where('user_id', Auth::user()->id)->get();
                foreach ($cartItems as $cartItem) {
                    $product = ProductModel::find($cartItem->product_id);

                    if ($product) {
                        $totalPrice = $request->total_price;
                        $productNames[] = $product->name;
                        $productQuantities[] = $cartItem->times;
                        $oneTotalPrice = $product->discounted_price * $cartItem->times;
                        $orderItem = OrderItemModel::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'original_price' => $product->price,
                            'discounted_price' => $product->discounted_price,
                            'item_count' => $cartItem->times,
                            'total_price' => $oneTotalPrice,
                            'offer_id' => 2,
                        ]);

                        if ($orderItem) {
                            CartModel::where('id', $cartItem->id)->delete();
                        }
                    }
                }
                session()->put('alert', 'thanks');
                $enCodeOrderId = base64_encode($order->id);
                $amount = $priceAfterCode;


                if (isset($request->pay_QR_UPI)) {

                    return response()->json(
                        [
                            'success' => true,
                            'msg' => 'Order created',
                            "order_id" => $orderNum,
                            'enc' => $enCodeOrderId,
                            'enc_amount' => $amount,
                            'server_order_id' => $server_order_id,
                            'intent' => $intent
                        ]
                    );
                }



                return response()->json(['success' => true, 'msg' => 'Order created', "order_id" => $orderNum, 'enc' => $enCodeOrderId, 'enc_amount' => $amount]);





                // return redirect()->route('thankyou', ['order_id' => $enCodeOrderId]);
            } else {
                // Handle the case where order creation fails
                return response()->json(['success' => false, 'msg' => 'Order Not Crated']);
                // return redirect()->route('home')->with('error', 'Failed to create order.');
            }
        } catch (\Throwable $th) {

            // dd($request->total_price);
            return response()->json(['success' => false, 'msg' => "Internal Server Error Total Price" . $request->total_price . "====  $th"], 200);
        }
    }

    // public function failure(Request $request): JsonResponse
    // {
    //     // DB::beginTransaction();

    //     try {
    //         $responseData = $request->input('response', []);
    //         $errorData = $responseData['error'] ?? [];
    //         dd($request);
    //         // Payment::create([
    //         //     'r_payment_id' => $errorData['metadata']['payment_id'] ?? null,
    //         //     'method' => $errorData['source'] ?? null,
    //         //     'currency' => 'INR',
    //         //     'email' => '', //email id for the the user
    //         //     'phone' => '', // mobile number for the user,
    //         //     'amount' => 100, // amount for the payment process
    //         //     'status' => 'failed',
    //         //     'json_response' => json_encode($responseData)
    //         // ]);

    //         // DB::commit();
    //         return response()->json(['success' => true, 'message' => 'Payment failure recorded']);
    //     } catch (\Throwable $th) {
    //         // DB::rollBack();
    //         // Log::error('PAYMENT_FAILURE_ERROR: '.$th->getMessage());
    //         return response()->json(['success' => false, 'error' => 'Internal Server Error'], 500);
    //     }
    // }


    public function generateIntent($payment_amount, $order_id, $phone, $name, $email)
    {


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.skpays.com/kuber/v1/payment/deep-link',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                    "amount": ' . $payment_amount . ',
                    "order_id": "' . $order_id . '"
                }',
            CURLOPT_HTTPHEADER => array(
                $this->samaypeKey,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $data =  json_decode($response, true);
        $orderId = $data['data']['payment_id'];
        $intent = $data['data']['deep_link'];






        $php_array['intent'] =   preg_replace('/tn=([^&]*)/', 'tn=' . $order_id, $intent);


        $php_array['order_id'] = $order_id;
        $php_array['server_order_id'] = $orderId;
        $php_array['status'] = true;

        // $response =json_encode($php_array);
        // response()->json($php_array);
        return  $php_array;





        // // URL for the first request
        // $url1 = "https://api.shubhzz-pay.com/api/api/api-module/payin/orders";

        // // Data for the first request
        // $data1 = json_encode([
        //     "clientId" => $this->clientId,
        //     "secretKey" => $this->secretKey,
        //     "name" => (string)$name,
        //     "mobileNo" => (string)$phone,
        //     "emailID" => (string)$email,
        //     "amount" => (string)$payment_amount,
        //     "clientOrderId" => $order_id
        // ]);

        // // Initialize cURL session
        // $ch1 = curl_init($url1);

        // // Set the cURL options
        // curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch1, CURLOPT_HTTPHEADER, [
        //     'Content-Type: application/json',
        //     'Accept: application/json'
        // ]);
        // curl_setopt($ch1, CURLOPT_POST, true);
        // curl_setopt($ch1, CURLOPT_POSTFIELDS, $data1);

        // // Execute the first request
        // $response1 = curl_exec($ch1);
        // $res_data['status'] = false;
        // // Check for errors
        // if (curl_errno($ch1)) {
        //     $res_data['msg'] = 'Error:' . curl_error($ch1);
        //     exit(json_encode($res_data));
        // } else {
        //     $result1 = json_decode($response1, true);
        //     $res_data['msg2'] = $response1;
        //     if (isset($result1['orderId'])) {
        //         $orderId = $result1['orderId'];
        //     } else {

        //         $res_data['msg'] = "Order id not created";
        //         exit(json_encode($res_data));
        //     }
        // }

        // // Close the cURL session
        // curl_close($ch1);





        // // URL for the second request
        // $url2 = "https://api.shubhzz-pay.com/api/api/api-module/payin/intent-initiate";

        // // Data for the second request, using the extracted orderId
        // $data2 = json_encode([
        //     "clientId" => $this->clientId,
        //     "secretKey" => $this->secretKey,
        //     "note" => "Playment Add",
        //     "orderId" => $orderId  // Use the extracted orderId here
        // ]);

        // // Initialize cURL session
        // $ch2 = curl_init($url2);

        // // Set the cURL options
        // curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch2, CURLOPT_HTTPHEADER, [
        //     'Content-Type: application/json',
        //     'Accept: application/json'
        // ]);
        // curl_setopt($ch2, CURLOPT_POST, true);
        // curl_setopt($ch2, CURLOPT_POSTFIELDS, $data2);

        // // Execute the second request
        // $response2 = curl_exec($ch2);

        // // Check for errors
        // if (curl_errno($ch2)) {
        //     $res_data['msg'] = 'Error:' . curl_error($ch2);
        //     exit(json_encode($res_data));
        // } else {
        //     $result2 = json_decode($response2, true);
        //     $res_data['msg3'] = $response2;
        //     if (isset($result2['upiurl'])) {
        //         $intent =  $result2['upiurl'];
        //     } else {
        //         $res_data['msg'] = "Intent Not Created";
        //         exit(json_encode($res_data));
        //     }
        // }

        // // Close the cURL session
        // curl_close($ch2);


        // if (!isset($intent)) {
        //     $res_data['msg'] = "Intent Not Created 2";
        //     exit(json_encode($res_data));
        // }



        // $php_array = [];








        // $php_array['intent'] =   preg_replace('/tn=([^&]*)/', 'tn=' . $order_id, $intent);


        // $php_array['order_id'] = $order_id;
        // $php_array['server_order_id'] = $orderId;
        // $php_array['status'] = true;

        // // $response =json_encode($php_array);
        // // response()->json($php_array);
        // return  $php_array;
    }

    public function check_order_status($order_id): JsonResponse
    {


        $orderModel =   OrderModel::where("order_num", $order_id)->first();

        $created_at =   $orderModel->created_at;
        if ($orderModel->payment_status == "COMPLETED") {
            $json['status'] = true;
            $json['payment_received_status'] = true;
            $json['payment_status'] = "success";
            $json['massage'] = "Add Point Success";
            return response()->json($json);
        }

        $mydata['status'] = false;
        $php_array = [];
        $php_array['status'] = false;

        // Skpays status

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.skpays.com/kuber/v1/payment/' . $orderModel->order_id . '/status',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                $this->samaypeKey
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $result2 =  $php_array =  json_decode($response, true);

        if ($php_array['status_code'] == 0) {
            $data = $php_array['data'];
            $payment_status = $data['status'] == "payment_generated" || $data['status'] == "payment_attempted" ? 'pending' : $data['status'];

            $transaction_id = "";
            if ($data['status'] == "payment_completed" || $data['status'] == "completed" || $data['status'] == "success") {


                $utr =  $data['payee']['rrn'] ?? "";
                $payment_date = $created_at;
                $transaction_id = $data['payee']['upi_txn_id'];
                $order = OrderModel::where("order_num", $order_id)->first(); // Fetch the order by ID

                if ($order) {


                    // Update the updated_at field (Laravel automatically does this on save)
                    $order->updated_at = now();
                    $order->payment_info = $response;

                    $order->payment_status = "COMPLETED";


                    // Save the changes
                    $order->save();
                }

                $json['status'] = true;
                $json['payment_received_status'] = true;
                $json['payment_status'] = "success";
                $json['massage'] = "Add Point Success";
                return response()->json($json);
            } else {
                $status_update = "";
                if (isset($payment_status)) {
                    $status = $payment_status;
                    $status_update = ",status='$status'";
                }

                if ($result2['data']['status'] == "payment_failed" || $result2['data']['status'] == "failed") {
                    $status = $payment_status = "failed";
                    $status_update = ",status='$status'";
                } else if ($result2['data']['status'] == "payment_expired" || $result2['data']['status'] == "expired" || $result2['data']['status'] == "payment_timeout" || $result2['data']['status'] == "timeout") {
                    $status = $payment_status = ($result2['data']['status'] == "payment_timeout" || $result2['data']['status'] == "timeout") ? "timeout" : "NOT_ATTEMPTED";


                    $status_update = ",status='$status'";
                }


                $order = OrderModel::find($order_id); // Fetch the order by ID

                if ($order) {
                    // Invert the payment_status value
                    $order->payment_status = !$order->payment_status;

                    // Update the updated_at field (Laravel automatically does this on save)
                    $order->updated_at = now();

                    // Update a JSON column (e.g., extra_data)
                    $order->extra_data = json_encode([
                        'payment_status' => $payment_status,
                        'payment_info' => $response,
                        // Add more key-value pairs as needed
                    ]);

                    // Save the changes
                    $order->save();
                }



                $json['status'] = true;
                $json['payment_received_status'] = false;
                $json['payment_status'] = "pending";
                $json['massage'] = "Please Wait we are verify you payment";


                //   Payment Notification on failed
                if (isset($payment_status) && (strtolower($payment_status) == "cancelled" || strtolower($payment_status) == "failed")) {
                    $json['payment_status'] = $payment_status;
                    $json['massage'] = "Payment Failed";
                }
                //   Payment Notification on failed

                //   echo $response;
                return response()->json($json);
                // return json_encode($json);
                // exit;
            }

            $json['status'] = true;
            $json['payment_received_status'] = false;
            $json['payment_status'] = "pending";
            $json['massage'] = "We are verify you payment please wait";
            return response()->json($json);
        } else {
            $json['status'] = true;
            $json['payment_status'] = "pending";
            $json['payment_received_status'] = false;
            $json['massage'] = "Please wait for payment verification";
            return response()->json($json);
        }



        // Skpays status End




        // URL for the request
        $url = "https://api.shubhzz-pay.com/api/api/api-module/payin/order-status";

        // Data for the request
        $data = json_encode([
            "clientId" => $this->clientId,
            "secretKey" => $this->secretKey,
            "orderId" => $orderModel->order_id
        ]);

        // Initialize cURL session
        $ch = curl_init($url);

        // Set the cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            $mydata['massage'] =  'Error:' . curl_error($ch);
            exit(json_encode($mydata));
        } else {

            $response_result =   $result = json_decode($response, true);
            $json['responce'] =  $mydata['responce'] =  $php_array['responce'] = $response;
            $response_result['status'] = false;
            if (isset($result['status'])) {

                $mydata['status'] = true;
                $php_array['status'] = true;

                if (strtolower($result['message']) == "successfully" || strtolower($result['message']) == "success") {
                    $response_result['status'] = true;

                    $php_array['payment_status'] = "SUCCESS";
                    $php_array['utr'] = $result['bankRefNo'];
                } else {
                    $php_array['payment_status'] =      $mydata['massage'] =  $result['message'];
                    if ($result['status'] == 3) {
                        $response_result['message'] = "Please Wait we are verify your payment";
                        $php_array['payment_status'] = "pending";
                        $php_array['data'] = ["status" => "pending"];
                    }
                }
            } else {
                if (isset($result['message'])) {
                    $php_array['data'] = ["massage" => $result['message']];
                    $mydata['massage'] =  $result['message'];
                    exit(json_encode($mydata));
                } else {
                    $php_array['data'] = ["massage" => "Unknown Error"];
                    $mydata['massage'] =  "Error";
                    exit(json_encode($mydata));
                }
            }
        }

        // Close the cURL session
        curl_close($ch);





        if ($php_array['status']) {
            $payment_status =  $php_array['payment_status'];
            $transaction_id = "";
            if ($payment_status == "SUCCESS") {


                $utr =   $php_array['utr'];
                $payment_date = $created_at;

                $order = OrderModel::where("order_num", $order_id)->first(); // Fetch the order by ID

                if ($order) {


                    // Update the updated_at field (Laravel automatically does this on save)
                    $order->updated_at = now();
                    $order->payment_info = $response;

                    $order->payment_status = "COMPLETED";


                    // Save the changes
                    $order->save();
                }

                $json['status'] = true;
                $json['payment_received_status'] = true;
                $json['payment_status'] = "success";
                $json['massage'] = "Add Point Success";
                return response()->json($json);
            } else {
                $status_update = "";
                if (isset($payment_status)) {
                    $status = $payment_status;
                    $status_update = ",status='$status'";
                }


                $order = OrderModel::find($order_id); // Fetch the order by ID

                if ($order) {
                    // Invert the payment_status value
                    $order->payment_status = !$order->payment_status;

                    // Update the updated_at field (Laravel automatically does this on save)
                    $order->updated_at = now();

                    // Update a JSON column (e.g., extra_data)
                    $order->extra_data = json_encode([
                        'payment_status' => $payment_status,
                        'payment_info' => $response,
                        // Add more key-value pairs as needed
                    ]);

                    // Save the changes
                    $order->save();
                }



                $json['status'] = true;
                $json['payment_received_status'] = false;
                $json['payment_status'] = "pending";
                $json['massage'] = "Please Wait we are verify you payment";


                //   Payment Notification on failed
                if (isset($payment_status) && (strtolower($payment_status) == "cancelled" || strtolower($payment_status) == "failed")) {
                    $json['payment_status'] = $payment_status;
                    $json['massage'] = "Payment Failed";
                }
                //   Payment Notification on failed

                //   echo $response;
                return response()->json($json);
                // return json_encode($json);
                // exit;
            }

            $json['status'] = true;
            $json['payment_received_status'] = false;
            $json['payment_status'] = "pending";
            $json['massage'] = "We are verify you payment please wait";
            return response()->json($json);
        } else {
            $json['status'] = true;
            $json['payment_status'] = "pending";
            $json['payment_received_status'] = false;
            $json['massage'] = "Please wait for payment verification";
            return response()->json($json);
        }




        // return response()->json([]);
    }


    public function all_order_page()
    {
        $pendingOrders = null;
        $shippedOrders = null;
        $canceledOrders = null;
        $deliveredOrders = null;
        $acceptedOrders = null;
        $items = [];

        // Retrieve orders with 'pending' status and their associated items
        $orders = OrderModel::with('user')->orderBy('id', 'DESC')->get();

        foreach ($orders as $order) {
            // Retrieve order items along with their associated products
            $items[$order->id] = OrderItemModel::with('product')->where('order_id', $order->id)->get();

            // Determine the status of the order and store it in the corresponding array
            switch ($order->order_status) {
                case 'pending':
                    $pendingOrders[] = $order;
                    break;
                case 'shipped':
                    $shippedOrders[] = $order;
                    break;
                case 'cancelled':
                    $canceledOrders[] = $order;
                    break;
                case 'delivered':
                    $deliveredOrders[] = $order;
                    break;
                case 'accepted':
                    $acceptedOrders[] = $order;
                    break;
                default:
                    // Handle unknown status if needed
                    break;
            }
        }

        // Return the view with all the orders and items
        return view('admin.all_orders', compact('pendingOrders', 'shippedOrders', 'canceledOrders', 'deliveredOrders', 'items', 'acceptedOrders'));
    }




    public function update_status(Request $request, $id)
    {
        // Validate the input fields
        $validatedData = $request->validate([
            'status' => 'required|string',
            'estimate_date' => 'required_if:status,accepted|nullable|date',
            'cancel_reason' => 'required_if:status,cancelled|nullable|string',
        ]);

        // Check if the order is being cancelled
        if ($request->status == "cancelled") {
            // Update the order for cancellation
            OrderModel::where('id', $id)->update([
                'order_status' => $request->status,
                'cancelled_by_admin' => "1",
                'cancelled_by' => "admin",
                'cancelled_date' => now(),  // Use Laravel's `now()` helper for the current timestamp
                'cancelled_remark' => $request->cancel_reason,
            ]);
            return redirect()->back()->with('success', 'Order Cancelled Successfully');
        } else {
            // Update the order for status other than 'cancelled'
            OrderModel::where('id', $id)->update([
                'order_status' => $request->status,
                'estimate_date' => $request->estimate_date,
            ]);
            return redirect()->back()->with('success', 'Status Updated Successfully');
        }
    }

    public function view_order($id)
    {
        $order = OrderModel::findOrFail($id);
        $paymentInfo = json_decode($order->payment_info, true);
        if (!$order) {
            redirect()->back()->with('error', 'Order not found');
        }

        $user_id = $order->user_id;
        $user = User::findOrFail($user_id);

        $allOrders = OrderModel::where('user_id', $user_id)->get();

        $items = OrderItemModel::where('order_id', $order->id)->get();
        $product = ProductModel::whereIn('id', $items->pluck('product_id'))->first();
        $address = AddressModel::where('id', $order->address_id)->first();
        $brand = BrandModel::where('id', $product->brand_id)->first();
        $category = CategorieModel::where('id', $product->category_id)->first();
        return view('admin.view_orders_details', compact('order', 'allOrders', 'user', 'items', 'product', 'address', 'brand', 'category', 'paymentInfo'));
    }


    public function datewise_order_page()
    {
        $ordersData = [];

        $orders = OrderModel::all();

        foreach ($orders as $order) {
            $user = User::find($order->user_id);
            $item = OrderItemModel::where('order_id', $order->id)->first();
            if ($item) {
                $product = ProductModel::find($item->product_id);
            } else {
                $product = null;
            }

            // Build an array containing data for each order
            $ordersData[] = [
                'order' => $order,
                'user' => $user,
                'product' => $product,
                'item' => $item,
            ];
        }

        return view('admin.datewise_orders', compact('ordersData'));
    }

    public function add_into_order_item(Request $request)
    {

        if ($request->price_after_coupan) {
            $offer = DiscountModel::where('coupon_code', $request->code)->first();
            $offerName = $offer->on_festival_name;
            $offerPercentage = $offer->discount_percentage;
            $offerCode = $offer->coupon_code;
            $priceAfterCode = $request->price_after_coupan;
        } else {
            $offerName = NULL;
            $offerCode = NULL;
            $offerPercentage = NULL;
            $priceAfterCode = $request->total_price;
        }

        if ($request->paymethod == "cod") {


            $paymethod = "cod";
            $paystatus = "pending";
            $productNames = [];
            $productQuantities = [];
            $city = CityModel::where('id', $request->city)->first();
            $cityName = $city->city;
            $state = StateModel::where('id', $request->state)->first();
            $stateName = $state->name;
            // dd($cityName,$stateName);
            $address = [
                'name' => $request->first_name . ' ' . $request->last_name,
                'address_line1' => $request->address1,
                'address_line2' => $request->address2 ?? null,
                'city' => $cityName,
                'state' => $stateName,
                'pin' => $request->post_code,
                'country' => 'India',
            ];
            $vaild = validator($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'address1' => 'required',
                'city' => 'required',
                'state' => 'required',
                'post_code' => 'required'

            ]);
            if ($vaild) {
                $add = AddressModel::create([
                    'user_id' => Auth::user()->id,
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'address_line1' => $request->address1,
                    'address_line2' => $request->address2 ?? null,
                    'city' => $request->city,
                    'state' => $request->state,
                    'pin' => $request->post_code,
                    'country' => 'India',

                ]);
                if ($add) {

                    $addressId = AddressModel::latest()->first()->id;
                    $currentDateTime = Carbon::now();
                    $estimateDate = $currentDateTime->addDays(5)->toDateString();

                    // Create order number
                    $orderNumPrefix = "ORD0000";
                    $orderID = OrderModel::max('id') + 1; // Get the max order ID and increment by 1
                    $orderNum = $orderNumPrefix . $orderID;

                    // Create the order
                    $order = OrderModel::create([
                        'user_id' => Auth::user()->id,
                        'address_id' => $addressId,
                        'phone1' => $request->phone,
                        'phone2' => $request->phone,
                        'total_price' => $request->total_price,
                        'order_status' => 'pending',
                        'estimate_date' => $estimateDate,
                        'cancelled_by' => null,
                        'order_num' => $orderNum,
                        'coupon_name' => $offerName,
                        'discount_percentage' => $offerPercentage,
                        'price_after_coupon' => $priceAfterCode,
                        'coupon_code' => $offerCode,
                        'payment_method' => $paymethod,
                        'payment_status' => $paystatus,
                    ]);
                }
            }
            if ($order) {
                $cartItems = CartModel::where('user_id', Auth::user()->id)->get();

                foreach ($cartItems as $cartItem) {
                    $product = ProductModel::find($cartItem->product_id);

                    if ($product) {
                        $totalPrice = $request->total_price;
                        $productNames[] = $product->name;
                        $productQuantities[] = $cartItem->times;
                        $oneTotalPrice = $product->discounted_price * $cartItem->times;
                        $orderItem = OrderItemModel::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'original_price' => $product->price,
                            'discounted_price' => $product->discounted_price,
                            'item_count' => $cartItem->times,
                            'total_price' => $oneTotalPrice,
                            'offer_id' => 2,
                        ]);

                        if ($orderItem) {
                            CartModel::where('id', $cartItem->id)->delete();
                        }
                    }
                }
                session()->put('alert', 'thanks');
                $orderID = $order->id;
                return redirect()->route('thankyou', ['order_id' => $orderID]);
            } else {
                // Handle the case where order creation fails
                return redirect()->route('home')->with('error', 'Failed to create order.');
            }
        } elseif ($request->paymethod == "online" || $request->paymethod == "upi") {

            echo "online_online";
            $paymethod = "online";
            $paystatus = "pending";



            $productNames = [];
            $productQuantities = [];
            $city = CityModel::where('id', $request->city)->first();
            $cityName = $city->city;
            $state = StateModel::where('id', $request->state)->first();
            $stateName = $state->name;
            // dd($cityName,$stateName);
            $address = [
                'name' => $request->first_name . ' ' . $request->last_name,
                'address_line1' => $request->address1,
                'address_line2' => $request->address2 ?? null,
                'city' => $cityName,
                'state' => $stateName,
                'pin' => $request->post_code,
                'country' => 'India',
            ];
            $vaild = validator($request->all(), [
                'first_name' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'address1' => 'required',
                'city' => 'required',
                'state' => 'required',
                'post_code' => 'required'

            ]);
            if ($vaild) {
                $add = AddressModel::create([
                    'user_id' => Auth::user()->id,
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'address_line1' => $request->address1,
                    'address_line2' => $request->address2 ?? null,
                    'city' => $request->city,
                    'state' => $request->state,
                    'pin' => $request->post_code,
                    'country' => 'India',

                ]);
                if ($add) {
                    $addressId = AddressModel::latest()->first()->id;
                    $currentDateTime = Carbon::now();
                    $estimateDate = $currentDateTime->addDays(5)->toDateString();

                    // Create order number
                    $orderNumPrefix = "ORD0000";
                    $orderID = OrderModel::max('id') + 1; // Get the max order ID and increment by 1
                    $orderNum = $orderNumPrefix . $orderID;

                    // Create the order
                    $order = OrderModel::create([
                        'user_id' => Auth::user()->id,
                        'address_id' => $addressId,
                        'phone1' => $request->phone,
                        'phone2' => $request->phone,
                        'total_price' => $request->total_price,
                        'order_status' => 'pending',
                        'estimate_date' => $estimateDate,
                        'cancelled_by' => null,
                        'order_num' => $orderNum,
                        'coupon_name' => $offerName,
                        'discount_percentage' => $offerPercentage,
                        'price_after_coupon' => $priceAfterCode,
                        'coupon_code' => $offerCode,
                        'payment_method' => $paymethod,
                        'payment_status' => "pending",
                    ]);
                }
            }
            $newsAndOffers = $request->input('update');

            if ($order) {
                $cartItems = CartModel::where('user_id', Auth::user()->id)->get();
                foreach ($cartItems as $cartItem) {
                    $product = ProductModel::find($cartItem->product_id);

                    if ($product) {
                        $totalPrice = $request->total_price;
                        $productNames[] = $product->name;
                        $productQuantities[] = $cartItem->times;
                        $oneTotalPrice = $product->discounted_price * $cartItem->times;
                        $orderItem = OrderItemModel::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'original_price' => $product->price,
                            'discounted_price' => $product->discounted_price,
                            'item_count' => $cartItem->times,
                            'total_price' => $oneTotalPrice,
                            'offer_id' => 2,
                        ]);

                        if ($orderItem) {
                            CartModel::where('id', $cartItem->id)->delete();
                        }
                    }
                }
                session()->put('alert', 'thanks');
                $enCodeOrderId = base64_encode($order->id);
                $amount = $priceAfterCode;



                // return redirect()->route('store', [
                //     'name' => $request->first_name . ' ' . $request->last_name,
                //     'mobile' => $request->phone,
                //     'email' => $request->email,
                //     'order_id' => $enCodeOrderId,
                //     'amount' => $amount
                // ]);
                // return redirect()->route('phonepay.get', ['orderID' => $enCodeOrderId,'amount'=>$amount]);


                if ($request->paymethod == "upi") {
                    return  response()->json([
                        'name' => $request->first_name . ' ' . $request->last_name,
                        'email' => $request->email,
                        'contact' => $request->phone,
                        'amount' => $amount,
                        'order_id' => $order->id
                    ]);
                }

                return redirect()->route('pay.createOrder', [
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'email' => $request->email,
                    'contact' => $request->phone,
                    'amount' => $amount,
                    'order_id' => $order->id
                ]);








                // return redirect()->route('thankyou', ['order_id' => $enCodeOrderId]);
            } else {
                // Handle the case where order creation fails
                return redirect()->back()->with('error', 'Failed to create order.');
                // return redirect()->route('home')->with('error', 'Failed to create order.');
            }
        } else {

            return redirect()->back()->with('error', 'Failed to create order.');
        }
    }



    public function thankYouPage($order_id)
    {
        // $order_id = base64_decode($order_id);
        $order = OrderModel::where('id', $order_id)
            ->orWhere('order_num', $order_id)
            ->first();
        $user_id = $order->user_id;
        if ($user_id === Auth::user()->id) {
            return view('thankyoupage')->with('order_id', $order->order_num);
        } else
            $nothing = $order->order_num;
        return view('thankyoupage')->with('order_id', $nothing);
    }
    public function thankYouPagePaymentNot($order_id)
    {
        // $order_id = base64_decode($order_id);
        $order = OrderModel::where('id', $order_id)
            ->orWhere('order_num', $order_id)
            ->first();
        $user_id = $order->user_id;
        if ($user_id === Auth::user()->id) {
            return view('thankyoupage')->with(['order_id' => $order->order_num, 'payment_received_status' => false]);
        } else
            $nothing = $order->order_num;
        return view('thankyoupage')->with('order_id', $nothing);
    }
    public function user_cancel_order(Request $request, $id)
    {

        $order = OrderModel::find($id);
        $order->order_status = "cancelled";
        $order->cancelled_by = "User";
        $order->cancelled_remark = $request->reason;
        $order->cancelled_date = now();
        $order->save();
        return redirect()->back()->with('success', 'Order Cancelled Successfully');
    }
    public function user_view_order_details($id)
    {
        $order = OrderModel::findOrFail($id);
        $paymentInfo = json_decode($order->payment_info, true);
        if (!$order) {
            redirect()->back()->with('error', 'Order not found');
        }

        $user_id = $order->user_id;
        $user = User::findOrFail($user_id);
        $allOrders = OrderModel::where('user_id', $user_id)->get();
        $items = OrderItemModel::where('order_id', $order->id)->get();
        $product = ProductModel::whereIn('id', $items->pluck('product_id'))->first();
        $brand = BrandModel::where('id', $product->brand_id)->first();
        $category = CategorieModel::where('id', $product->category_id)->first();
        return view('user_view_orders_details', compact('order', 'allOrders', 'user', 'items', 'product', 'brand', 'category', 'paymentInfo'));
    }
}
