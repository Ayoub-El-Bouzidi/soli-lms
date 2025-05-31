<?php

namespace Modules\Pkg_CahierText\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pkg_CahierText\Repositories\ModuleRepository;
use Modules\Pkg_CahierText\Repositories\SeanceRepository;
use Modules\Pkg_CahierText\Repositories\GroupeRepository;

class DashboardController extends Controller
{
    protected $moduleRepository;
    protected $seanceRepository;
    protected $groupeRepository;

    public function __construct(
        ModuleRepository $moduleRepository,
        SeanceRepository $seanceRepository,
        GroupeRepository $groupeRepository
    ) {
        $this->moduleRepository = $moduleRepository;
        $this->seanceRepository = $seanceRepository;
        $this->groupeRepository = $groupeRepository;
    }

   public function index()
{
    // Count modules
    $modulesTermines = \Modules\Pkg_CahierText\Models\Module::where('masse_horaire_totale', 0)->count();
    $modulesRestants = \Modules\Pkg_CahierText\Models\Module::where('masse_horaire_totale', '>', 0)->count();

    // Counts
    $seancesCount = $this->seanceRepository->getAllSeances()->count();
    $groupesCount = $this->groupeRepository->getAllGroupes()->count();

    // Contenu des modules
    $modules = $this->moduleRepository->getAllModules(); // Assumes method exists
    $contenus = collect($modules)->map(function ($module) {
        // If $module is array, cast to object
        if (is_array($module)) {
            $module = (object) $module;
        }
        // If seances is not set or not an object, set to empty collection
        $seances = isset($module->seances) && is_iterable($module->seances)
            ? collect($module->seances)
            : collect();
        $heuresTerminees = $seances->sum('duree');
        $heuresRestantes = isset($module->masse_horaire_totale)
            ? max(0, $module->masse_horaire_totale - $heuresTerminees)
            : 0;
        $etat = $heuresRestantes <= 0 ? 'terminé' : 'en cours';

        return [
            'nom' => $module->nom ?? '',
            'masse_horaire_totale' => $module->masse_horaire_totale ?? 0,
            'heures_terminees' => $heuresTerminees,
            'heures_restantes' => $heuresRestantes,
            'etat' => $etat,
        ];
    });

    return view('Pkg_CahierText::dashboard', compact(
        'modulesTermines',
        'modulesRestants',
        'seancesCount',
        'groupesCount',
        'contenus'
    ));
}

}
