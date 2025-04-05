<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\BudgetsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetsRequest;
use App\Models\Budgets;
use App\Models\BudgetTypes;
use App\Models\Department;
use App\Models\ExpensesTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BudgetsController extends Controller
{
 
    public function index(BudgetsDataTable $dataTable)
    {
        $departments = Department::where('church_id',$this->currentApp()->church_id)->get();
        $types = BudgetTypes::where('church_id',$this->currentApp()->church_id)->get();
        return $dataTable->render(' dashboard.budgets.index' ,compact('departments','types'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        $departments = Department::where('church_id',$this->currentApp()->church_id)->get();
        $types = BudgetTypes::where('church_id',$this->currentApp()->church_id)->get();

        return view('dashboard.budgets.createOrUpdate', compact('departments','types'));
    }
    public function store(BudgetsRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        if (isset($validatedData['department_id']) && $validatedData['department_id']) {
            $validatedData['department_id'] = $this->processDepartments($validatedData['department_id'], $validatedData['church_id']);
        } else {
            $validatedData['department_id'] = null;
        }
        if (isset($validatedData['type_id']) && $validatedData['type_id']) {
            $validatedData['type_id'] = $this->processBudgetTypes($validatedData['type_id'], $validatedData['church_id']);
        } else {
            $validatedData['type_id'] = null;
        }
        $data = Budgets::create($validatedData);
        if ($data) {
            return redirect('admin/budgets')->with('success', 'Created successfully');
        } else {
            return $this->errorResponse(__('Budgets Not Created'), 422);
        }
    }
    public function edit($id)
    {
        $data = Budgets::findOrFail($id);
        $departments = Department::where('church_id',$this->currentApp()->church_id)->get();
        $types = BudgetTypes::where('church_id',$this->currentApp()->church_id)->get();

        return view('dashboard.budgets.createOrUpdate', compact('departments','types','data'));
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Budgets::findOrFail($id);
        return $data;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(BudgetsRequest $request, $id)
    {
        $data = Budgets::findOrFail($id);
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        if (isset($validatedData['department_id']) && $validatedData['department_id']) {
            $validatedData['department_id'] = $this->processDepartments($validatedData['department_id'], $validatedData['church_id']);
        } else {
            $validatedData['department_id'] = null;
        }
        if (isset($validatedData['type_id']) && $validatedData['type_id']) {
            $validatedData['type_id'] = $this->processBudgetTypes($validatedData['type_id'], $validatedData['church_id']);
        } else {
            $validatedData['type_id'] = null;
        }
        DB::transaction(function () use ($validatedData, $data, $request) {
            $data->update($validatedData);
        });

        // $currentPage = $request->input('currentPage', 1); // Get the current page from the hidden input
        return redirect()->to('admin/budgets')->with('success', __('Updated Successfully'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Budgets::findOrFail($id);
        DB::transaction(function () use ($data) {
            $data->delete();
        });

        return $this->deleteResponse();
    }
}
