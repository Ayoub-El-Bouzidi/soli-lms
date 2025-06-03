<?php

namespace Modules\Pkg_Emploi\Controllers;

use Illuminate\Http\Request;
use Modules\Core\Controllers\Controller;

class EmploiController extends Controller
{
    public function index(){
        return view('Emploi::admin.emploies.index');
    }
}
