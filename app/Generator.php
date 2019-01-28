<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Generator extends Model
{
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
    public function estimates()
    {
        return $this->belongsToMany(Concept::class);
    }
}
