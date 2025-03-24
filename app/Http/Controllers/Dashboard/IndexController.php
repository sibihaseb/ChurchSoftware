<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Church;
use App\Models\Member;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\TemporaryAppCode;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    public function index()
    {
        if (!auth()->user()) {
            return view('pages.auth.signin-cover');
        } else {
            return redirect('/home');
        }
    }

    public function home(Request $request)
    {
        $churches = Church::all();
        return view('pages.welcome', compact('churches'));
    }

    public function topDonors(Request $request)
    {
        $churchId = $request->input('church_id');

        $topDonors = Member::select('members.first_name', 'members.last_name', 'members.email')
            ->selectRaw('SUM(service_invoice_items.amount) as total_donations')
            ->join('service_invoices', 'members.id', '=', 'service_invoices.member_id')
            ->join('service_invoice_items', 'service_invoices.id', '=', 'service_invoice_items.service_invoice_id')
            ->where('service_invoices.church_id', $churchId)
            ->groupBy('members.id', 'members.first_name', 'members.last_name', 'members.email')
            ->orderByDesc('total_donations')
            ->limit(5)
            ->get();


        return response()->json($topDonors);
    }

    public function profile()
    {
        $result = User::where('id', Auth()->user()->id)->get();
        return view('pages.profile', compact('result'));
    }
    public function UpdateProfile(UserRequest $request)
    {
        $validatedData = $request->validated();
        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        if (empty($validatedData['password'])) {
            $validatedData['password'] = Auth()->user()->password;
        }
        $user = User::where('id', Auth()->user()->id)->update($validatedData);
        if ($user) {
            return redirect()->back()->with('success', __('Profile updated Successfully'));
        } else {
            return redirect()->back()->with('error', __('Profile  Not updated'));
        }
    }
}
