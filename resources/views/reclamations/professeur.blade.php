@extends('layouts.app')

@section('content')

<div class="container">

    <h3>Réclamations reçues</h3>
    @forelse ($reclamations as $reclamation)

        <div class="card my-3">
               <br><br>   <br><br>
            <div class="card-body">
                <p><strong>Élève :</strong> {{ $reclamation->eleve->user->name }}</p>
                <p><strong>Matière :</strong> {{ $reclamation->matiere->nom }}</p>
                <p><strong>Période :</strong> {{ $reclamation->periode->nom ?? '-' }}</p>
                <p><strong>Type :</strong> {{ $reclamation->type }}</p>
                <p><strong>Description :</strong> {{ $reclamation->description }}</p>
                <p><strong>Statut :</strong> {{ $reclamation->statut }}</p>
            </div>
        </div>
    @empty
        <p>Aucune réclamation trouvée.</p>
    @endforelse
</div>
@endsection
