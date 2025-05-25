@extends('adminlte::page')

@section('title', 'Dashboard Cahier de Textes')

@section('content_header')
    <h1>Tableau de Bord - Modules</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Tableau Statistiques par Module -->
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title text-white">Statistiques par Module</h3>
            </div>
            <div class="card-body table-responsive p-0" style="max-height: 400px;">
                <table class="table table-hover table-bordered table-striped text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Module</th>
                            <th>Formateur</th>
                            <th>Total Séances</th>
                            <th>Heures Déclarées</th>
                            <th>Heures Validées</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Exemple statique (à remplacer avec boucle dynamique plus tard) -->
                        <tr>
                            <td>Développement Web</td>
                            <td>Ahmed El Amrani</td>
                            <td>12</td>
                            <td>36 h</td>
                            <td>30 h</td>
                        </tr>
                        <tr>
                            <td>Base de Données</td>
                            <td>Fatima Zahra</td>
                            <td>10</td>
                            <td>30 h</td>
                            <td>28 h</td>
                        </tr>
                        <tr>
                            <td>Réseaux Informatiques</td>
                            <td>Youssef Kabbaj</td>
                            <td>8</td>
                            <td>24 h</td>
                            <td>20 h</td>
                        </tr>
                        <tr>
                            <td>UI/UX Design</td>
                            <td>Imane Charif</td>
                            <td>6</td>
                            <td>18 h</td>
                            <td>18 h</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
