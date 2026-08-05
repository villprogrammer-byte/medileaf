<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserDashboardController extends Controller
{

    public function index(Request $request)
    {
        $patient = $this->patientData();
        $treatment = $this->sampleTreatment();
        $nextAppointment = $this->sampleNextAppointment();
        $profileIncomplete = $this->isProfileIncomplete();

        return view('user.dashboard', array_merge(
            compact('patient', 'treatment', 'nextAppointment', 'profileIncomplete'),
            $this->notificationsForView($request)
        ));
    }

    /**
     * Current Treatment — own page (sidebar: "Current Treatment").
     */
    public function treatment(Request $request)
    {
        $patient = $this->patientData();
        $treatment = $this->sampleTreatment();

        return view('user.treatment', array_merge(
            compact('patient', 'treatment'),
            $this->notificationsForView($request)
        ));
    }

    /**
     * Prescriptions — own page (sidebar: "Prescription").
     */
    public function prescription(Request $request)
    {
        $patient = $this->patientData();
        $search = trim((string) $request->query('search', ''));
        $prescriptions = $this->samplePrescriptions();

        if ($search !== '') {
            $needle = Str::lower($search);

            $prescriptions = $prescriptions->filter(function ($rx) use ($needle) {
                return Str::contains(Str::lower($rx->id ?? ''), $needle)
                    || Str::contains(Str::lower($rx->medicine_name ?? ''), $needle);
            })->values();
        }

        return view('user.prescription', array_merge(
            compact('patient', 'prescriptions', 'search'),
            $this->notificationsForView($request)
        ));
    }

    /**
     * Appointments — own page (sidebar: "Appointments").
     */
    public function appointments(Request $request)
    {
        $patient = $this->patientData();
        $search = trim((string) $request->query('search', ''));
        $nextAppointment = $this->sampleNextAppointment();
        $previousVisits = $this->samplePreviousVisits();

        if ($search !== '') {
            $needle = Str::lower($search);

            $previousVisits = $previousVisits->filter(function ($visit) use ($needle) {
                return Str::contains(Str::lower($visit->doctor_name ?? ''), $needle)
                    || Str::contains(Str::lower($visit->reason ?? ''), $needle)
                    || Str::contains(Str::lower($visit->date ?? ''), $needle);
            })->values();
        }

        return view('user.appointments', array_merge(
            compact('patient', 'nextAppointment', 'previousVisits', 'search'),
            $this->notificationsForView($request)
        ));
    }

    /**
     * Orders & Payments — own page (sidebar: "Orders & Payments").
     */
    public function orders(Request $request)
    {
        $patient = $this->patientData();
        $search = trim((string) $request->query('search', ''));
        $orders = $this->sampleOrders();

        if ($search !== '') {
            $needle = Str::lower($search);

            $orders = $orders->filter(function ($order) use ($needle) {
                return Str::contains(Str::lower($order->order_id ?? ''), $needle)
                    || Str::contains(Str::lower($order->payment_status ?? ''), $needle);
            })->values();
        }

        return view('user.orders', array_merge(
            compact('patient', 'orders', 'search'),
            $this->notificationsForView($request)
        ));
    }

    /**
     * Show the patient profile page.
     */
    public function profile(Request $request)
    {
        $user = Auth::user();

        $patient = (object) [
            'name' => $user->name ?? null,
            'patient_id' => $user->patient_id ?? null,
            'email' => $user->email ?? null,
            'mobile' => $user->mobile ?? null,
            'phone' => $user->mobile ?? null,
            'dob' => $user->dob ?? null,
            'date_of_birth' => $user->dob ?? null,
            'gender' => Schema::hasColumn('users', 'gender') ? ($user->gender ?? null) : null,
            'address_line' => Schema::hasColumn('users', 'address_line') ? ($user->address_line ?? null) : null,
            'city' => Schema::hasColumn('users', 'city') ? ($user->city ?? null) : null,
            'state' => Schema::hasColumn('users', 'state') ? ($user->state ?? null) : null,
            'postcode' => Schema::hasColumn('users', 'postcode') ? ($user->postcode ?? null) : null,
        ];

        return view('user.profile', array_merge(
            compact('patient'),
            $this->notificationsForView($request)
        ));
    }

    /**
     * Update personal details / address.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:20'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'gender' => ['nullable', 'string', 'in:male,female,other,prefer_not_to_say'],
            'address_line' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postcode' => ['nullable', 'string', 'max:20'],
        ]);

        $updates = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile' => $validated['phone'],
            'dob' => $validated['date_of_birth'],
        ];

        foreach (['gender', 'address_line', 'city', 'state', 'postcode'] as $field) {
            if (Schema::hasColumn('users', $field) && array_key_exists($field, $validated)) {
                $updates[$field] = $validated[$field];
            }
        }

        $user->forceFill($updates)->save();

        return redirect()
            ->route('user.profile')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Update password.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password updated successfully.');
    }

    /**
     * Track an order (placeholder — wire up to your Order model).
     */
    public function trackOrder($order)
    {
        return back()->with('success', "Tracking info for order {$order} coming soon.");
    }

    /**
     * Download invoice (placeholder — wire up to your Order model).
     */
    public function downloadInvoice($order)
    {
        abort(404, 'Invoice not available yet.');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllNotificationsRead(Request $request)
    {
        $ids = collect($this->sampleNotifications())->pluck('id')->all();

        $request->session()->put('user_read_notifications', $ids);

        return back()->with('success', 'All notifications marked as read.');
    }

    /**
     * Logout the patient/user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Shared patient/header data — used by every page in this controller.
     */
    private function patientData(): object
    {
        $user = Auth::user();

        return (object) [
            'name' => $user->name ?? 'Patient',
            'patient_id' => $user->patient_id ?? null,
            'last_login' => optional($user->last_login_at ?? now())->format('d M Y, h:i A'),
            'email' => $user->email ?? null,
            'mobile' => $user->mobile ?? null,
            'phone' => $user->mobile ?? null,
            'dob' => $user->dob ?? null,
            'date_of_birth' => $user->dob ?? null,
            'gender' => Schema::hasColumn('users', 'gender') ? ($user->gender ?? null) : null,
            'address_line' => Schema::hasColumn('users', 'address_line') ? ($user->address_line ?? null) : null,
            'city' => Schema::hasColumn('users', 'city') ? ($user->city ?? null) : null,
            'state' => Schema::hasColumn('users', 'state') ? ($user->state ?? null) : null,
            'postcode' => Schema::hasColumn('users', 'postcode') ? ($user->postcode ?? null) : null,
        ];
    }

    /**
     * Check whether the logged-in user's profile is incomplete.
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

        foreach (['gender', 'address_line', 'city', 'state', 'postcode'] as $field) {
            if (Schema::hasColumn('users', $field)) {
                $requiredValues[] = $user->{$field} ?? null;
            }
        }

        return collect($requiredValues)->contains(
            fn($value) => blank($value)
        );
    }

    /**
     * Sample treatment data.
     * Replace with: Treatment::where('patient_id', $user->id)->latest()->first();
     */
    private function sampleTreatment(): object
    {
        return (object) [
            'doctor_name' => 'Dr. Sarah Williams',
            'condition' => 'Chronic Back Pain',
            'status' => 'Active',
            'start_date' => '12 Jan 2026',
        ];
    }

    /**
     * Sample prescriptions data.
     * Replace with: Prescription::where('patient_id', $user->id)->get();
     */
    private function samplePrescriptions()
    {
        return collect([
            (object) [
                'id' => 'RX-2026-001245',
                'medicine_name' => 'Medical Cannabis Oil 10ml',
                'status' => 'Active',
                'download_url' => null,
            ],
            (object) [
                'id' => 'RX-2026-000998',
                'medicine_name' => 'Pain Relief Capsules',
                'status' => 'Completed',
                'download_url' => null,
            ],
        ]);
    }

    /**
     * Sample next appointment data.
     * Replace with: Appointment::where('patient_id', $user->id)
     *                   ->where('date', '>=', now())->orderBy('date')->first();
     */
    private function sampleNextAppointment(): object
    {
        return (object) [
            'date' => '18 Aug 2026, 10:30 AM',
            'doctor_name' => 'Dr. Sarah Williams',
            'type' => 'Follow-up Consultation',
        ];
    }

    /**
     * Sample previous visits data.
     * Replace with: Appointment::where('patient_id', $user->id)
     *                   ->where('date', '<', now())->latest('date')->get();
     */
    private function samplePreviousVisits()
    {
        return collect([
            (object) [
                'date' => '02 Jul 2026',
                'doctor_name' => 'Dr. Sarah Williams',
                'reason' => 'Routine Check-up',
                'status' => 'Completed',
            ],
            (object) [
                'date' => '14 May 2026',
                'doctor_name' => 'Dr. Michael Lee',
                'reason' => 'Prescription Renewal',
                'status' => 'Completed',
            ],
        ]);
    }

    /**
     * Sample orders data.
     * Replace with: Order::where('patient_id', $user->id)->latest()->get();
     */
    private function sampleOrders()
    {
        return collect([
            (object) [
                'order_id' => 'ORD-2026-000981',
                'payment_status' => 'Paid',
                'invoice_url' => null,
                'track_url' => null,
            ],
            (object) [
                'order_id' => 'ORD-2026-000876',
                'payment_status' => 'Pending',
                'invoice_url' => null,
                'track_url' => null,
            ],
        ]);
    }

    /**
     * Sample notification data.
     * Replace with a real query, e.g.:
     *   Auth::user()->notifications()->latest()->take(10)->get()
     */
    private function sampleNotifications(): array
    {
        return [
            [
                'id' => 1,
                'icon' => 'bi-calendar-check-fill',
                'title' => 'Upcoming Appointment',
                'message' => 'Your appointment with Dr. Sarah Williams is on 18 Aug 2026, 10:30 AM.',
                'time' => '2 hours ago',
            ],
            [
                'id' => 2,
                'icon' => 'bi-capsule-pill',
                'title' => 'Prescription Ready',
                'message' => 'Prescription RX-2026-001245 has been approved and is ready.',
                'time' => '1 day ago',
            ],
            [
                'id' => 3,
                'icon' => 'bi-truck',
                'title' => 'Order Shipped',
                'message' => 'Order ORD-2026-000981 has been shipped and is on its way.',
                'time' => '3 days ago',
            ],
        ];
    }

    /**
     * Builds the notifications + unread_count array shared with any view
     * that renders the header partial (dashboard, profile, etc.).
     */
    private function notificationsForView(Request $request): array
    {
        $readIds = $request->session()->get('user_read_notifications', []);

        $notifications = collect($this->sampleNotifications())->map(function ($n) use ($readIds) {
            $n['read'] = in_array($n['id'], $readIds, true);
            return (object) $n;
        });

        return [
            'notifications' => $notifications,
            'unreadCount' => $notifications->where('read', false)->count(),
        ];
    }
}