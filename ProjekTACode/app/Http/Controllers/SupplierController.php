<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function ajax(Request $request) {
        $name = $request->name;
        $results =  DB::table('supplier')->where('delete', 0)->where(function($query) use ($name) {
            $query->where('id_supplier', 'LIKE', '%' . $name . '%')
                  ->orWhere('nama', 'LIKE', '%' . $name . '%')
                  ->orWhere('telp', 'LIKE', '%' . $name . '%');
        })->get();
        $c = count($results);
        if($c == 0){
            return view('noresultView');
        }else{
            return view('supplier.ajaxsupplier')->with([
                'datasend' => $results
            ]);
        }
    }
    public function add(Request $request) {
         $messages = [
             'required' => ':attribute harus diisi',
            'numeric'    => ':attribute harus berupa angka',
               'nama.max' => 'Maximal 100 kata '
        ];
        $validator = Validator::make($request->all(), [
            'nama'     => ['required', 'max:100', function ($attribute, $value, $fail) {
                $exists = DB::table('supplier')
                           ->where('nama', $value)
                           ->exists();

                if ($exists) {
                    $fail('Nama sudah ada');
                }
            }],
            'telp'   => 'required|numeric'
        ],$messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        DB::table('supplier')->insert([
            'id_supplier' => "0",
            'nama' => $request->nama,
            'telp' => $request->telp
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
           'numeric'    => ':attribute harus berupa angka',
           'nama.max' => 'Maximal 100 kata'
       ];
        $validator = Validator::make($request->all(), [
            'nama'     => ['required', 'max:100', function ($attribute, $value, $fail) use ($id) {
                $exists = DB::table('supplier')
                           ->where('nama', $value)
                           ->where('id_supplier', '!=', $id)
                           ->exists();

                if ($exists) {
                    $fail('Nama sudah ada');
                }
            }],
            'telp'   => 'required|numeric'
        ],$messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        DB::table('supplier')->where('id_supplier',$id)->update([
            'nama' => $request->nama,
            'telp' => $request->telp
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diubah!'
        ]);
    }
    public function delete(Request $request) {
        DB::table('supplier')->where('id_supplier',$request->id)->update([
            'delete' => 1
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!'
        ]);
    }
}
