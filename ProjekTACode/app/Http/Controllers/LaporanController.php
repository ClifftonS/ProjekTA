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

        $perPage = 12; // Number of items per page
        if($jenis == "penjualan"){
            $totalUsers = DB::table('penjualan')->join('detail_penjualan', 'penjualan.id_penjualan','=', 'detail_penjualan.id_penjualan')->join('produk', 'produk.id_produk','=', 'detail_penjualan.id_produk')->select('produk.nama_produk', DB::raw('SUM(detail_penjualan.qty_detail) as total_qty'), DB::raw('SUM(detail_penjualan.qty_detail * detail_penjualan.harga_detail) as total_harga'))->where('tanggal_penjualan', ">=", $tgl1)->where('tanggal_penjualan', "<=", $tgl2)->groupBy('produk.nama_produk')->get();
            } else{
                $totalUsers =  DB::table('pembelian')->join('detail_pembelian', 'pembelian.id_pembelian','=', 'detail_pembelian.id_pembelian')->join('produk', 'produk.id_produk','=', 'detail_pembelian.id_produk')->select('produk.nama_produk', DB::raw('SUM(detail_pembelian.qty_detail) as total_qty'), DB::raw('SUM(detail_pembelian.qty_detail * detail_pembelian.harga_detail) as total_harga'))->where('tanggal_pembelian', ">=", $tgl1)->where('tanggal_pembelian', "<=", $tgl2)->groupBy('produk.nama_produk')->get();
            }
        $totalUsers = count($totalUsers);
         // Total number of users where DELETE_USER is 0
        $totalPages = ceil($totalUsers / $perPage); // Calculate total pages
    
        // Get the current page from the query string, default to 1 if not set
        $currentPage = $request->page;
    
        // Calculate the offset for the query
        $offset = ($currentPage - 1) * $perPage;
    
        // Fetch users for the current page
        if($jenis == "penjualan"){
            $results =  DB::table('penjualan')->join('detail_penjualan', 'penjualan.id_penjualan','=', 'detail_penjualan.id_penjualan')->join('produk', 'produk.id_produk','=', 'detail_penjualan.id_produk')->select('produk.nama_produk', DB::raw('SUM(detail_penjualan.qty_detail) as total_qty'), DB::raw('SUM(detail_penjualan.qty_detail * detail_penjualan.harga_detail) as total_harga'))->where('tanggal_penjualan', ">=", $tgl1)->where('tanggal_penjualan', "<=", $tgl2)->groupBy('produk.nama_produk')->orderBy('total_harga', 'desc')->offset($offset)->limit($perPage)->get();
            } else{
                $results =  DB::table('pembelian')->join('detail_pembelian', 'pembelian.id_pembelian','=', 'detail_pembelian.id_pembelian')->join('produk', 'produk.id_produk','=', 'detail_pembelian.id_produk')->select('produk.nama_produk', DB::raw('SUM(detail_pembelian.qty_detail) as total_qty'), DB::raw('SUM(detail_pembelian.qty_detail * detail_pembelian.harga_detail) as total_harga'))->where('tanggal_pembelian', ">=", $tgl1)->where('tanggal_pembelian', "<=", $tgl2)->groupBy('produk.nama_produk')->orderBy('total_harga', 'desc')->offset($offset)->limit($perPage)->get();
            }

            $c = count($results);
            if($c == 0){
                return view('noresultView');
            }else{
                if ($totalPages > 5){
                    if ($currentPage == 1){
                        $startPage = 1;
                        $endPage = min($currentPage + 4, $totalPages);
                    }elseif ($currentPage == 2){
                        $startPage = 1;
                        $endPage = min($currentPage + 3, $totalPages);
                    }elseif ($currentPage == $totalPages){
                        $startPage = $currentPage-4;
                        $endPage = $currentPage;
                    }
                    elseif ($currentPage == $totalPages-1){
                        $startPage = $currentPage-3;
                        $endPage = $currentPage+1;
                    }else{
                    $startPage = max($currentPage - 2, 1);
                    $endPage = min($currentPage + 2, $totalPages);
                    }
                    }else{
                        $startPage = 1;
                    $endPage = $totalPages;
                    }
                return view('laporan.ajaxlaporan')->with([
                    'datasend' => $results,
                    'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'startPage' => $startPage,
            'endPage' => $endPage
                ]);
            }
    }
}
