<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/{vue_capture?}', function () {
    if (Auth::check()) {
        return view('welcome');
    } else {
        return redirect('/');
    }
})->where('vue_capture', '[\/\w\.-]*');