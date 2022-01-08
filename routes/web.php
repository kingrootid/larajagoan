<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', [IndexController::class, 'index']);
    Route::get('/warga', [WargaController::class, 'index']);
    Route::get('/warga/rumah', [WargaController::class, 'rumah']);
    Route::get('/iuran/warga', [IuranController::class, 'index']);
    Route::get('/iuran/pengeluaran', [IuranController::class, 'pengeluaran']);
    Route::get('/config/category', [ConfigController::class, 'category']);
    Route::get('/config/admin', [ConfigController::class, 'admin']);
    Route::get('/iuran/history', [IuranController::class, 'history']);
});
Route::group(['prefix' => 'data', 'as' => 'data.'], function () {
    Route::get('history', [DataController::class, 'history']);
    Route::get('warga', [DataController::class, 'warga']);
    Route::get('warga/{id}', [DataController::class, 'getWarga']);
    Route::get('category', [DataController::class, 'category']);
    Route::get('category/{id}', [DataController::class, 'getCategory']);
    Route::get('admin', [DataController::class, 'admin']);
    Route::get('admin/{id}', [DataController::class, 'getAdmin']);
    Route::get('pengeluaran', [DataController::class, 'pengeluaran']);
    Route::get('pengeluaran/{id}', [DataController::class, 'getPengeluaran']);
    Route::get('rumah', [DataController::class, 'rumah']);
    Route::get('rumah/{id}', [DataController::class, 'getRumah']);
    Route::get('iuran/warga', [DataController::class, 'iuran_warga']);
    Route::get('iuran/warga/{id}', [DataController::class, 'getiuran_warga']);
    Route::get('wargaNotKK', [DataController::class, 'wargaNotKK']);
});
Route::group(['prefix' => 'ajax', 'as' => 'ajax.'], function () {
    Route::post('warga', [AjaxController::class, 'warga']);
    Route::post('rumah', [AjaxController::class, 'rumah']);
    Route::post('category', [AjaxController::class, 'category']);
    Route::post('pengeluaran', [AjaxController::class, 'pengeluaran']);
    Route::post('admin', [AjaxController::class, 'admin']);
    Route::post('iuran/warga', [AjaxController::class, 'iuran_warga']);
});
Route::post('login', [AuthController::class, 'authenticate']);
Route::get('app/login', [AuthController::class, 'login']);
Route::get('app/set_dummy', [AuthController::class, 'dummySuperAdmin']);
Route::get('app/logout', [AuthController::class, 'logout']);
