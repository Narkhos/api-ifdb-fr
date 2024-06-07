<?php

use App\Http\Controllers\IfdbController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get(
    '/',
    [IfdbController::class, 'index']
);

Route::get(
    '/competition-entries',
    [IfdbController::class, 'competitionEntries']
);

Route::get(
    '/{id}',
    [IfdbController::class, 'gameDetail']
);
