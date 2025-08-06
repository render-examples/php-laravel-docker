@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Ajouter une Période Académique</h2>

    <form action="{{ route('admin.periodes.store') }}" method="POST" class="card p-4 shadow-lg animate__animated animate__fadeInRight">
        @csrf

        <div class="mb-3">
            <label for="annee_academique_id" class="form-label">Année académique</label>
            <select name="annee_academique_id" class="form-select" required>
                <option value="">-- Sélectionnez une année --</option>
                @foreach ($annees as $annee)
                    <option value="{{ $annee->id }}">{{ $annee->libelle }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="nom" class="form-label">Nom de la période</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="date_debut" class="form-label">Date de début</label>
                <input type="date" name="date_debut" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="date_fin" class="form-label">Date de fin</label>
                <input type="date" name="date_fin" class="form-control" required>
            </div>
        </div>

        <button type="submit" class="btn btn-success w-100">Enregistrer</button>
    </form>
</div>
@endsection
