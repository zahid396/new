<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::active()->orderBy('sort_order')->get();
        $products = Product::available()->orderBy('sort_order')->get();
        $reviews = Review::active()->featured()->orderBy('sort_order')->limit(5)->get();

        return view('home', compact('banners', 'products', 'reviews'));
    }
}
