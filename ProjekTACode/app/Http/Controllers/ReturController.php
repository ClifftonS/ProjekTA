<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReturController extends Controller
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
            return view('noresultView');
        }else{
            return view('retur.ajaxretur')->with([
                'datasend' => $results
            ]);
        }
    }
    public function edit(Request $request) {
        $id = $request->id;

        for ($i = 1; $i <= $request->jumlahdata; $i++){
            $produk = "produk" . '' .$i;
            $cek = "cek" . '' .$i;
            $ket = "ket" . '' .$i;
            $date = "date" . '' .$i;
            if ($request->$cek == 1) {
                DB::table('detail_penjualan')->where('id_penjualan',$id)->where('id_produk',$request->$produk)->update([
                    'tglretur' => date('Y-m-d', strtotime($request->$date)),
                    'ketretur' => $request->$ket
                ]);
            } else {
                DB::table('detail_penjualan')->where('id_penjualan',$id)->where('id_produk',$request->$produk)->update([
                    'ketretur' => ""
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diubah!'
        ]);
    }
}
