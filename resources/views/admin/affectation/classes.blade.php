@extends('layouts.admin')

@section('content')
    <div class="container py-4">
        <div class="mb-4 text-center">
            <h2 class="fw-bold text-white bg-primary p-3 rounded shadow-sm">
                🏫 Classes de l’année : <span class="text-white">{{ $annee->libelle }}</span>
            </h2>
        </div>

        <div class="row g-4">
            @foreach ($classes as $classe)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('admin.affectation.eleves', [$annee->id, $classe->id]) }}" class="text-decoration-none">
                        <div class="card class-card h-100 border-0 shadow-sm">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">
                                <i class="fas fa-users fa-2x text-primary mb-3"></i>
                                <h5 class="fw-bold text-dark mb-0">{{ $classe->nom }}</h5>
                                <small class="text-muted">Voir les élèves</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
            @if ($classes->isEmpty())
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        Aucune classe disponible pour cette année.
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .class-card {
            background: linear-gradient(145deg, #f0f9ff, #ffffff);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .class-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 10px 25px rgba(0, 128, 0, 0.15);
        }
    </style>
@endsection
