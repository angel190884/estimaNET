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
        'code_concept',
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

    /**
     * Scope
     */
    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->where('name', 'LIKE', "%$name%");
        }
    }
}
