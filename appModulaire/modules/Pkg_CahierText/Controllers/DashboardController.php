<?php

namespace Modules\Pkg_CahierText\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pkg_CahierText\Repositories\ModuleRepository;
use Modules\Pkg_CahierText\Repositories\SeanceRepository;
use Modules\Pkg_CahierText\Repositories\GroupeRepository;
use Modules\Pkg_CahierText\Models\Module;
use Modules\Pkg_CahierText\Models\CahierEntry;
use Illuminate\Support\Facades\Auth;
use Modules\Pkg_CahierText\Repositories\CahierEntryRepository;

class DashboardController extends Controller
{
    protected $cahierEntryRepository;
    protected $moduleRepository;
    protected $seanceRepository;
    protected $groupeRepository;

    public function __construct(
        CahierEntryRepository $cahierEntryRepository,
        ModuleRepository $moduleRepository,
        SeanceRepository $seanceRepository,
        GroupeRepository $groupeRepository
    ) {
        $this->cahierEntryRepository = $cahierEntryRepository;
        $this->moduleRepository = $moduleRepository;
        $this->seanceRepository = $seanceRepository;
        $this->groupeRepository = $groupeRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedGroupId = $request->input('groupe_id');

        $groupes = $this->groupeRepository->getAllGroupes();

        $modules = $selectedGroupId
            ? $this->moduleRepository->getModulesByGroup($selectedGroupId)
            : $this->moduleRepository->getAllModules();

        $modulesTermines = $modules->where('heures_restees', '<=', 0)->count();
        $modulesRestants = $modules->where('heures_restees', '>', 0)->count();
        $cahierEntriesCount = CahierEntry::count();
        $groupesCount = $groupes->count();

        $contenus = collect($modules)->map(function ($module) {
            return [
                'nom' => $module->nom ?? '',
                'masse_horaire' => $module->masse_horaire ?? 0,
                'heures_terminees' => $module->heures_terminees ?? 0,
                'heures_restees' => $module->heures_restees ?? 0,
                'etat' => ($module->heures_restees ?? 0) <= 0 ? 'terminé' : 'en cours',
            ];
        });

        $perPage = 5;
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
