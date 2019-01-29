<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Generator extends Model
{
    /**
     * change the name of the table by convention.
     */
    protected $table= 'concept_estimate';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity'
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
    public function estimate()
    {
        return $this->belongsTo(Estimate::class);
    }

    public function concept()
    {
        return $this->belongsTo(Concept::class);
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class);
    }

    public function subGenerators()
    {
        return $this->hasMany(SubGenerator::class);
    }
}