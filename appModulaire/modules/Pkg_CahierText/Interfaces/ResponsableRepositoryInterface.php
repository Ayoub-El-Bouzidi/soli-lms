<?php
namespace Modules\Pkg_CahierText\Interfaces;

interface ResponsableRepositoryInterface
{
    public function getAllResponsables();
    public function getResponsableById($id);
    public function createResponsable(array $data);
    public function updateResponsable($id, array $data);
    public function deleteResponsable($id);
}
