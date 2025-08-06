@extends('layouts.admin')
<br> <br> <br> <br> <br> <br> <br>
@section('content')
    <h2>Élèves de la classe {{ $classe->nom }}</h2>

    <ul>
        @foreach($eleves as $eleve)
            <li>{{ $eleve->user->prenom }} {{ $eleve->user->nom }} - Moyenne : {{$eleve->calculerMoyenneAnnuelle() }}</li>
        @endforeach
    </ul>

    <a href="{{ route('migration.index', [$classe->id,$annee->id]) }}" class="btn btn-primary mt-4">
        Voir plus ->
    </a>
@endsection
