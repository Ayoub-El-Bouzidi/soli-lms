<?php

namespace Modules\Pkg_CahierText\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Pkg_Emploi\Models\Emploi;

class Groupe extends Model
{
    protected $fillable = ['name'];

    public function emploies()
    {
        return $this->hasMany(Emploi::class,'emploies','emploi_id');
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'groupe_module', 'groupe_id', 'module_id');
    }
    public function formateurs(){
        return $this->belongsToMany(Formateur::class, 'groupe_formateur', 'groupe_id', 'formateur_id');    }

}
