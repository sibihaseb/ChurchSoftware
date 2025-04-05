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

    public function budgetReport(DepartmentBudgetReportDataTable $dataTable, $code)
    {
        // $code = $request->code;
        return $this->renderUserReport($dataTable, $code);
    }

    public function budgetVexpensesReport(DepartmentBudgetVExpensesReportDataTable $dataTable, $code)
    {
        // $code = $request->code;
        return $this->renderUserReport($dataTable, $code);
    }
    public function expensesReport(DepartmentExpensesReportDataTable $dataTable, $code)
    {
        // $code = $request->code;
        return $this->renderUserReport($dataTable, $code);
    }

    public function allBugdetReports(DepartmentBudgetReportDataTable $dataTable)
    {
        // $code = $request->code;
        return $this->renderAllReport($dataTable);
    }
    public function allExpensesReports(DepartmentExpensesReportDataTable $dataTable)
    {
        // $code = $request->code;
        return $this->renderAllReport($dataTable);
    }


    private function renderAllReport($dataTable)
    {
        
        return $dataTable->render('dashboard.deprtment-reports.all-reports');
    }
}
