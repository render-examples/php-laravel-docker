@extends('layouts.admin')

@section('content')
<div class="container">
    <h3>Élèves à migrer - Classe {{ $classe->nom }} - Année {{ $annee->libelle }}</h3>

    <form method="POST" action="{{ route('migration.calcule', [$annee->id, $classe->id]) }}">
        @csrf
        <button class="btn btn-primary">Calculer les moyennes annuelles</button>
    </form>

    <hr>

    <h4>Élèves Admis (Moyenne ≥ 10)</h4>
    <ul class="list-group mb-4">
        @forelse($elevesAdmis as $eleve)
            <li class="list-group-item">
                {{ $eleve->user->prenom }} {{ $eleve->user->nom }} - 
                <strong>Moyenne: {{ number_format($eleve->moyenne_generale, 2) }}/20</strong>
            </li>
        @empty
            <li class="list-group-item">Aucun élève admis</li>
        @endforelse
    </ul>

    <a href="{{ route('migration.export.admis', [$annee->id, $classe->id]) }}" 
       class="btn btn-success mb-4">
        Télécharger PDF Admis
    </a>

    <hr>

    <h4>Élèves Non Admis (Moyenne < 10)</h4>
    <ul class="list-group mb-4">
        @forelse($elevesRefuses as $eleve)
            <li class="list-group-item">
                {{ $eleve->user->prenom }} {{ $eleve->user->nom }} - 
                <strong>Moyenne: {{ number_format($eleve->moyenne_generale, 2) }}/20</strong>
            </li>
        @empty
            <li class="list-group-item">Aucun élève non admis</li>
        @endforelse
    </ul>

    <a href="{{ route('migration.export.refuses', [$annee->id, $classe->id]) }}" 
       class="btn btn-danger">
        Télécharger PDF Non Admis
    </a>
</div>
@endsection