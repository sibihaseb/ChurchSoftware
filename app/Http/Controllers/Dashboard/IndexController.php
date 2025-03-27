<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
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
    // Get first and last day of this month
    public $startOfThisMonth;
    public $endOfThisMonth;

    // Get first and last day of last month
    public $startOfLastMonth;
    public $endOfLastMonth;

    public function __construct()
    {
        $this->startOfThisMonth = Carbon::now()->startOfMonth();
        $this->endOfThisMonth = Carbon::now()->endOfMonth();

        $this->startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $this->endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
    }

    public function index()
    {
        if (!auth()->user()) {
            return view('pages.auth.signin-cover');
        } else {
            return redirect('/admin/home');
        }
    }

    public function home()
    {
        $churches = Church::all();
        $alldonars = $this->allDonors();
        return view('pages.welcome', compact('churches', 'alldonars'));
    }

    public function allDonors()
    {
        // Count donors for this month
        $thisMonthDonors = User::where('account_type', 'd')
            ->whereBetween('created_at', [$this->startOfThisMonth, $this->endOfThisMonth])
            ->count();

        // Count donors for last month
        $lastMonthDonors = User::where('account_type', 'd')
            ->whereBetween('created_at', [$this->startOfLastMonth, $this->endOfLastMonth])
            ->count();

        // Calculate percentage change
        if ($lastMonthDonors > 0) {
            $percentageChange = (($thisMonthDonors - $lastMonthDonors) / $lastMonthDonors) * 100;
        } else {
            $percentageChange = $thisMonthDonors > 0 ? 100 : 0;
        }

        // Format the percentage with sign
        $sign = $percentageChange > 0 ? '+' : '';
        $percentageChange = $sign . number_format($percentageChange, 2) . '%';

        return [
            'last_month' => $lastMonthDonors,
            'this_month' => $thisMonthDonors,
            'percentage_change' => $percentageChange
        ];
    }

    public function topDonors(Request $request)
    {
        $churchId = $request->input('church_id');

        $topDonors = User::select('users.name', 'users.email')
            ->selectRaw('SUM(service_invoice_items.amount) as total_donations')
            ->join('service_invoices', 'users.id', '=', 'service_invoices.user_id')
            ->join('service_invoice_items', 'service_invoices.id', '=', 'service_invoice_items.service_invoice_id')
            ->where('service_invoices.church_id', $churchId)
            ->groupBy('users.id', 'users.name', 'users.email')
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
