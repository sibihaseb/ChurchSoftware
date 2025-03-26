<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\ExpensesTypesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExpensesTypesRequest;
use App\Models\ExpensesTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpensesTypesController extends Controller
{
  
    public function index(ExpensesTypesDataTable $dataTable)
    {
        return $dataTable->render(' dashboard.expenses_types.index');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpensesTypesRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        $data = ExpensesTypes::create($validatedData);
        if ($data) {
            return $this->successMessageResponse(__('ExpensesTypes Created Successfully'), 201);
        } else {
            return $this->errorResponse(__('ExpensesTypes Not Created'), 422);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = ExpensesTypes::findOrFail($id);
        return $data;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ExpensesTypesRequest $request, $id)
    {
        $data = ExpensesTypes::findOrFail($id);
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        DB::transaction(function () use ($validatedData, $data, $request) {
            $data->update($validatedData);
        });

        return $this->successMessageResponse(__('ExpensesTypes Updated Successfully'), 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = ExpensesTypes::findOrFail($id);
        DB::transaction(function () use ($data) {
            $data->delete();
        });

        return $this->deleteResponse();
    }
}
