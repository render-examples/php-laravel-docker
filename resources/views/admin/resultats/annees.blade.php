@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h2 class="fw-bold">📆 Résultats fin d'année</h2>
        <p class="text-muted">Veuillez sélectionner une année académique pour continuer</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="list-group shadow animate__animated animate__fadeInUp">
                @forelse($annees as $annee)
                    <a href="{{ route('admin.resultats.classes', $annee->id) }}"
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-calendar3 me-2 text-primary"></i>{{ $annee->libelle }}</span>
                        <i class="bi bi-chevron-right text-muted"></i>
                    </a>
                @empty
                    <div class="alert alert-warning text-center">
                        Aucune année académique disponible.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
