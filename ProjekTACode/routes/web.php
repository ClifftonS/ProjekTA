<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KonsumenController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;

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

Route::get('/', function () {
    return view('homepageView');
});

Route::get('/konsumen', [HomeController::class, 'konsumen']);
Route::get('/ajaxkonsumen', [KonsumenController::class, 'ajax']);
Route::post('/addkonsumen', [KonsumenController::class, 'add']);
Route::post('/editkonsumen', [KonsumenController::class, 'edit']);
Route::post('/deletekonsumen', [KonsumenController::class, 'delete']);

Route::get('/merk', [HomeController::class, 'merk']);
Route::get('/ajaxmerk', [MerkController::class, 'ajax']);
Route::post('/addmerk', [MerkController::class, 'add']);
Route::post('/editmerk', [MerkController::class, 'edit']);
Route::post('/deletemerk', [MerkController::class, 'delete']);

Route::get('/kategori', [HomeController::class, 'kategori']);
Route::get('/ajaxkategori', [KategoriController::class, 'ajax']);
Route::post('/addkategori', [KategoriController::class, 'add']);
Route::post('/editkategori', [KategoriController::class, 'edit']);
Route::post('/deletekategori', [KategoriController::class, 'delete']);

Route::get('/produk', [HomeController::class, 'produk']);
Route::get('/ajaxproduk', [ProdukController::class, 'ajax']);
Route::get('/ajaxprodukadd', [ProdukController::class, 'ajaxadd']);
Route::post('/addproduk', [ProdukController::class, 'add']);
Route::post('/editproduk', [ProdukController::class, 'edit']);
Route::post('/deleteproduk', [ProdukController::class, 'delete']);

Route::get('/penjualan', [HomeController::class, 'penjualan']);
Route::get('/pembelian', [HomeController::class, 'pembelian']);
