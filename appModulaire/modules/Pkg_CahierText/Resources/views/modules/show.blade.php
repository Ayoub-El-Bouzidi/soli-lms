@extends('adminlte::page')

@section('title', 'Détails du Module')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>{{ $module->nom }}</h1>
        <div>
            <a href="{{ route('modules.edit', $module->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="{{ route('modules.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <!-- Informations générales -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informations générales</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th style="width: 200px;">Masse horaire totale</th>
                            <td>{{ $module->masse_horaire }}h</td>
                        </tr>
                        <tr>
                            <th>Heures terminées</th>
                            <td>{{ $module->heures_terminees }}h</td>
                        </tr>
                        <tr>
                            <th>Heures restantes</th>
                            <td>{{ $module->heures_restees }}h</td>
                        </tr>
                        <tr>
                            <th>État</th>
                            <td>
                                @if($module->heures_restees <= 0)
                                    <span class="badge bg-success">Terminé</span>
                                @else
                                    <span class="badge bg-warning">En cours</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Séances -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Séances planifiées</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Horaire</th>
                                <th>Durée</th>
                                <th>Formateur</th>
                                <th>État</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($module->seances as $seance)
                                <tr>
                                    <td>{{ $seance->seance_emploi->date ?? 'N/A' }}</td>
                                    <td>
                                        {{ $seance->seance_emploi->heur_debut ?? 'N/A' }} -
                                        {{ $seance->seance_emploi->heur_fin ?? 'N/A' }}
                                    </td>
                                    <td>{{ $seance->duree ?? 'N/A' }}h</td>
                                    <td>{{ $seance->formateur->nom ?? 'N/A' }}</td>
                                    <td>
                                        @switch($seance->etat_validation)
                                            @case('approved')
                                                <span class="badge bg-success">Validée</span>
                                                @break
                                            @case('pending')
                                                <span class="badge bg-warning">En attente</span>
                                                @break
                                            @case('rejected')
                                                <span class="badge bg-danger">Rejetée</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">N/A</span>
                                        @endswitch
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Aucune séance planifiée</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Groupes -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Groupes associés</h3>
                </div>
                <div class="card-body">
                    @forelse($module->groupes as $groupe)
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-info mr-2">{{ $groupe->nom }}</span>
                        </div>
                    @empty
                        <p class="text-muted">Aucun groupe associé</p>
                    @endforelse
                </div>
            </div>

            <!-- Progression -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Progression</h3>
                </div>
                <div class="card-body">
                    @php
                        $progression = $module->masse_horaire > 0
                            ? round(($module->heures_terminees / $module->masse_horaire) * 100)
                            : 0;
                    @endphp
                    <div class="progress">
                        <div class="progress-bar bg-primary" role="progressbar"
                             style="width: {{ $progression }}%"
                             aria-valuenow="{{ $progression }}"
                             aria-valuemin="0"
                             aria-valuemax="100">
                            {{ $progression }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
