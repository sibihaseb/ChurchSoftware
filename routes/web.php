<?php

use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\DepartmentsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Dashboard\TagController;
use App\Http\Controllers\Dashboard\IndexController;
use App\Http\Controllers\Dashboard\ChurchController;
use App\Http\Controllers\Dashboard\BillingController;
use App\Http\Controllers\Dashboard\BudgetsController;
use App\Http\Controllers\Dashboard\BudgetTypesController;
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
use App\Http\Controllers\Dashboard\DepartmentReportController;
use App\Http\Controllers\Dashboard\ExpensesController;
use App\Http\Controllers\Dashboard\ExpensesTypesController;
use App\Http\Controllers\Dashboard\FamilyMemberController;
use App\Http\Controllers\Dashboard\MemberController;
use App\Http\Controllers\Dashboard\USStatesController;
use App\Models\Member;

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
Route::get('/church/signup', [IndexController::class, 'churchsignup'])->name('church.signup');
Route::prefix('donor')->middleware(['auth'])->group(function () {
    Route::get('/home', [IndexController::class, 'donorhome']);

    //payments
    Route::get('/payment', [BillingController::class, 'paymentpage'])->name('donar.wizard');
    Route::post('/donar/donate', [BillingController::class, 'donorPayment'])->name('donar.donate');
    Route::get('/donate/{member}/payment/{amount}', [BillingController::class, 'showPaymentForm'])->name('donor.payment');
    Route::post('/donate/{member}/pay', [BillingController::class, 'processPayment']);

    //donation history
    Route::get('/donation-history', [BillingController::class, 'donationHistory'])->name('donar.donation.history');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/home', [IndexController::class, 'index']);
    Route::get('/fetch-top-donors', [IndexController::class, 'topDonors'])->name('top-donors');
    Route::get('/analytics', [IndexController::class, 'getAnalytics']);

    Route::get('/userprofile', [IndexController::class, 'profile']);
    Route::post('/profileupdate', [IndexController::class, 'UpdateProfile']);

    Route::post('setappconfig', [TvAdminUserController::class, 'appCodeSet'])->name('currentapp');

    //payments
    Route::get('/members/{member}/payment/{amount}', [BillingController::class, 'showPaymentForm'])->name('show.payment');
    Route::post('/members/{member}/pay', [BillingController::class, 'processPayment']);

    //permission management
    Route::group(['middleware' => 'permission:Role Management'], function () {
        Route::get('roletable', [RolePermissionController::class, 'roletable'])->name('roletable');
        Route::get('createrole', [RolePermissionController::class, 'createrole'])->name('createrole');
        Route::post('storerole', [RolePermissionController::class, 'rolestore'])->name('addrole');
        Route::post('roleupdate', [RolePermissionController::class, 'roleupdate'])->name('role.update');
        Route::get('role/{id}/edit', [RolePermissionController::class, 'editrole']);
        Route::get('role/editpage/{id}', [RolePermissionController::class, 'editafter']);
        Route::get('role/destroy/{id}', [RolePermissionController::class, 'destroy']);
    });

    //user management
    Route::group(['middleware' => 'permission:User Management'], function () {
        Route::resource('adminuser', TvAdminUserController::class);
    });


    //donation management
    Route::group(['middleware' => 'permission:Donation Management'], function () {
        Route::resource('invoice', ServiceInvoiceController::class);
    });


    //church management
    Route::group(['middleware' => 'permission:Church Management'], function () {
        Route::resource('church', ChurchController::class);
    });

    //language management
    Route::group(['middleware' => 'permission:Language Management'], function () {
        Route::get('dashboard/languages', [DashboardLanguageController::class, 'index'])->name('dash.language');
        Route::get('dashboard/languages/create', [DashboardLanguageController::class, 'create'])->name('dash.lang.create');
        Route::post('dashboard/lang', [DashboardLanguageController::class, 'store'])->name('dash.lang');
        Route::post('change/lang', [DashboardLanguageController::class, 'change'])->name('user.lang');
        Route::delete('dash/languages/{id}', [DashboardLanguageController::class, 'destroy'])->name('dashboardlanguage.destroy');
    });

    //DepositeAccount
    Route::group(['middleware' => 'permission:Deposit Account Management'], function () {
        Route::resource('deposite-account', DepositeAccountController::class);
    });

    // PaymentMethod
    Route::group(['middleware' => 'permission:Payment Method Management'], function () {
        Route::resource('payment-method', PaymentMethodController::class);
    });

    // Product
    Route::group(['middleware' => 'permission:Product Management'], function () {
        Route::resource('product', ProductController::class);
    });

    // Tag
    Route::group(['middleware' => 'permission:Tag Management'], function () {
        Route::resource('tag', TagController::class);
    });

    // FamilyMemberType
    Route::group(['middleware' => 'permission:Donor Management'], function () {
        Route::resource('family-member-type', FamilyMemberTypeController::class);
        Route::resource('doners', MemberController::class);
        Route::get('doners/{tvcategory}/{status}', [MemberController::class, 'status']);
    });


    //country table
    Route::group(['middleware' => 'permission:Country Management'], function () {
        Route::get('country', [CountryController::class, 'index']);
    });

    //state table
    Route::group(['middleware' => 'permission:State Management'], function () {
        Route::get('us-states', [USStatesController::class, 'index']);
    });

    //Family Doners
    Route::resource('family-doners', FamilyMemberController::class);

    // Departments
    Route::group(['middleware' => 'permission:Department Management'], function () {
        Route::resource('departments', DepartmentsController::class);
        // Expenses
        Route::resource('expenses', ExpensesController::class);
        // Budgets
        Route::resource('budgets', BudgetsController::class);
        // ExpensesTypes
        Route::resource('expenses_types', ExpensesTypesController::class);
        // BudgetTypes
        Route::resource('budget_types', BudgetTypesController::class);
    });


    //multiple actions
    //common routes for multiple select routes delete or chnage status
    Route::post('/model/delete-selected/{model}', [MemberController::class, 'deleteSelected'])->name('common.deleteSelected');
    Route::post('/model/change-status-selected/{model}', [MemberController::class, 'changeStatusSelected'])->name('common.changeStatusSelected');

    // Route::group(['middleware' => 'permission:User Reports'], function () {
        // Route::get('department-report/{code}', [DepartmentReportController::class, 'index'])->name('department.report');
        Route::get('department-budget-report/{code}', [DepartmentReportController::class, 'budgetReport'])->name('department.budget.report');
        // Route::get('department-budgetVexpenses-report/{code}', [DepartmentReportController::class, 'budgetVexpensesReport'])->name('department.budgetVexpenses.report');
        Route::get('department-expenses-report/{code}', [DepartmentReportController::class, 'expensesReport'])->name('department.expenses.report');
    // });

    // Route::group(['middleware' => 'permission:All Department Reports'], function () {
   Route::get('all-budget-reports', [DepartmentReportController::class, 'allBugdetReports'])->name('department.all.reports');
   Route::get('all-expenses-reports', [DepartmentReportController::class, 'allExpensesReports'])->name('department.all.expenses.reports');
    // });
});
