@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <br><br>
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">
                    <i class="fas fa-clipboard-list me-2"></i>
                    Suivi des réclamations
                </h3>
            </div>

            <div class="card-body">
                @if ($reclamations->isEmpty())
                    <div class="alert alert-info wow animate__animated animate__fadeIn animate__delay-0.5s">
                        <i class="fas fa-info-circle me-2"></i>
                        Vous n'avez aucune réclamation en cours.
                    </div>
                @else
                    <div class="table-responsive wow animate__animated animate__fadeIn animate__delay-0.3s">
                        <table class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Élève</th>
                                    <th>Matière</th>
                                    <th>Période</th>
                                    <th>Évaluation</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reclamations as $reclamation)
                                    <tr>
                                        <td>{{ $reclamation->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $reclamation->eleve->user->nom }} {{ $reclamation->eleve->user->prenom }}
                                        </td>
                                        <td>{{ $reclamation->matiere->nom }}</td>
                                        <td>{{ $reclamation->periode->nom }}</td>
                                        <td>{{ ucfirst($reclamation->type_evaluation) }}
                                            ({{ $reclamation->note->nom_evaluation ?? 'N/A' }})</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $reclamation->statut == 'resolue' ? 'success' : ($reclamation->statut == 'rejetee' ? 'danger' : 'warning') }}">
                                                {{ ucfirst(str_replace('_', ' ', $reclamation->statut)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                data-bs-target="#detailsModal{{ $reclamation->id }}">
                                                <i class="fas fa-eye"></i> Détails
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Retour
                        </a>
                    </div>

                    <!-- Modals en dehors de la table -->
                    @foreach ($reclamations as $reclamation)
                        <div class="modal fade wow animate__animated animate__fadeIn animate__delay-1.5s"
                            id="detailsModal{{ $reclamation->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title">Détails de la réclamation -
                                            {{ $reclamation->eleve->user->nom }} {{ $reclamation->eleve->user->prenom }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <h6>Description :</h6>
                                            <p>{{ $reclamation->description }}</p>
                                        </div>

                                        @if ($reclamation->reponse_admin)
                                            <div class="mb-3">
                                                <h6>Réponse de l'administration :</h6>
                                                <div class="p-3 bg-light rounded">
                                                    <p>{{ $reclamation->reponse_admin }}</p>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Informations :</h6>
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <strong>Date création :</strong>
                                                        {{ $reclamation->created_at->format('d/m/Y H:i') }}
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Dernière mise à jour :</strong>
                                                        {{ $reclamation->updated_at->format('d/m/Y H:i') }}
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Statut :</strong>
                                                        <span
                                                            class="badge bg-{{ $reclamation->statut == 'resolue' ? 'success' : ($reclamation->statut == 'rejetee' ? 'danger' : 'warning') }}">
                                                            {{ ucfirst(str_replace('_', ' ', $reclamation->statut)) }}
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Note concernée :</h6>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <p><strong>Valeur :</strong>
                                                            {{ $reclamation->note->valeur ?? 'N/A' }}</p>
                                                        <p><strong>Type :</strong> {{ $reclamation->type_evaluation }}</p>
                                                        <p><strong>Statut :</strong>
                                                            @if ($reclamation->note && $reclamation->note->is_locked)
                                                                <span class="badge bg-danger">Verrouillée</span>
                                                            @else
                                                                <span class="badge bg-success">Déverrouillée</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
