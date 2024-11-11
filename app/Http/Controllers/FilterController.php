<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\ProductSizeModel;
use App\Models\CategorieModel;
class FilterController extends Controller
{
    public function filtering_products(Request $request)
    {
        // Start with a base query
        $query = ProductModel::query();

        // Filter by price range
        if ($request->has('filter_v_price_gte')) {
            $query->where('discounted_price', '>=', $request->filter_v_price_gte);
        }
        if ($request->has('filter_v_price_lte')) {
            $query->where('discounted_price', '<=', $request->filter_v_price_lte);
        }

        // Filter by size
        if ($request->has('sizes')) {
            $sizes = $request->sizes;
            $query->whereHas('sizes', function ($query) use ($sizes) {
                $query->whereIn('value', $sizes);
            });
        }

        // Filter by category
        if ($request->has('categories')) {
            $query->whereIn('category_id', $request->categories);
        }

        // Execute the query
        $products = $query->get();

        // Return the filtered products
        $allcategories = CategorieModel::all();

        return view('filter_product', compact('products', 'allcategories'));
    }
}
