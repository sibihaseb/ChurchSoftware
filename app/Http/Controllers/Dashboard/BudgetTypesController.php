<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\BudgetTypesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetTypesRequest;
use App\Models\BudgetTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BudgetTypesController extends Controller
{
    public function index(BudgetTypesDataTable $dataTable)
    {
        return $dataTable->render(' dashboard.budget_types.index');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(BudgetTypesRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        $data = BudgetTypes::create($validatedData);
        if ($data) {
            return $this->successMessageResponse(__('BudgetTypes Created Successfully'), 201);
        } else {
            return $this->errorResponse(__('BudgetTypes Not Created'), 422);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = BudgetTypes::findOrFail($id);
        return $data;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(BudgetTypesRequest $request, $id)
    {
        $data = BudgetTypes::findOrFail($id);
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        DB::transaction(function () use ($validatedData, $data, $request) {
            $data->update($validatedData);
        });

        return $this->successMessageResponse(__('BudgetTypes Updated Successfully'), 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = BudgetTypes::findOrFail($id);
        DB::transaction(function () use ($data) {
            $data->delete();
        });

        return $this->deleteResponse();
    }
}
