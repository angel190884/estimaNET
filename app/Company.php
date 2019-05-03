<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rfc', 'reason_social', 'admin_unique', 'telephone', 'address', 'logo', 'background', 'interbank_key', 'bank_account',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function contracts()
    {
        return $this->belongsToMany(Contract::class)->withTimestamps();
    }

    /**
     * Retorna el nombre con mayusculas.
     *
     * @return String
     */
    public function getReasonSocialOkAttribute()
    {
        return strtoupper($this->reason_social);
    }
}
