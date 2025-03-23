<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\TemporaryAppCode;
use App\Http\Controllers\Controller;
use App\Models\Project;

class IndexController extends Controller
{
    public function index()
    {
        if (!auth()->user()) {
            return view('pages.auth.signin-cover');
        } else {
            return redirect('/admin/home');
        }
    }

    public function landing()
    {
        $project = Project::findOrfail(1);
        $allimages = explode(',', $project->images);

        return view('welcome', compact('allimages'));
    }
}
