<?php
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Routes d'authentification (publiques)
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Routes d'authentification (protégées)
Route::prefix('auth')->middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);
});

// Routes publiques
Route::get('/notes',[PostController::class, 'show_notes']);
Route::get('/notes/{id}',[PostController::class, 'show_notes_prat']);
Route::get('/praticiens', [PostController::class, 'index']);
Route::get('/praticiens/search', [PostController::class, 'search']);
Route::get('/praticiens/{id}', [PostController::class, 'show']);
Route::get('/praticiens/nom/{nom}', [PostController::class, 'show_by_name']);

// Routes protégées par JWT (nécessitent un token)
Route::middleware('auth:api')->group(function () {
    Route::post('/praticiens', [PostController::class, 'store']);
    Route::put('/praticiens/{id}', [PostController::class, 'update']);
    Route::delete('/praticiens/{id}', [PostController::class, 'destroy']);
    Route::post('/note/create', [PostController::class, 'add_note']);
});
