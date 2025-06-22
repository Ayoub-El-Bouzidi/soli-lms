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
            $formateur = auth('formateurs')->user();
            $formateurId = auth('formateurs')->id(); // For getFormateurGroups
            $userId = $formateur->user_id; // For getEntriesByFormateur

            $entries = $this->repository->getEntriesByFormateur($userId);
            $groupes = $this->repository->getFormateurGroups($formateurId);
        }
        return view('Pkg_CahierText::cahier.index', compact('entries', 'groupes'));
    }

    public function create(Request $request)
    {
        $selectedModule = null;

        if ($request->has('module_id')) {
            $selectedModule = $this->repository->getModuleById($request->module_id);
        }

        // Check which guard is active and get the appropriate user ID
        if (auth('responsables')->check()) {
            // Responsable: can see all modules
            $modules = $this->repository->getAllModules();
        } else {
            // Formateur: can only see their assigned modules
            $formateur = auth('formateurs')->user();
            if ($formateur) {
                $formateurId = auth('formateurs')->id(); // For getAvailableModules
                $modules = $this->repository->getAvailableModules($formateurId);
            } else {
                // Fallback: if no formateur found, show empty modules
                $modules = collect();
            }
        }

        return view('Pkg_CahierText::cahier.create', compact('modules', 'selectedModule'));
    }

    public function store(CahierEntryRequest $request)
    {
        try {
            // Get the correct user ID based on the active guard
            if (auth('responsables')->check()) {
                $responsable = auth('responsables')->user();
                $userId = $responsable->user_id; // Get the user_id from the responsable model
            } else {
                $formateur = auth('formateurs')->user();
                $userId = $formateur->user_id; // Get the user_id from the formateur model
            }

            if (!$userId) {
                throw new \Exception('Utilisateur non authentifié.');
            }

            $this->repository->createEntry(
                $request->validated(),
                $userId
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
        // Check which guard is active and get the appropriate modules
        if (auth('responsables')->check()) {
            // Responsable: can see all modules
            $modules = $this->repository->getAllModules();
        } else {
            // Formateur: can only see their assigned modules
            $formateurId = auth('formateurs')->id();
            if ($formateurId) {
                $modules = $this->repository->getAvailableModules($formateurId);
            } else {
                // Fallback: if no formateur ID found, show empty modules
                $modules = collect();
            }
        }

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
