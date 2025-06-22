<?php

namespace Modules\Pkg_Emploi\Controllers;


// use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Core\Controllers\Controller;
use Modules\Pkg_CahierText\Models\Groupe;
use Modules\Pkg_Emploi\Models\Emploi;
use Modules\Pkg_Emploi\Models\SeanceEmploi;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        // 1. Récupérer tous les groupes
        $groupes = Groupe::all();
        $selectedGroupeId = $request->query('groupe_id', $groupes->first()?->id ?? null);

        // 2. Total des séancesEmploi dans l'emploi actuel
        $today = Carbon::today();
        $emploiActuel = Emploi::where('groupe_id', $selectedGroupeId)
            ->whereDate('date_debut', '<=', $today)
            ->whereDate('date_fin', '>=', $today)
            ->first();

        $totalSeanceEmploies = 0;
        if ($emploiActuel) {
            $totalSeanceEmploies = SeanceEmploi::where('emploie_id', $emploiActuel->id)->count();
        }

        // 3. Total des modules associés au groupe (via table pivot 'groupe_module')
        $totalModulesGroupe = DB::table('groupe_module')
            ->where('groupe_id', $selectedGroupeId)
            ->count();

        // 4. Jours restants jusqu'à la fin de l'emploi
        $joursRestants = 0;
        if ($emploiActuel) {
            $fin = Carbon::parse($emploiActuel->date_fin);
            $aujourdHui = Carbon::today();
            $joursRestants = max(0, $aujourdHui->diffInDays($fin));
        }

        // 5. Date de la dernière modification de l'emploi actuel
        $derniersModification = $emploiActuel?->updated_at; // null si pas d'emploi

        // 6. Calcul des modules 'terminés' et 'non terminés'
        //    on crée un tableau de comptages : ['Terminés' => x, 'Non terminés' => y]
        $statusCounts = ['Terminés' => 0, 'Non terminés' => 0];

        // 6.a. Récupérer le groupe avec ses modules (many-to-many pivot)
        $groupe = Groupe::with('modules')->findOrFail($selectedGroupeId);

        foreach ($groupe->modules as $module) {
            // 6.b. Récupérer toutes les séancesEmploi pour ce module et ce groupe
            $seanceEmplois = DB::table('seance_emploies')
                ->join('emploies', 'seance_emploies.emploie_id', '=', 'emploies.id')
                ->where('emploies.groupe_id', $selectedGroupeId)
                ->where('seance_emploies.module_id', $module->id)
                ->get(['seance_emploies.heur_debut', 'seance_emploies.heur_fin']);

            $totalMinutes = 0;
            foreach ($seanceEmplois as $se) {
                $start = Carbon::parse($se->heur_debut);
                $end = Carbon::parse($se->heur_fin);
                $totalMinutes += $start->diffInMinutes($end);
            }

            $totalHours = round($totalMinutes / 60, 2);
            if ($totalHours >= $module->masse_horaire) {
                $statusCounts['Terminés']++;
            } else {
                $statusCounts['Non terminés']++;
            }
        }

        // 7. Progression des modules
        $modulesProgression = DB::table('modules')
        ->join('groupe_module', 'groupe_module.module_id', '=', 'modules.id')
        ->where('groupe_module.groupe_id', $selectedGroupeId)
        ->select('modules.id', 'modules.nom', 'modules.masse_horaire')
        ->orderBy('modules.nom')
        ->get();

        foreach ($modulesProgression as $module) {
            $totalMinutes = DB::table('seance_emploies')
                ->join('emploies', 'emploies.id', '=', 'seance_emploies.emploie_id')
                ->where('seance_emploies.module_id', $module->id)
                ->where('emploies.groupe_id', $selectedGroupeId)
                ->sum(DB::raw('TIMESTAMPDIFF(MINUTE, seance_emploies.heur_debut, seance_emploies.heur_fin)'));

            $module->heures_passees = round($totalMinutes / 60, 2);
            $module->progression = $module->masse_horaire
                ? round($module->heures_passees / $module->masse_horaire * 100, 0)
                : 0;
        }


        // 8. Passer tout à la vue
        return view('Emploi::admin.dashboard', [
            'groupes'               => $groupes,
            'selectedGroupeId'      => $selectedGroupeId,
            'totalSeanceEmploies'   => $totalSeanceEmploies,
            'totalModulesGroupe'    => $totalModulesGroupe,
            'joursRestants'         => $joursRestants,
            'derniersModification'  => $derniersModification,
            'modulesPieData'        => $statusCounts,
            'modulesProgression'    => $modulesProgression,
        ]);
    }

    public function groups(){
        $groupes = Groupe::all();
        
    }
}
