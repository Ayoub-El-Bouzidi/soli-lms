<?php
namespace Modules\Pkg_CahierText\Repositories;
use Modules\Pkg_CahierText\Interfaces\ModuleRepositoryInterface;
use Modules\Pkg_CahierText\Models\Module;

class ModuleRepository implements ModuleRepositoryInterface
{
    public function getAllModules()
    {
        return Module::all()->count();
    }

    public function getModuleById($id)
    {
        return Module::findOrFail($id);
    }

    public function createModule(array $data)
    {
        return Module::create($data);
    }

    public function updateModule($id, array $data)
    {
        $module = $this->getModuleById($id);
        $module->update($data);
        return $module;
    }

    public function deleteModule($id)
    {
        $module = $this->getModuleById($id);
        return $module->delete();
    }
}
