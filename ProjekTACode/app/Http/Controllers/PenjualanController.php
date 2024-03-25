<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;

class PenjualanController extends Controller
{
    public function ajax(Request $request) {
        $name = $request->name;
        $tgl1 = date('Y-m-d', strtotime($request->tgl1));
        $tgl2 = date('Y-m-d', strtotime($request->tgl2));
        $results =  DB::table('penjualan')->join('konsumen', 'konsumen.id_konsumen','=', 'penjualan.id_konsumen')->where(function($query) use ($name) {
            $query->where('id_penjualan', 'LIKE', '%' . $name . '%')
                  ->orWhere('nama', 'LIKE', '%' . $name . '%')
                  ->orWhere('total_penjualan', 'LIKE', '%' . $name . '%')
                  ->orWhere('tanggal_penjualan', 'LIKE', '%' . $name . '%');
        })->where('tanggal_penjualan', ">=", $tgl1)->where('tanggal_penjualan', "<=", $tgl2)->orderBy('id_penjualan', 'desc')->get();
        $c = count($results);
        if($c == 0){
            return "<p>data tidak ada</p>";
        }else{
            return view('penjualan.ajaxpenjualan')->with([
                'datasend' => $results
            ]);
        }
    }
    public function ajaxadd() {
         $produk =  DB::table('produk')->where('delete', 0)->get();
         $supplier =  DB::table('konsumen')->where('delete', 0)->get();
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
        
        DB::table('penjualan')->insert([
            'id_penjualan' => "0",
            'id_konsumen' => $request->supplier,
            'tanggal_penjualan' => $formatted_date,
            'total_penjualan' => $request->total
        ]);

        $id_pembelian = DB::table('penjualan')
        ->orderByDesc('id_penjualan')
        ->first()
        ->id_penjualan;

        for ($i = 1; $i <= $request->jumlahdata; $i++){
            $produk = "produk" . '' .$i;
            $harga = "harga" . '' .$i;
            $qty = "qty" . '' .$i;
            if ($request->$produk != "kosong" && $request->$qty != null && $request->$harga != null) {
            DB::table('detail_penjualan')->insert([
                'id_penjualan' => $id_pembelian,
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
                    $fail('Konsumen tidak boleh kosong');
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
        
        DB::table('penjualan')->where('id_penjualan',$id)->update([
            'id_konsumen' => $request->supplier,
            'tanggal_penjualan' => $formatted_date,
            'total_penjualan' => $request->total
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
        $detail =  DB::table('penjualan')->join('detail_penjualan', 'detail_penjualan.id_penjualan','=', 'penjualan.id_penjualan')->where('penjualan.id_penjualan',$request->id)->get();
         $supplier =  DB::table('konsumen')->where('delete', 0)->get();
         $produk =  DB::table('produk')->where('delete', 0)->get();
         return response()->json([
            'detail' => $detail,
             'produk' => $produk,
             'supplier'    => $supplier
         ]);
    }
    public function print($id) {
        $detail = DB::table('penjualan')->join('detail_penjualan', 'detail_penjualan.id_penjualan','=', 'penjualan.id_penjualan')->join('konsumen', 'konsumen.id_konsumen','=', 'penjualan.id_konsumen')->join('produk', 'produk.id_produk','=', 'detail_penjualan.id_produk')->where('penjualan.id_penjualan',$id)->get();
        $pdf = PDF::loadView('penjualan.nota', ['data' => $detail])->setPaper('a4', 'landscape');
        return $pdf->stream($id. '.pdf');
    }
   
}
