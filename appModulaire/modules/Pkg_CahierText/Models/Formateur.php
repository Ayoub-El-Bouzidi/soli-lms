<?php

namespace Modules\Pkg_CahierText\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Pkg_CahierText\Models\Seance;
use Spatie\Permission\Traits\HasRoles;

class Formateur extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

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
