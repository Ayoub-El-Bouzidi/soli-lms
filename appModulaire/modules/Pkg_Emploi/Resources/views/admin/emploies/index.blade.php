@extends('adminlte::page')

@section('title', 'Emploi creation')

@section('header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content_header')
   <div class="card-header">
            <a href="{{ route('emploie.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Nouveau
            </a>
    </div>
@stop
@section('content')
    <div class="card">
        
        <div class="card-body">
            <table id="emplois-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date début</th>
                        <th>Date fin</th>
                        <th>Groupe</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($emplois as $emploi)
                        <tr>
                            <td>{{ $emploi->date_debut }}</td>
                            <td>{{ $emploi->date_fin }}</td>
                            <td>
                                {{-- Suppose each emploi has a related “groupe” with a “name” and optional “color” field --}}
                                <span class="badge badge-pill"
                                      style="background-color: {{ $emploi->groupe->color ?? '#6c757d' }}; 
                                             color: #fff;
                                             padding: .5em 1em;
                                             font-size: .9em;">
                                    {{ $emploi->groupe->nom }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('emploie.show', $emploi->id) }}" class="btn btn-info btn-sm" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('emploie.edit', $emploi) }}" class="btn btn-warning btn-sm" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('emploie.destroy', $emploi->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Supprimer"
                                            onclick="return confirm('Voulez-vous vraiment supprimer cet emploi ?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    {{-- Optional: tweak badge to be perfectly round --}}
    <style>
        .badge-pill {
            border-radius: 50rem !important;
            display: inline-block;
        }
    </style>
@stop

@section('js')
    {{-- Initialize DataTables (included with AdminLTE) --}}
    <script>
        $(function () {
            $('#emplois-table').DataTable({
                "order": [[ 0, "asc" ]],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/French.json"
                }
            });
        });
    </script>
@stop
