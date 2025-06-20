<?php

namespace Modules\Pkg_CahierText\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Pkg_CahierText\App\Exports\ModulesExport;
use Modules\Pkg_CahierText\app\Requests\ModuleRequest;
use Modules\Pkg_CahierText\Repositories\ModuleRepository;
use Modules\Pkg_CahierText\Models\Groupe;

class ModuleController extends Controller
{
    protected $repository;

    public function __construct(ModuleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $groupId = $request->query('groupe_id');
        $modules = $this->repository->getModulesByGroup($groupId);
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
    public function store(ModuleRequest $request)
    {
        $request->validated();

        $data = $request->all();
        $module = $this->repository->createModule($data);

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
        $module = $this->repository->getModuleById($id);
        return view('Pkg_CahierText::modules.show', compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $module = $this->repository->getModuleById($id);
        $groupes = Groupe::all();
        return view('Pkg_CahierText::modules.edit', compact('module', 'groupes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModuleRequest $request, string $id)
    {
        $request->validated();

        $data = $request->all();
        $module = $this->repository->updateModule($id, $data);

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
        $this->repository->deleteModule($id);
        return redirect()->route('modules.index')
            ->with('success', 'Module supprimé avec succès.');
    }


    /**
     * Export modules
     */
    public function export()
    {
        return Excel::download(new ModulesExport, 'modules.xlsx');
    }
}
