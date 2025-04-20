<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColaboradorController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/list-colaboradores', [ColaboradorController::class, 'index'])->name('colaborador.list');
Route::get('/informacoes-colaborador/{id}', [ColaboradorController::class, 'show'])->name('colaborador.info');
Route::delete('/excluir-colaborador/{id}', [ColaboradorController::class, 'destroy'])->name('colaborador.excluir');
Route::get('/create-colaboradores', [ColaboradorController::class, 'create'])->name('colaborador.create');
Route::post('/colaboradores-store', [ColaboradorController::class, 'store'])->name('colaborador.store');
Route::get('/edit-colaboradores/{id}', [ColaboradorController::class, 'edit'])->name('colaborador.edit');

