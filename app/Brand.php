<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'status',
        'custom_fields'
    ];

    protected $casts = [
        'custom_fields' => 'array'
    ];

    /**
     * Get the products for the brand.
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    /**
     * Scope a query to only include active brands.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive brands.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}