<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\IndexController;
use App\Http\Controllers\Dashboard\ProjectController;
use App\Http\Controllers\Dashboard\RolePermissionController;
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
    Route::group(['middleware' => 'permission:Role Management'], function () {
        Route::get('roletable', [RolePermissionController::class, 'roletable'])->name('roletable');
        Route::get('createrole', [RolePermissionController::class, 'createrole'])->name('createrole');
        Route::post('storerole', [RolePermissionController::class, 'rolestore'])->name('addrole');
        Route::post('roleupdate', [RolePermissionController::class, 'roleupdate'])->name('role.update');
        Route::get('role/{id}/edit', [RolePermissionController::class, 'editrole']);
        Route::get('role/editpage/{id}', [RolePermissionController::class, 'editafter']);
        Route::get('role/destroy/{id}', [RolePermissionController::class, 'destroy']);
    });
    Route::resource('adminuser', TvAdminUserController::class);
    Route::resource('projects', ProjectController::class);
    Route::post('projectfile/{id}', [ProjectController::class, 'uploadfile']);

    Route::resource('invoice', InvoiceController::class);
});
