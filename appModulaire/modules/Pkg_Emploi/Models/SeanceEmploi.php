<?php

namespace Modules\Pkg_Emploi\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Pkg_CahierText\Models\Formateur;
use Modules\Pkg_CahierText\Models\Module;
use Modules\Pkg_CahierText\Models\Seance;
use Modules\Pkg_Emploi\Models\Salle;

class SeanceEmploi extends Model
{

    protected $fillable = ['heur_debut','heur_fin','module_id','formateur_id','salle_id','emploie_id'];

    protected $table = "seance_emploies";

    public function formateur(){
        return $this->hasOne(Formateur::class);
    }

    public function module(){
        return $this->hasOne(Module::class);
    }

    public function emploie(){
        return $this->belongsTo(Emploi::class);
    }
    public function salle(){
        return $this->hasOne(Salle::class,'article_tag');
    }

    public function seances(){
        return $this->hasMany(Seance::class);
    }



}
