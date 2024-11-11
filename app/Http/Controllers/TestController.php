<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use App\Models\ProductSizeModel;
use Illuminate\Http\Request;
use App\Models\DiscountModel;
class TestController extends Controller
{
    public function req_test(Request $request)
    {
        dd($request->all());
        if($request->price_after_coupan){
            $offer=DiscountModel::where('coupon_code',$request->code)->first();
            $offerName=$offer->on_festival_name;
            $offerPrice=$offer->discount_percentage;
            $offerCode=$offer->coupon_code;

        }else{
            dd("not works");
        }
    }


public function test_req(Request $request) {
dd($request->all());
//     // $product=ProductModel::find(1);
//     // $sizes = $product->sizes;
//     $new = $request->size;
// $length = count($new);
// for($i=0;$i<$length;$i++){
//     ProductSizeModel::create([
//         'value'=>$new[$i],
//         'product_id'=>2
//     ]);
//     // print_r($new[$i]);
// }
}

}
