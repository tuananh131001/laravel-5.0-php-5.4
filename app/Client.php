<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'payout_rate'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'payout_rate' => 'decimal:2'
    ];

    /**
     * Get the products accessible to the client.
     */
    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

    /**
     * Get the cards issued to the client.
     */
    public function cards()
    {
        return $this->hasMany('App\Card');
    }

    /**
     * Get all transactions for the client's cards.
     */
    public function transactions()
    {
        return $this->hasManyThrough('App\CardTransaction', 'App\Card');
    }
}