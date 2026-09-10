<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientPrescription extends Model
{
    use HasFactory;

    protected $table = 'patient_prescriptions';

    protected $fillable = [
        'halaxy_patient_id',
        'ihi_id',
        'prescription_number',
        'medicine_name',
        'strength_form',
        'directions',
        'quantity',
        'repeats',
        'interval',
        'status',
    ];

    protected $casts = [
        'repeats' => 'integer',
    ];
}