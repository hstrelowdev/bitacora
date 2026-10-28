<?php

use App\Http\Controllers\EmpleoController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RubroController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::redirect('/', '/rubros');

    Route::resource('rubros', RubroController::class)->except('show');
    Route::resource('empresas', EmpresaController::class)->except('show');
    Route::resource('empleos', EmpleoController::class)->except('show');
});
