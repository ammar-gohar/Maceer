<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

Route::redirect('/home', '/')
    ->middleware('auth');

Route::get('/language/{lang?}', function($lang){
    if(isset($lang) && in_array($lang, config('app.available_locales'))){
        session()->put('language', $lang);
        app()->setLocale($lang);
    };
    return back();
});
