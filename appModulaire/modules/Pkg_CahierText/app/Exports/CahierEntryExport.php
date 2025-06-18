<?php

namespace Modules\Pkg_CahierText\app\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\Pkg_CahierText\Models\CahierEntry;

class CahierEntryExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CahierEntry::with('modules')->get()
        ->map(function($cahierEntry){
            return [
                'id' => $cahierEntry->id,
                'date' => $cahierEntry->date,
                'modules' => $cahierEntry->modules->pluck('nom')->implode(', '),
                'heures_prevues' => $cahierEntry->heures_prevues,
                'heure_debut' => $cahierEntry->heure_debut,
                'heure_fin' => $cahierEntry->heure_fin,
                'contenu' => $cahierEntry->contenu,
                'objectifs' => $cahierEntry->objectifs,
                'status' => $cahierEntry->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'id',
            'date',
            'modules',
            'heures_prevues',
            'heure_debut',
            'heure_fin',
            'contenu',
            'objectifs',
            'status',
        ];
    }
}
