@extends('adminlte::page')

@section('title', 'Cahier de Texte')

@section('content_header')
    <h1>Cahier de Texte</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                Mes Entrées
            </div>
            <a href="{{ route('cahier.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nouvelle Entrée
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Module</th>
                        <th>Heures Prévues</th>
                        <th>Horaire</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entries as $entry)
                        <tr>
                            <td>{{ $entry->date->format('d/m/Y') }}</td>
                            <td>{{ $entry->module->nom }}</td>
                            <td>{{ $entry->heures_prevues }}h</td>
                            <td>{{ $entry->heure_debut->format('H:i') }} - {{ $entry->heure_fin->format('H:i') }}</td>
                            <td>
                                <span class="badge bg-{{ $entry->status === 'realise' ? 'success' : ($entry->status === 'planifie' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($entry->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('cahier.edit', $entry) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('cahier.destroy', $entry) }}" method="POST" class="d-inline">
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

            <div class="d-flex justify-content-center mt-3">
                {{ $entries->links() }}
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
