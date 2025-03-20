<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\DataTables\DashboardLanguageDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardLanguageRequest;
use App\Models\DashboardLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use App\Jobs\RunArtisanCommands;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DashboardLanguageController extends Controller
{

    public function index(DashboardLanguageDataTable $dataTable)
    {
        return $dataTable->render('dashboard.dashboard_languages.index');
    }

    public function create()
    {
        return view('dashboard.dashboard_languages.create');
    }

    /**
     * Show the form for creating a new resource.
     */

    public function store(DashboardLanguageRequest $request)
    {
        // dd('sss');
        ini_set('max_execution_time', 2000);
        $validatedData = $request->validated();
       
        if ($request->hasFile('flag_image')) {
            $filename = $validatedData['title'] . '_' . Carbon::now()->format('Y-m-d_H-i-s') . '.' . $request->file('flag_image')->getClientOriginalExtension();
            $filename = preg_replace('/[^A-Za-z0-9.]/', '', $filename);
            $filename = str_replace(' ', '', $filename);

            // Store in public disk
            $imagepath = $request->file('flag_image')->storeAs('language', $filename, 'public');
            $validatedData['flag_image'] = $imagepath;
        }
        $data = DashboardLanguage::create($validatedData);
        if ($data) {
            return redirect()->route('dash.language');
        } else {
            return view('pages.dashboard_languages.create')->with('status', __('Tv Language cannot be created.'));
        }
    }



    public function change(Request $request)
    {
        $lang = $request->input('lang');
        Session::put('locale', $lang);
        return redirect()->back();
    }
    public function destroy($id)
    {
        $data = DashboardLanguage::findorFail($id);
        DB::transaction(function () use ($data) {
            if ($data->flag_image && Storage::disk('public')->exists($data->flag_image)) {
                Storage::disk('public')->delete($data->flag_image);
            }
            $data->delete();
        }, 1);

        return response()->json(['success' => __('Tv Language Deleted Successfully')]);
    }
}
