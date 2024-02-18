<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LangController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('lang/change', [LangController::class, 'change'])->name('change-lang');
