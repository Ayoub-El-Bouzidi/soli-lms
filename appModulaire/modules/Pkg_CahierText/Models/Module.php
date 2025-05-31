<?php

namespace Modules\Pkg_CahierText\Models;
use Illuminate\Database\Eloquent\Model;
use Modules\Pkg_Emploi\Models\SeanceEmploi;

class Module extends Model
{
    protected $fillable = [
        'nom',
        'masse_horaire_totale',
    ];

    /**
     * Get the sessions for this module.
     */
    public function seance_emploies()
    {
        return $this->hasMany(SeanceEmploi::class);
    }
    public function groupes(){
        return $this->belongsToMany(Groupe::class, 'groupe_module', 'groupe_id', 'module_id');
    }
}
