<?php

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AdminController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['role:admin', 'auth'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('user', AdminUserController::class)->only('index');
    Route::get('/get-user', [AdminUserController::class, 'getUser'])->name('getUser');

    Route::post('markNotification', [AdminUserController::class, 'markNotification'])->name('markNotification');
});
require __DIR__.'/auth.php';
