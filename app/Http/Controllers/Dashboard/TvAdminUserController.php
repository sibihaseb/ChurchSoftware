<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Church;
use App\Models\User;
use App\Models\TvApp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\AdminRegistered;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\DataTables\TvAdminUserDataTable;
use App\Http\Requests\TvAdminUserRequest;
use App\Models\FilmMakerContent;
use App\Models\TemporaryAppCode;
use App\Models\TrackViewer;
use App\Models\UserTrail;
use Illuminate\Support\Facades\Auth;

class TvAdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TvAdminUserDataTable $dataTable)
    {
        $church = Church::get();
        $role = Role::get();
        return $dataTable->render('pages.adminuser.index', compact('church', 'role'));
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
    public function store(TvAdminUserRequest $request)
    {
        $validatedData = $request->validated();
        // $code = Str::random(32);
        // $validatedData['code'] = $code;
        if (isset($validatedData['church_id'])) {
            $validatedData['church_id'] = implode(',', $validatedData['church_id']);
        } else {
            $validatedData['church_id'] = null;
        }
        $adminuser = User::create($validatedData);

        if ($adminuser) {
            $adminuser->assignRole($validatedData['role']);
            return $this->successMessageResponse("Admin User Created Successfully", 201);
        } else {
            return $this->errorResponse(__('Admin Not created'), 422);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(User $adminuser)
    {
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
    public function update(TvAdminUserRequest $request, User $adminuser)
    {
        $validatedData = $request->validated();
        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        if (isset($validatedData['church_id'])) {
            $validatedData['church_id'] = implode(',', $validatedData['church_id']);
        } else {
            $validatedData['church_id'] = null;
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
    public function destroy(User $adminuser)
    {
        DB::transaction(function () use ($adminuser) {
            // Delete the user's image if it exists
            // Finally, delete the user account
            $adminuser->delete();
        }, 2);

        return response()->json(['success' => __('Deleted Successfully')]);
    }

    public function appCodeSet(Request $request)
    {
        // dd($request->appCode);
        // $enable_app_role =  DB::table('tv_apps')->where('code', $request->appCode)->value('enable_app_role') ?? null;
        // if ($enable_app_role == 1 && auth()->user()->account_type !== 'S') {
        //     auth()->user()->roles()->detach();

        //     if (auth()->user()->account_type === 'F') {
        //         $role = Role::where('name', 'Content Partner')->first();
        //         auth()->user()->assignRole($role->id);
        //     } else {
        //         $new_role_id = DB::table('tv_apps')->where('code', $request->appCode)->value('role_id');
        //         auth()->user()->assignRole($new_role_id);
        //     }
        // } else {
        //     $role = auth()->user()->role;
        //     if (!empty($role)) {
        //         auth()->user()->roles()->detach();
        //         auth()->user()->assignRole($role);
        //     }
        // }
        $currentuser = auth()->user()->id;
        TemporaryAppCode::updateOrCreate([
            'user_id' => $currentuser
        ], ['church_id' => $request->appCode]);

        return response()->json(['success' => __('App Changed')]);
    }
}
