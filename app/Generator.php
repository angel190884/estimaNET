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

    /**
     * Getters
     */

    public function getQuantityOkAttribute()
    {
        return number_format($this->quantity, 6, '.', ',');
    }

    public function getLastTotalAttribute()
    {
        $estimate=$this->estimate;
        $previousEstimates = $estimate->contract->estimates()->previousEstimates($estimate)->get();
        $total = 0;
        foreach ($previousEstimates as $previousEstimate){
                $total+= $previousEstimate
                    ->generators()
                    ->select('quantity')
                    ->where('concept_id','=',$this->concept_id)
                    ->sum('quantity');
        }
        return number_format($total, 6, '.', ',');
    }
}
