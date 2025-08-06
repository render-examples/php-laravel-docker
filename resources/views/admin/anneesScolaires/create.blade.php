@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3>Créer une année scolaire</h3>
    <form method="POST" action="{{ route('admin.annees.store') }}">
        @csrf
        <div class="mb-3">
            <label>Nom de l'année</label>
            <input type="text" name="libelle" class="form-control" placeholder="ex: 2025-2026" required>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>
@endsection
