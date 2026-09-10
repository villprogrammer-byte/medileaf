<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PatientPrescription;
use Illuminate\Http\Request;

class PatientPrescriptionController extends Controller
{
    /**
     * Store a new prescription.
     *
     * This data is stored only in the MediLeaf database.
     * Nothing is sent to Halaxy.
     */
    public function store(
        Request $request,
        string $patientId
    ) {
        $validated = $request->validate([
            'ihi_id' => [
                'nullable',
                'string',
                'max:255',
            ],

            'prescription_number' => [
                'required',
                'string',
                'max:255',
            ],

            'medicine_name' => [
                'required',
                'string',
                'max:255',
            ],

            'strength_form' => [
                'nullable',
                'string',
                'max:255',
            ],

            'directions' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'quantity' => [
                'nullable',
                'string',
                'max:255',
            ],

            'repeats' => [
                'required',
                'integer',
                'min:0',
                'max:999',
            ],

            'interval' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:active,completed,cancelled',
            ],
        ]);

        PatientPrescription::create([
            'halaxy_patient_id' => $patientId,

            'ihi_id' =>
                $validated['ihi_id'] ?? null,

            'prescription_number' =>
                $validated['prescription_number'],

            'medicine_name' =>
                $validated['medicine_name'],

            'strength_form' =>
                $validated['strength_form'] ?? null,

            'directions' =>
                $validated['directions'] ?? null,

            'quantity' =>
                $validated['quantity'] ?? null,

            'repeats' =>
                $validated['repeats'],

            'interval' =>
                $validated['interval'] ?? null,

            'status' =>
                $validated['status'],
        ]);

        return redirect()
            ->route(
                'admin.halaxy-patients.show',
                $patientId
            )
            ->with(
                'success',
                'Prescription added successfully.'
            );
    }


    /**
     * Update an existing prescription.
     */
    public function update(
        Request $request,
        string $patientId,
        PatientPrescription $prescription
    ) {
        abort_unless(
            (string) $prescription->halaxy_patient_id ===
            (string) $patientId,
            404
        );

        $validated = $request->validate([
            'ihi_id' => [
                'nullable',
                'string',
                'max:255',
            ],

            'prescription_number' => [
                'required',
                'string',
                'max:255',
            ],

            'medicine_name' => [
                'required',
                'string',
                'max:255',
            ],

            'strength_form' => [
                'nullable',
                'string',
                'max:255',
            ],

            'directions' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'quantity' => [
                'nullable',
                'string',
                'max:255',
            ],

            'repeats' => [
                'required',
                'integer',
                'min:0',
                'max:999',
            ],

            'interval' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:active,completed,cancelled',
            ],
        ]);

        $prescription->update([
            'ihi_id' =>
                $validated['ihi_id'] ?? null,

            'prescription_number' =>
                $validated['prescription_number'],

            'medicine_name' =>
                $validated['medicine_name'],

            'strength_form' =>
                $validated['strength_form'] ?? null,

            'directions' =>
                $validated['directions'] ?? null,

            'quantity' =>
                $validated['quantity'] ?? null,

            'repeats' =>
                $validated['repeats'],

            'interval' =>
                $validated['interval'] ?? null,

            'status' =>
                $validated['status'],
        ]);

        return redirect()
            ->route(
                'admin.halaxy-patients.show',
                $patientId
            )
            ->with(
                'success',
                'Prescription updated successfully.'
            );
    }


    /**
     * Delete an existing prescription.
     *
     * This only deletes the prescription from the
     * MediLeaf database.
     *
     * Nothing is deleted from Halaxy.
     */
    public function destroy(
        string $patientId,
        PatientPrescription $prescription
    ) {
        /*
        |--------------------------------------------------------------------------
        | Patient Ownership Check
        |--------------------------------------------------------------------------
        |
        | Prevent a prescription belonging to another patient
        | from being deleted through a modified URL.
        |
        */

        abort_unless(
            (string) $prescription->halaxy_patient_id ===
            (string) $patientId,
            404
        );

        $prescription->delete();

        return redirect()
            ->route(
                'admin.halaxy-patients.show',
                $patientId
            )
            ->with(
                'success',
                'Prescription deleted successfully.'
            );
    }
}