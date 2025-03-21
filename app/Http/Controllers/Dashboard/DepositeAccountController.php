<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\DepositeAccountDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepositeAccountRequest;
use App\Models\DepositeAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepositeAccountController extends Controller
{
    public function index(DepositeAccountDataTable $dataTable)
    {
        return $dataTable->render(' dashboard.deposite-account.index');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(DepositeAccountRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        $data = DepositeAccount::create($validatedData);
        if ($data) {
            return $this->successMessageResponse(__('DepositeAccount Created Successfully'), 201);
        } else {
            return $this->errorResponse(__('DepositeAccount Not Created'), 422);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = DepositeAccount::findOrFail($id);
        return $data;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(DepositeAccountRequest $request, $id)
    {
        $data = DepositeAccount::findOrFail($id);
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        DB::transaction(function () use ($validatedData, $data, $request) {
            $data->update($validatedData);
        });

        return $this->successMessageResponse(__('DepositeAccount Updated Successfully'), 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = DepositeAccount::findOrFail($id);
        DB::transaction(function () use ($data) {
            $data->delete();
        });

        return $this->deleteResponse();
    }
}
