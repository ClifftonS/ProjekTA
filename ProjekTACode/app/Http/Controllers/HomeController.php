<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function kategori(Request $request) {
        return view('kategori.kategori');
    }
    public function konsumen(Request $request) {
        return view('konsumen.konsumen');
    }
    public function supplier(Request $request) {
        return view('supplier.supplier');
    }
    public function merk(Request $request) {
        return view('merk.merk');
    }
    public function produk(Request $request) {
        return view('produk.produk');
    }
    public function penjualan(Request $request) {
        return view('penjualan.penjualan');
    }
    public function pembelian(Request $request) {
        return view('pembelian.pembelian');
    }
    public function laporan(Request $request) {
        return view('laporan.laporan');
    }
    public function dashboard(Request $request) {
        return view('dashboard.dashboard');
    }
    public function stockop(Request $request) {
        return view('stockop.stockop');
    }
    public function retur(Request $request) {
        return view('retur.retur');
    }
}
