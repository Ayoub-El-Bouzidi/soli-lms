<?php

namespace Modules\Pkg_CahierText\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Responsable extends Authenticatable
{
     use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'email',
        'password',
    ];

    /**
     * Get the sessions validated by the responsable.
     */
    // public function validatedSeances()
    // {
    //     return $this->hasMany(Seance::class, 'responsable_id');
    // }
}
