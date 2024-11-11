<?php

namespace App\Http\Controllers;

use App\Models\ReviewModel;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function about_page(){
        $reviews=ReviewModel::all();
        return view('about',compact('reviews'));
    }
}
