<?php
namespace Modules\Pkg_CahierText\Repositories;
use Modules\Pkg_CahierText\Interfaces\SeanceRepositoryInterface;
use Modules\Pkg_CahierText\Models\Seance;

class SeanceRepository implements SeanceRepositoryInterface
{
    public function getAllSeances()
    {
        return Seance::all();
    }

    public function getSeanceById($id)
    {
        return Seance::findOrFail($id);
    }

    public function createSeance(array $data)
    {
        return Seance::create($data);
    }

    public function updateSeance($id, array $data)
    {
        $seance = $this->getSeanceById($id);
        $seance->update($data);
        return $seance;
    }

    public function deleteSeance($id)
    {
        $seance = $this->getSeanceById($id);
        return $seance->delete();
    }
}
