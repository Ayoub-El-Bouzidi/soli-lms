<?php

namespace Modules\Pkg_CahierText\Models;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'nom',
        'masse_horaire_totale',
    ];

    /**
     * Get the sessions for this module.
     */
    public function seance()
    {
        return $this->hasMany(Seance::class);
    }
}
