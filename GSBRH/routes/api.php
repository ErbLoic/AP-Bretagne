<?php
use App\Http\Controllers\PostController;

Route::get('/praticiens', [PostController::class, 'index']);
Route::get('/praticiens/{id}', [PostController::class, 'show']);
Route::post('/praticiens', [PostController::class, 'store']);
Route::put('/praticiens/{id}', [PostController::class, 'update']);
Route::delete('/praticiens/{id}', [PostController::class, 'destroy']);
