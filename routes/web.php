<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Dashboard\TagController;
use App\Http\Controllers\Dashboard\IndexController;
use App\Http\Controllers\Dashboard\ChurchController;
use App\Http\Controllers\Dashboard\BillingController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProjectController;
use App\Http\Controllers\Dashboard\MemberTypeController;
use App\Http\Controllers\Dashboard\TvAdminUserController;
use App\Http\Controllers\Dashboard\PaymentMethodController;
use App\Http\Controllers\Dashboard\RolePermissionController;
use App\Http\Controllers\Dashboard\ServiceInvoiceController;
use App\Http\Controllers\Dashboard\DepositeAccountController;
use App\Http\Controllers\Dashboard\FamilyMemberTypeController;
use App\Http\Controllers\Dashboard\DashboardLanguageController;

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
Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/home', [IndexController::class, 'home']);
    Route::get('/fetch-top-donors', [IndexController::class, 'topDonors'])->name('top-donors');

    Route::get('/userprofile', [IndexController::class, 'profile']);
    Route::post('/profileupdate', [IndexController::class, 'UpdateProfile']);

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
    Route::post('setappconfig', [TvAdminUserController::class, 'appCodeSet'])->name('currentapp');
    Route::resource('projects', ProjectController::class);
    Route::post('projectfile/{id}', [ProjectController::class, 'uploadfile']);

    Route::resource('invoice', ServiceInvoiceController::class);

    //All churches
    Route::resource('church', ChurchController::class);
    //dashbaord Lnaguage
    // Route::group(['middleware' => 'permission:Dashboard Language'], function () {
    Route::get('dashboard/languages', [DashboardLanguageController::class, 'index'])->name('dash.language');
    Route::get('dashboard/languages/create', [DashboardLanguageController::class, 'create'])->name('dash.lang.create');
    Route::post('dashboard/lang', [DashboardLanguageController::class, 'store'])->name('dash.lang');
    Route::post('change/lang', [DashboardLanguageController::class, 'change'])->name('user.lang');
    Route::delete('dash/languages/{id}', [DashboardLanguageController::class, 'destroy'])->name('dashboardlanguage.destroy');
    // });

    //DepositeAccount
    Route::resource('deposite-account', DepositeAccountController::class);
    // PaymentMethod
    Route::resource('payment-method', PaymentMethodController::class);
    // Product
    Route::resource('product', ProductController::class);
    // Tag
    Route::resource('tag', TagController::class);
    // FamilyMemberType
    Route::resource('family-member-type', FamilyMemberTypeController::class);
    // MemberType
    Route::resource('member-type', MemberTypeController::class);
    //payments
    Route::get('/members/{member}/payment/{amount}', [BillingController::class, 'showPaymentForm'])->name('show.payment');
    Route::post('/members/{member}/pay', [BillingController::class, 'processPayment']);
});
