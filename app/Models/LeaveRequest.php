<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $fillable = [
        'user_id',
        'from_date',
        'to_date',
        'leave_type',
        'medical_reason',
        'status',
        'approved_by',
    ];

    /**
     * Get the user who submitted the leave request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who approved the leave request (if any).
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
