@extends('adminlte::page')

@section('title', 'Cahier de Texte')

@section('content_header')
    <h1>Cahier de Texte</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Entrées du Cahier de Texte</h3>
                    <div class="card-tools">
                        <a href="{{ route('cahier-de-texte.export') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i> Exporter
                        </a>
                        <a href="{{ route('cahier-de-texte.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Nouvelle Entrée
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="width: 100%;">
                        <table class="table table-bordered table-striped w-100" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Formateur</th>
                                    <th>Date</th>
                                    <th>Module</th>
                                    <th>Groupe(s)</th>
                                    <th>Heures</th>
                                    <th>Heure de debut</th>
                                    <th>Heure de fin</th>
                                    <th>Contenu</th>
                                    <th>Objectifs</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($entries as $entry)
                                    <tr>
                                        <td>{{ $entry->formateur->nom ?? '' }} {{ $entry->formateur->prenom ?? '' }}</td>
                                        <td>{{ $entry->date->format('d/m/Y') }}</td>
                                        <td>{{ $entry->module->nom }}</td>
                                        <td>
                                            @if($entry->formateur)
                                                @foreach($entry->formateur->groupes as $groupe)
                                                    <span class="badge badge-info">{{ $groupe->nom }}</span>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{ $entry->heures_prevues }}h</td>
                                        <td>{{ $entry->heure_debut }}</td>
                                        <td>{{ $entry->heure_fin }}</td>
                                        <td>{{ $entry->contenu }}</td>
                                        <td>{{ $entry->objectifs }}</td>
                                        <td>
                                            <span class="badge badge-{{ $entry->status === 'realise' ? 'success' : ($entry->status === 'planifie' ? 'info' : 'danger') }}">
                                                {{ ucfirst($entry->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('cahier-de-texte.edit', $entry) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('cahier-de-texte.destroy', $entry) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette entrée ?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Aucune entrée trouvée</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $entries->links() }}
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Add any JavaScript functionality here
        });
    </script>
@stop
