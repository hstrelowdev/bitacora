<?php

use App\Http\Controllers\RubroController;
use App\Http\Controllers\EmpresaController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/rubros');

Route::resource('rubros', RubroController::class)->except('show');

Route::resource('empresas', EmpresaController::class)->except('show');
