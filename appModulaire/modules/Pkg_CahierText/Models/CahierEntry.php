<?php

namespace Modules\Pkg_CahierText\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

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
        return $this->belongsTo(User::class, 'formateur_id');
    }

    /**
     * Get the formateur's full name
     */
    public function getFormateurNameAttribute()
    {
        $user = $this->formateur;
        if (!$user) {
            return 'N/A';
        }

        // Try to get the formateur details from the formateurs table
        $formateur = \Modules\Pkg_CahierText\Models\Formateur::where('user_id', $user->id)->first();
        if ($formateur) {
            return $formateur->nom . ' ' . $formateur->prenom;
        }

        // Fallback to user name
        return $user->name;
    }
}
