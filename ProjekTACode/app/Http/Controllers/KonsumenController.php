<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class KonsumenController extends Controller
{
    public function ajax(Request $request) {
        $name = $request->name;
        $results =  DB::table('konsumen')->where('delete', 0)->where(function($query) use ($name) {
            $query->where('id_konsumen', 'LIKE', '%' . $name . '%')
                  ->orWhere('nama', 'LIKE', '%' . $name . '%')
                  ->orWhere('telp', 'LIKE', '%' . $name . '%')
                  ->orWhere('alamat', 'LIKE', '%' . $name . '%');
        })->get();
        $c = count($results);
        if($c == 0){
            return "<p>data tidak ada</p>";
        }else{
            return view('konsumen.ajaxkonsumen')->with([
                'datasend' => $results
            ]);
        }
    }
    public function add(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama'     => ['required', 'max:100', function ($attribute, $value, $fail) {
                $exists = DB::table('konsumen')
                           ->where('nama', $value)
                           ->exists();

                if ($exists) {
                    $fail('Data sudah ada dalam database.');
                }
            }],
            'telp'   => 'required|numeric|max:15',
            'alamat'   => 'required|max:100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('konsumen')->insert([
            'nama' => $request->nama,
            'telp' => $request->telp,
            'alamat' => $request->alamat
        ]);
    }
}
