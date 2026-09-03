<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\HalaxyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
                'page' => max(
                    (int) $request->get('page', 1),
                    1
                ),
                '_count' => 30,
            ];

            if ($request->filled('search')) {
                $search = trim(
                    (string) $request->get('search')
                );

                $params['name'] = $search;
            }

            $bundle = $this->halaxy->getPatients(
                $params
            );

            $patients = $this->halaxy->resources(
                $bundle
            );

            return view(
                'admin.halaxy-patients.index',
                [
                    'patients' => $patients,
                    'bundle' => $bundle,
                    'search' => $request->get('search'),
                    'currentPage' => (int) (
                        $params['page'] ?? 1
                    ),
                ]
            );

        } catch (Throwable $e) {
            report($e);

            return view(
                'admin.halaxy-patients.index',
                [
                    'patients' => [],
                    'bundle' => [],
                    'search' => $request->get('search'),
                    'currentPage' => 1,
                    'error' =>
                        'Unable to load Halaxy patients at the moment.',
                ]
            );
        }
    }

    /**
     * Display one Halaxy patient.
     */
    public function show(string $patientId)
    {
        /*
        |--------------------------------------------------------------------------
        | Patient
        |--------------------------------------------------------------------------
        */

        try {
            $patient = $this->halaxy->getPatient(
                $patientId
            );

            if (empty($patient)) {
                throw new \RuntimeException(
                    'Halaxy patient was not found.'
                );
            }

        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route(
                    'admin.halaxy-patients.index'
                )
                ->with(
                    'error',
                    'Unable to load this Halaxy patient.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Appointments
        |--------------------------------------------------------------------------
        */

        $appointments = [];

        try {
            $appointments =
                $this->halaxy->appointmentResources(
                    $patientId,
                    [
                        '_count' => 50,
                        '_sort' => '-date',
                    ]
                );

        } catch (Throwable $e) {
            Log::warning(
                'Unable to load Halaxy appointments for admin patient view.',
                [
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Practitioner details
        |--------------------------------------------------------------------------
        |
        | Resolve:
        |
        | Appointment
        |     -> PractitionerRole
        |     -> Practitioner
        |     -> readable practitioner name
        |
        | Failure here must never remove the appointment.
        |--------------------------------------------------------------------------
        */

        foreach ($appointments as $key => $appointment) {
            $appointments[$key]['practitioner_name'] =
                'Practitioner';

            try {
                $practitioner =
                    $this->halaxy->appointmentPractitioner(
                        $appointment
                    );

                if (
                    is_array($practitioner)
                    && !empty($practitioner['name'])
                ) {
                    $appointments[$key]['practitioner_name'] =
                        $practitioner['name'];
                }

            } catch (Throwable $e) {
                Log::warning(
                    'Unable to resolve Halaxy practitioner for appointment.',
                    [
                        'exception' => get_class($e),
                        'message' => $e->getMessage(),
                    ]
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Next Appointment
        |--------------------------------------------------------------------------
        */

        $nextAppointment = null;

        try {
            $nextAppointment =
                $this->halaxy->getNextAppointment(
                    $patientId
                );

            /*
             * Resolve practitioner for the next
             * appointment as well.
             */
            if ($nextAppointment) {
                $nextAppointment['practitioner_name'] =
                    'Practitioner';

                try {
                    $practitioner =
                        $this->halaxy->appointmentPractitioner(
                            $nextAppointment
                        );

                    if (
                        is_array($practitioner)
                        && !empty($practitioner['name'])
                    ) {
                        $nextAppointment['practitioner_name'] =
                            $practitioner['name'];
                    }

                } catch (Throwable $e) {
                    Log::warning(
                        'Unable to resolve practitioner for next Halaxy appointment.',
                        [
                            'exception' => get_class($e),
                            'message' => $e->getMessage(),
                        ]
                    );
                }
            }

        } catch (Throwable $e) {
            Log::warning(
                'Unable to load next Halaxy appointment for admin patient view.',
                [
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Invoices
        |--------------------------------------------------------------------------
        */

        $invoices = [];

        try {
            $invoices =
                $this->halaxy->patientInvoiceResources(
                    $patientId,
                    [
                        '_count' => 50,
                    ]
                );

        } catch (Throwable $e) {
            Log::warning(
                'Unable to load Halaxy invoices for admin patient view.',
                [
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.halaxy-patients.show',
            [
                'patient' => $patient,
                'appointments' => $appointments,
                'invoices' => $invoices,
                'nextAppointment' => $nextAppointment,
            ]
        );
    }
}