@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Modifier la Période : {{ $periode->nom }}</h2>

    <form action="{{ route('admin.periodes.update', $periode->id) }}" method="POST" class="card p-4 shadow-lg animate__animated animate__fadeInLeft">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Année académique</label>
            <input type="text" class="form-control" value="{{ $periode->annee->libelle }}" readonly>
            <input type="hidden" name="annee_academique_id" value="{{ $periode->annee_academique_id }}">
        </div>

        <div class="mb-3">
            <label for="nom" class="form-label">Nom de la période</label>
            <input type="text" name="nom" class="form-control" value="{{ $periode->nom }}" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="date_debut" class="form-label">Date de début</label>
                <input type="date" name="date_debut" class="form-control" value="{{ $periode->date_debut }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="date_fin" class="form-label">Date de fin</label>
                <input type="date" name="date_fin" class="form-control" value="{{ $periode->date_fin }}" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
    </form>
</div>
@endsection
