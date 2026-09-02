<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\HalaxyService;
use Illuminate\Http\Request;
use Throwable;

class HalaxyPatientController extends Controller
{
    public function __construct(
        protected HalaxyService $halaxy
    ) {
    }

    /**
     * Display Halaxy patient list.
     */
    public function index(Request $request)
    {
        try {
            $params = [
                'page' => max((int) $request->get('page', 1), 1),
                '_count' => 30,
            ];

            if ($request->filled('search')) {
                $search = trim($request->get('search'));

                /*
                 * Halaxy has different search filters.
                 * Start with name search for admin UI.
                 */
                $params['name'] = $search;
            }

            $bundle = $this->halaxy->getPatients($params);

            $patients = $this->halaxy->resources($bundle);

            return view('admin.halaxy-patients.index', [
                'patients' => $patients,
                'bundle' => $bundle,
                'search' => $request->get('search'),
                'currentPage' => (int) ($params['page'] ?? 1),
            ]);

        } catch (Throwable $e) {
            report($e);

            return view('admin.halaxy-patients.index', [
                'patients' => [],
                'bundle' => [],
                'search' => $request->get('search'),
                'currentPage' => 1,
                'error' => 'Unable to load Halaxy patients at the moment.',
            ]);
        }
    }

    /**
     * Display one Halaxy patient with
     * appointments and invoices.
     */
    public function show(string $patientId)
    {
        try {
            $patient = $this->halaxy->getPatient($patientId);

            $appointmentBundle = $this->halaxy->getAppointments(
                $patientId,
                [
                    '_count' => 50,
                    '_sort' => '-date',
                ]
            );

            $invoiceBundle = $this->halaxy->getPatientInvoices(
                $patientId,
                [
                    '_count' => 50,
                ]
            );

            $appointments = $this->halaxy->resources(
                $appointmentBundle
            );

            $invoices = $this->halaxy->resources(
                $invoiceBundle
            );

            $nextAppointment = $this->halaxy
                ->getNextAppointment($patientId);

            return view('admin.halaxy-patients.show', [
                'patient' => $patient,
                'appointments' => $appointments,
                'invoices' => $invoices,
                'nextAppointment' => $nextAppointment,
            ]);

        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('admin.halaxy-patients.index')
                ->with(
                    'error',
                    'Unable to load this Halaxy patient.'
                );
        }
    }
}