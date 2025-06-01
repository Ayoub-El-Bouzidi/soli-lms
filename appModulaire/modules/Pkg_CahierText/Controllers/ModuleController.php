<?php

namespace Modules\Pkg_CahierText\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pkg_CahierText\Repositories\ModuleRepository;

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
    public function index()
    {
        return view('Pkg_CahierText::cahierText.index', [
            'modules' => $this->moduleRepository->getAllModules(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Pkg_CahierText::cahierText.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $this->moduleRepository->createModule($data);
        return redirect()->route('modules.index')->with('success', 'Module créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $module = $this->moduleRepository->getModuleById($id);
        return view('Pkg_CahierText::cahierText.show', compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $module = $this->moduleRepository->getModuleById($id);
        return view('Pkg_CahierText::cahierText.edit', compact('module'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $this->moduleRepository->updateModule($id, $data);
        return redirect()->route('modules.index')->with('success', 'Module mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->moduleRepository->deleteModule($id);
        return redirect()->route('modules.index')->with('success', 'Module supprimé avec succès.');
    }
}
