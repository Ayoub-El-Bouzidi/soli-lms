<?php

namespace Modules\Pkg_CahierText\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Pkg_Emploi\Models\SeanceEmploi;

class Module extends Model
{
    protected $fillable = [
        'nom',
        'masse_horaire',
        'heures_terminees',
        'heures_restees',
        'etat_validation', // 'en cours', 'terminé', 'annulé'
    ];

    /**
     * Get the sessions for this module.
     */
    public function seance_emploies()
    {
        return $this->hasMany(SeanceEmploi::class);
    }
    public function seances()
    {
        return $this->hasManyThrough(
            Seance::class,         // Le modèle final
            SeanceEmploi::class,  // Le modèle intermédiaire
            'module_id',                       // Foreign key dans seance_emploies
            'seance_emploie_id',               // Foreign key dans seances
            'id',                              // Clé locale dans modules
            'id'                               // Clé locale dans seance_emploies
        );
    }
    public function groupes()
    {
        return $this->belongsToMany(Groupe::class, 'groupe_module', 'module_id', 'groupe_id');
    }
}
