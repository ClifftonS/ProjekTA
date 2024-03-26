<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function ajax(Request $request) {
        $jenis = $request->jenis;
        $tgl1 = date('Y-m-d', strtotime($request->tgl1));
        $tgl2 = date('Y-m-d', strtotime($request->tgl2));
        if($jenis == "penjualan"){
        $results =  DB::table('penjualan')->join('detail_penjualan', 'penjualan.id_penjualan','=', 'detail_penjualan.id_penjualan')->join('produk', 'produk.id_produk','=', 'detail_penjualan.id_produk')->select('produk.nama_produk', DB::raw('SUM(detail_penjualan.qty_detail) as total_qty'), DB::raw('SUM(detail_penjualan.qty_detail * detail_penjualan.harga_detail) as total_harga'))->where('tanggal_penjualan', ">=", $tgl1)->where('tanggal_penjualan', "<=", $tgl2)->groupBy('produk.nama_produk')->get();
        } else{
            $results =  DB::table('pembelian')->join('detail_pembelian', 'pembelian.id_pembelian','=', 'detail_pembelian.id_pembelian')->join('produk', 'produk.id_produk','=', 'detail_pembelian.id_produk')->select('produk.nama_produk', DB::raw('SUM(detail_pembelian.qty_detail) as total_qty'), DB::raw('SUM(detail_pembelian.qty_detail * detail_pembelian.harga_detail) as total_harga'))->where('tanggal_pembelian', ">=", $tgl1)->where('tanggal_pembelian', "<=", $tgl2)->groupBy('produk.nama_produk')->get();
        }
        $c = count($results);

        if($c == 0){
            return "<p>data tidak ada</p>";
        }else{
            return view('laporan.ajaxlaporan')->with([
                'datasend' => $results
            ]);
        }
    }
}
