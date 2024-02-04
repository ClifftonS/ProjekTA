<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    public function ajax(Request $request) {
        $name = $request->name;
        $results =  DB::table('produk')->join('merk', 'produk.id_merk','=', 'merk.id_merk')->join('kategori', 'produk.id_kategori','=', 'kategori.id_kategori')->where('produk.delete', 0)->where(function($query) use ($name) {
            $query->where('id_produk', 'LIKE', '%' . $name . '%')
                  ->orWhere('nama_produk', 'LIKE', '%' . $name . '%')
                  ->orWhere('stok_produk', 'LIKE', '%' . $name . '%')
                  ->orWhere('merk', 'LIKE', '%' . $name . '%')
                  ->orWhere('kategori', 'LIKE', '%' . $name . '%');
        })->get();
        $c = count($results);
        if($c == 0){
            return "<p>data tidak ada</p>";
        }else{
            return view('produk.ajaxproduk')->with([
                'datasend' => $results
            ]);
        }
    }
    public function ajaxadd() {
        $merk =  DB::table('merk')->where('delete', 0)->get();
        $kategori =  DB::table('kategori')->where('delete', 0)->get();
        return response()->json([
            'merk'    => $merk,
            'kategori'    => $kategori
        ]);
    }
    public function add(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama'     => ['required', 'max:50', function ($attribute, $value, $fail) {
                $exists = DB::table('produk')
                           ->where('nama_produk', $value)
                           ->exists();

                if ($exists) {
                    $fail('Name already exist');
                }
            }],
            'merk'   => ['required', function ($attribute, $value, $fail) {
                if ($value == "kosong") {
                    $fail('The merk field is required.');
                }
            }],
            'kategori'   => ['required', function ($attribute, $value, $fail) {
                if ($value == "kosong") {
                    $fail('The kategori field is required.');
                }
            }],
            'stok' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        DB::table('produk')->insert([
            'id_produk' => "0",
            'id_merk' => $request->merk,
            'id_kategori' => $request->kategori,
            'nama_produk' => $request->nama,
            'stok_produk' => $request->stok
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!'
        ]);
    }
    public function edit(Request $request) {
        $id = $request->id;
        $validator = Validator::make($request->all(), [
            'nama'     => ['required', 'max:50', function ($attribute, $value, $fail) use ($id) {
                $exists = DB::table('produk')
                           ->where('nama_produk', $value)
                           ->where('id_produk', '!=', $id)
                           ->exists();

                if ($exists) {
                    $fail('Name already exist.');
                }
            }],
            'merk'   => ['required', function ($attribute, $value, $fail) {
                if ($value == "kosong") {
                    $fail('The merk field is required.');
                }
            }],
            'kategori'   => ['required', function ($attribute, $value, $fail) {
                if ($value == "kosong") {
                    $fail('The kategori field is required.');
                }
            }],
            'stok' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        DB::table('produk')->where('id_produk',$id)->update([
            'id_merk' => $request->merk,
            'id_kategori' => $request->kategori,
            'nama_produk' => $request->nama,
            'stok_produk' => $request->stok
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diubah!'
        ]);
    }
    public function delete(Request $request) {
        DB::table('produk')->where('id_produk',$request->id)->update([
            'delete' => 1
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!'
        ]);
    }
}
