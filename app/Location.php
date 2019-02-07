<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'observations',
        'contract_id'
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

    public function generators()
    {
        return $this->belongsToMany(Generator::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function subGenerators()
    {
        return $this->hasMany(SubGenerator::class);
    }

    /**
     * Query scopes.
     */
    public function scopeSearchContract($query, $contract_id)
    {
        if ($contract_id) {
            return $query->where('contract_id', '=', $contract_id);
        }
    }
}
