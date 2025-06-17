<?php

namespace Modules\Pkg_CahierText\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CahierEntry extends Model
{
    protected $fillable = [
        'module_id',
        'formateur_id',
        'date',
        'heures_prevues',
        'heure_debut',
        'heure_fin',
        'contenu',
        'objectifs',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'heure_debut' => 'datetime',
        'heure_fin' => 'datetime',
        'heures_prevues' => 'float'
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function formateur(): BelongsTo
    {
        return $this->belongsTo(Formateur::class, 'formateur_id');
    }
}
