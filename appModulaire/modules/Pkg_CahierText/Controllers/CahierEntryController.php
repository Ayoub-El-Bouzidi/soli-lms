<?php

namespace Modules\Pkg_CahierText\Controllers;

use App\Http\Controllers\Controller;
use Modules\Pkg_CahierText\app\Requests\CahierEntryRequest;
use Modules\Pkg_CahierText\Models\CahierEntry;
use Modules\Pkg_CahierText\Repositories\CahierEntryRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CahierEntryController extends Controller
{
    protected $repository;

    public function __construct(CahierEntryRepository $repository)
    {
        $this->middleware(['auth:formateurs,responsables']);
        $this->repository = $repository;
    }

    public function index()
    {
        if (auth('responsables')->check()) {
            // Responsable: see all entries
            $entries = $this->repository->getAllEntries();
            $groupes = collect(); // Or fetch all groups if needed
        } else {
            // Formateur: see only their entries
            $formateurId = auth('formateurs')->id();
            $entries = $this->repository->getEntriesByFormateur($formateurId);
            $groupes = $this->repository->getFormateurGroups($formateurId);
        }
        return view('Pkg_CahierText::cahier.index', compact('entries', 'groupes'));
    }

    public function create(Request $request)
    {
        $formateurId = auth('formateurs')->id();
        $selectedModule = null;

        if ($request->has('module_id')) {
            $selectedModule = $this->repository->getModuleById($request->module_id);
        }

        $modules = $this->repository->getAvailableModules($formateurId);

        return view('Pkg_CahierText::cahier.create', compact('modules', 'selectedModule'));
    }

    public function store(CahierEntryRequest $request)
    {
        try {
            $this->repository->createEntry(
                $request->validated(),
                auth('formateurs')->id()
            );

            return redirect()->route('cahier-de-texte.index')
                ->with('success', 'Entrée créée avec succès');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function edit(CahierEntry $entry)
    {
        $formateurId = auth('formateurs')->id();
        $modules = $this->repository->getAvailableModules($formateurId);
        return view('Pkg_CahierText::cahier.edit', compact('entry', 'modules'));
    }

    public function update(Request $request, CahierEntry $entry)
    {
        try {
            $validated = $request->validate([
                'module_id' => 'required|exists:modules,id',
                'date' => 'required|date',
                'heures_prevues' => 'required|numeric|min:0.5|max:8',
                'heure_debut' => 'required',
                'contenu' => 'nullable|string',
                'objectifs' => 'nullable|string',
                'status' => 'required|in:planifie,realise,annule'
            ]);

            $this->repository->updateEntry($entry, $validated);

            return redirect()->route('cahier-de-texte.index')
                ->with('success', 'Entrée mise à jour avec succès');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy(CahierEntry $entry)
    {
        try {
            $this->repository->deleteEntry($entry);

            return redirect()->route('cahier-de-texte.index')
                ->with('success', 'Entrée supprimée avec succès');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Export the cahier entries to an Excel file
     */
    public function export()
    {
        return Excel::download(new CahierEntry(), 'cahier_entries.xlsx');
    }
}
