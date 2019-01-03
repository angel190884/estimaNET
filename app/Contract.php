<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function getCodeOkAttribute()
    {
        return strtoupper($this->code);
    }

    public function getTotalOkAttribute()
    {
        return number_format($this->total, 2, '.', ',');
    }

    public function getStartOkAttribute()
    {
        return Carbon::parse($this->start)->format('d-m-Y');
    }
}
