<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\ChurchDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChurchRequest;
use App\Models\Church;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ChurchController extends Controller
{
    public function index(ChurchDataTable $dataTable)
    {
        return $dataTable->render(' dashboard.church.index');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(ChurchRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('logo')) {
            $filename = $validatedData['name'] . '_' . Carbon::now()->format('Y-m-d_H-i-s') . '.' . $request->file('logo')->getClientOriginalExtension();
            $filename = preg_replace('/[^A-Za-z0-9.]/', '', $filename);
            $filename = str_replace(' ', '', $filename);

            // Store in public disk
            $imagepath = $request->file('logo')->storeAs('church', $filename, 'public');
            $validatedData['logo'] = $imagepath;
        }

        $data = Church::create($validatedData);

        if ($data) {
            return $this->successMessageResponse(__('Church Created Successfully'), 201);
        } else {
            return $this->errorResponse(__('Church Not Created'), 422);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Church::findOrFail($id);
        return $data;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ChurchRequest $request, $id)
    {
        $data = Church::findOrFail($id);
        $validatedData = $request->validated();

        if ($request->hasFile('logo')) {
            $filename = $validatedData['name'] . '_' . $data->id . '_' . Carbon::now()->format('Y-m-d_H-i-s') . '.' . $request->file('logo')->getClientOriginalExtension();
            $filename = preg_replace('/[^A-Za-z0-9.]/', '', $filename);
            $filename = str_replace(' ', '', $filename);

            // Store in public disk
            $imagepath = $request->file('logo')->storeAs('church', $filename, 'public');
            $validatedData['logo'] = $imagepath;
        } else {
            $validatedData['logo'] = $validatedData['oldimage'];
        }

        DB::transaction(function () use ($validatedData, $data, $request) {
            if ($request->hasFile('logo') && $data->logo) {
                if (Storage::disk('public')->exists($data->logo)) {
                    Storage::disk('public')->delete($data->logo);
                }
            }
            $data->update($validatedData);
        });

        return $this->successMessageResponse(__('Church Updated Successfully'), 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Church::findOrFail($id);
        DB::transaction(function () use ($data) {
            if ($data->logo && Storage::disk('public')->exists($data->logo)) {
                Storage::disk('public')->delete($data->logo);
            }
            $data->delete();
        });

        return $this->deleteResponse();
    }
}
