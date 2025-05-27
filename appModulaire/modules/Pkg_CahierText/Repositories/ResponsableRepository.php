<?php
namespace Modules\Pkg_CahierText\Repositories;
use Modules\Pkg_CahierText\Models\Responsable;



use App\Interfaces\ResponsableRepositoryInterface;

class ResponsableRepository
{

    public function getAllResponsables()
    {
        return Responsable::all();
    }

    public function getResponsableById($id)
    {
        return Responsable::findOrFail($id);
    }

    public function createResponsable(array $data)
    {
        return Responsable::create($data);
    }

    public function updateResponsable($id, array $data)
    {
        $responsable= $this->getResponsableById($id);
        $responsable->update($data);
        return $responsable;
    }

    public function deleteResponsable($id)
    {
        $responsable = $this->getResponsableById($id);
        return $responsable->delete();
    }
}
