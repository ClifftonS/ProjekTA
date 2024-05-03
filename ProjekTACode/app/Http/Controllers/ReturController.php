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

        $perPage = 12; // Number of items per page
        $totalUsers = DB::table('penjualan')->join('konsumen', 'konsumen.id_konsumen','=', 'penjualan.id_konsumen')->where(function($query) use ($name) {
            $query->where('id_penjualan', 'LIKE', '%' . $name . '%')
                  ->orWhere('nama', 'LIKE', '%' . $name . '%')
                  ->orWhere('total_penjualan', 'LIKE', '%' . $name . '%')
                  ->orWhere('tanggal_penjualan', 'LIKE', '%' . $name . '%');
        })->where('tanggal_penjualan', ">=", $tgl1)->where('tanggal_penjualan', "<=", $tgl2)->count(); // Total number of users where DELETE_USER is 0
        $totalPages = ceil($totalUsers / $perPage); // Calculate total pages
    
        // Get the current page from the query string, default to 1 if not set
        $currentPage = $request->page;
    
        // Calculate the offset for the query
        $offset = ($currentPage - 1) * $perPage;
    
        // Fetch users for the current page
        $results = DB::table('penjualan')->join('konsumen', 'konsumen.id_konsumen','=', 'penjualan.id_konsumen')->where(function($query) use ($name) {
            $query->where('id_penjualan', 'LIKE', '%' . $name . '%')
                  ->orWhere('nama', 'LIKE', '%' . $name . '%')
                  ->orWhere('total_penjualan', 'LIKE', '%' . $name . '%')
                  ->orWhere('tanggal_penjualan', 'LIKE', '%' . $name . '%');
        })->where('tanggal_penjualan', ">=", $tgl1)->where('tanggal_penjualan', "<=", $tgl2)->orderBy('id_penjualan', 'desc')->offset($offset)->limit($perPage)->get();
    
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
                return view('retur.ajaxretur')->with([
                    'datasend' => $results,
                    'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'startPage' => $startPage,
            'endPage' => $endPage
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
