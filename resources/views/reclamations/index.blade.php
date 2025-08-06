@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Réclamations reçues</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($reclamations->isEmpty())
        <div class="alert alert-info">
            Aucune réclamation trouvée.
        </div>
    @else
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Élève</th>
                                <th>Matière</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reclamations as $reclamation)
                            <tr>
                                <td>{{ $reclamation->eleve->user->nom }} {{ $reclamation->eleve->user->prenom }}</td>
                                <td>{{ $reclamation->matiere->nom }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $reclamation->type)) }}</td>
                                <td>{{ $reclamation->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{
                                        $reclamation->statut == 'resolue' ? 'success' :
                                        ($reclamation->statut == 'rejetee' ? 'danger' :
                                        ($reclamation->statut == 'nouvelle_admin' ? 'primary' : 'warning'))
                                    }}">
                                        {{ ucfirst(str_replace('_', ' ', $reclamation->statut)) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                       data-bs-target="#reclamationModal{{ $reclamation->id }}">
                                        <i class="fas fa-eye"></i> Traiter
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Modals -->
@foreach($reclamations as $reclamation)
<div class="modal fade" id="reclamationModal{{ $reclamation->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Détails de la réclamation #{{ $reclamation->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <h6>Informations de base</h6>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Élève :</strong> {{ $reclamation->eleve->user->nom }} {{ $reclamation->eleve->user->prenom }}</p>
                            <p><strong>Classe :</strong> {{ $reclamation->eleve->classe->nom ?? 'Non spécifié' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Matière :</strong> {{ $reclamation->matiere->nom }}</p>
                            <p><strong>Période :</strong> {{ $reclamation->periode->nom }}</p>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6>Détails de la réclamation</h6>
                    <hr>
                    <p><strong>Type :</strong> {{ ucfirst(str_replace('_', ' ', $reclamation->type)) }}</p>
                    <p><strong>Type d'évaluation :</strong> {{ $reclamation->type_evaluation }}</p>
                    <p><strong>Description :</strong></p>
                    <div class="border p-3 bg-light rounded">
                        {{ $reclamation->description }}
                    </div>
                </div>

                @if($reclamation->note)
                <div class="mb-4">
                    <h6>Détails de la note</h6>
                    <hr>
                    <p><strong>Note actuelle :</strong> {{ $reclamation->note->valeur }}</p>
                    <p><strong>Type :</strong> {{ $reclamation->note->type_evaluation }}</p>
                    <p><strong>Nom :</strong> {{ $reclamation->note->nom_evaluation }}</p>
                </div>
                @endif

                <form method="POST" action="{{ route('reclamations.profResponse', $reclamation) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Type de réponse</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="response_type"
                                   id="directResponse{{ $reclamation->id }}" value="direct" checked>
                            <label class="form-check-label" for="directResponse{{ $reclamation->id }}">
                                Réponse directe à l'élève
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="response_type"
                                   id="adminRequest{{ $reclamation->id }}" value="admin_request">
                            <label class="form-check-label" for="adminRequest{{ $reclamation->id }}">
                                Demande de modification à l'admin
                            </label>
                        </div>
                    </div>

                    <div class="mb-3" id="responseMessageContainer{{ $reclamation->id }}">
                        <label for="response_message{{ $reclamation->id }}" class="form-label">Message</label>
                        <textarea name="response_message" id="response_message{{ $reclamation->id }}"
                                  class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="mb-3 d-none" id="newNoteContainer{{ $reclamation->id }}">
                        <label for="proposed_new_note{{ $reclamation->id }}" class="form-label">Nouvelle note proposée</label>
                        <input type="number" step="0.01" min="0" max="20"
                               name="proposed_new_note" id="proposed_new_note{{ $reclamation->id }}"
                               class="form-control" value="{{ $reclamation->note->valeur ?? '' }}">
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i> Envoyer la réponse
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion de l'affichage des champs en fonction du type de réponse
        const setupModal = (modalId) => {
            const modal = document.getElementById(modalId);
            if (!modal) return;

            const directResponse = modal.querySelector('input[value="direct"]');
            const adminRequest = modal.querySelector('input[value="admin_request"]');
            const newNoteContainer = modal.querySelector('#newNoteContainer' + modalId.replace('reclamationModal', ''));
            const responseMessageContainer = modal.querySelector('#responseMessageContainer' + modalId.replace('reclamationModal', ''));

            const toggleFields = () => {
                if (directResponse.checked) {
                    newNoteContainer.classList.add('d-none');
                    responseMessageContainer.querySelector('label').textContent = 'Réponse à l\'élève';
                } else {
                    newNoteContainer.classList.remove('d-none');
                    responseMessageContainer.querySelector('label').textContent = 'Justification pour l\'admin';
                }
            };

            directResponse.addEventListener('change', toggleFields);
            adminRequest.addEventListener('change', toggleFields);
            toggleFields();
        };

        // Initialiser chaque modal
        @foreach($reclamations as $reclamation)
        setupModal('reclamationModal{{ $reclamation->id }}');
        @endforeach
    });
</script>
@endpush
@endsection
