<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KonsumenController;

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
Route::get('/ajaxkonsumen', [KonsumenController::class, 'ajax']);
Route::post('/addkonsumen', [KonsumenController::class, 'add']);
Route::post('/editkonsumen', [KonsumenController::class, 'edit']);
Route::post('/deletekonsumen', [KonsumenController::class, 'delete']);

