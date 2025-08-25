<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'hierarchy_level',
        'color',
        'icon',
        'permissions',
    ];

    /**
     * Get the users for this role.
     */
    public function users()
    {
        return $this->hasMany(\App\Models\User::class);
    }
}
