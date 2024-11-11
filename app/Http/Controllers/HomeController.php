<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\StateModel;
use App\Models\BlogModel;
use App\Models\BrandModel;
use App\Models\CartModel;
use App\Models\ProductModel;
use App\Models\CategorieModel;
use App\Models\HomeLastBannerModel;
use App\Models\HomeMainBannerModel;
use App\Models\HomeMiddleBannerModel;
use App\Models\ReviewModel;
use App\Models\SectionModel;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function home_page()
    {
        $sections = SectionModel::with('products')->get();
        $item = ProductModel::orderBy("id", "desc")->get();
        $count = 0;
        if ($sections->isNotEmpty()) {
            $blog = BlogModel::orderBy("id", "desc")->paginate(4);
            $newbrand = BrandModel::orderBy("id", "desc")->paginate(10);
            $reviews = ReviewModel::all();
            $banner = HomeMainBannerModel::all();
            $midbanners = HomeMiddleBannerModel::latest()->first();
            $lastbanners = HomeLastBannerModel::latest()->first();
            $categories = CategorieModel::orderBy("seq", "asc")->get();

            $data = compact("blog", "item", "newbrand", "reviews", "categories", "sections", "count", "banner", "midbanners", "lastbanners");

            return view("index", $data)->with($data);
        } else {
            $midbanners = HomeMiddleBannerModel::latest()->first();
            $lastbanners = HomeLastBannerModel::latest()->first();
            $categories = CategorieModel::orderBy("seq", "asc")->get();
            return view("index", compact('item', 'categories', 'lastbanners', 'midbanners'));
        }
    }

    public function find_by_categorie($catName)
    {
        // Decode the URL-encoded characters
    $decodedCatName = str_replace('-', ' ', $catName);

    // Lookup the category in the database
    $allcategories =CategorieModel::all();
    $categorie = CategorieModel::where("name", $decodedCatName)->first();
        if ($categorie) {
            $products = ProductModel::where('category_id', $categorie->id)->get();
            return view("shop", compact('products','allcategories'));
        } else {
            return redirect()->back()->with('error', 'Category not found');
        }
    }
}
