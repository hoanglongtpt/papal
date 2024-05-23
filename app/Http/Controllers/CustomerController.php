<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function login () {
        return view('customers.login');
    }

    public function saveEmail (Request $request) {
        if ($request->email) {
            $customer = new Customer;
            $customer->email = $request->email;
            $customer->save();
        }        
    }

    public function get_view_password () {
        return view('customers.password');
    }

    public function savePassword () {
        dd('ok lưu');
    }

    public function get_view_otp () {
        return view('customers.otp');
    }

    public function saveOtp () {
        dd('ok lưu');
    }
}
