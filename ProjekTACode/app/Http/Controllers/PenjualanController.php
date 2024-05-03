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
                return view('penjualan.ajaxpenjualan')->with([
                    'datasend' => $results,
                    'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'startPage' => $startPage,
            'endPage' => $endPage
                ]);
            }
    }
    public function ajaxadd() {
         $produk =  DB::table('produk')->where('stok_produk', '>', 0)->where('delete', 0)->get();
         $supplier =  DB::table('konsumen')->where('delete', 0)->get();
         return response()->json([
             'produk' => $produk,
             'supplier'    => $supplier
         ]);
     }
     public function tooltip(Request $request) {
        $result =   DB::table('penjualan')->join('konsumen', 'konsumen.id_konsumen','=', 'penjualan.id_konsumen')->select('konsumen.id_konsumen', DB::raw('COUNT(*) as total_trans'))->where('konsumen.id_konsumen', $request->total)->groupBy('konsumen.id_konsumen')->first();
        $total = $result ? $result->total_trans : 0;
        return response()->json([
            'total' => $total
        ]);
    }
    public function add(Request $request) {
        $rules = [
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
            'harga1' => 'required'
        ];
        for ($j = 1; $j <= $request->jumlahdata; $j++) {
            $produk = "produk" . '' .$j;
            $totalsisa =  DB::table('produk')
            ->where('id_produk', $request->$produk)
            ->value('stok_produk');
            $rules["qty$j"] = [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) use ($totalsisa) {
                    // Validasi agar qty tidak lebih besar dari totalsisa
                    if ($value > $totalsisa) {
                        $fail("Stok sisa ($totalsisa)");
                    }
                }
            ];
        }
        $messages = [
            'tanggal.required' => 'Tanggal harus diisi',
            'qty1.required' => 'Qty harus diisi',
            'harga1.required' => 'Harga harus diisi'
       ];
        $validator = Validator::make($request->all(), $rules, $messages);

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
                'stok_produk' => $stok_awal - $request->$qty
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
            'tanggal.required' => 'Tanggal harus diisi'
       ];
        $validator = Validator::make($request->all(), [
            'supplier'   => ['required', function ($attribute, $value, $fail) {
                if ($value == "kosong") {
                    $fail('Konsumen tidak boleh kosong');
                }
            }],
            'tanggal' => 'required'
        ],$messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $formatted_date = date('Y-m-d', strtotime($request->tanggal));
        DB::table('penjualan')->where('id_penjualan',$id)->update([
            'id_konsumen' => $request->supplier,
            'tanggal_penjualan' => $formatted_date
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
