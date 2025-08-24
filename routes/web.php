<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'message' => 'Hello from Inertia.js in Laravel!',
    ]);
});

Route::get('/todos', [TodoController::class, 'index']);
Route::post('/todos', [TodoController::class, 'store']);
Route::delete('/todos/{todo}', [TodoController::class, 'destroy']);
Route::patch('/todos/{todo}/toggle', [TodoController::class, 'toggle']);  // Specific for toggle
Route::patch('/todos/{todo}', [TodoController::class, 'updateTask']);  // For editing task