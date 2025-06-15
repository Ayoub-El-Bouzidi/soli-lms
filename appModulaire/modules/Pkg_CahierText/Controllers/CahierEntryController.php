<?php

namespace Modules\Pkg_CahierText\Controllers;

use App\Http\Controllers\Controller;
use Modules\Pkg_CahierText\app\Requests\CahierEntryRequest;
use Modules\Pkg_CahierText\Models\CahierEntry;
use Modules\Pkg_CahierText\Models\Module;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CahierEntryController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('can:view,cahier_entry')->only(['index', 'show']);
    //     $this->middleware('can:create,cahier_entry')->only(['create', 'store']);
    //     $this->middleware('can:update,cahier_entry')->only(['edit', 'update']);
    //     $this->middleware('can:delete,cahier_entry')->only(['destroy']);
    // }
    public function index()
    {
        $entries = CahierEntry::with('module')
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('Pkg_CahierText::cahier.index', compact('entries'));
    }

    public function create(Request $request)
    {
        $selectedModule = null;

        if ($request->has('module_id')) {
            $selectedModule = Module::findOrFail($request->module_id);

            // Check if module has remaining hours
            if ($selectedModule->heures_restees <= 0) {
                return redirect()->route('modules.index')
                    ->with('error', 'Ce module a déjà atteint sa masse horaire maximale.');
            }
        }

        $modules = Module::where('heures_restees', '>', 0)->get();

        if ($modules->isEmpty()) {
            return redirect()->route('modules.index')
                ->with('error', 'Aucun module disponible pour créer une entrée.');
        }

        return view('Pkg_CahierText::cahier.create', compact('modules', 'selectedModule'));
    }

    public function store(CahierEntryRequest $request)
    {
        $validated = $request->validated();

        // Check if module has enough remaining hours
        $module = Module::findOrFail($validated['module_id']);
        if ($module->heures_restees <= 0) {
            return redirect()->route('modules.index')
                ->with('error', 'Ce module a déjà atteint sa masse horaire maximale.');
        }

        if ($validated['heures_prevues'] > $module->heures_restees) {
            return back()->withInput()
                ->with('error', "Les heures prévues dépassent les heures restantes du module ({$module->heures_restees}h).");
        }

        // Calculate heure_fin based on heure_debut and heures_prevues
        $heureDebut = Carbon::createFromFormat('H:i', $request->heure_debut);
        $heureFin = $heureDebut->copy()->addHours((int)$validated['heures_prevues'])
            ->addMinutes(($validated['heures_prevues'] * 60) % 60);

        $entry = new CahierEntry($validated);
        $entry->formateur_id = 1; // Set a default formateur_id
        $entry->heure_debut = $heureDebut;
        $entry->heure_fin = $heureFin;
        $entry->save();

        // Update module's remaining hours
        $module->heures_terminees += $validated['heures_prevues'];
        $module->heures_restees = max(0, $module->masse_horaire - $module->heures_terminees);
        $module->save();

        return redirect()->route('cahier.index')
            ->with('success', 'Entrée créée avec succès');
    }

    public function edit(CahierEntry $entry)
    {
        $modules = Module::all();
        return view('Pkg_CahierText::cahier.edit', compact('entry', 'modules'));
    }

    public function update(Request $request, CahierEntry $entry)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'date' => 'required|date',
            'heures_prevues' => 'required|numeric|min:0.5|max:8',
            'heure_debut' => 'required',
            'contenu' => 'nullable|string',
            'objectifs' => 'nullable|string',
            'status' => 'required|in:planifie,realise,annule'
        ]);

        // Restore previous hours to the module
        $oldModule = $entry->module;
        $oldModule->heures_terminees -= $entry->heures_prevues;
        $oldModule->heures_restees = $oldModule->masse_horaire - $oldModule->heures_terminees;
        $oldModule->save();

        // Check if new module has enough remaining hours
        $newModule = Module::findOrFail($validated['module_id']);
        if ($validated['heures_prevues'] > $newModule->heures_restees) {
            return back()->withInput()
                ->with('error', "Les heures prévues dépassent les heures restantes du module ({$newModule->heures_restees}h).");
        }

        $heureDebut = Carbon::createFromFormat('H:i', $request->heure_debut);
        $heureFin = $heureDebut->copy()->addHours((int)$validated['heures_prevues'])
            ->addMinutes(($validated['heures_prevues'] * 60) % 60);

        $entry->update(array_merge($validated, [
            'heure_debut' => $heureDebut,
            'heure_fin' => $heureFin
        ]));

        // Update new module's remaining hours
        $newModule->heures_terminees += $validated['heures_prevues'];
        $newModule->heures_restees = max(0, $newModule->masse_horaire - $newModule->heures_terminees);
        $newModule->save();

        return redirect()->route('cahier.index')
            ->with('success', 'Entrée mise à jour avec succès');
    }

    public function destroy(CahierEntry $entry)
    {
        // Restore hours to the module
        $module = $entry->module;
        $module->heures_terminees -= $entry->heures_prevues;
        $module->heures_restees = $module->masse_horaire - $module->heures_terminees;
        $module->save();

        $entry->delete();
        return redirect()->route('cahier.index')
            ->with('success', 'Entrée supprimée avec succès');
    }
}
