<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function ajax(Request $request) {
        $name = $request->name;
        $perPage = 12; // Number of items per page
        $totalUsers = DB::table('supplier')->where('delete', 0)->where(function($query) use ($name) {
            $query->where('id_supplier', 'LIKE', '%' . $name . '%')
                  ->orWhere('nama', 'LIKE', '%' . $name . '%')
                  ->orWhere('telp', 'LIKE', '%' . $name . '%');
        })->count(); // Total number of users where DELETE_USER is 0
        $totalPages = ceil($totalUsers / $perPage); // Calculate total pages
    
        // Get the current page from the query string, default to 1 if not set
        $currentPage = $request->page;
    
        // Calculate the offset for the query
        $offset = ($currentPage - 1) * $perPage;
    
        // Fetch users for the current page
        $results = DB::table('supplier')->where('delete', 0)->where(function($query) use ($name) {
            $query->where('id_supplier', 'LIKE', '%' . $name . '%')
                  ->orWhere('nama', 'LIKE', '%' . $name . '%')
                  ->orWhere('telp', 'LIKE', '%' . $name . '%');
        })->offset($offset)->limit($perPage)->get();
    
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
                return view('supplier.ajaxsupplier')->with([
                    'datasend' => $results,
                    'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'startPage' => $startPage,
            'endPage' => $endPage
                ]);
            }
    }
    public function add(Request $request) {
         $messages = [
             'required' => ':attribute harus diisi',
            'numeric'    => ':attribute harus berupa angka',
               'nama.max' => 'Maximal 100 kata '
        ];
        $validator = Validator::make($request->all(), [
            'nama'     => ['required', 'max:100', function ($attribute, $value, $fail) {
                $exists = DB::table('supplier')
                           ->where('nama', $value)
                           ->exists();

                if ($exists) {
                    $fail('Nama sudah ada');
                }
            }],
            'telp'   => 'required|numeric'
        ],$messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        DB::table('supplier')->insert([
            'id_supplier' => "0",
            'nama' => $request->nama,
            'telp' => $request->telp
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!'
        ]);
    }
    public function edit(Request $request) {
        $id = $request->id;
        $messages = [
            'required' => ':attribute harus diisi',
           'numeric'    => ':attribute harus berupa angka',
           'nama.max' => 'Maximal 100 kata'
       ];
        $validator = Validator::make($request->all(), [
            'nama'     => ['required', 'max:100', function ($attribute, $value, $fail) use ($id) {
                $exists = DB::table('supplier')
                           ->where('nama', $value)
                           ->where('id_supplier', '!=', $id)
                           ->exists();

                if ($exists) {
                    $fail('Nama sudah ada');
                }
            }],
            'telp'   => 'required|numeric'
        ],$messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        DB::table('supplier')->where('id_supplier',$id)->update([
            'nama' => $request->nama,
            'telp' => $request->telp
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diubah!'
        ]);
    }
    public function delete(Request $request) {
        DB::table('supplier')->where('id_supplier',$request->id)->update([
            'delete' => 1
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!'
        ]);
    }
}
