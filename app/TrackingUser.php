<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackingUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tracking_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'role', 'grade'
    ];
}
