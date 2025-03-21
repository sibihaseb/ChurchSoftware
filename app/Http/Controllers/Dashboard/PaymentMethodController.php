<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\PaymentMethodDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethodRequest;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentMethodController extends Controller
{
    public function index(PaymentMethodDataTable $dataTable)
    {
        return $dataTable->render(' dashboard.payment-method.index');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentMethodRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        $data = PaymentMethod::create($validatedData);
        if ($data) {
            return $this->successMessageResponse(__('PaymentMethod Created Successfully'), 201);
        } else {
            return $this->errorResponse(__('PaymentMethod Not Created'), 422);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = PaymentMethod::findOrFail($id);
        return $data;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentMethodRequest $request, $id)
    {
        $data = PaymentMethod::findOrFail($id);
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        DB::transaction(function () use ($validatedData, $data, $request) {
            $data->update($validatedData);
        });

        return $this->successMessageResponse(__('PaymentMethod Updated Successfully'), 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = PaymentMethod::findOrFail($id);
        DB::transaction(function () use ($data) {
            $data->delete();
        });

        return $this->deleteResponse();
    }
}
