<?php

namespace Modules\Pkg_Emploi\Models;

use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    protected $fillable = [
        'nom',
    ];

    /**
     * Get the sessions associated with the salle.
     */
    public function seanceemploies()
    {
        return $this->hasMany(SeanceEmploi::class);
    }


}
