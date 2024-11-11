<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\CategorieModel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $comp_webtitle = "Pacific Mall Online Wear Shop";
        $comp_name = "pacific-mall";
        $comp_mobile = "+91 8002442002";
        $comp_mobile1 = "+91 8002442002";
        $comp_email = "shubhzzpayment@gmail.com";
        $comp_email1 = "shubhzzpayment@gmail.com";
        $comp_gst = "27ABNCS1399FIZV";
        $comp_address = "Shubhzz Payment Technologies PRIVATE LIMITED
         C/ORAJENDRA AVHAD, 73/1. 
         KOPARGAON BET.  Kopargaon.
        Ahmed Nagar- 423601. Maharashtra";
        view()->share('comp_name', $comp_name);
        view()->share('comp_mobile', $comp_mobile);
        view()->share('comp_mobile1', $comp_mobile1);
        view()->share('comp_email', $comp_email);
        view()->share('comp_email1', $comp_email1);
        view()->share('comp_address', $comp_address);
        view()->share('comp_gst', $comp_gst);
        view()->share('comp_webtitle', $comp_webtitle);
        $categories = CategorieModel::orderBy("seq", "asc")->get();
        view()->share('categories', $categories);
    }
}
