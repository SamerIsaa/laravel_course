<?php

use Illuminate\Http\Request;
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
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {

    Route::get('/', function () {
        $data['title'] = "dashboard";
        $data['range'] = range(10, 1000, 50);
        $data['blog'] = \App\Models\Blog::query()->first();
        return view('panel.index', $data);
    });


    Route::get('/page2', function () {
        $title = "page2";
        $color = "#123483";
        return view('panel.samer', compact('title', 'color'));
    });

    Route::get('/page3', function () {
        echo app()->getLocale() . '<br>';
        return __('auth.password');
    });


    Route::get('auth/callback', function (Request $request) {
        $provider = $request->provider;
        if ($provider == "github") {
            $user = \Laravel\Socialite\Facades\Socialite::driver('github')->user();

            if (!$user->email){
                $check = \App\Models\User::query()->where('email', $user->email)->first();
                if ($check) {
                    // login done
                    dd('login done');
                }
            }else{
                $check = \App\Models\User::query()->where('provider_id', $user->id)
                        ->where('provider', $provider)
                    ->first();


                if ($check) {
                    dd('login done 2');
                };
            }



            \App\Models\User::query()->create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => \Illuminate\Support\Facades\Hash::make(rand(100000, 999999)),

                'provider_id' => $user->id,
                'provider' => $provider,
            ]);

            dd('register done');

        }
    })->name('auth.callback');;

    Route::get('auth/{provider}', function ($provider) {

        if ($provider == "github") {
            return \Laravel\Socialite\Facades\Socialite::driver('github')->redirect();
        } elseif ($provider == "facebook") {
            return \Laravel\Socialite\Facades\Socialite::driver('facebook')->redirect();
        }

//        dd("provider not found")
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
