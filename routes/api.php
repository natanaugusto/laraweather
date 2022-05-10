<?php
use App\Http\Controllers\WeatherController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'weather', 'as' => 'weather.'], function () {
    Route::get(uri: '/', action: [WeatherController::class, 'index'])->name(name: 'index');
    Route::group(['prefix' => 'city', 'as' => 'city.'], function () {
        Route::get(uri: '/{city?}', action: [WeatherController::class, 'fetch'])->name(name: 'fetch');
        Route::delete(uri: '/{city}', action: [WeatherController::class, 'destroy'])->name(name: 'destroy');
    });
});
