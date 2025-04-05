<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\DepartmentBudgetReportDataTable;
use App\DataTables\DepartmentBudgetVExpensesReportDataTable;
use App\DataTables\DepartmentExpensesReportDataTable;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentReportController extends Controller
{
    // Centralized method for fetching user data and rendering the view
    private function renderUserReport($dataTable, $code)
    {
        $user = Department::where('id', $code)->first();
        return $dataTable->render('dashboard.deprtment-reports.index', compact('user'));
    }

    public function budgetReport(DepartmentBudgetReportDataTable $dataTable, Request $request)
    {
        $code = $request->code;
        return $this->renderUserReport($dataTable, $code);
    }

    public function budgetVexpensesReport(DepartmentBudgetVExpensesReportDataTable $dataTable, Request $request)
    {
        $code = $request->code;
        return $this->renderUserReport($dataTable, $code);
    }
    public function expensesReport(DepartmentExpensesReportDataTable $dataTable, Request $request)
    {
        $code = $request->code;
        return $this->renderUserReport($dataTable, $code);
    }
}
