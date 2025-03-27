<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\DepartmentsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentsRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentsController extends Controller
{
    public function index(DepartmentsDataTable $dataTable)
    {
        return $dataTable->render(' dashboard.departments.index');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentsRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        $data = Department::create($validatedData);
        if ($data) {
            return $this->successMessageResponse(__('Department Created Successfully'), 201);
        } else {
            return $this->errorResponse(__('Department Not Created'), 422);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Department::findOrFail($id);
        return $data;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentsRequest $request, $id)
    {
        $data = Department::findOrFail($id);
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        DB::transaction(function () use ($validatedData, $data, $request) {
            $data->update($validatedData);
        });

        return $this->successMessageResponse(__('Department Updated Successfully'), 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Department::findOrFail($id);
        DB::transaction(function () use ($data) {
            $data->delete();
        });

        return $this->deleteResponse();
    }
}
