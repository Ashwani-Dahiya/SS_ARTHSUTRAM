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
        $comp_webtitle = "ARTHSUTRAM SOLUTION PRIVATE LIMITED";
        $comp_name = "ARTHSUTRAM";
        $comp_mobile = "+91 7276419292";
        $comp_mobile1 = "+91 7276419292";
        $comp_email = "arthsutramsp11@gmail.com";
        $comp_email1 = "arthsutramsp11@gmail.com";
        $comp_gst = "27ABBCA3944L1ZH";
        $comp_address = "ARTHSUTRAM SOLUTION PRIVATE LIMITED
594, LAXMI ROAD, Sadashiv Peth, Pune City, Pune- 411030, Maharashtra.";
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
