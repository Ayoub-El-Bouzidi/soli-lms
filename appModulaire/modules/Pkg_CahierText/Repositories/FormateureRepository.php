<?php
namespace Modules\Pkg_CahierText\Repositories;
use Modules\Pkg_CahierText\Interfaces\FormateureRepositoryInterface;
use Modules\Pkg_CahierText\Models\Formateur;

class FormateureRepository implements FormateureRepositoryInterface
{
    public function getAllFormateurs()
    {
        return Formateur::all();
    }

    public function getFormateurById($id)
    {
        return Formateur::findOrFail($id);
    }

    public function createFormateur(array $data)
    {
        return Formateur::create($data);
    }

    public function updateFormateur($id, array $data)
    {
        $formateur = $this->getFormateurById($id);
        $formateur->update($data);
        return $formateur;
    }

    public function deleteFormateur($id)
    {
        $formateur = $this->getFormateurById($id);
        return $formateur->delete();
    }
}
