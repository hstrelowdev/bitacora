<?php

use App\Http\Controllers\RubroController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/rubros');

Route::resource('rubros', RubroController::class)->except('show');
