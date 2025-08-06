@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-lg">
            <div class="card-header bg-admin">
                <h3 class="mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Réclamations en attente de traitement
                </h3>
                <br>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <div class="card-body">
                @if ($reclamations->isEmpty())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Aucune réclamation en attente de traitement.
                    </div>
                @else
                    <div class="table-responsive">

                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Professeur</th>
                                    <th>Élève</th>
                                    <th>Matière</th>
                                    <th>Période</th>
                                    <th>Évaluation</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reclamations as $reclamation)
                                    <tr>
                                        <td>{{ $reclamation->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $reclamation->professeur->user->nom ?? 'N/A' }}</td>
                                        <td>{{ $reclamation->eleve->user->nom }} {{ $reclamation->eleve->user->prenom }}
                                        </td>
                                        <td>{{ $reclamation->matiere->nom }}</td>
                                        <td>{{ $reclamation->periode->nom }}</td>
                                        <td>{{ ucfirst($reclamation->type_evaluation) }}
                                            ({{ $reclamation->note->nom_evaluation ?? 'N/A' }})
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#traitementModal{{ $reclamation->id }}">
                                                <i class="fas fa-edit"></i> Traiter
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Traitement -->
                                    <div class="modal fade" id="traitementModal{{ $reclamation->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title">Traitement de la réclamation</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.reclamations.unlock', $reclamation) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <h6>Description :</h6>
                                                            <p>{{ $reclamation->description }}</p>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <h6>Note actuelle :</h6>
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <p><strong>Valeur :</strong>
                                                                            {{ $reclamation->note->valeur ?? 'N/A' }}</p>
                                                                        <p><strong>Statut :</strong>
                                                                            @if ($reclamation->note && $reclamation->note->is_locked)
                                                                                <span
                                                                                    class="badge bg-danger">Verrouillée</span>
                                                                            @else
                                                                                <span
                                                                                    class="badge bg-success">Déverrouillée</span>
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6>Informations :</h6>
                                                                <ul class="list-group">
                                                                    <li class="list-group-item">
                                                                        <strong>Professeur :</strong>
                                                                        {{ $reclamation->professeur->user->nom ?? 'N/A' }}
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <strong>Date création :</strong>
                                                                        {{ $reclamation->created_at->format('d/m/Y H:i') }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="action" class="form-label">Action</label>
                                                            <select class="form-select" name="action" id="action"
                                                                required>
                                                                <option value="accept">Accepter (déverrouiller la note)
                                                                </option>
                                                                <option value="reject">Rejeter (maintenir verrouillée)
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="reponse_admin" class="form-label">Réponse à envoyer
                                                                au professeur</label>
                                                            <textarea class="form-control" name="reponse_admin" id="reponse_admin" rows="3" required></textarea>
                                                            <small class="text-muted">Cette réponse sera envoyée au
                                                                professeur qui a fait la demande</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Annuler</button>
                                                        <button type="submit" class="btn btn-primary">Valider la
                                                            décision</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $reclamations->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
