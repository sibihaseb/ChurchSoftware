<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\ExpensesDataTable;
use App\DataTables\ExpensesTypesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExpensesRequest;
use App\Models\Expenses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpensesController extends Controller
{
    public function index(ExpensesDataTable $dataTable)
    {
        return $dataTable->render(' dashboard.expenses.index');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpensesRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        $data = Expenses::create($validatedData);
        if ($data) {
            return $this->successMessageResponse(__('Expenses Created Successfully'), 201);
        } else {
            return $this->errorResponse(__('Expenses Not Created'), 422);
        }
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
        DB::transaction(function () use ($validatedData, $data, $request) {
            $data->update($validatedData);
        });

        return $this->successMessageResponse(__('Expenses Updated Successfully'), 201);
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
