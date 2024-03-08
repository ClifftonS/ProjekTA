<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class KategoriController extends Controller
{
    public function ajax(Request $request) {
        $name = $request->name;
        $results =  DB::table('kategori')->where('delete', 0)->where(function($query) use ($name) {
            $query->where('id_kategori', 'LIKE', '%' . $name . '%')
                  ->orWhere('kategori', 'LIKE', '%' . $name . '%');
        })->get();
        $c = count($results);
        if($c == 0){
            return "<p>data tidak ada</p>";
        }else{
            return view('kategori.ajaxkategori')->with([
                'datasend' => $results
            ]);
        }
    }
    public function add(Request $request) {
        $messages = [
            'required' => ':attribute harus diisi',
           'nama.max' => 'Maximal 50 kata '
       ];
        $validator = Validator::make($request->all(), [
            'nama'     => ['required', 'max:50', function ($attribute, $value, $fail) {
                $exists = DB::table('kategori')
                           ->where('kategori', $value)
                           ->exists();

                if ($exists) {
                    $fail('Name sudah ada');
                }
            }]
        ],$messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        DB::table('kategori')->insert([
            'id_kategori' => "0",
            'kategori' => $request->nama
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!'
        ]);
    }
    public function edit(Request $request) {
        $id = $request->id;
        $messages = [
            'required' => ':attribute harus diisi',
           'nama.max' => 'Maximal 50 kata '
       ];
        $validator = Validator::make($request->all(), [
            'nama'     => ['required', 'max:50', function ($attribute, $value, $fail) use ($id) {
                $exists = DB::table('kategori')
                           ->where('kategori', $value)
                           ->where('id_kategori', '!=', $id)
                           ->exists();

                if ($exists) {
                    $fail('Nama sudah ada');
                }
            }]
        ],$messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        DB::table('kategori')->where('id_kategori',$id)->update([
            'kategori' => $request->nama
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diubah!'
        ]);
    }
    public function delete(Request $request) {
        DB::table('kategori')->where('id_kategori',$request->id)->update([
            'delete' => 1
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!'
        ]);
    }
}
