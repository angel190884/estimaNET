<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concept extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'contract_id',
        'code',
        'location',
        'address',
        'name',
        'measurement_unit',
        'quantity',
        'unit_price',
        'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Relations.
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function estimates()
    {
        return $this->belongsToMany(Estimate::class)->withTimestamps();
    }

    public function generators()
    {
        return $this->hasMany(Generator::class);
    }

    /**
     * Scope
     */
    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->where('name', 'LIKE', "%$name%");
        }
    }

    /**
     * Getters
     */
    public function getCodeOkAttribute()
    {
        return strtoupper($this->code);
    }

    public function getUnitPriceOkAttribute()
    {
        return '$' . number_format($this->unit_price, 2, '.', ',');
    }

    public function getQuantityOkAttribute()
    {
        return number_format($this->quantity, 2, '.', ',');
    }
}
