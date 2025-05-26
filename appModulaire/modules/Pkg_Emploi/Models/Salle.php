<?php

namespace Modules\Pkg_Emploi\Database\Seeders;

use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    protected $fillable = [
        'nom',
        'capacite',
        'equipements',
        'disponibilite',
    ];

    /**
     * Get the sessions associated with the salle.
     */
    public function seances()
    {
        return $this->hasMany('Modules\Pkg_CahierText\Models\Seance', 'salle_id');
    }
}
