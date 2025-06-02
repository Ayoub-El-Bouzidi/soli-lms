<?php

namespace Modules\Pkg_Emploi\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Modules\Pkg_CahierText\Models\Groupe;
use Modules\Pkg_CahierText\Models\Module;

class Emploi extends Model
{

    use HasFactory;
    protected $fillable = ["date_debut", "date_fin", "groupe_id"];

    protected $table = 'emploies';

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }
    public function seance_emplois()
    {
        return $this->hasMany(SeanceEmploi::class);
    }
    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}
