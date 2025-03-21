<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\FamilyMemberTypeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\FamilyMemberTypeRequest;
use App\Models\FamilyMemberType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FamilyMemberTypeController extends Controller
{
    public function index(FamilyMemberTypeDataTable $dataTable)
    {
        return $dataTable->render(' dashboard.family-member-type.index');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(FamilyMemberTypeRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        $data = FamilyMemberType::create($validatedData);
        if ($data) {
            return $this->successMessageResponse(__('FamilyMemberType Created Successfully'), 201);
        } else {
            return $this->errorResponse(__('FamilyMemberType Not Created'), 422);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = FamilyMemberType::findOrFail($id);
        return $data;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(FamilyMemberTypeRequest $request, $id)
    {
        $data = FamilyMemberType::findOrFail($id);
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        DB::transaction(function () use ($validatedData, $data, $request) {
            $data->update($validatedData);
        });

        return $this->successMessageResponse(__('FamilyMemberType Updated Successfully'), 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = FamilyMemberType::findOrFail($id);
        DB::transaction(function () use ($data) {
            $data->delete();
        });

        return $this->deleteResponse();
    }
}
