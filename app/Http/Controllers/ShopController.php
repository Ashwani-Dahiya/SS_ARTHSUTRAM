<?php

namespace App\Http\Controllers;

use App\Models\CategorieModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class ShopController extends Controller
{
   public function shop_page(){
    $allcategories=CategorieModel::all();
    $catName="";
    $products=ProductModel::all();
       return view('shop',compact('products','allcategories','catName'));
   }
}
