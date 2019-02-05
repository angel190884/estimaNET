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
        return $this->format($this->quantity);
    }

    public function getLastTotalOkAttribute()
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
        return $this->format($total);
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
        return $total;
    }

    private function format($number)
    {
        $numbers= explode(".", $number);
        if ( ! isset($numbers[1])) {
            $numbers[1] = null;
        }
        if (strlen($numbers[1]) < 2 ) {
            return number_format($number,2,'.',',');
        }else {
            return number_format($numbers[0],0,'.',',').'.'.$numbers[1];
        }
    }
}
