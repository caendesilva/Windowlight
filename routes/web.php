<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\HydeController;
use App\Http\Controllers\MarkdownViewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WindowlightController;
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

Route::get('/', [WindowlightController::class, 'show'])->name('home');
Route::post('/generate', [WindowlightController::class, 'store'])->name('windowlight.store')->middleware('throttle:generate');

Route::get('/about', [MarkdownViewController::class, 'about'])->name('about');
Route::get('/examples', [MarkdownViewController::class, 'examples'])->name('examples');

Route::get('/analytics', [AnalyticsController::class, 'show'])->name('analytics');
Route::get('/analytics/raw', [AnalyticsController::class, 'raw'])->name('analytics.raw');
Route::get('/analytics/json', [AnalyticsController::class, 'json'])->name('analytics.json');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('hyde')->group(function () {
    Route::get('/posts', [HydeController::class, 'posts'])->name('posts');
    Route::get('/posts/{identifier}', [HydeController::class, 'post'])->name('post');
});

Route::redirect('/terms-of-service', '/about#terms-of-service', 301)->name('terms-of-service');
Route::redirect('/privacy-policy', '/about#privacy-policy', 301)->name('privacy-policy');

require __DIR__.'/auth.php';
