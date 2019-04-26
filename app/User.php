<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRolesAndAbilities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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
     * Relation deductions.
     *
     * @return hasMany
     */
    public function deductions()
    {
        return $this->hasMany(Deduction::class);
    }

    /**
     * Return FullName user upper.
     *
     * @return String
     */
    public function getFullNameAttribute()
    {
        return strtoupper($this->name);
    }
}
