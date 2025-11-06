<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PraticienControlleur;
use App\Http\Controllers\ConnexionControlleur;
use App\Http\Controllers\PostController;


Route::get('/', [ConnexionControlleur::class, 'index'])->name('connexion.index');
Route::get('/login', [ConnexionControlleur::class, 'fraude'])->name('login');
Route::post('/login', [ConnexionControlleur::class, 'connecter'])->name('login.post');

Route::middleware('auth')->group(function () {
Route::post('/search', [PraticienControlleur::class, 'search'])->name('praticiens.search');
Route::get('/praticiens', [PraticienControlleur::class, 'index'])->name('praticiens.index');
Route::post('/praticiens/{id}/add-anciennete', [PraticienControlleur::class, 'addAnciennete'])->name('praticiens.add');
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
Route::get('/praticiens/{id}', [PraticienControlleur::class, 'show'])->name('praticiens.show');
});


