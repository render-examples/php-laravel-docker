@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h2 class="fw-bold">📚 Résultats fin d'année</h2>
        <p class="lead">
            Année scolaire : <span class="badge bg-primary">{{ $annee->libelle }}</span>
        </p>
        <p class="text-muted">Veuillez sélectionner une classe pour afficher les résultats</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="list-group shadow animate__animated animate__fadeInUp">
                @forelse($classes as $classe)
                    <a href="{{ route('admin.resultats.eleves', ['anneeId' => $annee->id, 'classeId' => $classe->id]) }}"
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-person-lines-fill me-2 text-secondary"></i>{{ $classe->nom }}</span>
                        <i class="bi bi-chevron-right text-muted"></i>
                    </a>
                @empty
                    <div class="alert alert-warning text-center">
                        Aucune classe disponible pour cette année.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
