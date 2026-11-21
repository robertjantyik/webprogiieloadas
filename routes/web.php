<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotebookController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/adatbazis', [NotebookController::class, 'index'])->name('notebooks.index');
Route::get('/diagram', [PageController::class, 'chart'])->name('chart');
Route::get('/kapcsolat', [MessageController::class, 'create'])->name('contact');
Route::post('/kapcsolat', [MessageController::class, 'store'])->name('contact.store');
Route::get('/uzenetek', [MessageController::class, 'index'])->middleware('auth')->name('messages.index');
Route::middleware('guest')->group(function () {
    Route::get('/bejelentkezes', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/bejelentkezes', [AuthController::class, 'login']);
    Route::get('/regisztracio', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/regisztracio', [AuthController::class, 'register']);
});
Route::middleware('auth')->group(function () {
    Route::post('/kijelentkezes', [AuthController::class, 'logout'])->name('logout');
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('notebooks', [NotebookController::class, 'index'])->name('notebooks.index');
        Route::get('notebooks/create', [NotebookController::class, 'create'])->name('notebooks.create');
        Route::post('notebooks', [NotebookController::class, 'store'])->name('notebooks.store');
        Route::get('notebooks/{notebook}/edit', [NotebookController::class, 'edit'])->name('notebooks.edit');
        Route::put('notebooks/{notebook}', [NotebookController::class, 'update'])->name('notebooks.update');
        Route::delete('notebooks/{notebook}', [NotebookController::class, 'destroy'])->name('notebooks.destroy');
    });
});
