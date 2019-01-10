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
        'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class)->withTimestamps();
    }

    public function getCodeOkAttribute()
    {
        return strtoupper($this->code);
    }

    public function getTotalOkAttribute()
    {
        return number_format($this->amount_total, 2, '.', ',');
    }

    public function getStartOkAttribute()
    {
        return Carbon::parse($this->date_start)->format('d-m-Y');
    }
}
