@extends('adminlte::page')

@section('title', 'Modifier Entrée - Cahier de Texte')

@section('content_header')
    <h1>Modifier Entrée - Cahier de Texte</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('cahier.update', $entry) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="module_id">Module <span class="text-danger">*</span></label>
                            <select name="module_id" id="module_id" class="form-control select2 @error('module_id') is-invalid @enderror" required>
                                <option value="">Sélectionner un module</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module->id }}" {{ old('module_id', $entry->module_id) == $module->id ? 'selected' : '' }}>
                                        {{ $module->nom }} ({{ $module->heures_restees }}h restantes)
                                    </option>
                                @endforeach
                            </select>
                            @error('module_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror"
                                value="{{ old('date', $entry->date->format('Y-m-d')) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="heures_prevues">Heures Prévues <span class="text-danger">*</span></label>
                            <input type="number" name="heures_prevues" id="heures_prevues"
                                class="form-control @error('heures_prevues') is-invalid @enderror"
                                value="{{ old('heures_prevues', $entry->heures_prevues) }}" step="0.5" min="0.5" max="8" required>
                            @error('heures_prevues')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="heure_debut">Heure de Début <span class="text-danger">*</span></label>
                            <input type="time" name="heure_debut" id="heure_debut"
                                class="form-control @error('heure_debut') is-invalid @enderror"
                                value="{{ old('heure_debut', $entry->heure_debut->format('H:i')) }}" required>
                            @error('heure_debut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Heure de fin calculée: <span id="heure_fin_display">{{ $entry->heure_fin->format('H:i') }}</span></small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="contenu">Contenu</label>
                    <textarea name="contenu" id="contenu" rows="4"
                        class="form-control @error('contenu') is-invalid @enderror">{{ old('contenu', $entry->contenu) }}</textarea>
                    @error('contenu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="objectifs">Objectifs</label>
                    <textarea name="objectifs" id="objectifs" rows="4"
                        class="form-control @error('objectifs') is-invalid @enderror">{{ old('objectifs', $entry->objectifs) }}</textarea>
                    @error('objectifs')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="planifie" {{ old('status', $entry->status) == 'planifie' ? 'selected' : '' }}>Planifié</option>
                        <option value="realise" {{ old('status', $entry->status) == 'realise' ? 'selected' : '' }}>Réalisé</option>
                        <option value="annule" {{ old('status', $entry->status) == 'annule' ? 'selected' : '' }}>Annulé</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('cahier.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" rel="stylesheet" />
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: 'Sélectionner un module'
            });

            function updateEndTime() {
                const heuresInput = document.getElementById('heures_prevues');
                const startTimeInput = document.getElementById('heure_debut');

                if (heuresInput.value && startTimeInput.value) {
                    const heures = parseFloat(heuresInput.value);
                    const [hours, minutes] = startTimeInput.value.split(':');
                    const startTime = new Date();
                    startTime.setHours(parseInt(hours));
                    startTime.setMinutes(parseInt(minutes));

                    const endTime = new Date(startTime.getTime() + (heures * 60 * 60 * 1000));
                    const endTimeString = endTime.getHours().toString().padStart(2, '0') + ':' +
                                        endTime.getMinutes().toString().padStart(2, '0');

                    document.getElementById('heure_fin_display').textContent = endTimeString;
                }
            }

            document.getElementById('heures_prevues').addEventListener('input', updateEndTime);
            document.getElementById('heure_debut').addEventListener('input', updateEndTime);
        });
    </script>
@stop
