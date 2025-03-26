<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\BudgetsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetsRequest;
use App\Models\Budgets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BudgetsController extends Controller
{
 
    public function index(BudgetsDataTable $dataTable)
    {
        return $dataTable->render(' dashboard.budgets.index');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(BudgetsRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        $data = Budgets::create($validatedData);
        if ($data) {
            return $this->successMessageResponse(__('Budgets Created Successfully'), 201);
        } else {
            return $this->errorResponse(__('Budgets Not Created'), 422);
        }
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
        DB::transaction(function () use ($validatedData, $data, $request) {
            $data->update($validatedData);
        });

        return $this->successMessageResponse(__('Budgets Updated Successfully'), 201);
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
