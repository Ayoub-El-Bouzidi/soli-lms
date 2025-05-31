<?php

namespace Modules\Pkg_CahierText\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Pkg_CahierText\Models\Seance;


class Formateur extends Model
{
    use HasFactory;
     protected $fillable = ['user_id', 'nom', 'prenom', 'email', 'password'];

    /**
     * Get the sessions planned by the formateur.
     */
    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
    public function groupes()
    {
        return $this->belongsToMany(Groupe::class, 'groupe_formateur', 'formateur_id', 'groupe_id');
    }
}
