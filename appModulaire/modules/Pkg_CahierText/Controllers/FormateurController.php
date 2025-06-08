<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Pkg_CahierText\Repositories\FormateureRepository;

class FormateurController extends Controller
{
    protected $formateureRepository;

    public function __construct(FormateureRepository $formateureRepository)
    {
        $this->formateureRepository = $formateureRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('formateurs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $this->formateureRepository->createFormateur($data);
        return redirect()->route('formateurs.index')->with('success', 'Formateur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $formateur = $this->formateureRepository->getFormateurById($id);
        return view('formateurs.show', compact('formateur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $formateur = $this->formateureRepository->getFormateurById($id);
        return view('formateurs.edit', compact('formateur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $this->formateureRepository->updateFormateur($id, $data);
        return redirect()->route('formateurs.index')->with('success', 'Formateur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->formateureRepository->deleteFormateur($id);
        return redirect()->route('formateurs.index')->with('success', 'Formateur supprimé avec succès.');
    }
}
