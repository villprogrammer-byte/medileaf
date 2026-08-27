<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PractitionerReferral extends Model
{
    use HasFactory;

    /**
     * Database table name
     */
    protected $table = 'practitioner_referrals';


    /**
     * Mass assignable fields
     */
    protected $fillable = [

        // Practitioner Details
        'practitioner_name',
        'practice_name',
        'practitioner_email',
        'practitioner_phone',

        // Patient Details
        'patient_first_name',
        'patient_last_name',
        'patient_email',
        'patient_phone',
        'patient_dob',

        // Additional Information
        'medicare_number',
        'notes',

        // Optional future fields
        'status',
    ];


    /**
     * Cast fields
     */
    protected $casts = [
        'patient_dob' => 'date',
    ];
}