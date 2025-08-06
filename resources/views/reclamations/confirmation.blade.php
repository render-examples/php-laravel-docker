@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <div class="alert alert-success">
        <h4 class="mb-3">Réclamation envoyée avec succès !</h4>
        <p>Votre réclamation a bien été enregistrée. Vous recevrez une réponse sous peu.</p>
        <a href="{{ route('reclamations.index') }}" class="btn btn-primary mt-3">
            <i class="fas fa-list me-1"></i> Voir mes réclamations
        </a>
    </div>
</div>
@endsection
