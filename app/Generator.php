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

    public function validate()
    {
        if ($this->quantity == 0) {
            return false;
        }
        if ($this->estimate->contract->split_catalog) {
            if (round($this->quantity, 6, PHP_ROUND_HALF_DOWN) != round($this->subGenerators()->sum('quantity'), 6, PHP_ROUND_HALF_DOWN)) {
                return false;
            }
        }

        if (round($this->quantity, 6, PHP_ROUND_HALF_DOWN) + round($this->getLastQuantityAttribute(), 6, PHP_ROUND_HALF_DOWN) > round($this->concept->quantityMax, 6, PHP_ROUND_HALF_DOWN)) {
            return false;
        }

        return true;
    }

    public function getQuantityOkAttribute()
    {
        return format($this->quantity);
    }

    public function getLastQuantityOkAttribute()
    {
        return format($this->getLastQuantityAttribute());
    }

    public function getLastQuantityAttribute()
    {
        $estimate=$this->estimate;
        $previousEstimates = $estimate->contract->estimates()->previousEstimates($estimate)->get();
        //dump($previousEstimates);
        $total = 0;
        foreach ($previousEstimates as $previousEstimate) {
            $total+= $previousEstimate
                ->generators
                //->select('quantity')
                ->where('concept_id', $this->concept_id)
                ->sum->quantity;
        }
        return $total;
    }

    public function getAccumulatedQuantityOkAttribute()
    {
        return format($this->getLastQuantityAttribute() + $this->quantity);
    }

    public function getAmountAttribute()
    {
        return round($this->quantity * $this->concept->unit_price, 2, PHP_ROUND_HALF_DOWN);
    }

    public function getAmountOkAttribute()
    {
        return '$' . format(round($this->quantity * $this->concept->unit_price, 2, PHP_ROUND_HALF_DOWN));
    }

    public function getLastAmountAttribute()
    {
        $estimate=$this->estimate;
        $previousEstimates = $estimate->contract->estimates()->previousEstimates($estimate)->get();
        $total = 0;

        foreach ($previousEstimates as $previousEstimate) {
            $generatorsPrevious = $previousEstimate
                ->generators()
                ->where('concept_id', '=', $this->concept_id)
                ->get();

            foreach ($generatorsPrevious as $generatorPrevious) {
                $total+= round($generatorPrevious->quantity * $generatorPrevious->concept->unit_price, 2, PHP_ROUND_HALF_DOWN);
            }
        }
        return $total;
    }

    public function getLastAmountOkAttribute()
    {
        return '$' . format($this->getLastAmountAttribute());
    }


    public function getAccumulatedAmountAttribute()
    {
        return '$' . format($this->getLastAmountAttribute() + $this->getAmountAttribute());
    }

    public function getMaximumQuantityPossibleOkAttribute()
    {
        return round(
            round($this->concept->quantityMax, 6, PHP_ROUND_HALF_DOWN) -
            round($this->getLastQuantityAttribute(), 6, PHP_ROUND_HALF_DOWN),
            6,
            PHP_ROUND_HALF_DOWN
        );
    }
}
