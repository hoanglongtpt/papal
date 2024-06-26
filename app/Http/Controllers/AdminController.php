<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
class AdminController extends Controller
{
    public function index()
    {
        $customers = Customer::orderByDesc('id')->get();
        return view('admin.layouts.master', compact('customers'));
    }
}
