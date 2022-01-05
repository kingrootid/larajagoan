<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\IndexController;
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
});
Route::group(['prefix' => 'data', 'as' => 'data.'], function () {
    Route::get('warga', [DataController::class, 'warga']);
    Route::get('warga/{id}', [DataController::class, 'getWarga']);
});
Route::group(['prefix' => 'ajax', 'as' => 'ajax.'], function () {
    Route::post('warga', [AjaxController::class, 'warga']);
});
Route::post('login', [AuthController::class, 'authenticate']);
Route::get('app/login', [AuthController::class, 'login'])->name('login');
