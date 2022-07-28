<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/', [HomeController::class, 'show'])->name('show');

Auth::routes();

Route::resource('/menus', MenuController::class)->except(['show', 'destroy'])->middleware('auth');
Route::prefix('menus')->name('menus.')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/delete', [MenuController::class, 'delete'])->name('delete');
        Route::post('/destroy', [MenuController::class, 'destroy'])->name('destroy');
    });
});

Route::prefix('users')->name('users.')->group(function () {
    Route::middleware('auth')->group(function () {
        // Route::get('/{user}/mypage', [UserController::class, 'show'])->name('show');
        Route::get('/mypage', [UserController::class, 'show'])->name('show');
        // Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::get('/edit', [UserController::class, 'edit'])->name('edit');
        Route::post('/{user}', [UserController::class, 'update'])->name('update');
    });
});
