@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-2 mt-3">
        <h3 class="">Mes Séances</h3>
        <button class="btn btn-success" id="toggleFormBtn">+ Créer une séance</button>
    </div>

    {{-- Group Filter --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('seances.index') }}" class="d-flex align-items-center">
                <div class="form-group mb-0 mr-3">
                    <label for="groupe_id" class="mr-2">Filtrer par groupe:</label>
                    <select name="groupe_id" id="groupe_id" class="form-control" onchange="this.form.submit()">
                        <option value="">Tous les groupes</option>
                        @foreach($groupes as $groupe)
                            <option value="{{ $groupe->id }}" {{ $selectedGroupId == $groupe->id ? 'selected' : '' }}>
                                {{ $groupe->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    {{-- Formulaire caché par défaut --}}
    <div class="card mb-4 d-none" id="createSeanceCard">
        <div class="card-header">Nouvelle séance</div>
        <div class="card-body">
            <form method="POST" action="{{ route('cahier-de-texte.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="module" class="form-label">Module</label>
                    <input type="text" class="form-control" id="module" name="module" required>
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>

                <div class="mb-3">
                    <label for="heure" class="form-label">Heure</label>
                    <input type="time" class="form-control" id="heure" name="heure" required>
                </div>

                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>

    {{-- Tableau --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Module</th>
                <th>Jour</th>
                <th>Heure</th>
                <th>Durée</th>
                <th>État</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($seances as $seance)
            <tr>
                <td>{{ $seance->module->nom ?? '-' }}</td>
                <td>{{ $seance->seance_emploi->jours ?? '-' }}</td>
                <td>
                    @if($seance->seance_emploi)
                        {{ $seance->seance_emploi->heur_debut ?? '-' }} - {{ $seance->seance_emploi->heur_fin ?? '-' }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($seance->seance_emploi && $seance->seance_emploi->heur_debut && $seance->seance_emploi->heur_fin)
                        @php
                            $start = \Carbon\Carbon::parse($seance->seance_emploi->heur_debut);
                            $end = \Carbon\Carbon::parse($seance->seance_emploi->heur_fin);
                            $duration = $start->diffInHours($end) + ($start->diffInMinutes($end) % 60) / 60;
                        @endphp
                        {{ number_format($duration, 1) }}h
                    @else
                        -
                    @endif
                </td>
                <td>
                    <span class="badge bg-{{ $seance->status_class ?? 'warning' }}">
                        {{ $seance->status ?? 'En cours' }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('cahier-de-texte.edit', $seance->id) }}" class="btn btn-primary btn-sm">Remplir</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('js')
<script>
    document.getElementById('toggleFormBtn').addEventListener('click', function () {
        const card = document.getElementById('createSeanceCard');
        card.classList.toggle('d-none');
    });
</script>
@endsection
