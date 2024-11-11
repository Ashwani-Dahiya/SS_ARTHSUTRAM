<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\StateModel;
use App\Models\CityModel;
class AuthController extends Controller
{
    public function login_page()
    {
        return view('auth.login');
    }
    public function register_page()
    {
        return view('auth.register');
    }
    public function check_login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('home')->with('success', 'Successfully Logged In');
        }

        return redirect()->back()->with('error-db', 'Invalid Credentials');
    }


    public function logout()
    {
        Auth::logout();
        return redirect('home')->with('success-logout', 'Logout Successfully');
    }

    public function register_post(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string|min:2|max:50',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('home')->with('success', 'Successfully Logged In');
        }
        return redirect('autn.register')->withError('error');
    }
    public function update_profile(Request $request)
    {
        $stateName = "";
        $cityName = "";

        if (is_string($request->state)) {
            $stateName = $request->state;
        }
        if (is_numeric($request->state)) {
            $state = StateModel::findOrFail($request->state);
            $stateName = $state->name;
        }

        if (is_string($request->city)) {
            $cityName = $request->city;
        }
        if (is_numeric($request->city)) {
            $city = CityModel::findOrFail($request->city);
            $cityName = $city->city;
        }



        $user = User::find(Auth::user()->id);
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $cityName,
            'state' => $stateName,
            'post_code' => $request->post_code,
            'country' => $request->country,
            'username' => $request->first_name,
        ]);
        return redirect()->route('profile.view')->with("success", "Profile Updated Successfully");
    }
    public function profile_page()
    {
        $user = User::find(Auth::user()->id);
        return view("user_view.user_dashboard", compact("user"));
    }
}
