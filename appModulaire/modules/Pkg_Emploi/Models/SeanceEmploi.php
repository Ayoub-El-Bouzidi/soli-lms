<?php

namespace Modules\Pkg_Emploi\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Pkg_CahierText\Models\Formateur;
use Modules\Pkg_CahierText\Models\Module;
use Modules\Pkg_CahierText\Models\Seance;
use Modules\Pkg_Emploi\Models\Salle;
use Modules\Pkg_Emploi\Models\Emploi;

class SeanceEmploi extends Model
{

    protected $fillable = ['heur_debut', 'heur_fin', 'module_id', 'formateur_id', 'salle_id', 'emploie_id'];

    protected $table = "seance_emploies";

    public function formateur()
    {
        return $this->belongsTo(Formateur::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function emploi()
    {
        return $this->belongsTo(Emploi::class, 'emploie_id');
    }
    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
}
