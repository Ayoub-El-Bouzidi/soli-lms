<?php

namespace Modules\Pkg_CahierText\App\Exports;

use Modules\Pkg_CahierText\Models\Module;
use Maatwebsite\Excel\Concerns\FromCollection;

class ModulesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Module::with('groupes')->get()
        ->map(function($module){
            return [
                'id' => $module->id,
                'nom' => $module->nom,
                'groupe' => $module->groupes->pluck('nom')->implode(', '),
                'masse_horaire' => $module->masse_horaire,
                'etat' => $module->etat,
                'heures_terminees' => $module->heures_terminees,
                'heures_restantes' => $module->heures_restantes,
                'created_at' => $module->created_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nom',
            'Groupe',
            'Masse horaire',
            'Etat',
            'Heures terminees',
            'Heures restantes',
            'Date de creation',
        ];
    }
}
