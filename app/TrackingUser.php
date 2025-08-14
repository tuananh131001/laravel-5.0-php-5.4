<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackingUser extends Model
{
    protected $fillable = ['name', 'role', 'grade'];
}
