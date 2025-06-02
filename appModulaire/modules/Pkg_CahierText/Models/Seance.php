<?php

namespace Modules\Pkg_CahierText\Models;

use Modules\Pkg_CahierText\Models\Formateur;
use Modules\Pkg_CahierText\Models\Module;
use Modules\Pkg_CahierText\Models\Responsable;
use Modules\Pkg_Emploi\Models\SeanceEmploi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seance extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'date',
        // 'heure_debut',
        // 'heure_fin',
        // 'duree',
        'etat_validation',
        'seance_emploie_id',
        'formateur_id',
        'module_id',
        'responsable_id',
    ];

    public function formateur()
    {
        return $this->belongsTo(Formateur::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function responsable()
    {
        return $this->belongsTo(Responsable::class, 'responsable_id');
    }

    public function seance_emploi()
    {
        return $this->belongsTo(SeanceEmploi::class, 'seance_emploie_id');
    }
}
