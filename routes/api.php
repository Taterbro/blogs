<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\apicontroller;
use App\Http\Controllers\commentcontrol;

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

Route::get('/',[apicontroller::class, 'index']);
Route::post('/',[apicontroller::class, 'addblog'])->middleware('auth:sanctum'); 
Route::put('edit/{id}',[apicontroller::class, 'editblog'])->middleware('auth:sanctum'); 
Route::delete('edit/{id}',[apicontroller::class, 'deleteblog'])->middleware('auth:sanctum'); 
Route::post('register',[apicontroller::class, 'register']);
Route::get('ability',[apicontroller::class, 'ability'])->middleware('auth:sanctum');

//comment urls
Route::post('comment/{blog}',[commentcontrol::class, 'addcomment'])->middleware('auth:sanctum'); 
Route::get('comment/{blog}',[commentcontrol::class, 'getcomment'])->middleware('auth:sanctum');
Route::put('comment/{comment}',[commentcontrol::class, 'editcomment'])->middleware('auth:sanctum');
Route::delete('comment/{comment}',[commentcontrol::class, 'deletecomment'])->middleware('auth:sanctum');
Route::post('/like/{blog}', [apicontroller::class, 'addlike'])->name('like')->middleware('auth:sanctum');
Route::delete('/unlike/{blog}', [apicontroller::class, 'unlike'])->name('unlike')->middleware('auth:sanctum');



