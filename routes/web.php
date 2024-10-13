<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/create-colaboradores', function () {
    return view('create-colaboradores');
});

Route::get('/edit-colaboradores', function () {
    return view('edit-colaboradores');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/colaboradores-store', [App\Http\Controllers\ColaboradorController::class, 'store'])->name('colaborador.store');
