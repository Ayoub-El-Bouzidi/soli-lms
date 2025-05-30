<?php
namespace Modules\Pkg_CahierText\Interfaces;

interface ModuleRepositoryInterface
{
    public function getAllModules();
    public function getModuleById($id);
    public function createModule(array $data);
    public function updateModule($id, array $data);
    public function deleteModule($id);
}

