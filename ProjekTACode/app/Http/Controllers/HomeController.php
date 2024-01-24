<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function get() {
        $result = DB::table('konsumen')->where('delete', 0)->get();
        return response()->json($result);
    }
}
