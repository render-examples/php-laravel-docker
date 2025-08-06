@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1>Modifier l'année scolaire</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.annees.update', $annee->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom de l'année scolaire</label>
            <input type="text" name="libelle" id="nom" class="form-control" value="{{ old('libelle', $annee->libelle) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('admin.annees.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
