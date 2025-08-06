@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Déposer une réclamation</h4>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reclamations.store', $bulletin) }}" id="reclamationForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="matiere_id" class="form-label">Matière concernée <span class="text-danger">*</span></label>
                                <select class="form-select" id="matiere_id" name="matiere_id" required>
                                    <option value="">Sélectionnez une matière...</option>
                                    @foreach ($matieres as $matiere)
                                        <option value="{{ $matiere->id }}" @selected(old('matiere_id') == $matiere->id)>
                                            {{ $matiere->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type_evaluation" class="form-label">Type d'évaluation <span class="text-danger">*</span></label>
                                <select class="form-select @error('type_evaluation') is-invalid @enderror"
                                        id="type_evaluation" name="type_evaluation" required>
                                    <option value="">Sélectionnez un type...</option>
                                    <option value="interro1" {{ old('type_evaluation') == 'interro1' ? 'selected' : '' }}>Interrogation 1</option>
                                    <option value="interro2" {{ old('type_evaluation') == 'interro2' ? 'selected' : '' }}>Interrogation 2</option>
                                    <option value="interro3" {{ old('type_evaluation') == 'interro3' ? 'selected' : '' }}>Interrogation 3</option>
                                    <option value="devoir1" {{ old('type_evaluation') == 'devoir1' ? 'selected' : '' }}>Devoir 1</option>
                                    <option value="devoir2" {{ old('type_evaluation') == 'devoir2' ? 'selected' : '' }}>Devoir 2</option>
                                </select>
                                @error('type_evaluation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="periode_id" class="form-label">Période <span class="text-danger">*</span></label>
                                <select class="form-select" id="periode_id" name="periode_id" required>
                                    <option value="">Sélectionnez une période...</option>
                                    @foreach ($periodes as $periode)
                                        <option value="{{ $periode->id }}" @selected(old('periode_id') == $periode->id)>
                                            {{ $periode->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="annee_academique_id" class="form-label">Année académique <span class="text-danger">*</span></label>
                                <select class="form-select" id="annee_academique_id" name="annee_academique_id" required>
                                    <option value="">Sélectionnez une année...</option>
                                    @foreach ($annees as $annee)
                                        <option value="{{ $annee->id }}" @selected(old('annee_academique_id') == $annee->id)>
                                            {{ $annee->libelle }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Type de réclamation <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Sélectionnez un type...</option>
                                <option value="omission" @selected(old('type') == 'omission')>Note manquante</option>
                                <option value="erreur_saisie" @selected(old('type') == 'erreur_saisie')>Erreur de saisie</option>
                                <option value="autre" @selected(old('type') == 'autre')>Autre problème</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description détaillée <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-paper-plane me-1"></i> Envoyer la réclamation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reclamationForm');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Envoi en cours...';

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                alert('Réclamation enregistrée.');
            }
        })
        .catch(error => {
            console.error('Erreur lors de l\'envoi :', error);
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-1"></i> Envoyer la réclamation';
        });
    });
});
</script>
@endsection
