@extends('adminlte::page')

@section('title', 'Gestion des Modules')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Gestion des Modules</h1>
        <div class="d-flex gap-2 align-items-center justify-content-between">
            @role('responsable')
                <a href="{{ route('modules.export') }}" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Exporter
                </a>
            @endrole

            @role('responsable')
                <a href="{{ route('modules.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouveau Module
                </a>
            @endrole
        </div>

    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Liste des Modules</h3>
            <div class="card-tools d-flex justify-content-between align-items-center">
                <form action="{{ route('modules.index') }}" method="GET" class="form-inline">
                    <select name="groupe_id" class="form-control mr-2">
                        <option value="">Tous les groupes</option>
                        @foreach($groupes as $groupe)
                            <option value="{{ $groupe->id }}" {{ request('groupe_id') == $groupe->id ? 'selected' : '' }}>
                                {{ $groupe->nom }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Masse Horaire</th>
                            <th>Heures Terminées</th>
                            <th>Heures Restantes</th>
                            <th>État</th>
                            <th>Groupes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($modules as $module)
                            <tr>
                                <td>{{ $module->nom }}</td>
                                <td>{{ $module->masse_horaire }}h</td>
                                <td>{{ $module->heures_terminees }}h</td>
                                <td>{{ $module->heures_restees }}h</td>
                                <td>
                                    <span class="badge badge-{{ $module->etat_validation === 'terminé' ? 'success' : ($module->etat_validation === 'en cours' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($module->etat_validation) }}
                                    </span>
                                </td>
                                <td>
                                    @foreach($module->groupes as $groupe)
                                        <span class="badge badge-info">{{ $groupe->nom }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('modules.show', $module) }}" class="btn btn-sm btn-info" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @role('responsable')
                                        <a href="{{ route('modules.edit', $module) }}" class="btn btn-sm btn-primary" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endrole
                                        @role('responsable')
                                        <form action="{{ route('modules.destroy', $module) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce module ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endrole
                                        {{-- Cahier de texte button - Only show for formateurs and if hours remaining --}}
                                        @if(Auth::guard('formateurs')->check())
                                            @if($module->heures_restees > 0)
                                                <a href="{{ route('cahier-de-texte.create', ['module_id' => $module->id]) }}"
                                                    class="btn btn-sm btn-success" title="Cahier de texte">
                                                    <i class="fas fa-book"></i>
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucun module trouvé</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
