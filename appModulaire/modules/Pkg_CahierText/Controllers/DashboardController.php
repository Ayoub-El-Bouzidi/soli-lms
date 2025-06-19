<?php

namespace Modules\Pkg_CahierText\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pkg_CahierText\Repositories\ModuleRepository;
use Modules\Pkg_CahierText\Repositories\SeanceRepository;
use Modules\Pkg_CahierText\Repositories\GroupeRepository;
use Modules\Pkg_CahierText\Models\Module;
use Modules\Pkg_CahierText\Models\CahierEntry;

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
        $query = Module::query();
        if ($selectedGroupId) {
            $query->whereHas('groupes', function ($q) use ($selectedGroupId) {
                $q->where('groupes.id', $selectedGroupId);
            });
        }
        $modulesTermines = (clone $query)->where('heures_restees', 0)->count();
        $modulesRestants = (clone $query)->where('heures_restees', '>', 0)->count();

        // Count CahierEntries for the selected group or all groups
        $cahierEntriesQuery = CahierEntry::query();
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
            $module = (object) $module;
            return [
                'nom' => $module->nom ?? '',
                'masse_horaire' => $module->masse_horaire ?? 0,
                'heures_terminees' => $module->heures_terminees ?? 0,
                'heures_restees' => $module->heures_restees ?? 0,
                'etat' => ($module->heures_restees ?? 0) <= 0 ? 'terminé' : 'en cours',
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
