<?php

use App\Http\Controllers\authcontroller;
use App\Http\Controllers\blogcontrol;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('register');
});

Route::post('/register', [authcontroller::class, 'register'])->name('register');
Route::post('/login', [authcontroller::class, 'login'])->name('login');
Route::post('/logout', [authcontroller::class, 'logout'])->name('logout');

Route::get('/blogs', [blogcontrol::class, 'blogs'])->name('blogs')->middleware('auth');
Route::post('/addblog', [blogcontrol::class, 'addblog'])->name('addblog')->middleware('auth');
Route::get('/myblogs', [blogcontrol::class, 'myblogs'])->name('myblogs');
Route::get('/bloginfo/{blog}', [blogcontrol::class, 'bloginfo'])->name('bloginfo')->middleware('auth');
Route::delete('/deleteblog/{blog}', [blogcontrol::class, 'deleteblog'])->name('deleteblog')->middleware('auth');






