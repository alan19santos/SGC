<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fines extends Model
{
    use HasFactory;


    protected $table = 'fines';

    protected $fillable = [
        'condominium_id',
        'resident_id',
        'occurrence_id',
        'amount',
        'issued_at',
        'due_date',
        'financial_status_id',
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }

    public function occurrence()
    {
        return $this->belongsTo(Occurrence::class, 'occurrence_id');
    }

    public function condominium()
    {
        return $this->belongsTo(Condominium::class, 'condominium_id');
    }

    public function financialStatus()
    {
        return $this->belongsTo(FinancialStatus::class, 'financial_status_id');
    }
}
