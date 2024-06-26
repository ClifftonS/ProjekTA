<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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

            $clientContent = DB::table('user')
                    ->select('password')
                    ->where([
                        ['username', '=', $clientUser],
                        // ['password', '=', $clientPassword]
                    ])
                    ->get();

                    if ($clientContent->count() > 0) {
                        if (Hash::check($clientPassword, $clientContent->first()->password)) {
                            $request->session()->put('clientAccess', 'owner');
                            return redirect('/');
                        }
                        //  elseif ($clientEmail == env('ADMINEMAIL') && $clientPassword == env('ADMINPASSWORD')){
                        //      $request->session()->put('clientAccess', 'admin');
                        //      return redirect('/admin');
                        //  }
                    }
                
            
           
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

    public function adduser()
    {
        $passwordhash = Hash::make("Cliff44");
        DB::table('user')->insert([
            'username' => "bmulia",
            'password' => $passwordhash
        ]);
    }
    // public function edituser(Request $request)
    // {
    //     $passwordhash = Hash::make("");
    // }
}
