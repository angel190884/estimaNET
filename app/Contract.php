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
        'type',
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
     * Relation users.
     *
     * @return belongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * Relation concepts.
     *
     * @return hasMany
     */
    public function concepts()
    {
        return $this->hasMany(Concept::class);
    }

    /**
     * Relation companies.
     *
     * @return belongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class)->withTimestamps();
    }

    /**
     * Relation estimates.
     *
     * @return hasMany
     */
    public function estimates()
    {
        return $this->hasMany(Estimate::class);
    }

    /**
     * Relation locations.
     *
     * @return hasMany
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    /**
     * Relation deductions.
     *
     * @return belongsToMany
     */
    public function deductions()
    {
        return $this->belongsToMany(Deduction::class)->withTimestamps()->withPivot('factor');
    }

    /**
     * Return Code contract upper.
     *
     * @return String
     */
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
    public function getSignatureWithLettersAttribute()
    {
        return $this->changeDateLetter($this->date_signature);
    }
    public function getCovenantOkAttribute()
    {
        return Carbon::parse($this->date_signature_covenant)->format('d-m-Y');
    }
    public function getDateModifiedOkAttribute()
    {
        if ($this->date_finish_modified) {
            return Carbon::parse($this->date_finish_modified)->format('d-m-Y');
        }
        return "---";
    }

    public function getTotalAmountAttribute()
    {
        return $this->getOriginalAmountAttribute() + $this->getExtensionAmountAttribute();
    }
    public function getTotalAmountOkAttribute()
    {
        return $this->format($this->getOriginalAmountAttribute() + $this->getExtensionAmountAttribute());
    }
    public function getOriginalAmountAttribute()
    {
        return round($this->amount_total, 2, PHP_ROUND_HALF_DOWN);
    }
    public function getExtensionAmountAttribute()
    {
        return round($this->amount_extension, 2, PHP_ROUND_HALF_DOWN);
    }
    public function getNameContractFormattedAttribute()
    {
        return strtoupper(
            substr($this->code, -15, 2)." ".
            substr($this->code, -13, 2)." ".
            substr($this->code, -11, 2)." ".
            substr($this->code, -9, 2)." ".
            substr($this->code, -7, 4)." ".
            substr($this->code, -3, 1)." ".
            substr($this->code, -2)
        );
    }
    public function getTypeOkAttribute()
    {
        switch ($this->type) {
            case 1:
                return 'builder';
                break;
            case 2:
                return 'supervision';
                break;
            default:
                return 'builder';
        }
    }


    //QUERY SCOPE
    public function scopeCode($query, $code)
    {
        if ($code) {
            return $query->where('code', 'LIKE', "%$code%");
        }
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeSplit($query)
    {
        return $query->where('split_catalog', true);
    }

    private function format($number)
    {
        $numbers= explode(".", $number);
        if (! isset($numbers[1])) {
            $numbers[1] = null;
        }
        if (strlen($numbers[1]) < 2) {
            return number_format($number, 2, '.', ',');
        } else {
            return number_format($numbers[0], 0, '.', ',').'.'.$numbers[1];
        }
    }

    
    private function changeDateLetter($date)
    {
        if ($date=='0000-00-00') {
            return '------';
        }
        $mes='';
        $arraydate = explode("-", $date);
            
        if ($arraydate[1]=='01') {
            $mes='ENERO';
        }
        if ($arraydate[1]=='02') {
            $mes='FEBRERO';
        }
        if ($arraydate[1]=='03') {
            $mes='MARZO';
        }
        if ($arraydate[1]=='04') {
            $mes='ABRIL';
        }
        if ($arraydate[1]=='05') {
            $mes='MAYO';
        }
        if ($arraydate[1]=='06') {
            $mes='JUNIO';
        }
        if ($arraydate[1]=='07') {
            $mes='JULIO';
        }
        if ($arraydate[1]=='08') {
            $mes='AGOSTO';
        }
        if ($arraydate[1]=='09') {
            $mes='SEPTIEMBRE';
        }
        if ($arraydate[1]=='10') {
            $mes='OCTUBRE';
        }
        if ($arraydate[1]=='11') {
            $mes='NOVIEMBRE';
        }
        if ($arraydate[1]=='12') {
            $mes='DICIEMBRE';
        }
            
        
        return strtoupper($arraydate[2].' de '.$mes.' del '.$arraydate[0]);
    }
}
