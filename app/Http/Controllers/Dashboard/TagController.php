<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\TagDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function index(TagDataTable $dataTable)
    {
        return $dataTable->render(' dashboard.tag.index');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        $data = Tag::create($validatedData);
        if ($data) {
            return $this->successMessageResponse(__('Tag Created Successfully'), 201);
        } else {
            return $this->errorResponse(__('Tag Not Created'), 422);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Tag::findOrFail($id);
        return $data;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, $id)
    {
        $data = Tag::findOrFail($id);
        $validatedData = $request->validated();
        $validatedData['church_id'] = $this->currentApp()->church_id ?? null;
        DB::transaction(function () use ($validatedData, $data, $request) {
            $data->update($validatedData);
        });

        return $this->successMessageResponse(__('Tag Updated Successfully'), 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Tag::findOrFail($id);
        DB::transaction(function () use ($data) {
            $data->delete();
        });

        return $this->deleteResponse();
    }
}
