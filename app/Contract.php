<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'short_name',
        'description',
        'amount_total',
        'amount_anticipated',
        'amount_extension',
        'amount_adjustment',
        'date_start',
        'date_finish',
        'date_signature',
        'date_signature_covenant',
        'date_finish_modified',
        'active',
        'split_catalog'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Relations
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function concepts()
    {
        return $this->hasMany(Concept::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class)->withTimestamps();
    }

    public function estimates()
    {
        return $this->hasMany(Estimate::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function getCodeOkAttribute()
    {
        return strtoupper($this->code);
    }

    public function getTotalOkAttribute()
    {
        return "$ " . number_format($this->amount_total, 2, '.', ',');
    }

    public function getStartOkAttribute()
    {
        return Carbon::parse($this->date_start)->format('d-m-Y');
    }
    public function getFinishOkAttribute()
    {
        return Carbon::parse($this->date_finish)->format('d-m-Y');
    }
    public function getSignatureOkAttribute()
    {
        return Carbon::parse($this->date_signature)->format('d-m-Y');
    }
    public function getCovenantOkAttribute()
    {
        return Carbon::parse($this->date_signature_covenant)->format('d-m-Y');
    }
    public function getDateModifiedOkAttribute()
    {
        return Carbon::parse($this->date_finish_modified)->format('d-m-Y');
    }

    public function getTotalAmountAttribute()
    {
        return $this->getOriginalAmountAttribute() + $this->getExtensionAmountAttribute();
    }
    public function getOriginalAmountAttribute()
    {
        return round($this->amount_total,2,PHP_ROUND_HALF_DOWN);
    }
    public function getExtensionAmountAttribute()
    {
        return round($this->amount_extension,2, PHP_ROUND_HALF_DOWN);
    }
    public function getNameContractFormattedAttribute()
    {
        return strtoupper(
            substr($this->code,-15,2)." ".
            substr($this->code,-13,2)." ".
            substr($this->code,-11,2)." ".
            substr($this->code,-9,2)." ".
            substr($this->code,-7,4)." ".
            substr($this->code,-3,1)." ".
            substr($this->code,-2));
    }

    //QUERY SCOPE
    public function scopeCode($query, $code)
    {
        if ($code) {
            return $query->where('code', 'LIKE', "%$code%");
        }
    }

    public function scopeSplit($query)
    {
        return $query->where('split_catalog', true);
    }


}
