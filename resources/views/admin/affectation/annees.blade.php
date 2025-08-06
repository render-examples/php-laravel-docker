@extends('layouts.admin')

@section('content')
    <div class="container py-4">
        <div class="mb-4 text-center">
            <h2 class="fw-bold text-white bg-primary p-3 rounded shadow-sm">
                🎓 Choisissez une année scolaire à affecter
            </h2>
        </div>

        <div class="card shadow-lg border-0">
            <div class="card-body p-0">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-primary text-center">
                        <tr>
                            <th style="width: 10%">Ordre</th>
                            <th>Année scolaire</th>
                            <th style="width: 20%">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($annees as $index => $annee)
                            <tr>
                                <td class="fw-bold">{{ $index + 1 }}</td>
                                <td class="text-dark fs-5">{{ $annee->libelle }}</td>
                                <td>
                                    <a href="{{ route('admin.affectation.classes', $annee->id) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-arrow-right"></i> Voir les classes
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        @if ($annees->isEmpty())
                            <tr>
                                <td colspan="3" class="text-muted">Aucune année scolaire disponible.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
