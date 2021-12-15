<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\AdminController;

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



Route::post('/edd',[ProfileController::class, 'calculate']);
Route::post('/profile',[ProfileController::class, 'store']);
Route::get('profile/{id}', [ProfileController::class,'show']);
Route::put('profile/{id}', [ProfileController::class,'update']);


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

Route::post('/adminregister', 'App\Http\Controllers\AdminController@register');
Route::post('/adminlogin', 'App\Http\Controllers\AdminController@login');
Route::post('/adminlogout', 'App\Http\Controllers\AdminController@logout');


Route::get('/diaries', [DiaryController::class, 'index']);
Route::post('/diaries',[DiaryController::class, 'store']);
Route::get('diaries/{id}', [DiaryController::class,'show']);
Route::put('diaries/{id}', [DiaryController::class,'update']);
Route::delete('diaries/{id}', [DiaryController::class,'destroy']);
