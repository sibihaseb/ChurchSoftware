<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\MemberTypeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberTypeRequest;
use App\Models\MemberType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberTypeController extends Controller
{
    public function index(MemberTypeDataTable $dataTable)
    {
        return $dataTable->render(' dashboard.member-type.index');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(MemberTypeRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        $data = MemberType::create($validatedData);
        if ($data) {
            return $this->successMessageResponse(__('MemberType Created Successfully'), 201);
        } else {
            return $this->errorResponse(__('MemberType Not Created'), 422);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = MemberType::findOrFail($id);
        return $data;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(MemberTypeRequest $request, $id)
    {
        $data = MemberType::findOrFail($id);
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        DB::transaction(function () use ($validatedData, $data, $request) {
            $data->update($validatedData);
        });

        return $this->successMessageResponse(__('MemberType Updated Successfully'), 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = MemberType::findOrFail($id);
        DB::transaction(function () use ($data) {
            $data->delete();
        });

        return $this->deleteResponse();
    }
}
