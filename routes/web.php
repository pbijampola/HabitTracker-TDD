<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HabitController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/habits', [HabitController::class, 'index']);
Route::post('/habits', [HabitController::class, 'store']);
Route::put('/habits/{habit}', [HabitController::class, 'update']);
Route::delete('/habits/{habit}', [HabitController::class, 'destroy']);

