<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\PairController;
use App\Http\Controllers\ServerStatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'admin', 'middleware'=> 'auth:sanctum'] ,function () {
    Route::resource('/pairs', PairController::class);
    Route::resource('/currencies', CurrencyController::class);
});

Route::get('/pairs', [PairController::class, 'publicIndex']);
Route::get('/count', [PairController::class, 'getCountByCurrenciesCode']);
Route::get('/convertion', [PairController::class, 'getConvertedDataFromPair']);
Route::get('/ping', [ServerStatusController::class, 'serverStatus']);