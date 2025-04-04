<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\ExpensesDataTable;
use App\DataTables\ExpensesTypesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExpensesRequest;
use App\Models\Department;
use App\Models\Expenses;
use App\Models\ExpensesTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpensesController extends Controller
{
    public function index(ExpensesDataTable $dataTable)
    {
        $departments = Department::where('church_id',$this->currentApp()->church_id)->get();
        $types = ExpensesTypes::where('church_id',$this->currentApp()->church_id)->get();
        return $dataTable->render('dashboard.expenses.index' ,compact('departments','types'));
    }
    public function create()
    {
        $departments = Department::where('church_id',$this->currentApp()->church_id)->get();
        $types = ExpensesTypes::where('church_id',$this->currentApp()->church_id)->get();

        return view('dashboard.expenses.createOrUpdate', compact('departments','types'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpensesRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        if (isset($validatedData['department_id']) && $validatedData['department_id']) {
            $validatedData['department_id'] = $this->processDepartments($validatedData['department_id'], $validatedData['church_id']);
        } else {
            $validatedData['department_id'] = null;
        }
        if (isset($validatedData['type_id']) && $validatedData['type_id']) {
            $validatedData['type_id'] = $this->processExpensesTypes($validatedData['type_id'], $validatedData['church_id']);
        } else {
            $validatedData['type_id'] = null;
        }
        $data = Expenses::create($validatedData);
        if ($data) {
            return redirect('admin/expenses')->with('success', 'Created successfully');
        } else {
            return $this->errorResponse(__('Expenses Not Created'), 422);
        }
    }
    public function edit($id)
    {
        $data = Expenses::findOrFail($id);
        $departments = Department::where('church_id',$this->currentApp()->church_id)->get();
        $types = ExpensesTypes::where('church_id',$this->currentApp()->church_id)->get();

        return view('dashboard.expenses.createOrUpdate', compact('departments','types','data'));
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Expenses::findOrFail($id);
        return $data;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ExpensesRequest $request, $id)
    {
        $data = Expenses::findOrFail($id);
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        if (isset($validatedData['department_id']) && $validatedData['department_id']) {
            $validatedData['department_id'] = $this->processDepartments($validatedData['department_id'], $validatedData['church_id']);
        } else {
            $validatedData['department_id'] = null;
        }
        if (isset($validatedData['type_id']) && $validatedData['type_id']) {
            $validatedData['type_id'] = $this->processExpensesTypes($validatedData['type_id'], $validatedData['church_id']);
        } else {
            $validatedData['type_id'] = null;
        }
        DB::transaction(function () use ($validatedData, $data, $request) {
            $data->update($validatedData);
        });

        // $currentPage = $request->input('currentPage', 1); // Get the current page from the hidden input
        return redirect()->to('admin/expenses')->with('success', __('Updated Successfully'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Expenses::findOrFail($id);
        DB::transaction(function () use ($data) {
            $data->delete();
        });

        return $this->deleteResponse();
    }
}
