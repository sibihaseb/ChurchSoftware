<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\USStatesDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class USStatesController extends Controller
{
    public function index(USStatesDataTable $dataTable)
    {
        return $dataTable->render('dashboard.us-states.index');
    }
}
