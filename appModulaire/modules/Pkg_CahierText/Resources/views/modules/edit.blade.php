@extends('adminlte::page')

@section('title', 'Modifier le Module')

@section('content_header')
    <h1>Modifier le Module</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('modules.update', $module->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nom">Nom du module <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $module->nom) }}" required>
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="masse_horaire">Masse horaire (en heures) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('masse_horaire') is-invalid @enderror" id="masse_horaire" name="masse_horaire" value="{{ old('masse_horaire', $module->masse_horaire) }}" required min="1">
                    @error('masse_horaire')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="groupes">Groupes</label>
                    <select name="groupes[]" id="groupes" class="form-control select2 @error('groupes') is-invalid @enderror" multiple>
                        @foreach($groupes as $groupe)
                            <option value="{{ $groupe->id }}" {{ in_array($groupe->id, old('groupes', $module->groupes->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $groupe->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('groupes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('modules.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Sélectionnez les groupes',
                allowClear: true
            });
        });
    </script>
@stop
