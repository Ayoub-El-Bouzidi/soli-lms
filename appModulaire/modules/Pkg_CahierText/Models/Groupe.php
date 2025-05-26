<?php

namespace Modules\Pkg_CahierText\Models;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $fillable = ['name'];

    protected $table = 'groupes';
    protected $primaryKey = 'groupe_id';



}
