<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\WindowlightController::class, 'show'])->name('home');
Route::post('/generate', [\App\Http\Controllers\WindowlightController::class, 'store'])->name('windowlight.store')->middleware('throttle:generate');

Route::get('/about', [\App\Http\Controllers\MarkdownViewController::class, 'about'])->name('about');
Route::get('/examples', [\App\Http\Controllers\MarkdownViewController::class, 'examples'])->name('examples');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
