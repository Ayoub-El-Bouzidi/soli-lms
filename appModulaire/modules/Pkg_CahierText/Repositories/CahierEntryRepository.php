<?php

namespace Modules\Pkg_CahierText\Repositories;

use Carbon\Carbon;
use Modules\Pkg_CahierText\Models\CahierEntry;
use Modules\Pkg_CahierText\Models\Module;
use Modules\Pkg_CahierText\Models\Groupe;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CahierEntryRepository
{
    public function getAllEntries(): LengthAwarePaginator
    {
        return CahierEntry::with('module.groupes', 'formateur')
            ->orderBy('date', 'desc')
            ->paginate(10);
    }

    public function getFormateurGroups(int $formateurId): Collection
    {
        return Groupe::whereHas('formateurs', function ($query) use ($formateurId) {
            $query->where('formateurs.id', $formateurId);
        })->get();
    }

    public function getAvailableModules(int $formateurId)
    {
        // Get modules from formateur's groups
        return Module::whereHas('groupes.formateurs', function ($query) use ($formateurId) {
            $query->where('formateurs.id', $formateurId);
        })->where('heures_restees', '>', 0)->get();
    }

    public function getModuleById(int $moduleId): Module
    {
        return Module::findOrFail($moduleId);
    }

    public function createEntry(array $data, int $formateurId): CahierEntry
    {
        $module = $this->getModuleById($data['module_id']);

        if ($module->heures_restees <= 0) {
            throw new \Exception('Ce module a déjà atteint sa masse horaire maximale.');
        }

        if ($data['heures_prevues'] > $module->heures_restees) {
            throw new \Exception("Les heures prévues dépassent les heures restantes du module ({$module->heures_restees}h).");
        }

        $heureDebut = Carbon::createFromFormat('H:i', $data['heure_debut']);
        $heureFin = $heureDebut->copy()
            ->addHours((int)$data['heures_prevues'])
            ->addMinutes(($data['heures_prevues'] * 60) % 60);

        $entry = new CahierEntry($data);
        $entry->formateur_id = $formateurId;
        $entry->heure_debut = $heureDebut;
        $entry->heure_fin = $heureFin;
        $entry->save();

        $this->updateModuleHours($module, $data['heures_prevues']);

        return $entry;
    }

    public function updateEntry(CahierEntry $entry, array $data): CahierEntry
    {
        // Restore previous hours to the old module
        $oldModule = $entry->module;
        $this->restoreModuleHours($oldModule, $entry->heures_prevues);

        // Check if new module has enough remaining hours
        $newModule = $this->getModuleById($data['module_id']);
        if ($data['heures_prevues'] > $newModule->heures_restees) {
            throw new \Exception("Les heures prévues dépassent les heures restantes du module ({$newModule->heures_restees}h).");
        }

        $heureDebut = Carbon::createFromFormat('H:i', $data['heure_debut']);
        $heureFin = $heureDebut->copy()
            ->addHours((int)$data['heures_prevues'])
            ->addMinutes(($data['heures_prevues'] * 60) % 60);

        $entry->update(array_merge($data, [
            'heure_debut' => $heureDebut,
            'heure_fin' => $heureFin
        ]));

        $this->updateModuleHours($newModule, $data['heures_prevues']);

        return $entry;
    }

    public function deleteEntry(CahierEntry $entry): bool
    {
        $module = $entry->module;
        $this->restoreModuleHours($module, $entry->heures_prevues);

        return $entry->delete();
    }

    private function updateModuleHours(Module $module, float $hours): void
    {
        $module->heures_terminees += $hours;
        $module->heures_restees = max(0, $module->masse_horaire - $module->heures_terminees);
        $module->save();
    }

    private function restoreModuleHours(Module $module, float $hours): void
    {
        $module->heures_terminees -= $hours;
        $module->heures_restees = $module->masse_horaire - $module->heures_terminees;
        $module->save();
    }

    public function getEntriesByFormateur(int $formateurId): LengthAwarePaginator
    {
        return CahierEntry::with(['module', 'formateur.groupes'])
            ->where('formateur_id', $formateurId)
            ->orderBy('date', 'desc')
            ->paginate(10);
    }
}
