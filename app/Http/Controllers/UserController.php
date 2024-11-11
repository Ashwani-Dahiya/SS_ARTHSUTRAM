<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\OrderModel;
use App\Models\ReasonModel;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function main_page()
    {
        $user = User::find(Auth::user()->id);
        return view("user_view.user_dashboard", compact("user"));
    }
    public function your_orders()
    {
        $user = auth()->user();
        $orders = OrderModel::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        $reasons = ReasonModel::all();
        return view('user_view.user_orders', compact('orders', 'reasons'));
    }

    public function update_profile()
    {

    $user = Auth::user();
    $states = StateModel::with('cities')->get();

    $cities = CityModel::all();
    $cityNames = []; // Array to store city names

    // Iterate through cities to get city names
    foreach ($cities as $city) {
        $cityNames[$city->id] = $city->city; // Store city name using city ID as key
    }


        $record = User::find(Auth::user()->id);
        $lastAddress = User::find(Auth::user()->id);
        return view("user_view.user_update_profile", compact("states", "record", "lastAddress", "cityNames",));
    }
    public function delete_page()
    {

        return view("user_view.user_delete_profile");
    }
    public function change_password_page()

    {
        $record = User::find(Auth::user()->id);
        return view("user_view.user_change_password", compact("record"));


    }
    public function getCities($stateId)
    {
        $cities = CityModel::where('state_id', $stateId)->get();
        return response()->json($cities);
    }
}
