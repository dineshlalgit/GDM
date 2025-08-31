<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'opening_balance',
        'closing_balance',
        'total_income',
        'total_expenses',
        'net_change',
        'notes',
        'updated_by',
    ];

    protected $casts = [
        'date' => 'date',
        'opening_balance' => 'decimal:2',
        'closing_balance' => 'decimal:2',
        'total_income' => 'decimal:2',
        'total_expenses' => 'decimal:2',
        'net_change' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('date', 'desc');
    }

    public function calculateNetChange()
    {
        $this->net_change = $this->total_income - $this->total_expenses;
        return $this->net_change;
    }

    public function calculateClosingBalance()
    {
        $this->closing_balance = $this->opening_balance + $this->net_change;
        return $this->closing_balance;
    }
}
