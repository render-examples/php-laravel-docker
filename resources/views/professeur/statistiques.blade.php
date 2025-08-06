@extends('layouts.app')

@section('content')
    <br><br><br>
    <div class="container py-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        Statistiques - {{ $classe->nom }} ({{ $annee->libelle }})
                    </h3>
                    <a href="{{ route('professeur.classe.eleves', ['anneeId' => $annee->id, 'classeId' => $classe->id]) }}"
                        class="btn btn-light">
                        <i class="fas fa-arrow-left me-1"></i> Retour
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form method="GET"
                    action="{{ route('professeur.statistiques.show', ['anneeId' => $annee->id, 'classeId' => $classe->id]) }}"
                    class="mb-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="periode_id" class="form-label">Période académique</label>
                            <select name="periode_id" id="periode_id" class="form-select" onchange="this.form.submit()">
                                @foreach ($periodes as $periode)
                                    <option value="{{ $periode->id }}"
                                        {{ $selectedPeriodeId == $periode->id ? 'selected' : '' }}>
                                        {{ $periode->nom }} ({{ $periode->date_debut }} - {{ $periode->date_fin }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="matiere_id" class="form-label">Matière (optionnel)</label>
                            <select name="matiere_id" id="matiere_id" class="form-select" onchange="this.form.submit()">
                                <option value="">...</option>
                                @foreach ($affectations as $affectation)
                                    <option value="{{ $affectation->matiere->id }}"
                                        {{ $selectedMatiereId == $affectation->matiere->id ? 'selected' : '' }}>
                                        {{ $affectation->matiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>

                @if ($selectedPeriodeId)
                    <div class="row">
                        <!-- Statistiques globales -->
                        <div class="col-md-12 mb-4">
                            <div class="card border-primary">
                                <div class="card-header bg-light">
                                    <h4 class="mb-0"><i class="fas fa-globe me-2"></i>Statistiques Globales</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 text-center">
                                            <div class="stat-card bg-success text-white p-3 rounded">
                                                <h5>Taux de Réussite</h5>
                                                <h2>
                                                    {{ $globalStats && $globalStats->total_eleves > 0
                                                        ? round(($globalStats->reussite / $globalStats->total_eleves) * 100, 2)
                                                        : '0.00' }}%
                                                </h2>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <div class="stat-card bg-danger text-white p-3 rounded">
                                                <h5>Taux d'Échec</h5>
                                                <h2>
                                                    {{ $globalStats && $globalStats->total_eleves > 0
                                                        ? round(($globalStats->echec / $globalStats->total_eleves) * 100, 2)
                                                        : '0.00' }}%
                                                </h2>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <div class="stat-card bg-info text-white p-3 rounded">
                                                <h5>Moyenne Générale</h5>
                                                <h2>{{ $globalStats ? round($globalStats->moyenne_generale, 2) : 0 }}/20
                                                </h2>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <div class="stat-card bg-warning text-dark p-3 rounded">
                                                <h5>Effectif</h5>
                                                <h2>{{ $globalStats ? $globalStats->total_eleves : 0 }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statistiques par matière si une matière est sélectionnée -->
                        @if ($selectedMatiereId && $statistics)
                            <div class="col-md-12 mb-4">
                                <div class="card border-primary">
                                    <div class="card-header bg-light">
                                        <h4 class="mb-0">
                                            <i class="fas fa-book me-2"></i>
                                            Statistiques pour
                                            {{ $affectations->firstWhere('matiere_id', $selectedMatiereId)->matiere->nom }}
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Réussite/Échec</h5>
                                                        <canvas id="successChart" height="200"></canvas>
                                                        <div class="text-center mt-2">
                                                            <span class="badge bg-success me-2">Réussite:
                                                                {{ $statistics->reussite }}</span>
                                                            <span class="badge bg-danger">Échec:
                                                                {{ $statistics->echec }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Notes Extrêmes</h5>
                                                        <div class="d-flex justify-content-between mb-3">
                                                            <div class="text-center">
                                                                <h6>Meilleure note</h6>
                                                                <h3 class="text-success">
                                                                    {{ $statistics->meilleure_note }}/20</h3>
                                                            </div>
                                                            <div class="text-center">
                                                                <h6>Pire note</h6>
                                                                <h3 class="text-danger">{{ $statistics->pire_note }}/20
                                                                </h3>
                                                            </div>
                                                        </div>
                                                        <div class="progress" style="height: 20px;">
                                                            <div class="progress-bar bg-success"
                                                                style="width: {{ ($statistics->meilleure_note / 20) * 100 }}%">
                                                            </div>
                                                            <div class="progress-bar bg-danger"
                                                                style="width: {{ max((($statistics->meilleure_note - $statistics->pire_note) / 20) * 100, 0) }}%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Moyenne de la classe</h5>
                                                        <h1 class="display-4 text-center text-primary">
                                                            {{ round($statistics->moyenne_classe, 2) }}/20
                                                        </h1>
                                                        <div class="progress mt-3" style="height: 10px;">
                                                            <div class="progress-bar bg-primary"
                                                                style="width: {{ ($statistics->moyenne_classe / 20) * 100 }}%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Taux de réussite par matière -->
                        <div class="col-md-12 mb-4">
                            <div class="card border-primary">
                                <div class="card-header bg-light">
                                    <h4 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Taux de Réussite par Matière
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <canvas id="matieresChart" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                        <h4>La listes des 3 premiers et trois derniers par période</h4>
                        <!-- Top et bottom élèves -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h4 class="mb-0"><i class="fas fa-trophy me-2"></i>Top 3 Élèves</h4>
                                </div>
                                <div class="card-body">
                                    @if ($topStudents->count() > 0)
                                        <div class="list-group">
                                            @foreach ($topStudents as $index => $student)
                                                <div
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <span class="badge bg-primary me-2">{{ $index + 1 }}</span>
                                                        {{ $student->eleve->user->prenom }}
                                                        {{ $student->eleve->user->nom }}
                                                    </div>
                                                    <span class="badge bg-success rounded-pill">
                                                        {{ round($student->moyenne, 2) }}/20
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="alert alert-warning">Aucun élève trouvé</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card border-danger">
                                <div class="card-header bg-danger text-white">
                                    <h4 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>3 Derniers Élèves
                                    </h4>
                                </div>
                                <div class="card-body">
                                    @if ($bottomStudents->count() > 0)
                                        <div class="list-group">
                                            @foreach ($bottomStudents as $index => $student)
                                                <div
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <span class="badge bg-secondary me-2">{{ $index + 1 }}</span>
                                                        {{ $student->eleve->user->prenom }}
                                                        {{ $student->eleve->user->nom }}
                                                    </div>
                                                    <span class="badge bg-danger rounded-pill">
                                                        {{ round($student->moyenne, 2) }}/20
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="alert alert-warning">Aucun élève trouvé</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Sélectionnez une période académique pour voir les statistiques
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Inclure Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($selectedMatiereId && $statistics)
                const reussite = Number(@json($statistics->reussite ?? 0));
                const echec = Number(@json($statistics->echec ?? 0));
                const total = reussite + echec;

                console.log('Reussite:', reussite);
                console.log('Echec:', echec);
                console.log('Total:', total);

                if (total > 0) {
                    const successCtx = document.getElementById('successChart').getContext('2d');
                    new Chart(successCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Réussite', 'Échec'],
                            datasets: [{
                                data: [reussite, echec],
                                backgroundColor: ['#28a745', '#dc3545'],
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                } else {
                    document.getElementById('successChart').style.display = 'none';
                    const parent = document.getElementById('successChart').parentNode;
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-info mt-3';
                    alertDiv.textContent = 'Pas de données suffisantes pour afficher le graphique réussite/échec.';
                    parent.appendChild(alertDiv);
                }
            @endif

            @if (!empty($successRates))
                const matieresCtx = document.getElementById('matieresChart').getContext('2d');
                new Chart(matieresCtx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode(array_keys($successRates)) !!},
                        datasets: [{
                            label: 'Taux de réussite (%)',
                            data: {!! json_encode(array_values($successRates)) !!},
                            backgroundColor: 'rgba(40, 167, 69, 0.7)',
                            borderColor: 'rgba(40, 167, 69, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100
                            }
                        }
                    }
                });
            @endif
        });
    </script>



    <style>
        .stat-card {
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }

        .progress {
            border-radius: 10px;
        }

        .progress-bar {
            border-radius: 10px;
        }

        #successChart {
            display: block;
            max-width: 100%;
            height: 200px !important;
            margin: 0 auto;
        }
    </style>
@endsection
