<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function post(Request $request)
    {
        if ($request->session()->has('clientAccess') == null) {

            $rules = [
                'user' => 'required',
                'password' => 'required|max:20'
            ];

            $rulesErrorMessage = [
                'user.required' => 'Email diperlukan ',
                'password.required' => 'Password diperlukan ',
                'password.max' => 'Password maximal 20 digit '
            ];
            $validator = Validator::make($request->all(), $rules, $rulesErrorMessage);
            if ($validator->fails()) {
                return redirect('/')->withErrors($validator->errors());
            }

            $clientUser = $request->input('user');
            $clientPassword = $request->input('password');
            if ($clientUser == env('OWNERUSERNAME') && $clientPassword == env('OWNERPASSWORD')) {
                $request->session()->put('clientAccess', 'owner');
                return redirect('/');
            }
            //  elseif ($clientEmail == env('ADMINEMAIL') && $clientPassword == env('ADMINPASSWORD')){
            //      $request->session()->put('clientAccess', 'admin');
            //      return redirect('/admin');
            //  }
            return redirect()->back()->withErrors(['invalidLogin' => 'Email atau Kata Sandi salah']);
        }
    }

    public function get(Request $request)
    {
        if ($request->session()->has('clientAccess') != null) {
            $currAccess = $request->session()->get('clientAccess');
            if ($currAccess == 'owner') {
                return view('homepageView');
            }
        } else {
            return redirect('/loginpage');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
}
