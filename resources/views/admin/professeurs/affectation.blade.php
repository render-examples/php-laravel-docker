@extends('layouts.admin')

@section('content')
    <div class="container mt-4">


        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Erreur !</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Titre de la page --}}
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body bg-light d-flex align-items-center">
                <i class="bi bi-clipboard-check-fill fs-4 text-primary me-3"></i>
                <h3 class="mb-0 text-dark">Affecter à des classes et matières</h3>
            </div>
        </div>

        {{-- Filtres Année académique --}}
        <div class="mb-3">
            <label for="anneeFilter" class="form-label fw-bold">Filtrer par année académique :</label>
            <select id="anneeFilter" class="form-select">
                <option value="all">-- Toutes les années --</option>
                @foreach ($annees as $annee)
                    <option value="annee-{{ $annee->id }}">{{ $annee->libelle }}</option>
                @endforeach
            </select>
        </div>

        {{-- Formulaire --}}
        <form action="{{ route('admin.professeurs.affectation.update', $professeur->id) }}" method="POST">
            @csrf
            @method('PUT')

            @foreach ($annees as $annee)
                <div class="annee-section annee-{{ $annee->id }}">
                    <h4 class="text-primary">{{ $annee->libelle }}</h4>

                    @foreach ($classes as $classe)
                        <div class="card mb-3">
                            <div class="card-header fw-semibold">
                                {{ $classe->nom }} @if ($classe->serie)
                                    ({{ $classe->serie }})
                                @endif
                            </div>
                            <div class="card-body">
                                @php
                                    $matieresUniques = $classe->matieres->unique('id');
                                @endphp

                                @if ($matieresUniques->isEmpty())
                                    <p class="text-muted fst-italic">Aucune matière disponible pour cette classe.</p>
                                @endif

                                @foreach ($matieresUniques as $matiere)
                                    @php
                                        $checked = $affectations->contains(function ($aff) use (
                                            $annee,
                                            $classe,
                                            $matiere,
                                        ) {
                                            return $aff->annee_academique_id == $annee->id &&
                                                $aff->classe_id == $classe->id &&
                                                $aff->matiere_id == $matiere->id;
                                        });
                                    @endphp

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="affectations[]"
                                            value="{{ $annee->id }}-{{ $classe->id }}-{{ $matiere->id }}"
                                            id="aff_{{ $annee->id }}_{{ $classe->id }}_{{ $matiere->id }}"
                                            {{ $checked ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="aff_{{ $annee->id }}_{{ $classe->id }}_{{ $matiere->id }}">
                                            {{ $matiere->nom }} ({{ $matiere->code }})
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <button class="btn btn-success mt-3 w-100">
                <i class="bi bi-save me-2"></i> Enregistrer / Mise à jour
            </button>
        </form>
    </div>

    {{-- Script JS pour filtrage par année --}}
    <script>
        document.getElementById('anneeFilter').addEventListener('change', function() {
            const selected = this.value;
            const sections = document.querySelectorAll('.annee-section');
            sections.forEach(section => {
                if (selected === 'all' || section.classList.contains(selected)) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        });
    </script>
@endsection
