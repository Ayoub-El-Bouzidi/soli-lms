<?php

namespace Modules\Pkg_Emploi\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Pkg_CahierText\Models\Formateur;
use Modules\Pkg_CahierText\Models\Module;
use Modules\Pkg_CahierText\Models\Seance;
use Modules\Pkg_Emploi\Models\Salle;

class SeanceEmploi extends Model
{

    protected $fillable = [
        'heur_debut',
        'heur_fin', 
        'jours',
        'module_id',
        'formateur_id',
        'salle_id',
        'color', 
        'emploie_id'
    ];  

    protected $table = 'seance_emploies';

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function formateur()
    {
        return $this->belongsTo(Formateur::class, 'formateur_id');
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class, 'salle_id');
    }

    public function emploi()
    {
        return $this->belongsTo(Emploi::class, 'emploie_id');
    }
    
    public function seances(){
        return $this->hasMany(Seance::class);
    }



}
