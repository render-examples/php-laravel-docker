@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Tableau de bord administrateur</h2>
        <h5 class="mb-4 text-dark">Validation - Supression - Désactivation</h5>

        <div class="row mb-4 ">
            <div class="col-md-4 mb-3">
                <div class="card dashboard-card bg-success text-white">
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <i class="fas fa-user-clock card-icon"></i>
                        <h5 class="card-title">Demandes en attente</h5>
                        <h3 class="card-text">{{ $counts['pending'] }}</h3>
                        <a href="{{ route('admin.users.pending') }}" class="btn btn-outline-light btn-sm mt-2">Voir demandes</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card dashboard-card bg-success text-white">
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <i class="fas fa-users card-icon"></i>
                        <h5 class="card-title">Utilisateurs actifs</h5>
                        <h3 class="card-text">{{ $counts['active'] }}</h3>
                        <a href="{{ route('admin.users.active') }}" class="btn btn-outline-light btn-sm mt-2">Voir utilisateurs</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <br>
            <h5 class="mb-4 text-dark">Ajouter-Année-Période</h5>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card dashboard-card bg-black text-white">
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <i class="fas fa-calendar card-icon"></i>
                            <h5 class="card-title">Ajouter/Modifier année</h5>
                            <h3 class="card-text"></h3>
                            <a href="{{ route('admin.annees.index') }}" class="btn btn-outline-light btn-sm mt-2">Voir années</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div
                        class="card dashboard-card bg-black shadow-sm border-0 h-100 animate__animated animate__fadeInUp text-white">
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <i class="fas fa-clock fa-2x mb-3"></i>
                            <h5 class="card-title">Gérer les Périodes</h5>
                            <a href="{{ route('admin.periodes.index') }}" class="btn btn-outline-light btn-sm mt-2">Voir les périodes</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card mb-4">
            <br>
            <h5 class="mb-4 text-dark">Affectation-Elèves-Professeurs</h5>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card dashboard-card bg-warning text-white">
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <i class="fas fa-compass card-icon"></i>
                            <h5 class="card-title">Affectation professeurs</h5>
                            <h3 class="card-text"></h3>
                            <a href="{{ route('professeurs.index') }}" class="btn btn-outline-light btn-sm mt-2">Voir professeurs</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card dashboard-card bg-warning text-white">
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <i class="fas fa-user-graduate card-icon"></i>
                            <h5 class="card-title">Affectation élèves</h5>
                            <h3 class="card-text"></h3>
                            <a href="{{ route('admin.affectation.annees') }}" class="btn btn-outline-light btn-sm mt-2">Voir élèves</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card dashboard-card bg-warning text-white">
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <i class="fas fa-envelope card-icon"></i>
                            <h5 class="card-title">Gestion des réclamations</h5>
                            <h3 class="card-text"></h3>
                            <a href="{{ route('admin.reclamations.admin') }}" class="btn btn-outline-light btn-sm mt-2">Voir
                                plus</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>



    <div class="card mb-4">
        <br>
        <h5 class="mb-4 text-dark">Modifier comptes</h5>

        <div class="col-md-4 mb-3">
            <div class="card dashboard-card bg-danger text-white">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <i class="fas fa-edit card-icon"></i>
                    <h5 class="card-title">Modifier les comptes utilisateurs</h5>
                    <h3 class="card-text"></h3>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light btn-sm mt-2">Voir utilisteurs</a>
                </div>
            </div>
        </div>

    </div>
    </div>
@endsection
