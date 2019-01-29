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
        'contract_id',
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

    /**
     * Relations.
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function concepts()
    {
        return $this->belongsToMany(Concept::class)->withTimestamps();
    }

    public function generators()
    {
        return $this->hasMany(Generator::class);
    }

    /**
     * Getters.
     */
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

    /**
     * Query Scope.
     */

}
