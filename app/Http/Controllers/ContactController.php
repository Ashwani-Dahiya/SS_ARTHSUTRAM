<?php

namespace App\Http\Controllers;

use App\Models\ContactModel;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contact_page()
    {
        return view('contact');
    }
    public function contact_store(Request $request)
    {
        $errors=$request->validate([
            'first_name' => 'required',
            'email' => 'required',
            'phone' => 'required|numeric',
            'message' => ['required', 'regex:/^[a-zA-Z0-9\s]*$/'],
        ]);
        $data = ContactModel::create([
            'first_name' => $request->first_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'last_name' => $request->last_name ?? null,
        ]);
        if($data){
            return back()->with('success', 'Your message has been sent successfully');
        }else{
            return back()->withErrors($errors)->withInput();
        }
    }
}
