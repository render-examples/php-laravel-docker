@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="text-center mb-5">
        <h2 class="fw-bold">📊 Résultats fin d'année</h2>
        <p class="lead text-muted">
            Classe <span class="badge bg-primary">{{ $classe->nom }}</span> —
            Année <span class="badge bg-secondary">{{ $annee->libelle }}</span>
        </p>
    </div>
    <form method="GET" action="{{ route('admin.resultats.eleves', ['anneeId' => $annee->id, 'classeId' => $classe->id]) }}" class="mb-4">
    <div class="input-group">
        <label class="input-group-text" for="seuil">Moyenne de base</label>
        <input type="number" step="0.01" name="seuil" id="seuil" class="form-control" value="{{ request('seuil', 10) }}">
        <button type="submit" class="btn btn-primary">Filtrer</button>
    </div>
</form>
<p>
    <strong>Seuil de moyenne utilisé :</strong> {{ number_format($seuilAdmission, 2) }}/20
</p>


    {{-- Élèves Admis --}}
    <div class="card shadow mb-5 animate__animated animate__fadeInLeft">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">✅ Élèves Admis (Moyenne ≥  {{ number_format($seuilAdmission, 2) }})</h4>
        </div>
        <div class="card-body">
            @if($elevesAdmis->isEmpty())
                <div class="alert alert-warning">Aucun élève admis</div>
            @else
                <ul class="list-group list-group-flush mb-4">
                    @foreach($elevesAdmis as $eleve)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $eleve->user->prenom }} {{ $eleve->user->nom }}</span>
                            <span class="badge bg-success fs-6">{{ number_format($eleve->moyenne_generale, 2) }}/20</span>
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('admin.migration.export.admis', [$annee->id, $classe->id]) }}?seuil={{ $seuilAdmission }}"
   class="btn btn-success mb-4">
    Télécharger PDF Admis
</a>
            @endif
        </div>
    </div>

    {{-- Élèves Non Admis --}}
    <div class="card shadow animate__animated animate__fadeInRight">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">❌ Élèves Non Admis (Moyenne &lt;  {{ number_format($seuilAdmission, 2) }})</h4>
        </div>
        <div class="card-body">
            @if($elevesRefuses->isEmpty())
                <div class="alert alert-success">Aucun élève non admis</div>
            @else
                <ul class="list-group list-group-flush mb-4">
                    @foreach($elevesRefuses as $eleve)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $eleve->user->prenom }} {{ $eleve->user->nom }}</span>
                            <span class="badge bg-danger fs-6">{{ number_format($eleve->moyenne_generale, 2) }}/20</span>
                        </li>
                    @endforeach
                </ul>
               <a href="{{ route('admin.migration.export.refuses', [$annee->id, $classe->id]) }}?seuil={{ $seuilAdmission }}"
   class="btn btn-danger mb-4">
    Télécharger PDF Non Admis
</a>
            @endif
        </div>
    </div>
</div>
@endsection
