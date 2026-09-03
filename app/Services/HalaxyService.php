<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

class HalaxyService
{
    protected string $baseUrl;
    protected string $clientId;
    protected string $clientSecret;
    protected string $userAgent;

    protected array $practitionerCache = [];
    protected array $practitionerRoleCache = [];

    public function __construct()
    {
        $this->baseUrl = rtrim(
            config(
                'services.halaxy.base_url',
                'https://au-api.halaxy.com/main'
            ),
            '/'
        );

        $this->clientId = (string) config(
            'services.halaxy.client_id'
        );

        $this->clientSecret = (string) config(
            'services.halaxy.client_secret'
        );

        $this->userAgent = (string) config(
            'services.halaxy.user_agent',
            config('app.name', 'MediLeaf')
            . ' ('
            . config(
                'mail.from.address',
                'admin@medileaf.co.au'
            )
            . ')'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    public function getAccessToken(): string
    {
        if (!$this->clientId || !$this->clientSecret) {
            throw new RuntimeException(
                'Halaxy Client ID or Client Secret is missing.'
            );
        }

        return Cache::remember(
            'halaxy_access_token',
            now()->addMinutes(14),
            function () {
                $response = Http::withHeaders([
                    'Accept' => 'application/fhir+json',
                    'Content-Type' => 'application/json',
                    'User-Agent' => $this->userAgent,
                ])->post(
                        $this->baseUrl . '/oauth/token',
                        [
                            'grant_type' => 'client_credentials',
                            'client_id' => $this->clientId,
                            'client_secret' => $this->clientSecret,
                        ]
                    );

                if ($response->failed()) {
                    throw new RuntimeException(
                        'Halaxy authentication failed. HTTP '
                        . $response->status()
                        . ': '
                        . $response->body()
                    );
                }

                $token = $response->json('access_token');

                if (!$token) {
                    throw new RuntimeException(
                        'Halaxy access token was not returned.'
                    );
                }

                return (string) $token;
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Generic GET
    |--------------------------------------------------------------------------
    */

    protected function get(
        string $endpoint,
        array $query = []
    ): array {
        $response = Http::withToken(
            $this->getAccessToken()
        )
            ->withHeaders([
                'Accept' => 'application/fhir+json',
                'Content-Type' => 'application/json',
                'User-Agent' => $this->userAgent,
            ])
            ->get(
                $this->baseUrl . '/' . ltrim($endpoint, '/'),
                $query
            );

        if ($response->failed()) {
            throw new RuntimeException(
                'Halaxy API request failed. HTTP '
                . $response->status()
                . ': '
                . $response->body()
            );
        }

        $data = $response->json();

        if (!is_array($data)) {
            return [];
        }

        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isOperationOutcome(
        ?array $resource
    ): bool {
        if (!$resource) {
            return false;
        }

        return (
            $resource['resourceType'] ?? null
        ) === 'OperationOutcome';
    }

    /**
     * Extract resource ID from either:
     *
     * PractitionerRole/123
     *
     * or:
     *
     * https://au-api.halaxy.com/main/PractitionerRole/123
     *
     * No regex is used here.
     */
    protected function referenceId(
        ?string $reference,
        string $resourceType
    ): ?string {
        if (!$reference) {
            return null;
        }

        $reference = trim($reference);

        if ($reference === '') {
            return null;
        }

        /*
         * Remove query string and fragment first.
         */
        $reference = explode('#', $reference, 2)[0];
        $reference = explode('?', $reference, 2)[0];

        /*
         * Absolute URL.
         */
        if (
            str_starts_with($reference, 'http://')
            || str_starts_with($reference, 'https://')
        ) {
            $path = parse_url(
                $reference,
                PHP_URL_PATH
            );

            if (!is_string($path)) {
                return null;
            }

            $reference = $path;
        }

        $segments = array_values(
            array_filter(
                explode(
                    '/',
                    trim($reference, '/')
                ),
                fn($segment) => $segment !== ''
            )
        );

        foreach ($segments as $index => $segment) {
            if (
                strcasecmp(
                    $segment,
                    $resourceType
                ) !== 0
            ) {
                continue;
            }

            $id = $segments[$index + 1] ?? null;

            if (!$id) {
                return null;
            }

            return rawurldecode(
                $id
            );
        }

        return null;
    }

    /**
     * Convert FHIR HumanName into readable name.
     */
    protected function humanName(
        array $resource
    ): ?string {
        $names = $resource['name'] ?? [];

        if (!is_array($names)) {
            return null;
        }

        /*
         * Some FHIR resources may return a single
         * name object instead of an indexed array.
         */
        if (
            isset($names['given'])
            || isset($names['family'])
            || isset($names['text'])
        ) {
            $names = [$names];
        }

        foreach ($names as $name) {
            if (!is_array($name)) {
                continue;
            }

            if (!empty($name['text'])) {
                $text = trim(
                    (string) $name['text']
                );

                if ($text !== '') {
                    return $text;
                }
            }

            $parts = [];

            foreach (
                (array) ($name['prefix'] ?? [])
                as $prefix
            ) {
                $prefix = trim(
                    (string) $prefix
                );

                if ($prefix !== '') {
                    $parts[] = $prefix;
                }
            }

            foreach (
                (array) ($name['given'] ?? [])
                as $given
            ) {
                $given = trim(
                    (string) $given
                );

                if ($given !== '') {
                    $parts[] = $given;
                }
            }

            if (!empty($name['family'])) {
                $parts[] = trim(
                    (string) $name['family']
                );
            }

            $fullName = trim(
                implode(' ', $parts)
            );

            if ($fullName !== '') {
                return $fullName;
            }
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Patients
    |--------------------------------------------------------------------------
    */

    public function getPatients(
        array $params = []
    ): array {
        $params = array_merge([
            'page' => 1,
            '_count' => 30,
        ], $params);

        return $this->get(
            '/Patient',
            $params
        );
    }

    public function getPatient(
        string $halaxyPatientId
    ): array {
        $data = $this->get(
            '/Patient/'
            . urlencode($halaxyPatientId)
        );

        if ($this->isOperationOutcome($data)) {
            return [];
        }

        return $data;
    }

    public function findPatientByEmail(
        string $email
    ): ?array {
        $data = $this->get(
            '/Patient',
            [
                'email' => trim($email),
                '_count' => 10,
            ]
        );

        if ($this->isOperationOutcome($data)) {
            return null;
        }

        foreach (
            $this->resources($data)
            as $resource
        ) {
            if (
                ($resource['resourceType'] ?? null)
                === 'Patient'
            ) {
                return $resource;
            }
        }

        return null;
    }

    public function findPatientByPhone(
        string $phone
    ): ?array {
        $data = $this->get(
            '/Patient',
            [
                'phone' => trim($phone),
                '_count' => 10,
            ]
        );

        if ($this->isOperationOutcome($data)) {
            return null;
        }

        foreach (
            $this->resources($data)
            as $resource
        ) {
            if (
                ($resource['resourceType'] ?? null)
                === 'Patient'
            ) {
                return $resource;
            }
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Patient References
    |--------------------------------------------------------------------------
    */

    public function patientReference(
        string $halaxyPatientId
    ): string {
        return $this->baseUrl
            . '/Patient/'
            . rawurlencode($halaxyPatientId);
    }

    public function invoicePatientReference(
        string $halaxyPatientId
    ): string {
        return 'Patient/'
            . rawurlencode($halaxyPatientId);
    }

    /*
    |--------------------------------------------------------------------------
    | Appointments
    |--------------------------------------------------------------------------
    */

    public function getAllAppointments(
        array $params = []
    ): array {
        $params = array_merge([
            'page' => 1,
            '_count' => 10,
            '_sort' => '-date',
        ], $params);

        return $this->get(
            '/Appointment',
            $params
        );
    }

    public function getAppointments(
        string $halaxyPatientId,
        array $params = []
    ): array {
        $params = array_merge([
            'patient' => $this->patientReference(
                $halaxyPatientId
            ),
            'page' => 1,
            '_count' => 30,
            '_sort' => '-date',
        ], $params);

        return $this->get(
            '/Appointment',
            $params
        );
    }

    public function appointmentResources(
        string $halaxyPatientId,
        array $params = []
    ): array {
        $bundle = $this->getAppointments(
            $halaxyPatientId,
            $params
        );

        return collect(
            $this->resources($bundle)
        )
            ->filter(function ($resource) {
                return (
                    $resource['resourceType']
                    ?? null
                ) === 'Appointment';
            })
            ->values()
            ->all();
    }

    public function getAppointment(
        string $appointmentId
    ): array {
        $data = $this->get(
            '/Appointment/'
            . urlencode($appointmentId)
        );

        if ($this->isOperationOutcome($data)) {
            return [];
        }

        return $data;
    }

    public function getNextAppointment(
        string $halaxyPatientId
    ): ?array {
        $appointments =
            $this->appointmentResources(
                $halaxyPatientId,
                [
                    '_sort' => 'date',
                    '_count' => 30,
                ]
            );

        $now = now();

        foreach (
            $appointments
            as $appointment
        ) {
            $start =
                $appointment['start']
                ?? null;

            if (!$start) {
                continue;
            }

            try {
                if (
                    Carbon::parse($start)
                        ->greaterThanOrEqualTo($now)
                ) {
                    return $appointment;
                }
            } catch (Throwable $e) {
                continue;
            }
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Practitioner Role
    |--------------------------------------------------------------------------
    */

    public function getPractitionerRole(
        string $practitionerRoleId
    ): array {
        if (
            array_key_exists(
                $practitionerRoleId,
                $this->practitionerRoleCache
            )
        ) {
            return $this->practitionerRoleCache[
                $practitionerRoleId
            ];
        }

        $data = $this->get(
            '/PractitionerRole/'
            . rawurlencode($practitionerRoleId)
        );

        if ($this->isOperationOutcome($data)) {
            $data = [];
        }

        $this->practitionerRoleCache[
            $practitionerRoleId
        ] = $data;

        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | Practitioner
    |--------------------------------------------------------------------------
    */

    public function getPractitioner(
        string $practitionerId
    ): array {
        if (
            array_key_exists(
                $practitionerId,
                $this->practitionerCache
            )
        ) {
            return $this->practitionerCache[
                $practitionerId
            ];
        }

        $data = $this->get(
            '/Practitioner/'
            . rawurlencode($practitionerId)
        );

        if ($this->isOperationOutcome($data)) {
            $data = [];
        }

        $this->practitionerCache[
            $practitionerId
        ] = $data;

        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | Appointment Practitioner Resolver
    |--------------------------------------------------------------------------
    */

    public function appointmentPractitioner(
        array $appointment
    ): ?array {
        foreach (
            $appointment['participant'] ?? []
            as $participant
        ) {
            $actor =
                $participant['actor']
                ?? [];

            if (!is_array($actor)) {
                continue;
            }

            $reference =
                $actor['reference']
                ?? null;

            $display =
                isset($actor['display'])
                ? trim((string) $actor['display'])
                : null;

            /*
             * Direct Practitioner reference.
             */
            $practitionerId =
                $this->referenceId(
                    $reference,
                    'Practitioner'
                );

            if ($practitionerId) {
                try {
                    $practitioner =
                        $this->getPractitioner(
                            $practitionerId
                        );

                    $name =
                        $this->humanName(
                            $practitioner
                        );

                    return [
                        'name' =>
                            $name
                            ?: $display
                            ?: 'Practitioner',

                        'practitioner_id' =>
                            $practitionerId,

                        'practitioner_role_id' =>
                            null,
                    ];

                } catch (Throwable $e) {
                    return [
                        'name' =>
                            $display
                            ?: 'Practitioner',

                        'practitioner_id' =>
                            $practitionerId,

                        'practitioner_role_id' =>
                            null,
                    ];
                }
            }

            /*
             * PractitionerRole reference.
             */
            $practitionerRoleId =
                $this->referenceId(
                    $reference,
                    'PractitionerRole'
                );

            if (!$practitionerRoleId) {
                continue;
            }

            try {
                $role =
                    $this->getPractitionerRole(
                        $practitionerRoleId
                    );
            } catch (Throwable $e) {
                return [
                    'name' =>
                        $display
                        ?: 'Practitioner',

                    'practitioner_id' =>
                        null,

                    'practitioner_role_id' =>
                        $practitionerRoleId,
                ];
            }

            $practitionerReference =
                data_get(
                    $role,
                    'practitioner.reference'
                );

            $roleDisplay =
                data_get(
                    $role,
                    'practitioner.display'
                );

            if (!$roleDisplay) {
                $roleDisplay = $display;
            }

            $practitionerId =
                $this->referenceId(
                    $practitionerReference,
                    'Practitioner'
                );

            if (!$practitionerId) {
                return [
                    'name' =>
                        $roleDisplay
                        ?: 'Practitioner',

                    'practitioner_id' =>
                        null,

                    'practitioner_role_id' =>
                        $practitionerRoleId,
                ];
            }

            try {
                $practitioner =
                    $this->getPractitioner(
                        $practitionerId
                    );

                $name =
                    $this->humanName(
                        $practitioner
                    );

                return [
                    'name' =>
                        $name
                        ?: $roleDisplay
                        ?: 'Practitioner',

                    'practitioner_id' =>
                        $practitionerId,

                    'practitioner_role_id' =>
                        $practitionerRoleId,
                ];

            } catch (Throwable $e) {
                return [
                    'name' =>
                        $roleDisplay
                        ?: 'Practitioner',

                    'practitioner_id' =>
                        $practitionerId,

                    'practitioner_role_id' =>
                        $practitionerRoleId,
                ];
            }
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Invoices
    |--------------------------------------------------------------------------
    */

    public function getInvoices(
        array $params = []
    ): array {
        $params = array_merge([
            'page' => 1,
            '_count' => 30,
        ], $params);

        return $this->get(
            '/Invoice',
            $params
        );
    }

    public function getPatientInvoices(
        string $halaxyPatientId,
        array $params = []
    ): array {
        $params = array_merge([
            'recipient' =>
                $this->invoicePatientReference(
                    $halaxyPatientId
                ),
            'page' => 1,
            '_count' => 30,
        ], $params);

        return $this->get(
            '/Invoice',
            $params
        );
    }

    public function patientInvoiceResources(
        string $halaxyPatientId,
        array $params = []
    ): array {
        $bundle =
            $this->getPatientInvoices(
                $halaxyPatientId,
                $params
            );

        return collect(
            $this->resources($bundle)
        )
            ->filter(function ($resource) {
                return (
                    $resource['resourceType']
                    ?? null
                ) === 'Invoice';
            })
            ->values()
            ->all();
    }

    public function getInvoice(
        string $invoiceId
    ): array {
        $data = $this->get(
            '/Invoice/'
            . urlencode($invoiceId)
        );

        if ($this->isOperationOutcome($data)) {
            return [];
        }

        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | Medications
    |--------------------------------------------------------------------------
    */

    public function getMedications(
        string $halaxyPatientId
    ): array {
        $data = $this->get(
            '/MedicationRequest',
            [
                'patient' => $halaxyPatientId,
                'status' => 'active',
            ]
        );

        if ($this->isOperationOutcome($data)) {
            return [];
        }

        return collect(
            $this->resources($data)
        )
            ->filter(function ($resource) {
                return (
                    $resource['resourceType']
                    ?? null
                ) === 'MedicationRequest';
            })
            ->values()
            ->all();
    }

    /*
    |--------------------------------------------------------------------------
    | Bundle Resources
    |--------------------------------------------------------------------------
    */

    public function resources(
        array $bundle
    ): array {
        if ($this->isOperationOutcome($bundle)) {
            return [];
        }

        return collect(
            $bundle['entry'] ?? []
        )
            ->pluck('resource')
            ->filter(function ($resource) {
                if (!is_array($resource)) {
                    return false;
                }

                if (
                    ($resource['resourceType'] ?? null)
                    === 'OperationOutcome'
                ) {
                    return false;
                }

                return true;
            })
            ->values()
            ->all();
    }

    /*
    |--------------------------------------------------------------------------
    | Token Cache
    |--------------------------------------------------------------------------
    */

    public function clearAccessToken(): void
    {
        Cache::forget(
            'halaxy_access_token'
        );
    }
}