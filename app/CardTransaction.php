<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardTransaction extends Model
{
    protected $fillable = [
        'card_id',
        'amount',
        'currency',
        'description'
    ];

    protected $casts = [
        'amount' => 'decimal:2'
    ];

    /**
     * Get the card that owns the transaction.
     */
    public function card()
    {
        return $this->belongsTo('App\Card');
    }

    /**
     * Get the client that owns the card.
     */
    public function client()
    {
        return $this->hasOneThrough('App\Client', 'App\Card');
    }
}