<?php

namespace App\Http\Controllers\Prescription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UploadPrescriptionController extends Controller
{
    public function index()
    {
        return view('prescription.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required',
            'state' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'prescription_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'notes' => 'nullable|string',
            'consent' => 'accepted',
        ]);

        $uploadedFile = $request->file('prescription_file')->store(
            'uploaded-prescriptions',
            'public'
        );

        Mail::send('emails.upload-prescription', [
            'data' => $request->all(),
            'file' => $uploadedFile,
        ], function ($message) use ($uploadedFile) {

            $message->to('admin@medileaf.com.au')
                ->subject('New Uploaded Prescription');

            $message->attach(
                storage_path('app/public/' . $uploadedFile),
                [
                    'as' => basename($uploadedFile),
                ]
            );
        });

        return redirect()
            ->back()
            ->with('success', 'Your prescription has been uploaded successfully. Our healthcare team will review it and contact you shortly.');
    }
}