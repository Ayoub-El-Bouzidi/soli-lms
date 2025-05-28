@extends('adminlte::page')

@section('title', 'Tableau de bord')

@section('content_header')
    <h1>Tableau de bord</h1>
@stop

@section('content')
    <div class="row">
        <!-- Modules terminés -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $modulesTermines }}</h3>
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
                    <h3>{{ $modulesRestants }}</h3>
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
                    <h3>{{ $seancesCount }}</h3>
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
                    <h3>{{ $groupesCount }}</h3>
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
                    <canvas id="donutChart" style="height: 300px;"></canvas>
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
                    <table class="table table-hover text-nowrap table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>Module</th>
                                <th>H. totales</th>
                                <th>H. faites</th>
                                <th>H. restantes</th>
                                <th>État</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contenus as $contenu)
                                <tr class="text-center">
                                    <td>{{ $contenu['nom'] }}</td>
                                    <td>{{ $contenu['masse_horaire_totale'] }}</td>
                                    <td>{{ $contenu['heures_terminees'] }}</td>
                                    <td>{{ $contenu['heures_restantes'] }}</td>
                                    <td>
                                        @if ($contenu['etat'] === 'terminé')
                                            <span class="badge bg-success">Terminé</span>
                                        @else
                                            <span class="badge bg-warning text-dark">En cours</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('donutChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Modules terminés', 'Modules restants'],
            datasets: [{
                data: [{{ $modulesTermines }}, {{ $modulesRestants }}],
                backgroundColor: ['#17a2b8', '#28a745'],
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@stop
