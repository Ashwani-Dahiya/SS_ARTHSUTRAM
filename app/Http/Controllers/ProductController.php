<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use Illuminate\Http\Request;
use App\Models\BrandModel;
use App\Models\CategorieModel;
use App\Models\ProductSizeModel;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function product_detail_page($id){
        $product=ProductModel::findOrFail($id);
        $sizes=$product->sizes;
        return view('product-details',compact('product','sizes'));
    }


    public function all_products_page()
    {
        $lists = ProductModel::orderBy("id", "desc")->get();
        foreach ($lists as $list) {
            $cat_id = $list->category_id;
            $brand_id = $list->brand_id;
            $list->category = CategorieModel::where('id', $cat_id)->first();
            $list->brand = BrandModel::where('id', $brand_id)->first();
        }
        return view("admin.my_products", compact("lists"));
    }
    public function add_products_page()
    {
        $categories = CategorieModel::orderBy("id", "desc")->get();
        $brands = BrandModel::orderBy("id", "desc")->get();

        return view("admin.add_product", compact('categories', 'brands'));
    }
    public function add_products(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'brand_id' => 'required',
            'product_image' => 'required|file|mimes:jpeg,png,jpg,webp',
            'product_image_2' => 'file|mimes:jpeg,png,jpg,webp',
            'product_image_3' => 'file|mimes:jpeg,png,jpg,webp',
            'product_image_4' => 'file|mimes:jpeg,png,jpg,webp',
            'product_image_5' => 'file|mimes:jpeg,png,jpg,webp',
            'color' => 'required',
            'about1' => 'required',
            'discounted_price' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $targetDirectory = 'uploads/Products Images/';

        // Handle product_image separately
        $productImage = $request->file('product_image');
        $productImageName = $productImage->getClientOriginalName();
        $productImage->move(public_path($targetDirectory), $productImageName);

        // Handle additional product images if provided
        $additionalImages = [];
        for ($i = 2; $i <= 5; $i++) {
            $fileInputName = 'product_image_' . $i;

            if ($request->hasFile($fileInputName)) {
                $additionalImage = $request->file($fileInputName);
                $additionalImageName = $additionalImage->getClientOriginalName();
                $additionalImage->move(public_path($targetDirectory), $additionalImageName);
                $additionalImages[] = $additionalImageName;
            }
        }

        // Create the product record
        $product = new ProductModel();
        $product->name = $request->product_name;

        $product->brand_id = $request->brand_id;
        $product->category_id = $request->category_id;

        $product->colors = $request->color;
        $product->image = $productImageName;
        $product->image2 = isset($additionalImages[0]) ? $additionalImages[0] : null;
        $product->image3 = isset($additionalImages[1]) ? $additionalImages[1] : null;
        $product->image4 = isset($additionalImages[2]) ? $additionalImages[2] : null;
        $product->image5 = isset($additionalImages[3]) ? $additionalImages[3] : null;
        $product->price = $request->price;
        $product->discounted_price = $request->discounted_price;
        $product->about1 = $request->about1;
        $product->save();
        if($request->size){
            $new = $request->size;
            $length = count($new);
            $product_id = $product->id;
            for($i=0;$i<$length;$i++){
                ProductSizeModel::create([
                    'value'=>$new[$i],
                    'product_id'=>$product_id,
                ]);}
        }

        return redirect()->back()->with('success', 'Product Added successfully.');
    }


    public function delete_product($id)
    {
        ProductModel::find($id)->delete();
        return redirect()->back()->with('success', 'Product Deleted successfully.');
    }
    public function update_product($id){
        $sizes=ProductSizeModel::where('product_id', $id)->get();
        // dd($sizes);
        if($sizes->count() < 0){
            $sizes=null;
        }
        $categories = CategorieModel::orderBy("id", "desc")->get();
        $brands = BrandModel::orderBy("id", "desc")->get();
        $product=ProductModel::findOrFail($id);
        $brandName=BrandModel::where('id',$product->brand_id)->first();
        $categorieName=CategorieModel::where('id', $product->category_id)->first();
        return view('admin.update_product', compact('product','categories','brands','brandName','categorieName','sizes'));
    }
    public function update_product_post(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'brand_id' => 'required',
            'product_image' => 'file|mimes:jpeg,png,jpg,webp',
            'product_image_2' => 'file|mimes:jpeg,png,jpg,webp',
            'product_image_3' => 'file|mimes:jpeg,png,jpg,webp',
            'product_image_4' => 'file|mimes:jpeg,png,jpg,webp',
            'product_image_5' => 'file|mimes:jpeg,png,jpg,webp',
            'color' => 'required',
            'about1' => 'required',
            'discounted_price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $targetDirectory = 'uploads/Products Images/';
        $product = ProductModel::findOrFail($id);

        // Handle product_image separately
        if ($request->hasFile('product_image')) {
            $productImage = $request->file('product_image');
            $productImageName = $productImage->getClientOriginalName();

            // Unlink existing image if exists
            if (file_exists(public_path($targetDirectory . $product->image))) {
                unlink(public_path($targetDirectory . $product->image));
            }

            $productImage->move(public_path($targetDirectory), $productImageName);
            $product->image = $productImageName;
        }

        // Handle additional product images if provided
        $additionalImages = [];
        for ($i = 2; $i <= 5; $i++) {
            $fileInputName = 'product_image_' . $i;

            if ($request->hasFile($fileInputName)) {
                $additionalImage = $request->file($fileInputName);
                $additionalImageName = $additionalImage->getClientOriginalName();

                // Unlink existing image if exists
                $imageField = 'image' . $i;
                if (file_exists(public_path($targetDirectory . $product->$imageField))) {
                    unlink(public_path($targetDirectory . $product->$imageField));
                }

                $additionalImage->move(public_path($targetDirectory), $additionalImageName);
                $product->$imageField = $additionalImageName;
            }
        }

        // Update the product record
        $product->name = $request->product_name;
        $product->brand_id = $request->brand_id;
        $product->category_id = $request->category_id;
        $product->colors = $request->color;
        $product->price = $request->price;
        $product->discounted_price = $request->discounted_price;
        $product->about1 = $request->about1;
        $product->save();

        // Update product sizes
        if ($request->size) {
            $newSizes = $request->size;
            $product->sizes()->delete(); // Delete existing sizes

            foreach ($newSizes as $sizeValue) {
                ProductSizeModel::create([
                    'value' => $sizeValue,
                    'product_id' => $product->id,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

}
