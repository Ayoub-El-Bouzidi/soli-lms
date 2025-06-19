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

    public function index(Request $request)
    {
        // Get the selected group ID from the request
        $selectedGroupId = $request->query('groupe_id');

        // Get all groups for the filter dropdown
        $groupes = $this->groupeRepository->getAllGroupes();

        // Filter modules by group if selected
        $modules = $selectedGroupId
            ? $this->moduleRepository->getModulesByGroup($selectedGroupId)
            : $this->moduleRepository->getAllModules();

        // Compter les modules terminés et restants (filtered by group if selected)
        $query = \Modules\Pkg_CahierText\Models\Module::query();
        if ($selectedGroupId) {
            $query->whereHas('groupes', function ($q) use ($selectedGroupId) {
                $q->where('groupes.id', $selectedGroupId);
            });
        }
        $modulesTermines = (clone $query)->where('heures_restees', 0)->count();
        $modulesRestants = (clone $query)->where('heures_restees', '>', 0)->count();

        // Count CahierEntries for the selected group or all groups
        $cahierEntriesQuery = \Modules\Pkg_CahierText\Models\CahierEntry::query();
        if ($selectedGroupId) {
            $cahierEntriesQuery->whereHas('module.groupes', function ($q) use ($selectedGroupId) {
                $q->where('groupes.id', $selectedGroupId);
            });
        }
        $cahierEntriesCount = $cahierEntriesQuery->count();

        // Get group count (this doesn't change with filtering)
        $groupesCount = $groupes->count();

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

        // Paginate the contents
        $perPage = 5; // Number of items per page
        $page = $request->get('page', 1);
        $contenus = new \Illuminate\Pagination\LengthAwarePaginator(
            $contenus->forPage($page, $perPage),
            $contenus->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('Pkg_CahierText::dashboard', compact(
            'modulesTermines',
            'modulesRestants',
            'cahierEntriesCount',
            'groupesCount',
            'contenus',
            'groupes',
            'selectedGroupId'
        ));
    }
    public function responsableDashboard(Request $request)
    {
        // For now, reuse the index logic for responsables
        return $this->index($request);
    }
    public function formateurDashboard(Request $request)
    {
        // For now, reuse the index logic for formateurs
        return $this->index($request);
    }
}
