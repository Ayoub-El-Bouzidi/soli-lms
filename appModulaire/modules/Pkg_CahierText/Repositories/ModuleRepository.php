<?php

namespace Modules\Pkg_CahierText\Repositories;

use Modules\Pkg_CahierText\Interfaces\ModuleRepositoryInterface;
use Modules\Pkg_CahierText\Models\Module;

class ModuleRepository implements ModuleRepositoryInterface
{
    public function getAllModules()
    {
        return Module::with('seances', 'groupes')->get();
    }

    public function getModuleById($id)
    {
        return Module::findOrFail($id);
    }

    public function createModule(array $data)
    {
        // Set heures_restees equal to masse_horaire initially
        $data['heures_restees'] = $data['masse_horaire'];
        return Module::create($data);
    }

    public function updateModule($id, array $data)
    {
        $module = $this->getModuleById($id);

        // Update heures_restees if masse_horaire changes
        if (isset($data['masse_horaire']) && $data['masse_horaire'] != $module->masse_horaire) {
            $difference = $data['masse_horaire'] - $module->masse_horaire;
            $data['heures_restees'] = $module->heures_restees + $difference;
        }

        $module->update($data);
        return $module;
    }

    public function deleteModule($id)
    {
        $module = $this->getModuleById($id);
        return $module->delete();
    }

    public function getModulesByGroup($groupId = null)
    {
        $query = Module::with('seances', 'groupes');

        if ($groupId) {
            $query->whereHas('groupes', function ($q) use ($groupId) {
                $q->where('groupes.id', $groupId);
            });
        }

        return $query->get();
    }
}
