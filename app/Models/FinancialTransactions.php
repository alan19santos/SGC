<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialTransactions extends Model
{
    use HasFactory;

    protected $table = 'financial_transactions';

    protected $fillable = [
        'condominium_id',
        'description',
        'amount',
        'transaction_date',
        'due_date',
        'paid_at',
        'financial_category_id',
        'financial_type_id',
        'financial_status_id',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'due_date' => 'date',
    ];

    public function condominium()
    {
        return $this->belongsTo(Condominium::class, 'condominium_id', 'id');
    }

    public function financialCategory()
    {
        return $this->belongsTo(FinancialCategory::class, 'financial_category_id', 'id');
    }

    public function financialType()
    {
        return $this->belongsTo(FinancialType::class, 'financial_type_id', 'id');
    }

    public function financialStatus()
    {
        return $this->belongsTo(FinancialStatus::class, 'financial_status_id', 'id');
    }

}
