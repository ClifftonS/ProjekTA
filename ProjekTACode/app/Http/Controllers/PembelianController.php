<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function ajax(Request $request) {
        $name = $request->name;
        $results =  DB::table('pembelian')->join('produk', 'produk.id_produk','=', 'pembelian.id_produk')->where('pembelian.delete', 0)->where(function($query) use ($name) {
            $query->where('id_pembelian', 'LIKE', '%' . $name . '%')
                  ->orWhere('nama_produk', 'LIKE', '%' . $name . '%')
                  ->orWhere('qty_pembelian', 'LIKE', '%' . $name . '%')
                  ->orWhere('tanggal_pembelian', 'LIKE', '%' . $name . '%');
        })->get();
        $c = count($results);
        if($c == 0){
            return "<p>data tidak ada</p>";
        }else{
            return view('pembelian.ajaxpembelian')->with([
                'datasend' => $results
            ]);
        }
    }
    public function ajaxadd() {
         $produk =  DB::table('produk')->where('delete', 0)->get();
         return response()->json([
             'produk'    => $produk
         ]);
     }
    public function add(Request $request) {
        $messages = [
            'required' => ':attribute harus diisi'
       ];
        $validator = Validator::make($request->all(), [
            'produk'   => ['required', function ($attribute, $value, $fail) {
                if ($value == "kosong") {
                    $fail('Produk tidak boleh kosong');
                }
            }],
            'tanggal' => 'required',
            'qty' => 'required',
            'harga' => 'required'
        ],$messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $subtotal = $request->harga * $request->qty;

        DB::table('pembelian')->insert([
            'id_pembelian' => "0",
            'id_produk' => $request->produk,
            'tanggal_pembelian' => $request->tanggal,
            'qty_pembelian' => $request->qty,
            'harga_pembelian' => $request->harga,
            'subtotal_pembelian ' => $subtotal
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!'
        ]);
    }
    public function edit(Request $request) {
        $id = $request->id;
        $messages = [
            'required' => ':attribute harus diisi.'
       ];
        $validator = Validator::make($request->all(), [
            'produk'   => ['required', function ($attribute, $value, $fail) {
                if ($value == "kosong") {
                    $fail('Produk tidak boleh kosong');
                }
            }],
            'tanggal' => 'required',
            'qty' => 'required',
            'harga' => 'required'
        ],$messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $subtotal = $request->harga * $request->qty;
        
        DB::table('pembelian')->where('id_pembelian',$id)->update([
            'id_produk' => $request->produk,
            'tanggal_pembelian' => $request->tanggal,
            'qty_pembelian' => $request->qty,
            'harga_pembelian' => $request->harga,
            'subtotal_pembelian ' => $subtotal,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diubah!'
        ]);
    }
    public function delete(Request $request) {
        DB::table('pembelian')->where('id_pembelian',$request->id)->update([
            'delete' => 1
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!'
        ]);
    }
}
