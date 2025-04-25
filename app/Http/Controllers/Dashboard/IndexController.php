<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Church;
use App\Models\Member;
use App\Models\Budgets;
use App\Models\Product;
use App\Models\Project;
use App\Models\Expenses;
use Illuminate\Http\Request;
use App\Models\ServiceInvoice;
use App\Models\TemporaryAppCode;
use App\Http\Requests\UserRequest;
use App\Models\ServiceInvoiceItem;
use Illuminate\Support\Facades\DB;
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

    public function churchsignup()
    {
        return view('pages.auth.signup-church');
    }

    public function index()
    {
        if (!auth()->check()) {
            return view('pages.auth.signin-cover');
        }
        return auth()->user()->account_type == 'd'
            ? $this->donorhome()
            : $this->home();
    }


    public function home()
    {
        ini_set('max_execution_time', '1000');
        $churches = Church::all();
        $alldonars = $this->allDonors();
        $totalRevenue = $this->totalRevenue();
        $totalDonations = $this->totalDonations();
        $allUsers = $this->allUsers();
        $topProducts = $this->getTopProducts();
        $allProductFive = $this->allProductFive();
        return view('pages.welcome', compact('churches', 'alldonars', 'totalRevenue', 'totalDonations', 'allUsers', 'topProducts', 'allProductFive'));
    }

    public function donorhome()
    {
        $churches = Church::all();
        $totalDonations = $this->totalDonations();
        $alldonars = $this->allDonors();
        $topProducts = $this->getTopProducts();
        return view('donor.welcome', compact('churches', 'alldonars', 'totalDonations', 'topProducts'));
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

    public function allUsers()
    {
        // Count donors for this month
        $thisMonthDonors = User::where('account_type', '!=', 'd')
            ->whereBetween('created_at', [$this->startOfThisMonth, $this->endOfThisMonth])
            ->count();

        // Count donors for last month
        $lastMonthDonors = User::where('account_type', '!=', 'd')
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

    public function totalRevenue()
    {
        // Get first and last day of this month
        $startOfThisMonth = $this->startOfThisMonth;
        $endOfThisMonth = $this->endOfThisMonth;

        // Get first and last day of last month
        $startOfLastMonth = $this->startOfLastMonth;
        $endOfLastMonth = $this->endOfLastMonth;

        // Calculate revenue for this month using Eloquent relationship
        $thisMonthRevenue = ServiceInvoiceItem::whereHas('salesReceipt', function ($query) use ($startOfThisMonth, $endOfThisMonth) {
            $query->whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth]);
        })
            ->sum('amount');

        // Calculate revenue for last month using Eloquent relationship
        $lastMonthRevenue = ServiceInvoiceItem::whereHas('salesReceipt', function ($query) use ($startOfLastMonth, $endOfLastMonth) {
            $query->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth]);
        })
            ->sum('amount');

        // Calculate percentage change
        if ($lastMonthRevenue > 0) {
            $percentageChange = (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        } else {
            $percentageChange = $thisMonthRevenue > 0 ? 100 : 0;
        }

        // Format the percentage with sign
        $sign = $percentageChange > 0 ? '+' : '';
        $percentageChange = $sign . number_format($percentageChange, 2) . '%';

        return [
            'last_month' => $lastMonthRevenue,
            'this_month' => $thisMonthRevenue,
            'percentage_change' => $percentageChange
        ];
    }

    public function totalDonations()
    {
        // Get first and last day of this month
        $startOfThisMonth = $this->startOfThisMonth;
        $endOfThisMonth = $this->endOfThisMonth;

        // Get first and last day of last month
        $startOfLastMonth = $this->startOfLastMonth;
        $endOfLastMonth = $this->endOfLastMonth;

        // Count Service Invoices for this month
        $thisMonthRevenue = ServiceInvoice::whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])->count();

        // Count Service Invoices for last month
        $lastMonthRevenue = ServiceInvoice::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();

        // Calculate percentage change
        if ($lastMonthRevenue > 0) {
            $percentageChange = (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        } else {
            $percentageChange = $thisMonthRevenue > 0 ? 100 : 0;
        }

        // Format the percentage with sign
        $sign = $percentageChange > 0 ? '+' : '';
        $percentageChange = $sign . number_format($percentageChange, 2) . '%';

        return [
            'last_month' => $lastMonthRevenue,
            'this_month' => $thisMonthRevenue,
            'percentage_change' => $percentageChange
        ];
    }

    public function getAnalytics(Request $request)
    {
        $currentAppCode = TemporaryAppCode::where('user_id', auth()->user()->id)->first()->church_id;

        if (!$currentAppCode) {
            return response()->json(['error' => 'church_id is required'], 400);
        }

        $months = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec'
        ];

        $expenses = Expenses::where('church_id', $currentAppCode)
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');
        $budgets = Budgets::where('church_id', $currentAppCode)
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $expenseData = [];
        $budgetData = [];

        foreach ($months as $num => $name) {
            $expenseData[] = ['x' => $name, 'y' => $expenses[$num] ?? 0];
            $budgetData[] = ['x' => $name, 'y' => $budgets[$num] ?? 0];
        }

        return response()->json([
            'expenseData' => $expenseData,
            'budgetData' => $budgetData
        ]);
    }


    public function topDonors(Request $request)
    {
        $currentAppCode = TemporaryAppCode::where('user_id', auth()->user()->id)->first()->church_id;
        $topDonors = User::select('users.name', 'users.email')
            ->selectRaw('SUM(service_invoice_items.amount) as total_donations')
            ->join('service_invoices', 'users.id', '=', 'service_invoices.user_id')
            ->join('service_invoice_items', 'service_invoices.id', '=', 'service_invoice_items.service_invoice_id')
            ->where('service_invoices.church_id', $currentAppCode)
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderByDesc('total_donations')
            ->limit(5)
            ->get();


        return response()->json($topDonors);
    }

    public function getTopProducts()
    {
        $topProducts = ServiceInvoiceItem::select('product_id')
            ->selectRaw('COUNT(product_id) as total_count, SUM(amount) as total_amount')
            ->groupBy('product_id')
            ->orderByDesc('total_count')
            ->with('product') // Eager load product details
            ->limit(5)
            ->get();
        $topProducts->map(function ($item) {
            return [
                'product' => $item->product,
                'total_count' => $item->total_count,
                'total_amount' => $item->total_amount,
            ];
        });
        return [
            'topProducts' => $topProducts,
            'total_count' => ServiceInvoiceItem::count(),
        ];
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

    public function allProductFive()
    {
        $currentAppCode = TemporaryAppCode::where('user_id', auth()->user()->id)->first()->church_id;

        $topProducts = ServiceInvoiceItem::where('church_id', $currentAppCode)
            ->select('product_id', DB::raw('COUNT(product_id) as usage_count'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy('product_id')
            ->orderByDesc('usage_count')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $product = Product::find($item->product_id);
                return [
                    'name' => $product->name ?? 'Unknown',
                    'usage_count' => $item->usage_count,
                    'total_amount' => $item->total_amount,
                ];
            });

        $totalAmount = $topProducts->sum('total_amount');

        return [
            'topProducts' => $topProducts,
            'totalAmount' => $totalAmount
        ];
    }

    public function monthlyRevenue()
    {
        $revenueData = [];

        // Get the start of the current year
        $startOfYear = now()->copy()->startOfYear();

        // Loop through all 12 months of the current year
        for ($i = 0; $i < 12; $i++) {
            $startOfMonth = $startOfYear->copy()->addMonths($i)->startOfMonth();
            $endOfMonth = $startOfMonth->copy()->endOfMonth();
            $label = $startOfMonth->format('M'); // Jan, Feb, Mar, etc.

            $monthlyRevenue = ServiceInvoiceItem::whereHas('salesReceipt', function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            })->sum('amount');

            $revenueData[] = [
                'month' => $label,
                'revenue' => round($monthlyRevenue, 2),
            ];
        }

        return response()->json([
            'revenueData' => $revenueData,
        ]);
    }

    public function totalDonationsChart()
    {
        $donationData = [];

        // Get the start of the current year
        $startOfYear = now()->copy()->startOfYear();

        // Loop through all 12 months of the current year
        for ($i = 0; $i < 12; $i++) {
            $startOfMonth = $startOfYear->copy()->addMonths($i)->startOfMonth();
            $endOfMonth = $startOfMonth->copy()->endOfMonth();
            $label = $startOfMonth->format('M'); // Jan, Feb, Mar, etc.

            // Count Service Invoices (donations) for the month
            $monthlyDonations = ServiceInvoice::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

            $donationData[] = [
                'month' => $label,
                'donations' => $monthlyDonations,
            ];
        }

        return response()->json([
            'donationData' => $donationData,
        ]);
    }
}
