<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\ContactUsDataTable;
use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index(ContactUsDataTable $dataTable)
    {
        return $dataTable->render('dashboard.contacts-us.index');
    }
    public function create()
    {
        return view('contact-us'); // Make sure this view exists: resources/views/contact.blade.php
    }

    public function store(Request $request)
    {
        // Validate the form input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'subject' => 'required|string',
        ]);
        // Save data to the database
        ContactUs::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => $request->input('message'),
            'message' => $request->input('subject'),
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'We’ve received your message and will get back to you shortly!');
    }
    public function destroy($id)
    {
        ContactUs::destroy($id);
        return response()->json(['success' => true]);
    }

    public function bulkDelete(Request $request)
    {
        ContactUs::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => true]);
    }
}
