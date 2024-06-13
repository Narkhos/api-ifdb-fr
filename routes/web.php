<?php

use App\Http\Controllers\IfdbController;
use Illuminate\Support\Facades\Route;

// Route::get(
//     '/xdebug-info',
//     [IfdbController::class, function () {
//         return xdebug_info();
//     }]
// );

// Route::get(
//     '/php-info',
//     [IfdbController::class, function () {
//         return phpinfo();
//     }]
// );

Route::get(
    '/',
    [IfdbController::class, 'index']
);

Route::get(
    '/competitions/{id}',
    [IfdbController::class, 'competitionEntries']
);

Route::get(
    '/games/{id}',
    [IfdbController::class, 'gameDetail']
);
