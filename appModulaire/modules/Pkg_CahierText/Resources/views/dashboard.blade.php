@extends('adminlte::page')

@section('title', 'Tableau de bord')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Tableau de bord</h1>
        <div class="d-flex align-items-center">
            <form method="GET" action="{{ route('dashboard') }}" class="form-inline">
                <div class="form-group mx-2">
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
@stop

@section('content')
    <div class="row">
        <!-- Modules terminés -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $modulesTermines ?? 0 }}</h3>
                    <p>Modules terminés</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a class="small-box-footer">
                    Plus d'infos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Modules restants -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $modulesRestants ?? 0 }}</h3>
                    <p>Modules restants</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <a class="small-box-footer">
                    Plus d'infos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Séances -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $seancesCount ?? 0 }}</h3>
                    <p>Séances planifiées</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <a class="small-box-footer">
                    Plus d'infos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Groupes -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $groupesCount ?? 0 }}</h3>
                    <p>Groupes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a class="small-box-footer">
                    Plus d'infos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Donut chart and Module Table Side by Side -->
    <div class="row">
        <!-- Donut Chart -->
        <div class="col-md-6">
            <div class="card card-primary card-outline h-100">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="far fa-chart-bar"></i> Répartition des Modules
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="donutChart" style="min-height: 250px; max-height: 300px; width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Tableau des contenus de modules -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">Contenu des Modules</h3>
                </div>
                <div class="card-body table-responsive p-0" style="max-height: 300px;">
                    <table class="table table-hover text-nowrap table-bordered" style="min-width: 600px;">
                        <thead style="position: sticky; top: 0; background-color: #f8f9fa;">
                            <tr class="text-center">
                                <th style="width: 30%;">Module</th>
                                <th style="width: 20%;">H. totales</th>
                                <th style="width: 20%;">H. faites</th>
                                <th style="width: 20%;">H. restantes</th>
                                <th style="width: 10%;">État</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($contenus))
                                @foreach ($contenus as $contenu)
                                    <tr class="text-center">
                                        <td>{{ e($contenu['nom'] ?? 'N/A') }}</td>
                                        <td>{{ $contenu['masse_horaire'] ?? 0 }}</td>
                                        <td>{{ $contenu['heures_terminees'] }}</td>
                                        <td>{{ $contenu['heures_restantes'] ?? 0 }}</td>
                                        <td>
                                            @if (($contenu['etat'] ?? '') === 'terminé')
                                                <span class="badge bg-success">Terminé</span>
                                            @else
                                                <span class="badge bg-warning text-dark">En cours</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">Aucun contenu disponible</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('donutChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Modules terminés', 'Modules restants'],
                datasets: [{
                    data: [{{ $modulesTermines ?? 0 }}, {{ $modulesRestants ?? 0 }}],
                    backgroundColor: ['#17a2b8', '#28a745'],
                    hoverOffset: 10,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                return `${label}: ${value}`;
                            }
                        }
                    }
                }
            }
        });
    </script>
@stop
