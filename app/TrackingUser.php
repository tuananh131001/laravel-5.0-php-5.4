<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackingUser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'role', 'grade'
    ];
}
