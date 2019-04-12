<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubGenerator extends Model
{
    /**
     * change the name of the table by convention.
     */
    protected $table= 'generator_location';

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
    public function generator()
    {
        return $this->belongsTo(Generator::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function getAmountAttribute()
    {
        return round ( $this->quantity * $this->generator->concept->unit_price, 2, PHP_ROUND_HALF_DOWN);
    }

    public function getLastQuantityOkAttribute()
    {
        return $this->format($this->getLastQuantityAttribute());
    }

    public function getQuantityOkAttribute()
    {
        return $this->format($this->quantity);
    }

    public function getLastQuantityAttribute()
    {
        $generator=$this->generator;
        $estimate=$generator->estimate;
        $previousEstimates = $estimate->contract->estimates()->previousEstimates($estimate)->get();
        //dump($previousEstimates);
        $total = 0;
        foreach ($previousEstimates as $previousEstimate){
            $total+= $previousEstimate
                ->generators
                //->select('quantity')
                ->where('concept_id',$this->concept_id)
                ->sum->quantity;
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
