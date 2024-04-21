<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MerkController extends Controller
{
    public function ajax(Request $request) {
        $name = $request->name;
        $results =  DB::table('merk')->where('delete', 0)->where(function($query) use ($name) {
            $query->where('id_merk', 'LIKE', '%' . $name . '%')
                  ->orWhere('merk', 'LIKE', '%' . $name . '%');
        })->get();
        $c = count($results);
        if($c == 0){
            return view('noresultView');
        }else{
            return view('merk.ajaxmerk')->with([
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
                $exists = DB::table('merk')
                           ->where('merk', $value)
                           ->exists();

                if ($exists) {
                    $fail('Nama sudah ada');
                }
            }]
        ],$messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        DB::table('merk')->insert([
            'id_merk' => "0",
            'merk' => $request->nama
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
                $exists = DB::table('merk')
                           ->where('merk', $value)
                           ->where('id_merk', '!=', $id)
                           ->exists();

                if ($exists) {
                    $fail('Nama sudah ada');
                }
            }]
        ],$messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        DB::table('merk')->where('id_merk',$id)->update([
            'merk' => $request->nama
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diubah!'
        ]);
    }
    public function delete(Request $request) {
        DB::table('merk')->where('id_merk',$request->id)->update([
            'delete' => 1
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!'
        ]);
    }
}
