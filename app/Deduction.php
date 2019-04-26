<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nexmo\Message\Query;

class Deduction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'code',
        'name',
        'percentage',
        'description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Relation user.
     *
     * @return belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withTimestamps();
    }

    /**
     * Relation contracts.
     *
     * @return belongsToMany
     */
    public function contracts()
    {
        return $this->belongsToMany(Contract::class)->withTimestamps();
    }

    /**
     * Relation estimates.
     *
     * @return belongsToMany
     */
    public function estimates()
    {
        return $this->belongsToMany(Estimate::class)->withTimestamps();
    }

    /**
     * Return attribute type formatted.
     *
     * @return String
     */
    public function getTypeOkAttribute()
    {
        switch ($this->type) {
            case 1:
                $type = 'Contrato';
                break;
            case 2:
                $type = 'Estimación';
                break;
            
            default:
                $type = 'Estimacion';
                break;
        }
        return $type;
    }

    /**
     * Return scope type contract.
     *
     * @return hasMany
     */
    public function scopeTypeContract($query)
    {
        return $query->where('type', 1);
    }

    /**
     * Return scope type contract.
     *
     * @return hasMany
     */
    public function scopeTypeEstimate($query)
    {
        return $query->where('type', 2);
    }
}
