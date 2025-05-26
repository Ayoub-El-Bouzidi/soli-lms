<?php

namespace Modules\Pkg_CahierText\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Responsable extends Model
{
     use HasFactory;

    protected $fillable = [
        'nom',
        'email',
        'password',
    ];

    /**
     * Get the sessions validated by the responsable.
     */
    public function validatedSeances()
    {
        return $this->hasMany(Seance::class, 'responsable_id');
    }
}
