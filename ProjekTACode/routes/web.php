<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KonsumenController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StockopController;
use App\Http\Controllers\ReturController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'get']);
Route::post('/login', [LoginController::class, 'post']);
Route::get('/logout', [LoginController::class, 'logout']);
Route::get('/adduser', [LoginController::class, 'adduser']);
Route::get('/loginpage', function () {
    return view('login');
});

Route::get('/konsumen', [HomeController::class, 'konsumen'])->middleware(['access:owner']);
Route::get('/ajaxkonsumen', [KonsumenController::class, 'ajax'])->middleware(['access:owner']);
Route::post('/addkonsumen', [KonsumenController::class, 'add']);
Route::post('/editkonsumen', [KonsumenController::class, 'edit']);
Route::post('/deletekonsumen', [KonsumenController::class, 'delete']);

Route::get('/supplier', [HomeController::class, 'supplier'])->middleware(['access:owner']);
Route::get('/ajaxsupplier', [SupplierController::class, 'ajax'])->middleware(['access:owner']);
Route::post('/addsupplier', [SupplierController::class, 'add']);
Route::post('/editsupplier', [SupplierController::class, 'edit']);
Route::post('/deletesupplier', [SupplierController::class, 'delete']);

Route::get('/merk', [HomeController::class, 'merk'])->middleware(['access:owner']);
Route::get('/ajaxmerk', [MerkController::class, 'ajax'])->middleware(['access:owner']);
Route::post('/addmerk', [MerkController::class, 'add']);
Route::post('/editmerk', [MerkController::class, 'edit']);
Route::post('/deletemerk', [MerkController::class, 'delete']);

Route::get('/kategori', [HomeController::class, 'kategori'])->middleware(['access:owner']);
Route::get('/ajaxkategori', [KategoriController::class, 'ajax'])->middleware(['access:owner']);
Route::post('/addkategori', [KategoriController::class, 'add']);
Route::post('/editkategori', [KategoriController::class, 'edit']);
Route::post('/deletekategori', [KategoriController::class, 'delete']);

Route::get('/produk', [HomeController::class, 'produk'])->middleware(['access:owner']);
Route::get('/ajaxproduk', [ProdukController::class, 'ajax'])->middleware(['access:owner']);
Route::get('/ajaxprodukadd', [ProdukController::class, 'ajaxadd']);
Route::post('/addproduk', [ProdukController::class, 'add']);
Route::post('/editproduk', [ProdukController::class, 'edit']);
Route::post('/deleteproduk', [ProdukController::class, 'delete']);

Route::get('/penjualan', [HomeController::class, 'penjualan'])->middleware(['access:owner']);
Route::get('/ajaxpenjualan', [PenjualanController::class, 'ajax'])->middleware(['access:owner']);
Route::get('/ajaxpenjualanadd', [PenjualanController::class, 'ajaxadd']);
Route::get('/ajaxpenjualanlihat', [PenjualanController::class, 'ajaxlihat']);
Route::get('/ajaxtooltip', [PenjualanController::class, 'tooltip']);
Route::post('/addpenjualan', [PenjualanController::class, 'add']);
Route::post('/editpenjualan', [PenjualanController::class, 'edit']);
Route::get('/cetaknota/{id}', [PenjualanController::class, 'print']);

Route::get('/pembelian', [HomeController::class, 'pembelian'])->middleware(['access:owner']);
Route::get('/ajaxpembelian', [PembelianController::class, 'ajax'])->middleware(['access:owner']);
Route::get('/ajaxpembelianadd', [PembelianController::class, 'ajaxadd']);
Route::get('/ajaxpembelianlihat', [PembelianController::class, 'ajaxlihat']);
Route::post('/addpembelian', [PembelianController::class, 'add']);
Route::post('/editpembelian', [PembelianController::class, 'edit']);

Route::get('/laporan', [HomeController::class, 'laporan'])->middleware(['access:owner']);
Route::get('/ajaxlaporan', [LaporanController::class, 'ajax'])->middleware(['access:owner']);

Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['access:owner']);
Route::get('/ajaxdashboardstok', [DashboardController::class, 'ajax1']);
Route::get('/ajaxkonsumenter', [DashboardController::class, 'ajax2']);
Route::get('/ajaxprodukter', [DashboardController::class, 'ajax3']);
Route::get('/ajaxpendapatan', [DashboardController::class, 'ajax4']);
Route::get('/chart', [DashboardController::class, 'chart']);
Route::get('/subchart', [DashboardController::class, 'subchart']);

Route::get('/stockop', [HomeController::class, 'stockop'])->middleware(['access:owner']);
Route::get('/ajaxstockop', [StockopController::class, 'ajax'])->middleware(['access:owner']);
Route::post('/addstockop', [StockopController::class, 'add']);
Route::post('/editstockop', [StockopController::class, 'edit']);
Route::get('/ajaxstockopadd', [StockopController::class, 'ajaxadd']);
Route::get('/ajaxstockopaddstok', [StockopController::class, 'ajaxaddstok']);

Route::get('/retur', [HomeController::class, 'retur'])->middleware(['access:owner']);
Route::get('/ajaxretur', [ReturController::class, 'ajax'])->middleware(['access:owner']);
Route::post('/editretur', [ReturController::class, 'edit']);



