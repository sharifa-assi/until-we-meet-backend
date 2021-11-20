<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;


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

Route::get('/categories',[CategoryController::class, 'index']);
Route::post('/categories',[CategoryController::class, 'store']);
Route::get('categories/{id}', [CategoryController::class,'show']);
Route::put('categories/{id}', [CategoryController::class,'update']);
Route::delete('categories/{id}', [CategoryController::class,'destroy']);



Route::get('/blogs', [BlogController::class, 'index']);
Route::post('/blogs',[BlogController::class, 'store']);
Route::get('blogs/{id}', [BlogController::class,'show']);
Route::put('blogs/{id}', [BlogController::class,'update']);
Route::delete('blogs/{id}', [BlogController::class,'destroy']);

Route::group(['middleware' => 'auth.jwt'], function () {

});
Route::post('/register', 'App\Http\Controllers\AuthController@register');
Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/logout', 'App\Http\Controllers\AuthController@logout');
