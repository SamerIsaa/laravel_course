<?php

use Illuminate\Support\Facades\DB;
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

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function() {

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

    Route::get('/page3', function () {
        echo app()->getLocale() . '<br>';
        return __('auth.password');
    });

//    Route::get('/change-locale/{locale}', function ($locale) {
////    ''
//        app()->setLocale($locale);
//
//        echo app()->getLocale() . '<br>';
//        return __('auth.password');
//
//    });

});


//
//Route::get('/fill-users-materials', function () {
//   $users = \App\Models\User::query()->get();
//    foreach ($users as $user) {
//        $rand = rand(0,4);
//        $materials = \App\Models\Material::query()->take($rand)->inRandomOrder()->get();
//        foreach ($materials as $material) {
//            DB::table('users_materials')->insert([
//                'user_id' => $user->id,
//                'material_id' => $material->id,
//            ]);
//        }
//    }
//
//    dd('done');
//
//});
