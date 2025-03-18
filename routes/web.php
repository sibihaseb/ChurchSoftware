<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\IndexController;
use App\Http\Controllers\Dashboard\ProjectController;
use App\Http\Controllers\Dashboard\TvAdminUserController;
use App\Http\Controllers\InvoiceController;

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

Route::get('/', [IndexController::class, 'index']);
Route::get('/landing', [IndexController::class, 'landing']);
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('pages.welcome');
    });
    Route::resource('adminuser', TvAdminUserController::class);
    Route::resource('projects', ProjectController::class);
    Route::post('projectfile/{id}', [ProjectController::class, 'uploadfile']);

    Route::resource('invoice', InvoiceController::class);
});
