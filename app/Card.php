<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'product_id',
        'activation_number',
        'pin',
        'status'
    ];

    protected $dates = [
        'cancelled_at'
    ];

    /**
     * Get the client that owns the card.
     */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    /**
     * Get the product associated with the card.
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    /**
     * Get the transactions for the card.
     */
    public function transactions()
    {
        return $this->hasMany('App\CardTransaction');
    }

    /**
     * Scope a query to only include active cards.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include cancelled cards.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Cancel the card.
     */
    public function cancel()
    {
        $this->status = 'cancelled';
        $this->cancelled_at = now();
        $this->save();
    }
}