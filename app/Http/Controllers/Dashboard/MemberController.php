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
            return $this->successMessageResponse("Admin User Updated", 201);
        } else {
            return $this->errorResponse(__('Admin User not Updated'), 422);
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
}
