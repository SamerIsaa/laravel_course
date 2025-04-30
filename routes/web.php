<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
//*/

Route::get('/', function () {
    $data['title'] = "dashboard";
    $data['range'] = range(10, 1000 , 50);
    return view('panel.index',$data);
});

Route::get('/page2', function () {
    $title = "page2";
    $color= "#123483";
    return view('panel.samer' , compact('title' , 'color'));
});
