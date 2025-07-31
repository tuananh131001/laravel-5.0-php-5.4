<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'brand_id',
        'name',
        'price',
        'currency',
        'status',
        'custom_fields'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'custom_fields' => 'array'
    ];

    /**
     * Get the brand that owns the product.
     */
    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

    /**
     * Get the clients that have access to this product.
     */
    public function clients()
    {
        return $this->belongsToMany('App\Client');
    }

    /**
     * Get the cards issued for this product.
     */
    public function cards()
    {
        return $this->hasMany('App\Card');
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive products.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}