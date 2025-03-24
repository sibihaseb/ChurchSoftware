<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\CountryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(CountryDataTable $dataTable)
    {
        return $dataTable->render('dashboard.country.index');
    }
}
