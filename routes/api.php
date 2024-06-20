<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Protected
Route::group(['middleware'=>['auth:sanctum']], function () {
    Route::post('/posts/{id}/store',[PostController::class,'store']);
    Route::put('/posts/{id}/update',[PostController::class,'update']);
    Route::delete('/posts/{id}/destroy',[PostController::class,'destroy']);
    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/posts/{id}',[PostController::class,'fetch_post_user']);
    Route::get('/posts/{id}/show',[PostController::class,'show']);

});

//Public
Route::get('/posts',[PostController::class,'index'])->name('index');


//USER
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
