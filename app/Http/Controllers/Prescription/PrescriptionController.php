<?php

namespace App\Http\Controllers\Prescription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PrescriptionController extends Controller
{
    public function index()
    {
        return view('prescription.enquiry');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile' => 'required',
            'consent' => 'accepted',
            'prescription' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $uploadedFile = null;

        if ($request->hasFile('prescription')) {
            $uploadedFile = $request->file('prescription')->store('prescriptions', 'public');
        }

        Mail::send('emails.prescription', [
            'data' => $request->all(),
            'uploadedFile' => $uploadedFile,
        ], function ($message) use ($uploadedFile) {

            $message->to('admin@medileaf.com.au')
                ->subject('New Prescription Enquiry');

            if ($uploadedFile) {
                $message->attach(
                    storage_path('app/public/' . $uploadedFile),
                    [
                        'as' => basename($uploadedFile),
                    ]
                );
            }
        });

        return back()->with('success', 'Prescription enquiry submitted successfully.');
    }
}