<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockopController extends Controller
{
    public function ajax(Request $request) {
        $name = $request->name;
        $tgl1 = date('Y-m-d', strtotime($request->tgl1));
        $tgl2 = date('Y-m-d', strtotime($request->tgl2));

        $perPage = 12; // Number of items per page
        $totalUsers = DB::table('stock_opname')->join('produk', 'produk.id_produk','=', 'stock_opname.id_produk')->where(function($query) use ($name) {
            $query->where('id_stockop', 'LIKE', '%' . $name . '%')
                  ->orWhere('keterangan', 'LIKE', '%' . $name . '%')
                  ->orWhere('tgl_stockop', 'LIKE', '%' . $name . '%')
                  ->orWhere('jumlah_sistem', 'LIKE', '%' . $name . '%')
                  ->orWhere('jumlah_hitung', 'LIKE', '%' . $name . '%')
                  ->orWhere('nama_produk', 'LIKE', '%' . $name . '%');
        })->where('tgl_stockop', ">=", $tgl1)->where('tgl_stockop', "<=", $tgl2)->count(); // Total number of users where DELETE_USER is 0
        $totalPages = ceil($totalUsers / $perPage); // Calculate total pages
    
        // Get the current page from the query string, default to 1 if not set
        $currentPage = $request->page;
    
        // Calculate the offset for the query
        $offset = ($currentPage - 1) * $perPage;
    
        // Fetch users for the current page
        $results = DB::table('stock_opname')->join('produk', 'produk.id_produk','=', 'stock_opname.id_produk')->where(function($query) use ($name) {
            $query->where('id_stockop', 'LIKE', '%' . $name . '%')
                  ->orWhere('keterangan', 'LIKE', '%' . $name . '%')
                  ->orWhere('tgl_stockop', 'LIKE', '%' . $name . '%')
                  ->orWhere('jumlah_sistem', 'LIKE', '%' . $name . '%')
                  ->orWhere('jumlah_hitung', 'LIKE', '%' . $name . '%')
                  ->orWhere('nama_produk', 'LIKE', '%' . $name . '%');
        })->where('tgl_stockop', ">=", $tgl1)->where('tgl_stockop', "<=", $tgl2)->orderBy('id_stockop', 'desc')->offset($offset)->limit($perPage)->get();
    
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
                return view('stockop.ajaxstockop')->with([
                    'datasend' => $results,
                    'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'startPage' => $startPage,
            'endPage' => $endPage
                ]);
            }
    }
    public function ajaxadd() {
        $produk =  DB::table('produk')->where('delete', 0)->get();
         return response()->json([
             'produk' => $produk
         ]);
    }
    public function ajaxaddstok(Request $request) {
        $stok =  DB::table('produk')->where('id_produk', $request->id)->value('stok_produk');
         return response()->json([
             'stok' => $stok
         ]);
    }
    public function add(Request $request) {
        $messages = [
            'required' => ':attribute harus diisi'
       ];
        $validator = Validator::make($request->all(), [
            'nama'   => ['required', function ($attribute, $value, $fail) {
                if ($value == "kosong") {
                    $fail('Merk tidak boleh kosong');
                }
            }],
            'stok' => 'required',
            'ket' => 'required',
            'tanggal' => 'required'
        ],$messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        DB::table('stock_opname')->insert([
            'id_stockop' => "0",
            'tgl_stockop' => $request->tanggal,
            'id_produk' => $request->nama,
            'keterangan' => $request->ket,
            'jumlah_hitung' => $request->stok,
            'jumlah_sistem'  => $request->stoksistem
        ]);

        DB::table('produk')->where('id_produk',$request->nama)->update([
            'stok_produk' => $request->stok
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!'
        ]);
    }
    // public function edit(Request $request) {
    //     $id = $request->id;
    //     $messages = [
    //         'required' => ':attribute harus diisi',
    //        'nama.max' => 'Maximal 50 kata '
    //    ];
    //     $validator = Validator::make($request->all(), [
    //         'nama'     => ['required', 'max:50', function ($attribute, $value, $fail) use ($id) {
    //             $exists = DB::table('kategori')
    //                        ->where('kategori', $value)
    //                        ->where('id_kategori', '!=', $id)
    //                        ->exists();

    //             if ($exists) {
    //                 $fail('Nama sudah ada');
    //             }
    //         }]
    //     ],$messages);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }

    //     DB::table('kategori')->where('id_kategori',$id)->update([
    //         'kategori' => $request->nama
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Data Berhasil Diubah!'
    //     ]);
    // }
}
