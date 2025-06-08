<?php

namespace Modules\Pkg_CahierText\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pkg_CahierText\Repositories\ModuleRepository;
use Modules\Pkg_CahierText\Models\Groupe;

class ModuleController extends Controller
{
    protected $moduleRepository;

    public function __construct(ModuleRepository $moduleRepository)
    {
        $this->moduleRepository = $moduleRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $groupId = $request->query('groupe_id');
        $modules = $this->moduleRepository->getModulesByGroup($groupId);
        $groupes = Groupe::all();

        return view('Pkg_CahierText::modules.index', [
            'modules' => $modules,
            'groupes' => $groupes,
            'selectedGroupId' => $groupId
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groupes = Groupe::all();
        return view('Pkg_CahierText::modules.create', compact('groupes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'masse_horaire' => 'required|integer|min:1',
            'groupes' => 'array'
        ]);

        $data = $request->all();
        $module = $this->moduleRepository->createModule($data);

        if ($request->has('groupes')) {
            $module->groupes()->sync($request->groupes);
        }

        return redirect()->route('modules.index')
            ->with('success', 'Module créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $module = $this->moduleRepository->getModuleById($id);
        return view('Pkg_CahierText::modules.show', compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $module = $this->moduleRepository->getModuleById($id);
        $groupes = Groupe::all();
        return view('Pkg_CahierText::modules.edit', compact('module', 'groupes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'masse_horaire' => 'required|integer|min:1',
            'groupes' => 'array'
        ]);

        $data = $request->all();
        $module = $this->moduleRepository->updateModule($id, $data);

        if ($request->has('groupes')) {
            $module->groupes()->sync($request->groupes);
        }

        return redirect()->route('modules.index')
            ->with('success', 'Module mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->moduleRepository->deleteModule($id);
        return redirect()->route('modules.index')
            ->with('success', 'Module supprimé avec succès.');
    }
}
