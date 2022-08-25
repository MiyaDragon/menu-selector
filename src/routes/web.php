<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes(['confirm'  => false]);

Route::resource('/menus', MenuController::class)->except(['show'])->middleware('auth');
Route::prefix('menus')->name('menus.')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/calendar', [MenuController::class, 'showMenuCalendar'])->name('calendar');
        Route::post('/ateMenu/store', [MenuController::class, 'ateMenuStore'])->name('ateMenuStore');
    });
});

Route::prefix('users')->name('users.')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/edit', [UserController::class, 'edit'])->name('edit');
        Route::get('/edit/name', [UserController::class, 'editName'])->name('editName');
        Route::put('/update/name', [UserController::class, 'updateName'])->name('updateName');
        Route::get('/edit/email', [UserController::class, 'editEmail'])->name('editEmail');
        Route::put('/update/email', [UserController::class, 'updateEmail'])->name('updateEmail');
        Route::get('/edit/password', [UserController::class, 'editPassword'])->name('editPassword');
        Route::put('/update/password', [UserController::class, 'updatePassword'])->name('updatePassword');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
});

Route::prefix('login')->name('login.')->group(function () {
    Route::get('/{provider}', [LoginController::class, 'redirectToProvider'])->name('{provider}');
    Route::get('/{provider}/callback', [LoginController::class, 'handleProviderCallback'])->name('{provider}.callback');
});

Route::prefix('register')->name('register.')->group(function () {
    Route::get('/{provider}', [RegisterController::class, 'showProviderUserRegistrationForm'])->name('{provider}');
    Route::post('/{provider}', [RegisterController::class, 'registerProviderUser'])->name('{provider}');
});
