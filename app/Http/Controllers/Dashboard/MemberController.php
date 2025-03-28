<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\MemberDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Models\Church;
use App\Models\Country;
use App\Models\User;
use App\Models\USStates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class MemberController extends Controller
{
    public function index(MemberDataTable $dataTable)
    {
        $church = Church::get();
        $role = Role::get();
        $countries = Country::get();
        $states = USStates::get();
        return $dataTable->render('dashboard.doners.index', compact(
            'church',
            'role',
            'countries',
            'states'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MemberRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['account_type'] = "D";
        if (isset($validatedData['church_id'])) {
            $validatedData['church_id'] = implode(',', $validatedData['church_id']);
        } else {
            $validatedData['church_id'] = null;
        }
        if (isset($validatedData['country_id'])) {
            $validatedData['country_id'] = implode(',', $validatedData['country_id']);
        } else {
            $validatedData['country_id'] = null;
        }
        if (isset($validatedData['state_id'])) {
            $validatedData['state_id'] = implode(',', $validatedData['state_id']);
        } else {
            $validatedData['state_id'] = null;
        }

        $adminuser = User::create($validatedData);

        if ($adminuser) {
            $adminuser->assignRole("Doner");
            return $this->successMessageResponse("Created Successfully", 201);
        } else {
            return $this->errorResponse(__('Not created'), 422);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $adminuser = User::findOrFail($id);
        $adminuser->roles();
        $role = DB::table('roles')->where('name',  $adminuser->role)->value('name') ?? null;
        if (empty($role)) {
            $role = $adminuser->roles()->pluck('name')->first();
        }
        $adminuser->setAttribute('role', $role);
        return $adminuser;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MemberRequest $request, $id)
    {
        $adminuser = User::findOrFail($id);
        $validatedData = $request->validated();
        $validatedData['account_type'] = "D";
        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        if (isset($validatedData['church_id'])) {
            $validatedData['church_id'] = implode(',', $validatedData['church_id']);
        } else {
            $validatedData['church_id'] = null;
        }
        if (isset($validatedData['country_id'])) {
            $validatedData['country_id'] = implode(',', $validatedData['country_id']);
        } else {
            $validatedData['country_id'] = null;
        }
        if (isset($validatedData['state_id'])) {
            $validatedData['state_id'] = implode(',', $validatedData['state_id']);
        } else {
            $validatedData['state_id'] = null;
        }

        $adminuser->update($validatedData);

        if ($adminuser) {
            return $this->successMessageResponse("Record Updated", 201);
        } else {
            return $this->errorResponse(__('Record not Updated'), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $adminuser = User::findOrFail($id);
        DB::transaction(function () use ($adminuser) {
            $adminuser->delete();
        }, 2);

        return response()->json(['success' => __(' Deleted Successfully')]);
    }
    public function deleteSelected(Request $request, $model)
    {
        $ids = explode(',', $request->input('ids'));
        if (empty($ids) || empty($model)) {
            return redirect()->back()->with(['error' => 'No records selected.']);
        }

        try {
            DB::transaction(function () use ($ids, $model) {
                foreach ($ids as $id) {
                    $modelClass = "App\\Models\\$model";
                    $data = $modelClass::findOrFail($id);
    
                    if ($data) {
                        $data->delete();
                    }
                }
            });
            $baseUrl = explode('?', redirect()->back()->getTargetUrl())[0];
            $queryParams = ['page' => $request->input('page')];

            return redirect()->back()
                ->setTargetUrl($baseUrl . '?' . http_build_query($queryParams))
                ->with(['success' => 'Selected records have been deleted.']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    /**
     * Change the status of selected rows dynamically for any model.
     */
    public function changeStatusSelected(Request $request, $model)
    {
        $ids = explode(',', $request->input('ids'));

        // Check if no records or model are selected
        if (empty($ids) || empty($model)) {
            return redirect()->back()->with(['error' => 'No records selected.']);
        }

        // Wrap the status change logic in a DB transaction
        DB::transaction(function () use ($ids, $model) {
            foreach ($ids as $id) {
                // Dynamically resolve the model class
                $modelClass = "App\\Models\\$model";
                // Find the record by ID, or fail if not found
                $data = $modelClass::findOrFail($id);
                // Toggle the status
                    $data->status = ($data->status == 1) ? 0 : 1;
                // Save the record and log the action
                $data->save();
            }
        });
        // Return success message
        //dd($request->input('page'));

        $baseUrl = explode('?', redirect()->back()->getTargetUrl())[0];
        $queryParams = ['page' => $request->input('page')];
        return redirect()->back()
            ->setTargetUrl($baseUrl . '?' . http_build_query($queryParams))
            ->with(['success' => 'Status updated successfully.']);
    }

    public function status($id, $status)
    {
        $category = User::findorFail($id);
        $category->status = $status;
        if ($category->save()) {
            return $this->successMessageResponse("Status changed", 201);
        } else {
            return $this->errorResponse('Status not Updated', 204);
        }
    }
}
