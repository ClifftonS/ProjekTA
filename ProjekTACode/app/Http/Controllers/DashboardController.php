<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function ajax1(Request $request) {
        $results =  DB::table('produk')->where('delete', 0)->where('stok_produk', '<' , 10)->where('stokwrn', '=' , 1)->orderBy('stok_produk', 'asc')->get();
        $terlaris =  DB::table('detail_penjualan')->select('id_produk', DB::raw('SUM(qty_detail) as total_qty'))->orderBy('total_qty', 'desc')->limit(20)->groupBy('id_produk')->get();
        $c = count($results);
        if($c == 0){
            return "<p>data tidak ada</p>";
        }else{
            return view('dashboard.ajaxstok')->with([
                'datasend' => $results,
'terlaris' => $terlaris
            ]);
        }
    }
    public function ajax2(Request $request) {
        $tgl1 = date('Y-m-d', strtotime($request->tgl1));
        $tgl2 = date('Y-m-d', strtotime($request->tgl2));
        $results =  DB::table('penjualan')->join('konsumen', 'konsumen.id_konsumen','=', 'penjualan.id_konsumen')->select('konsumen.id_konsumen','nama', DB::raw('COUNT(*) as total_trans'))->where('tanggal_penjualan', ">=", $tgl1)->where('tanggal_penjualan', "<=", $tgl2)->groupBy('konsumen.id_konsumen', 'nama')
        ->orderBy('total_trans', 'desc')
        ->limit(5)
        ->get();
        $c = count($results);
        if($c == 0){
            return "<p>data tidak ada</p>";
        }else{
            return view('dashboard.ajaxkonster')->with([
                'datasend' => $results
            ]);
        }
    }
    public function ajax3(Request $request) {
        $tgl1 = date('Y-m-d', strtotime($request->tgl1));
        $tgl2 = date('Y-m-d', strtotime($request->tgl2));
        $results =   DB::table('detail_penjualan')->join('produk', 'produk.id_produk','=', 'detail_penjualan.id_produk')->join('penjualan', 'penjualan.id_penjualan','=', 'detail_penjualan.id_penjualan')->select('produk.id_produk','nama_produk', DB::raw('SUM(qty_detail) as total_qty'))->where('tanggal_penjualan', ">=", $tgl1)->where('tanggal_penjualan', "<=", $tgl2)->groupBy('produk.id_produk', 'nama_produk')
        ->orderBy('total_qty', 'desc')
        ->limit(5)
        ->get();
        $c = count($results);
        if($c == 0){
            return "<p>data tidak ada</p>";
        }else{
            return view('dashboard.ajaxprodukter')->with([
                'datasend' => $results
            ]);
        }
    }
    public function ajax4(Request $request) {
        $tgl1 = date('Y-m-d', strtotime($request->tgl1));
        $tgl2 = date('Y-m-d', strtotime($request->tgl2));
        $results =   DB::table('penjualan')->where('tanggal_penjualan', ">=", $tgl1)->where('tanggal_penjualan', "<=", $tgl2)->sum('total_penjualan');
        if ($results == null){
            $results = 0;
        }
        return response()->json([
            'result' => $results
        ]);
    }
    public function chart(Request $request) {
        $tgl1 = date('Y-m-d', strtotime($request->tgl1));
        $tgl2 = date('Y-m-d', strtotime($request->tgl2));
        $items = DB::table('detail_penjualan')->join('produk', 'produk.id_produk','=', 'detail_penjualan.id_produk')->join('kategori', 'kategori.id_kategori','=', 'produk.id_kategori')->join('penjualan', 'penjualan.id_penjualan','=', 'detail_penjualan.id_penjualan')
        ->select(DB::raw('sum(qty_detail) as jumlah, kategori.kategori'))
        ->where('tanggal_penjualan', ">=", $tgl1)->where('tanggal_penjualan', "<=", $tgl2)
        ->groupBy('kategori.kategori')
        ->get();
    
        return response()->json([
            'data' => $items
        ]);
    }
    public function subchart(Request $request) {
        $tgl1 = date('Y-m-d', strtotime($request->tgl1));
        $tgl2 = date('Y-m-d', strtotime($request->tgl2));
        $subitems = DB::table('detail_penjualan')
            ->join('produk', 'produk.id_produk', '=', 'detail_penjualan.id_produk')
            ->join('kategori', 'kategori.id_kategori', '=', 'produk.id_kategori')
            ->join('merk', 'merk.id_merk', '=', 'produk.id_merk')
            ->join('penjualan', 'penjualan.id_penjualan','=', 'detail_penjualan.id_penjualan')
            ->select(DB::raw('sum(qty_detail) as jumlah, merk.merk'))
            ->where('kategori.kategori', $request->category)
            ->where('tanggal_penjualan', ">=", $tgl1)->where('tanggal_penjualan', "<=", $tgl2)
            ->groupBy('merk.merk')
            ->get();
        
        return response()->json([
            'data' => $subitems
        ]);
    }
}
