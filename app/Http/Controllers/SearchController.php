<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\CategorieModel;
class SearchController extends Controller
{
    public function search_products(Request $request)
{
    $category = $request->input('categorie');
    $name = $request->input('name');

    $query = ProductModel::query();

    // If a category is selected and it's not "All Categories"
    if ($category && $category != 0) {
        $query->where('category_id', $category);
    }

    // If a product name is entered
    if ($name) {
        $query->where('name', 'like', '%' . $name . '%');
    }

    $products = $query->get();

    // Pass all categories for the select dropdown and filtered products to the view
    $allcategories = CategorieModel::all();
    $searchedCatID= $category;
    $searchedName= $name;
    return view("shop", compact('products', 'allcategories','searchedCatID','searchedName'));
}

}
