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
    public function getNameOkAttribute()
    {
        return strtoupper($this->name);
    }
    public function getLocationOkAttribute()
    {
        return strtoupper($this->location);
    }

    public function getCodeOkAttribute()
    {
        return strtoupper($this->code);
    }

    public function getUnitPriceOkAttribute()
    {
        if ($this->contract->type == 2){
            $amount = $this->contract->amount_total+
                $this->contract->amount_extension +
                $this->contract->amount_adjustment;
            return '$' . number_format(round($amount/100, 2, PHP_ROUND_HALF_DOWN), 2,'.',',');
        }

        return '$' . number_format($this->unit_price, 2, '.', ',');
    }

    public function getQuantityOkAttribute()
    {
        if ($this->type != 'N'){
            return '---';
        }
        return number_format($this->quantity, 2, '.', ',');
    }

    public function getQuantityMaxAttribute()
    {
        $percentage = 25;
        $realPercentage= ($percentage / 100) + 1;
        return round ( $this->quantity * $realPercentage, 2, PHP_ROUND_HALF_DOWN);
    }
    public function getQuantityMaxOkAttribute()
    {
        return number_format(round ( $this->getQuantityMaxAttribute(), 2, PHP_ROUND_HALF_DOWN),2, '.',',');
    }

    public function getMeasurementUnitOkAttribute()
    {
        return strtoupper($this->measurement_unit);
    }
}
