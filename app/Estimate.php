<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'id_contract',
        'start',
        'finish',
        'release',
        'retention',
        'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function getStartOkAttribute()
    {
        return Carbon::parse($this->start)->format('d-m-Y');
    }
    public function getFinishOkAttribute()
    {
        return Carbon::parse($this->finish)->format('d-m-Y');
    }
    public function getReleaseOkAttribute()
    {
        return Carbon::parse($this->release)->format('d-m-Y');
    }
}
