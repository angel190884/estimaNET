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
}
