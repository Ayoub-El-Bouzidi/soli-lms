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
    // Compter les modules terminés et restants
    $modulesTermines = \Modules\Pkg_CahierText\Models\Module::where('heures_restees', 0)->count();
    $modulesRestants = \Modules\Pkg_CahierText\Models\Module::where('heures_restees', '>', 0)->count();

    // Compter les séances et les groupes
    $seancesCount = $this->seanceRepository->getAllSeances()->count();
    $groupesCount = $this->groupeRepository->getAllGroupes()->count();

    // Récupérer tous les modules avec leurs séances (relation correcte requise)
    $modules = $this->moduleRepository->getAllModules();

    // Préparer les contenus pour l'affichage
    $contenus = collect($modules)->map(function ($module) {
        // S'assurer que $module est un objet
        $module = (object) $module;

        // Charger les séances liées (si relation "seances" définie dans Module.php)
        $seances = isset($module->seances) && is_iterable($module->seances)
            ? collect($module->seances)
            : collect();

        // Calcul des heures
        $heuresTerminees = $seances->sum('duree');
        $masseHoraire = $module->masse_horaire ?? 0;
        $heuresRestantes = max(0, $masseHoraire - $heuresTerminees);
        $etat = $heuresRestantes <= 0 ? 'terminé' : 'en cours';

        return [
            'nom' => $module->nom ?? '',
            'masse_horaire' => $masseHoraire,
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
