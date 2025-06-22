@extends('Emploi::layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Hero Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="hero-section bg-gradient-primary text-white rounded-lg p-5">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h1 class="display-4 font-weight-bold mb-3">
                                <i class="fas fa-calendar-alt mr-3"></i>
                                Bienvenue dans votre système de gestion d'emploi du temps
                            </h1>
                            <p class="lead mb-4">
                                Gérez efficacement vos emplois du temps, organisez vos cours et optimisez 
                                l'utilisation de vos ressources pédagogiques en toute simplicité.
                            </p>
                            <div class="hero-actions">
                                <a href="" class="btn btn-light btn-lg mr-3">
                                    <i class="fas fa-plus mr-2"></i>
                                    Créer un nouvel emploi
                                </a>
                                <a href="{{ route('emploie.index') }}" class="btn btn-outline-light btn-lg">
                                    <i class="fas fa-list mr-2"></i>
                                    Voir tous les emplois
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center">
                            <div class="hero-illustration">
                                <i class="fas fa-chalkboard-teacher fa-10x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card bg-info text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="card-title">{{ $stats['total_emplois'] ?? 0 }}</h3>
                                <p class="card-text">Emplois du temps</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-calendar-week fa-2x"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('emploie.index') }}" class="text-white">
                            <small>Voir tous <i class="fas fa-arrow-right"></i></small>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="card-title">{{ $stats['total_groupes'] ?? 0 }}</h3>
                                <p class="card-text">Groupes actifs</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="" class="text-white">
                            <small>Gérer les groupes <i class="fas fa-arrow-right"></i></small>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="card-title">{{ $stats['total_formateurs'] ?? 0 }}</h3>
                                <p class="card-text">Formateurs</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-user-tie fa-2x"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="" class="text-white">
                            <small>Voir formateurs <i class="fas fa-arrow-right"></i></small>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card bg-danger text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="card-title">{{ $stats['total_salles'] ?? 0 }}</h3>
                                <p class="card-text">Salles disponibles</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-door-open fa-2x"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="" class="text-white">
                            <small>Gérer salles <i class="fas fa-arrow-right"></i></small>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Features -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="fas fa-star text-warning mr-2"></i>
                    Fonctionnalités principales
                </h2>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card feature-card h-100">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-calendar-plus fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title">Création d'emplois du temps</h5>
                        <p class="card-text">
                            Créez facilement des emplois du temps interactifs avec notre interface 
                            intuitive de glisser-déposer.
                        </p>
                        <a href="{{ route('emploie.create') }}" class="btn btn-primary">
                            Commencer <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card feature-card h-100">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-users-cog fa-3x text-success"></i>
                        </div>
                        <h5 class="card-title">Gestion des ressources</h5>
                        <p class="card-text">
                            Gérez vos formateurs, salles, modules et groupes depuis une interface 
                            centralisée et efficace.
                        </p>
                        <a href="{{ route('dashboard') }}" class="btn btn-success">
                            Gérer <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card feature-card h-100">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-file-export fa-3x text-info"></i>
                        </div>
                        <h5 class="card-title">Export et impression</h5>
                        <p class="card-text">
                            Exportez vos emplois du temps en PDF ou imprimez-les directement 
                            pour une distribution facile.
                        </p>
                        <a href="#" class="btn btn-info">
                            Exporter <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities & Quick Actions -->
        <div class="row">
            <!-- Recent Activities -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-clock mr-2"></i>
                            Activités récentes
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(isset($recent_activities) && count($recent_activities) > 0)
                            <div class="timeline">
                                @foreach($recent_activities as $activity)
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-primary"></div>
                                        <div class="timeline-content">
                                            <h6 class="timeline-title">{{ $activity['title'] }}</h6>
                                            <p class="timeline-text">{{ $activity['description'] }}</p>
                                            <small class="text-muted">
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ $activity['created_at'] }}
                                            </small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucune activité récente</p>
                                <a href="{{ route('emploie.create') }}" class="btn btn-primary">
                                    Créer votre premier emploi du temps
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-bolt mr-2"></i>
                            Actions rapides
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="" class="list-group-item list-group-item-action">
                                <i class="fas fa-plus text-primary mr-3"></i>
                                Nouvel emploi du temps
                            </a>
                            <a href="" class="list-group-item list-group-item-action">
                                <i class="fas fa-users text-success mr-3"></i>
                                Ajouter un groupe
                            </a>
                            <a href="" class="list-group-item list-group-item-action">
                                <i class="fas fa-user-plus text-warning mr-3"></i>
                                Ajouter un formateur
                            </a>
                            <a href="" class="list-group-item list-group-item-action">
                                <i class="fas fa-door-open text-info mr-3"></i>
                                Ajouter une salle
                            </a>
                            <a href="" class="list-group-item list-group-item-action">
                                <i class="fas fa-book text-danger mr-3"></i>
                                Ajouter un module
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Help Section -->
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-question-circle mr-2"></i>
                            Besoin d'aide ?
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            Consultez notre guide d'utilisation ou contactez le support technique.
                        </p>
                        <a href="#" class="btn btn-outline-primary btn-sm mr-2">
                            <i class="fas fa-book mr-1"></i>
                            Guide
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-headset mr-1"></i>
                            Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .hero-illustration {
        opacity: 0.3;
    }

    .feature-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .feature-icon {
        transition: transform 0.3s ease;
    }

    .feature-card:hover .feature-icon {
        transform: scale(1.1);
    }

    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }

    .timeline-marker {
        position: absolute;
        left: -23px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 0 0 2px #007bff;
    }

    .timeline-content {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #007bff;
    }

    .timeline-title {
        margin-bottom: 5px;
        color: #495057;
    }

    .timeline-text {
        margin-bottom: 5px;
        color: #6c757d;
    }

    .card {
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border-radius: 10px;
    }

    .card-header {
        border-radius: 10px 10px 0 0 !important;
        border-bottom: 1px solid #e9ecef;
    }

    .list-group-item {
        border: none;
        padding: 12px 15px;
        transition: background-color 0.3s ease;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }

    @media (max-width: 768px) {
        .hero-section {
            text-align: center;
        }
        
        .hero-actions {
            margin-top: 20px;
        }
        
        .hero-actions .btn {
            display: block;
            margin: 10px 0;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Add smooth scrolling for anchor links
        $('a[href^="#"]').on('click', function(event) {
            var target = $(this.getAttribute('href'));
            if( target.length ) {
                event.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 100
                }, 1000);
            }
        });

        // Add animation to feature cards
        $('.feature-card').each(function(index) {
            $(this).delay(index * 100).fadeIn(500);
        });

        // Add tooltip to buttons
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection