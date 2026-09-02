<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class HalaxyService
{
    protected string $baseUrl;
    protected string $clientId;
    protected string $clientSecret;
    protected string $userAgent;

    public function __construct()
    {
        $this->baseUrl = rtrim(
            config('services.halaxy.base_url', 'https://au-api.halaxy.com/main'),
            '/'
        );

        $this->clientId = (string) config('services.halaxy.client_id');
        $this->clientSecret = (string) config('services.halaxy.client_secret');

        $this->userAgent = (string) config(
            'services.halaxy.user_agent',
            config('app.name', 'MediLeaf') . ' (' . config('mail.from.address', 'admin@medileaf.co.au') . ')'
        );
    }

    /**
     * Get a valid Halaxy OAuth access token.
     *
     * Halaxy tokens are valid for 15 minutes.
     * We cache the token for 14 minutes.
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
                ])->post($this->baseUrl . '/oauth/token', [
                            'grant_type' => 'client_credentials',
                            'client_id' => $this->clientId,
                            'client_secret' => $this->clientSecret,
                        ]);

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

                return $token;
            }
        );
    }

    /**
     * Make an authenticated GET request to Halaxy.
     */
    protected function get(string $endpoint, array $query = []): array
    {
        $response = Http::withToken($this->getAccessToken())
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

        return $response->json();
    }

    /**
     * Get existing Halaxy patients.
     *
     * Supported filters include:
     * page, _count, _id, name, family, given,
     * email, phone, status, birthdate,
     * _lastUpdated, created and _sort.
     */
    public function getPatients(array $params = []): array
    {
        $params = array_merge([
            'page' => 1,
            '_count' => 30,
        ], $params);

        return $this->get('/Patient', $params);
    }

    /**
     * Get one Halaxy patient by patient ID.
     */
    public function getPatient(string $halaxyPatientId): array
    {
        return $this->get(
            '/Patient/' . urlencode($halaxyPatientId)
        );
    }

    /**
     * Find a Halaxy patient by email.
     *
     * Used when linking a MediLeaf user
     * with an already existing Halaxy patient.
     */
    public function findPatientByEmail(string $email): ?array
    {
        $data = $this->get('/Patient', [
            'email' => trim($email),
            '_count' => 10,
        ]);

        return $data['entry'][0]['resource'] ?? null;
    }

    /**
     * Find a Halaxy patient by phone.
     */
    public function findPatientByPhone(string $phone): ?array
    {
        $data = $this->get('/Patient', [
            'phone' => trim($phone),
            '_count' => 10,
        ]);

        return $data['entry'][0]['resource'] ?? null;
    }

    /**
     * Get all appointments for a Halaxy patient.
     *
     * Can include past, current and future appointments.
     */
    public function getAppointments(
        string $halaxyPatientId,
        array $params = []
    ): array {
        $params = array_merge([
            'patient' => $halaxyPatientId,
            'page' => 1,
            '_count' => 30,
            '_sort' => '-date',
        ], $params);

        return $this->get('/Appointment', $params);
    }

    /**
     * Get one specific Halaxy appointment.
     */
    public function getAppointment(string $appointmentId): array
    {
        return $this->get(
            '/Appointment/' . urlencode($appointmentId)
        );
    }

    /**
     * Get the next upcoming appointment.
     *
     * We retrieve appointments sorted by date ascending
     * and then select the first appointment in the future.
     */
    public function getNextAppointment(
        string $halaxyPatientId
    ): ?array {
        $data = $this->getAppointments(
            $halaxyPatientId,
            [
                '_sort' => 'date',
                '_count' => 30,
            ]
        );

        $now = now();

        foreach ($data['entry'] ?? [] as $entry) {
            $appointment = $entry['resource'] ?? null;

            if (!$appointment) {
                continue;
            }

            $start = $appointment['start'] ?? null;

            if (!$start) {
                continue;
            }

            try {
                if (\Carbon\Carbon::parse($start)->greaterThanOrEqualTo($now)) {
                    return $appointment;
                }
            } catch (\Throwable $e) {
                continue;
            }
        }

        return null;
    }

    /**
     * Get invoices.
     *
     * Can be used for practice-wide invoice lists
     * or filtered by patient recipient.
     */
    public function getInvoices(array $params = []): array
    {
        $params = array_merge([
            'page' => 1,
            '_count' => 30,
        ], $params);

        return $this->get('/Invoice', $params);
    }

    /**
     * Get invoices for one Halaxy patient.
     *
     * Halaxy Invoice API uses "recipient"
     * to filter invoices by patient or organisation.
     */
    public function getPatientInvoices(
        string $halaxyPatientId,
        array $params = []
    ): array {
        $params = array_merge([
            'recipient' => $halaxyPatientId,
            'page' => 1,
            '_count' => 30,
        ], $params);

        return $this->get('/Invoice', $params);
    }

    /**
     * Get one specific invoice.
     */
    public function getInvoice(string $invoiceId): array
    {
        return $this->get(
            '/Invoice/' . urlencode($invoiceId)
        );
    }

    /**
     * Existing medication method.
     *
     * Keep this method for compatibility with
     * existing MediLeaf code.
     *
     * We will only use it after confirming that
     * MedicationRequest is available for your
     * Halaxy API account and permissions.
     */

    public function getMedications(
        string $halaxyPatientId
    ): array {
        $data = $this->get('/MedicationRequest', [
            'patient' => $halaxyPatientId,
            'status' => 'active',
        ]);

        return $data['entry'] ?? [];
    }

    /**
     * Extract only resources from a FHIR Bundle.
     *
     * Useful for controllers/views.
     */
    public function resources(array $bundle): array
    {
        return collect($bundle['entry'] ?? [])
            ->pluck('resource')
            ->filter()
            ->values()
            ->all();
    }

    /**
     * Clear the cached Halaxy OAuth token.
     *
     * Useful if credentials change or token
     * authentication needs to be retried.
     */
    public function clearAccessToken(): void
    {
        Cache::forget('halaxy_access_token');
    }
}