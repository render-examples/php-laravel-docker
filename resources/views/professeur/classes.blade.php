@extends('layouts.app')

@section('content')
<div class="professor-classes">
    <div class="container py-5">
        <div class="card shadow-lg animate__animated animate__fadeIn">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="fas fa-chalkboard-teacher me-2"></i>
                    Mes Classes - Année {{ $annee->libelle }}
                </h3>
                <span class="badge bg-light text-primary fs-6">{{ $classes->count() }} classes</span>
            </div>

            <div class="card-body">
                @if($classes->isEmpty())
                <div class="alert alert-info animate__animated animate__fadeIn">
                    <i class="fas fa-info-circle me-2"></i>
                    Vous n'êtes affecté à aucune classe pour cette année académique.
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover animate__animated animate__fadeInUp">
                        <thead class="table-light">
                            <tr>
                                <th>Classe</th>
                                <th>Série</th>
                                <th>Matières</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classes as $classeId => $affectations)
                            @php $classe = $affectations->first()->classe; @endphp
                            <tr>
                                <td>{{ $classe->nom }}</td>
                                <td>{{ $classe->serie ?? 'N/A' }}</td>
                                <td>
                                    @foreach($affectations as $affectation)
                                    <span class="badge bg-secondary me-1">{{ $affectation->matiere->nom }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('professeur.classe.eleves', ['anneeId' => $annee->id, 'classeId' => $classe->id]) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-users me-1"></i> Voir les élèves
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .professor-classes {
        background: url('../images/image_3.png') no-repeat center center fixed;
        background-size: cover;
        min-height: calc(100vh - 80px);
        padding-top: 80px;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.1);
    }

    .badge {
        font-size: 0.9em;
        padding: 0.5em 0.75em;
    }
</style>
@endsection
