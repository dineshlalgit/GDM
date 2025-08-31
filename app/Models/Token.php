<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Token extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'contact_number',
        'balance_amount',
        'status',
        'token_code',
    ];

    protected $casts = [
        'balance_amount' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($token) {
            if (empty($token->token_code)) {
                $token->token_code = self::generateUniqueTokenCode();
            }
        });
    }

    public static function generateUniqueTokenCode(): string
    {
        do {
            $code = 'GDP' . strtoupper(Str::random(8));
        } while (static::where('token_code', $code)->exists());

        return $code;
    }

    public function isUsed(): bool
    {
        return $this->status === 'used';
    }

    public function isGenerated(): bool
    {
        return $this->status === 'generated';
    }
}
