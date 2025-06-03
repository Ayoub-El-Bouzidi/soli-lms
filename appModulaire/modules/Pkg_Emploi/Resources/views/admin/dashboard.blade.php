@extends('Emploi::layouts.admin')

@section('content')
    <section class="content">
        <div class="container-fluid">

            {{-- 1) Filtre “Groupe” en GET --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <form method="GET" action="">
                        <label for="groupe-select" class="font-weight-bold">Filtrer par Groupe :</label>
                        <select
                            id="groupe-select"
                            name="groupe_id"
                            class="form-control"
                            onchange="this.form.submit()"
                        >
                            @foreach ($groupes as $g)
                                <option
                                    value="{{ $g->id }}"
                                    @if ($g->id == $selectedGroupeId) selected @endif
                                >
                                    {{ $g->nom }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            {{-- 2) Small boxes --}}
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalSeanceEmploies }}</h3>
                            <p>Total des séances</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            Plus d’infos <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $derniersModification ? $derniersModification->format('d/m/Y') : 'N/A' }}</h3>
                            <p>Dernière mise à jour</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            Plus d’infos <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>
                                @if ($joursRestants > 0)
                                    {{ $joursRestants }}
                                @else
                                    Terminé
                                @endif
                            </h3>
                            <p>Temps restant à cet emploi</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            Plus d’infos <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gradient-success">
                        <div class="inner">
                            <h3>{{ $totalModulesGroupe }}</h3>
                            <p>Total des modules</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            Plus d’infos <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- 3) Charts et tableau --}}
          
            <div class="row">
                {{-- 3.a) Striped Full Width Table --}}
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Progression des Modules</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped projects">
                                <thead>
                                    <tr>
                                        <th style="width: 30%">Nom du module</th>
                                        <th style="width: 20%">Masse horaire</th>
                                        <th style="width: 20%">Heures passées</th>
                                        <th style="width: 30%">Progression</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($modulesProgression as $module)
                                        <tr>
                                            <td>{{ $module->nom }}</td>
                                            <td>{{ $module->masse_horaire }} h</td>
                                            <td>{{ $module->heures_passees ?? 0 }} h</td>
                                            <td>
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar bg-success" style="width: {{ $module->progression }}%"></div>
                                                </div>
                                                <small>{{ $module->progression }}%</small>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Aucun module trouvé pour ce groupe.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

                {{-- 3.b) Pie Chart --}}
                <div class="col-md-5">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Statut des modules</h3>
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
                            <canvas id="pieChart" style="min-height:250px; height:250px; max-height:250px; max-width:100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1) Récupérer les données injectées par PHP
        var modulesPieData = @json([
            'Terminés'    => $modulesPieData['Terminés'] ?? 0,
            'Non terminés' => $modulesPieData['Non terminés'] ?? 0
        ]);

        // 2) Extraire les labels et les valeurs
        var pieLabels = Object.keys(modulesPieData);       // ["Terminés", "Non terminés"]
        var pieValues = Object.values(modulesPieData);     // [countTerminés, countNonTerminés]

        // 3) Couleurs : vert pour Terminés, rouge pour Non terminés
        var pieColors = ['#00a65a', '#f56954'];

        // 4) Initialiser le pie chart
        var pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    data: pieValues,
                    backgroundColor: pieColors
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                var value = context.parsed;
                                var total = context.chart.data.datasets[0].data
                                    .reduce(function(sum, v) { return sum + v; }, 0);
                                var pct = total > 0 ? Math.round((value / total) * 100) : 0;
                                return label + ': ' + value + ' (' + pct + '%)';
                            }
                        }
                    }
                }
            }
        });
    });
    </script>
@endsection
