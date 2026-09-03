<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\HalaxyService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class UserDashboardController extends Controller
{
    public function __construct(
        protected HalaxyService $halaxy
    ) {
    }

    /**
     * Main user dashboard.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Link Existing Halaxy Patient
        |--------------------------------------------------------------------------
        |
        | If the logged-in MediLeaf user has a verified email
        | and a Halaxy patient exists with the same email,
        | save the Halaxy patient ID.
        |
        */

        $this->syncHalaxyPatient();

        $patient = $this->patientData();
        $treatment = $this->sampleTreatment();
        $profileIncomplete = $this->isProfileIncomplete();

        /*
        |--------------------------------------------------------------------------
        | Real Halaxy Appointment Data
        |--------------------------------------------------------------------------
        */

        $appointmentData = $this->halaxyAppointmentData();

        $nextAppointment =
            $appointmentData['nextAppointment'];

        return view('user.dashboard', array_merge(
            compact(
                'patient',
                'treatment',
                'nextAppointment',
                'profileIncomplete'
            ),
            $this->notificationsForView($request)
        ));
    }

    /**
     * Current Treatment.
     */
    public function treatment(Request $request)
    {
        $patient = $this->patientData();
        $treatment = $this->sampleTreatment();

        return view('user.treatment', array_merge(
            compact(
                'patient',
                'treatment'
            ),
            $this->notificationsForView($request)
        ));
    }

    /**
     * Prescriptions.
     *
     * Currently sample data.
     * Halaxy prescription access has not been
     * confirmed yet, so we do not use it here.
     */
    public function prescription(Request $request)
    {
        $patient = $this->patientData();

        $search = trim(
            (string) $request->query(
                'search',
                ''
            )
        );

        $prescriptions =
            $this->samplePrescriptions();

        if ($search !== '') {
            $needle = Str::lower($search);

            $prescriptions =
                $prescriptions
                    ->filter(
                        function ($rx) use ($needle) {
                            return Str::contains(
                                Str::lower(
                                    $rx->id ?? ''
                                ),
                                $needle
                            )
                                || Str::contains(
                                    Str::lower(
                                        $rx->medicine_name ?? ''
                                    ),
                                    $needle
                                );
                        }
                    )
                    ->values();
        }

        return view(
            'user.prescription',
            array_merge(
                compact(
                    'patient',
                    'prescriptions',
                    'search'
                ),
                $this->notificationsForView($request)
            )
        );
    }

    /**
     * Appointments page.
     *
     * Appointment booking still happens on Halaxy.
     * MediLeaf only reads appointment data
     * through the Halaxy API.
     */
    public function appointments(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Make Sure User Is Linked
        |--------------------------------------------------------------------------
        */

        $this->syncHalaxyPatient();

        $patient = $this->patientData();

        $search = trim(
            (string) $request->query(
                'search',
                ''
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Real Halaxy Appointments
        |--------------------------------------------------------------------------
        */

        $appointmentData =
            $this->halaxyAppointmentData();

        $nextAppointment =
            $appointmentData['nextAppointment'];

        $previousVisits =
            $appointmentData['previousVisits'];

        /*
        |--------------------------------------------------------------------------
        | Search Previous Visits
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {
            $needle = Str::lower($search);

            $previousVisits =
                $previousVisits
                    ->filter(
                        function ($visit) use ($needle) {
                            return Str::contains(
                                Str::lower(
                                    $visit->doctor_name ?? ''
                                ),
                                $needle
                            )
                                || Str::contains(
                                    Str::lower(
                                        $visit->reason ?? ''
                                    ),
                                    $needle
                                )
                                || Str::contains(
                                    Str::lower(
                                        $visit->date ?? ''
                                    ),
                                    $needle
                                )
                                || Str::contains(
                                    Str::lower(
                                        $visit->status ?? ''
                                    ),
                                    $needle
                                );
                        }
                    )
                    ->values();
        }

        return view(
            'user.appointments',
            array_merge(
                compact(
                    'patient',
                    'nextAppointment',
                    'previousVisits',
                    'search'
                ),
                $this->notificationsForView($request)
            )
        );
    }

    /**
     * Orders & Payments.
     *
     * Existing sample data remains unchanged
     * until Halaxy invoices/payments are connected.
     */
    public function orders(Request $request)
    {
        $patient = $this->patientData();

        $search = trim(
            (string) $request->query(
                'search',
                ''
            )
        );

        $orders = $this->sampleOrders();

        if ($search !== '') {
            $needle = Str::lower($search);

            $orders =
                $orders
                    ->filter(
                        function ($order) use ($needle) {
                            return Str::contains(
                                Str::lower(
                                    $order->order_id ?? ''
                                ),
                                $needle
                            )
                                || Str::contains(
                                    Str::lower(
                                        $order->payment_status ?? ''
                                    ),
                                    $needle
                                );
                        }
                    )
                    ->values();
        }

        return view(
            'user.orders',
            array_merge(
                compact(
                    'patient',
                    'orders',
                    'search'
                ),
                $this->notificationsForView($request)
            )
        );
    }

    /**
     * Show patient profile.
     */
    public function profile(Request $request)
    {
        $user = Auth::user();

        $patient = (object) [
            'name' => $user->name ?? null,
            'patient_id' =>
                $user->patient_id ?? null,
            'email' => $user->email ?? null,
            'mobile' => $user->mobile ?? null,
            'phone' => $user->mobile ?? null,
            'dob' => $user->dob ?? null,
            'date_of_birth' =>
                $user->dob ?? null,

            'gender' =>
                Schema::hasColumn(
                    'users',
                    'gender'
                )
                ? ($user->gender ?? null)
                : null,

            'address_line' =>
                Schema::hasColumn(
                    'users',
                    'address_line'
                )
                ? ($user->address_line ?? null)
                : null,

            'city' =>
                Schema::hasColumn(
                    'users',
                    'city'
                )
                ? ($user->city ?? null)
                : null,

            'state' =>
                Schema::hasColumn(
                    'users',
                    'state'
                )
                ? ($user->state ?? null)
                : null,

            'postcode' =>
                Schema::hasColumn(
                    'users',
                    'postcode'
                )
                ? ($user->postcode ?? null)
                : null,
        ];

        return view(
            'user.profile',
            array_merge(
                compact('patient'),
                $this->notificationsForView($request)
            )
        );
    }

    /**
     * Update personal details / address.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique(
                    'users',
                    'email'
                )->ignore($user->id),
            ],

            'phone' => [
                'required',
                'string',
                'max:20',
            ],

            'date_of_birth' => [
                'required',
                'date',
                'before:today',
            ],

            'gender' => [
                'nullable',
                'string',
                'in:male,female,other,prefer_not_to_say',
            ],

            'address_line' => [
                'nullable',
                'string',
                'max:255',
            ],

            'city' => [
                'nullable',
                'string',
                'max:100',
            ],

            'state' => [
                'nullable',
                'string',
                'max:100',
            ],

            'postcode' => [
                'nullable',
                'string',
                'max:20',
            ],
        ]);

        $updates = [
            'name' =>
                $validated['name'],

            'email' =>
                $validated['email'],

            'mobile' =>
                $validated['phone'],

            'dob' =>
                $validated['date_of_birth'],
        ];

        foreach (
            [
                'gender',
                'address_line',
                'city',
                'state',
                'postcode',
            ] as $field
        ) {
            if (
                Schema::hasColumn(
                    'users',
                    $field
                )
                && array_key_exists(
                    $field,
                    $validated
                )
            ) {
                $updates[$field] =
                    $validated[$field];
            }
        }

        $user->forceFill(
            $updates
        )->save();

        return redirect()
            ->route('user.profile')
            ->with(
                'success',
                'Profile updated successfully.'
            );
    }

    /**
     * Update password.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' =>
                'required',

            'password' =>
                'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (
            !Hash::check(
                $request->current_password,
                $user->password
            )
        ) {
            return back()->withErrors([
                'current_password' =>
                    'Current password is incorrect.',
            ]);
        }

        $user->update([
            'password' =>
                Hash::make(
                    $request->password
                ),
        ]);

        return back()->with(
            'success',
            'Password updated successfully.'
        );
    }

    /**
     * Track an order.
     */
    public function trackOrder($order)
    {
        return back()->with(
            'success',
            "Tracking info for order {$order} coming soon."
        );
    }

    /**
     * Download invoice.
     */
    public function downloadInvoice($order)
    {
        abort(
            404,
            'Invoice not available yet.'
        );
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllNotificationsRead(
        Request $request
    ) {
        $ids = collect(
            $this->sampleNotifications()
        )
            ->pluck('id')
            ->all();

        $request->session()->put(
            'user_read_notifications',
            $ids
        );

        return back()->with(
            'success',
            'All notifications marked as read.'
        );
    }

    /**
     * Logout patient/user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()
            ->invalidate();

        $request->session()
            ->regenerateToken();

        return redirect()
            ->route('login');
    }

    /**
     * Link the logged-in MediLeaf user
     * with an existing Halaxy patient.
     *
     * Important:
     *
     * - This does NOT create a Halaxy patient.
     * - MediLeaf email must already be verified.
     * - Matching is done using verified email only.
     * - No phone-number fallback is used.
     * - If no Halaxy patient exists yet,
     *   nothing happens.
     */
    private function syncHalaxyPatient(): void
    {
        $user = Auth::user();

        if (!$user) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Verified Email Required
        |--------------------------------------------------------------------------
        */

        if (!$user->hasVerifiedEmail()) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Already Linked
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
            $user->halaxy_patient_id
        )
        ) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Email Required
        |--------------------------------------------------------------------------
        */

        if (empty($user->email)) {
            return;
        }

        try {
            /*
            |--------------------------------------------------------------------------
            | Search Existing Halaxy Patient By Email
            |--------------------------------------------------------------------------
            */

            $halaxyPatient =
                $this->halaxy
                    ->findPatientByEmail(
                        trim(
                            $user->email
                        )
                    );

            /*
            |--------------------------------------------------------------------------
            | No Matching Halaxy Patient
            |--------------------------------------------------------------------------
            */

            if (!$halaxyPatient) {
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Validate Halaxy Patient
            |--------------------------------------------------------------------------
            */

            if (
                (
                    $halaxyPatient['resourceType']
                    ?? null
                ) !== 'Patient'
                || empty(
                $halaxyPatient['id']
            )
            ) {
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Save Halaxy Patient ID
            |--------------------------------------------------------------------------
            */

            $user->halaxy_patient_id =
                $halaxyPatient['id'];

            $user->save();

            Log::info(
                'MediLeaf user linked with existing Halaxy patient.',
                [
                    'user_id' =>
                        $user->id,

                    'halaxy_patient_id' =>
                        $user->halaxy_patient_id,
                ]
            );
        } catch (Throwable $e) {
            /*
            |--------------------------------------------------------------------------
            | Halaxy Failure Must Never Break Dashboard
            |--------------------------------------------------------------------------
            */

            Log::warning(
                'Unable to link MediLeaf user with Halaxy patient.',
                [
                    'user_id' =>
                        $user->id,

                    'message' =>
                        $e->getMessage(),
                ]
            );
        }
    }

    /**
     * Load and prepare real Halaxy appointments
     * for the logged-in MediLeaf user.
     *
     * Returns:
     *
     * nextAppointment
     * previousVisits
     */
    private function halaxyAppointmentData(): array
    {
        $user = Auth::user();

        $emptyResult = [
            'nextAppointment' => null,
            'previousVisits' => collect(),
        ];

        /*
        |--------------------------------------------------------------------------
        | User Must Be Logged In
        |--------------------------------------------------------------------------
        */

        if (!$user) {
            return $emptyResult;
        }

        /*
        |--------------------------------------------------------------------------
        | User Must Be Linked With Halaxy
        |--------------------------------------------------------------------------
        */

        if (
            empty(
            $user->halaxy_patient_id
        )
        ) {
            return $emptyResult;
        }

        try {
            /*
            |--------------------------------------------------------------------------
            | Get Real Halaxy Appointments
            |--------------------------------------------------------------------------
            */

            $appointments =
                $this->halaxy
                    ->appointmentResources(
                        (string) 
                        $user->halaxy_patient_id,
                        [
                            '_count' => 100,
                            '_sort' => 'date',
                        ]
                    );

            if (empty($appointments)) {
                return $emptyResult;
            }

            /*
            |--------------------------------------------------------------------------
            | Convert Halaxy Resources To Dashboard Objects
            |--------------------------------------------------------------------------
            */

            $mappedAppointments =
                collect($appointments)
                    ->map(
                        fn(array $appointment) =>
                        $this->mapHalaxyAppointment(
                            $appointment
                        )
                    )
                    ->filter(
                        fn($appointment) =>
                        !empty(
                        $appointment->start_raw
                    )
                    )
                    ->values();

            if (
                $mappedAppointments->isEmpty()
            ) {
                return $emptyResult;
            }

            $now = now();

            /*
            |--------------------------------------------------------------------------
            | Next Upcoming Appointment
            |--------------------------------------------------------------------------
            |
            | Cancelled appointments are not used
            | as the "next appointment".
            |
            */

            $nextAppointment =
                $mappedAppointments
                    ->filter(
                        function ($appointment) use ($now) {
                            try {
                                $start = Carbon::parse(
                                    $appointment->start_raw
                                );

                                return
                                    $start->greaterThanOrEqualTo(
                                        $now
                                    )
                                    && !in_array(
                                        Str::lower(
                                            $appointment->status_raw
                                            ?? ''
                                        ),
                                        [
                                            'cancelled',
                                            'entered-in-error',
                                        ],
                                        true
                                    );
                            } catch (Throwable $e) {
                                return false;
                            }
                        }
                    )
                    ->sortBy(
                        fn($appointment) =>
                        Carbon::parse(
                            $appointment->start_raw
                        )->timestamp
                    )
                    ->first();

            /*
            |--------------------------------------------------------------------------
            | Previous Visits
            |--------------------------------------------------------------------------
            */

            $previousVisits =
                $mappedAppointments
                    ->filter(
                        function ($appointment) use ($now) {
                            try {
                                return Carbon::parse(
                                    $appointment->start_raw
                                )->lessThan($now);
                            } catch (Throwable $e) {
                                return false;
                            }
                        }
                    )
                    ->sortByDesc(
                        fn($appointment) =>
                        Carbon::parse(
                            $appointment->start_raw
                        )->timestamp
                    )
                    ->values();

            return [
                'nextAppointment' =>
                    $nextAppointment,

                'previousVisits' =>
                    $previousVisits,
            ];
        } catch (Throwable $e) {
            /*
            |--------------------------------------------------------------------------
            | Halaxy API Failure Must Not Break User Dashboard
            |--------------------------------------------------------------------------
            */

            Log::warning(
                'Unable to load Halaxy appointments for MediLeaf user.',
                [
                    'user_id' =>
                        $user->id,

                    'message' =>
                        $e->getMessage(),
                ]
            );

            return $emptyResult;
        }
    }

    /**
     * Convert a Halaxy Appointment resource
     * into the existing MediLeaf dashboard format.
     */
    private function mapHalaxyAppointment(
        array $appointment
    ): object {
        $start =
            $appointment['start']
            ?? null;

        return (object) [
            /*
            |--------------------------------------------------------------------------
            | Internal Halaxy Appointment ID
            |--------------------------------------------------------------------------
            */

            'halaxy_appointment_id' =>
                $appointment['id']
                ?? null,

            /*
            |--------------------------------------------------------------------------
            | Raw Start Time
            |--------------------------------------------------------------------------
            */

            'start_raw' => $start,

            /*
            |--------------------------------------------------------------------------
            | Existing Dashboard Fields
            |--------------------------------------------------------------------------
            */

            'date' =>
                $this->formatAppointmentDate(
                    $start
                ),

            'doctor_name' =>
                $this->appointmentPractitionerName(
                    $appointment
                ),

            'type' =>
                $this->appointmentType(
                    $appointment
                ),

            'reason' =>
                $this->appointmentType(
                    $appointment
                ),

            'status' =>
                $this->appointmentStatus(
                    $appointment['status']
                    ?? null
                ),

            /*
            |--------------------------------------------------------------------------
            | Raw Status For Internal Filtering
            |--------------------------------------------------------------------------
            */

            'status_raw' =>
                $appointment['status']
                ?? null,
        ];
    }

    /**
     * Find practitioner display name from
     * Halaxy Appointment participants.
     *
     * Halaxy may return PractitionerRole
     * without a display value.
     * In that case we safely show "Practitioner".
     */
    private function appointmentPractitionerName(
        array $appointment
    ): string {
        foreach (
            $appointment['participant']
            ?? []
            as $participant
        ) {
            $actor =
                $participant['actor']
                ?? [];

            $type =
                $actor['type']
                ?? null;

            if (
                !in_array(
                    $type,
                    [
                        'Practitioner',
                        'PractitionerRole',
                    ],
                    true
                )
            ) {
                continue;
            }

            $display = trim(
                (string) 
                ($actor['display'] ?? '')
            );

            if ($display !== '') {
                return $display;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Other Possible Display Locations
        |--------------------------------------------------------------------------
        */

        $practitionerDisplay = trim(
            (string) 
            (
                $appointment['practitioner']['display']
                ?? ''
            )
        );

        if (
            $practitionerDisplay !== ''
        ) {
            return $practitionerDisplay;
        }

        return 'Practitioner';
    }

    /**
     * Get appointment type / reason
     * without exposing internal IDs.
     */
    private function appointmentType(
        array $appointment
    ): string {
        /*
        |--------------------------------------------------------------------------
        | Appointment Type
        |--------------------------------------------------------------------------
        */

        $appointmentType = trim(
            (string) 
            (
                $appointment['appointmentType']['text']
                ?? ''
            )
        );

        if ($appointmentType !== '') {
            return $appointmentType;
        }

        /*
        |--------------------------------------------------------------------------
        | Service Type
        |--------------------------------------------------------------------------
        */

        foreach (
            $appointment['serviceType']
            ?? []
            as $serviceType
        ) {
            $text = trim(
                (string) 
                ($serviceType['text'] ?? '')
            );

            if ($text !== '') {
                return $text;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Reason Code
        |--------------------------------------------------------------------------
        */

        foreach (
            $appointment['reasonCode']
            ?? []
            as $reasonCode
        ) {
            $text = trim(
                (string) 
                ($reasonCode['text'] ?? '')
            );

            if ($text !== '') {
                return $text;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Description
        |--------------------------------------------------------------------------
        */

        $description = trim(
            (string) 
            (
                $appointment['description']
                ?? ''
            )
        );

        if ($description !== '') {
            return $description;
        }

        return 'Consultation';
    }

    /**
     * Format appointment status for display.
     */
    private function appointmentStatus(
        ?string $status
    ): string {
        $status = Str::lower(
            trim(
                (string) $status
            )
        );

        return match ($status) {
            'fulfilled' =>
            'Completed',

            'booked' =>
            'Booked',

            'arrived' =>
            'Arrived',

            'checked-in' =>
            'Checked In',

            'cancelled' =>
            'Cancelled',

            'noshow' =>
            'No Show',

            'pending' =>
            'Pending',

            'proposed' =>
            'Proposed',

            'entered-in-error' =>
            'Cancelled',

            default =>
            $status !== ''
            ? Str::headline($status)
            : 'Scheduled',
        };
    }

    /**
     * Format Halaxy appointment date
     * for MediLeaf dashboard.
     */
    private function formatAppointmentDate(
        ?string $date
    ): ?string {
        if (!$date) {
            return null;
        }

        try {
            return Carbon::parse(
                $date
            )->format(
                    'd M Y, h:i A'
                );
        } catch (Throwable $e) {
            return $date;
        }
    }

    /**
     * Shared patient/header data.
     */
    private function patientData(): object
    {
        $user = Auth::user();

        return (object) [
            'name' =>
                $user->name
                ?? 'Patient',

            'patient_id' =>
                $user->patient_id
                ?? null,

            'last_login' =>
                optional(
                    $user->last_login_at
                    ?? now()
                )->format(
                        'd M Y, h:i A'
                    ),

            'email' =>
                $user->email
                ?? null,

            'mobile' =>
                $user->mobile
                ?? null,

            'phone' =>
                $user->mobile
                ?? null,

            'dob' =>
                $user->dob
                ?? null,

            'date_of_birth' =>
                $user->dob
                ?? null,

            'gender' =>
                Schema::hasColumn(
                    'users',
                    'gender'
                )
                ? (
                    $user->gender
                    ?? null
                )
                : null,

            'address_line' =>
                Schema::hasColumn(
                    'users',
                    'address_line'
                )
                ? (
                    $user->address_line
                    ?? null
                )
                : null,

            'city' =>
                Schema::hasColumn(
                    'users',
                    'city'
                )
                ? (
                    $user->city
                    ?? null
                )
                : null,

            'state' =>
                Schema::hasColumn(
                    'users',
                    'state'
                )
                ? (
                    $user->state
                    ?? null
                )
                : null,

            'postcode' =>
                Schema::hasColumn(
                    'users',
                    'postcode'
                )
                ? (
                    $user->postcode
                    ?? null
                )
                : null,
        ];
    }

    /**
     * Check whether logged-in
     * user's profile is incomplete.
     */
    private function isProfileIncomplete(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return true;
        }

        $requiredValues = [
            $user->name ?? null,
            $user->mobile ?? null,
            $user->dob ?? null,
        ];

        foreach (
            [
                'gender',
                'address_line',
                'city',
                'state',
                'postcode',
            ] as $field
        ) {
            if (
                Schema::hasColumn(
                    'users',
                    $field
                )
            ) {
                $requiredValues[] =
                    $user->{$field}
                    ?? null;
            }
        }

        return collect(
            $requiredValues
        )->contains(
                fn($value) =>
                blank($value)
            );
    }

    /**
     * Sample treatment data.
     *
     * Keep until real clinical data
     * source is available.
     */
    private function sampleTreatment(): object
    {
        return (object) [
            'doctor_name' =>
                'Dr. Sarah Williams',

            'condition' =>
                'Chronic Back Pain',

            'status' =>
                'Active',

            'start_date' =>
                '12 Jan 2026',
        ];
    }

    /**
     * Sample prescriptions data.
     *
     * Keep until prescription API
     * access is confirmed.
     */
    private function samplePrescriptions()
    {
        return collect([
            (object) [
                'id' =>
                    'RX-2026-001245',

                'medicine_name' =>
                    'Medical Cannabis Oil 10ml',

                'status' =>
                    'Active',

                'download_url' =>
                    null,
            ],

            (object) [
                'id' =>
                    'RX-2026-000998',

                'medicine_name' =>
                    'Pain Relief Capsules',

                'status' =>
                    'Completed',

                'download_url' =>
                    null,
            ],
        ]);
    }

    /**
     * Sample orders data.
     */
    private function sampleOrders()
    {
        return collect([
            (object) [
                'order_id' =>
                    'ORD-2026-000981',

                'payment_status' =>
                    'Paid',

                'invoice_url' =>
                    null,

                'track_url' =>
                    null,
            ],

            (object) [
                'order_id' =>
                    'ORD-2026-000876',

                'payment_status' =>
                    'Pending',

                'invoice_url' =>
                    null,

                'track_url' =>
                    null,
            ],
        ]);
    }

    /**
     * Sample notifications.
     */
    private function sampleNotifications(): array
    {
        return [
            [
                'id' => 1,

                'icon' =>
                    'bi-calendar-check-fill',

                'title' =>
                    'Upcoming Appointment',

                'message' =>
                    'Check your appointments for your latest booking information.',

                'time' =>
                    'Recently',
            ],

            [
                'id' => 2,

                'icon' =>
                    'bi-capsule-pill',

                'title' =>
                    'Prescription Ready',

                'message' =>
                    'Your prescription information will appear here when available.',

                'time' =>
                    'Recently',
            ],

            [
                'id' => 3,

                'icon' =>
                    'bi-truck',

                'title' =>
                    'Order Update',

                'message' =>
                    'Your MediLeaf order updates will appear here.',

                'time' =>
                    'Recently',
            ],
        ];
    }

    /**
     * Build notifications
     * and unread count.
     */
    private function notificationsForView(
        Request $request
    ): array {
        $readIds =
            $request->session()->get(
                'user_read_notifications',
                []
            );

        $notifications =
            collect(
                $this->sampleNotifications()
            )
                ->map(
                    function ($n) use ($readIds) {
                        $n['read'] =
                            in_array(
                                $n['id'],
                                $readIds,
                                true
                            );

                        return (object) $n;
                    }
                );

        return [
            'notifications' =>
                $notifications,

            'unreadCount' =>
                $notifications
                    ->where(
                        'read',
                        false
                    )
                    ->count(),
        ];
    }
}