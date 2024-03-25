<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PembelianController extends Controller
{
    public function ajax(Request $request) {
        $name = $request->name;
        $tgl1 = date('Y-m-d', strtotime($request->tgl1));
        $tgl2 = date('Y-m-d', strtotime($request->tgl2));
        $results =  DB::table('pembelian')->join('supplier', 'supplier.id_supplier','=', 'pembelian.id_supplier')->where(function($query) use ($name) {
            $query->where('id_pembelian', 'LIKE', '%' . $name . '%')
                  ->orWhere('nama', 'LIKE', '%' . $name . '%')
                  ->orWhere('total_pembelian', 'LIKE', '%' . $name . '%')
                  ->orWhere('tanggal_pembelian', 'LIKE', '%' . $name . '%');
        })->where('tanggal_pembelian', ">=", $tgl1)->where('tanggal_pembelian', "<=", $tgl2)->orderBy('id_pembelian', 'desc')->get();
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
         $supplier =  DB::table('supplier')->where('delete', 0)->get();
         return response()->json([
             'produk' => $produk,
             'supplier'    => $supplier
         ]);
     }
    public function add(Request $request) {
        $messages = [
            'tanggal.required' => 'Tanggal harus diisi',
            'qty1.required' => 'Qty harus diisi',
            'harga1.required' => 'Harga harus diisi'
       ];
        $validator = Validator::make($request->all(), [
            'produk1'   => ['required', function ($attribute, $value, $fail) {
                if ($value == "kosong") {
                    $fail('Produk tidak boleh kosong');
                }
            }],
            'supplier'   => ['required', function ($attribute, $value, $fail) {
                if ($value == "kosong") {
                    $fail('Supplier tidak boleh kosong');
                }
            }],
            'tanggal' => 'required',
            'qty1' => 'required',
            'harga1' => 'required'
        ],$messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $formatted_date = date('Y-m-d', strtotime($request->tanggal));
        
        DB::table('pembelian')->insert([
            'id_pembelian' => "0",
            'id_supplier' => $request->supplier,
            'tanggal_pembelian' => $formatted_date,
            'total_pembelian' => $request->total
        ]);

        $id_pembelian = DB::table('pembelian')
        ->orderByDesc('id_pembelian')
        ->first()
        ->id_pembelian;

        for ($i = 1; $i <= $request->jumlahdata; $i++){
            $produk = "produk" . '' .$i;
            $harga = "harga" . '' .$i;
            $qty = "qty" . '' .$i;
            if ($request->$produk != "kosong" && $request->$qty != null && $request->$harga != null) {
            DB::table('detail_pembelian')->insert([
                'id_pembelian' => $id_pembelian,
                'id_produk' => $request->$produk,
                'qty_detail' => $request->$qty,
                'harga_detail' => $request->$harga
            ]);
            }

            $stok_awal = DB::table('produk')
            ->where('id_produk', $request->$produk)
            ->value('stok_produk');

            DB::table('produk')->where('id_produk', $request->$produk)->update([
                'stok_produk' => $stok_awal + $request->$qty
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!'
        ]);
    }
    public function edit(Request $request) {
        $id = $request->id;
        $messages = [
            'tanggal.required' => 'Tanggal harus diisi',
            'qty1.required' => 'Qty harus diisi',
            'harga1.required' => 'Harga harus diisi'
       ];
        $validator = Validator::make($request->all(), [
            'produk1'   => ['required', function ($attribute, $value, $fail) {
                if ($value == "kosong") {
                    $fail('Produk tidak boleh kosong');
                }
            }],
            'supplier'   => ['required', function ($attribute, $value, $fail) {
                if ($value == "kosong") {
                    $fail('Supplier tidak boleh kosong');
                }
            }],
            'tanggal' => 'required',
            'qty1' => 'required',
            'harga1' => 'required'
        ],$messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $formatted_date = date('Y-m-d', strtotime($request->tanggal));
        
        DB::table('pembelian')->where('id_pembelian',$id)->update([
            'id_supplier' => $request->supplier,
            'tanggal_pembelian' => $formatted_date,
            'total_pembelian' => $request->total
        ]);

        // for ($i = 1; $i <= $request->jumlahdata; $i++){
        //     $produk = "produk" . '' .$i;
        //     $harga = "harga" . '' .$i;
        //     $qty = "qty" . '' .$i;
        //     if ($request->$produk != "kosong" && $request->$qty != null && $request->$harga != null) {
        //     DB::table('detail_pembelian')->where('id_pembelian',$id)->update([
        //         'id_produk' => $request->$produk,
        //         'qty_detail' => $request->$qty,
        //         'harga_detail' => $request->$harga
        //     ]);
        //     }
        // }

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diubah!'
        ]);
    }
    public function ajaxlihat(Request $request) {
        $detail =  DB::table('pembelian')->join('detail_pembelian', 'detail_pembelian.id_pembelian','=', 'pembelian.id_pembelian')->where('pembelian.id_pembelian',$request->id)->get();
         $supplier =  DB::table('supplier')->where('delete', 0)->get();
         $produk =  DB::table('produk')->where('delete', 0)->get();
         return response()->json([
            'detail' => $detail,
             'produk' => $produk,
             'supplier'    => $supplier
         ]);
    }
}
