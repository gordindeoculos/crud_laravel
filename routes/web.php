<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColaboradorController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/create-colaboradores', [ColaboradorController::class, 'create'])->name('colaborador.create');
Route::get('/edit-colaborador/{id}', [ColaboradorController::class, 'edit'])->name('colaborador.edit');
Route::put('/update-colaborador/{id}', [ColaboradorController::class, 'update'])->name('colaborador.update');
Route::get('/detalhes-colaborador/{id}', [ColaboradorController::class, 'show'])->name('colaborador.detalhes');
Route::delete('/excluir-colaborador/{id}', [ColaboradorController::class, 'destroy'])->name('colaborador.excluir');
Route::get('/list-colaboradores', [ColaboradorController::class, 'index'])->name('coloborador.list');
Route::post('/colaboradores-store', [ColaboradorController::class, 'store'])->name('colaborador.store');
