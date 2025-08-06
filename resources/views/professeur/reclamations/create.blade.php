@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <br><br><br>
        <div class="card shadow-lg border-light">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Nouvelle réclamation pour {{ $eleve->user->nom }} {{ $eleve->user->prenom }}
                </h3>
            </div>
            <br>
            @if ($errors->any())
                <div class="alert alert-danger mt-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif


            <div class="card-body">
                <form action="{{ route('reclamations.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="eleve_id" value="{{ $eleve->id }}">

                    <!-- Matière -->
                    <div class="mb-3 wow animate__animated animate__fadeIn animate__delay-0.5s">
                        <label for="matiere_id" class="form-label">Matière concernée</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                            <select class="form-select" name="matiere_id" id="matiere_id" required>
                                @foreach ($matieres as $matiere)
                                    <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Période académique -->
                    <div class="mb-3 wow animate__animated animate__fadeIn animate__delay-1s">
                        <label for="periode_id" class="form-label">Période académique</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            <select class="form-select" name="periode_id" id="periode_id" required>
                                @foreach ($periodes as $periode)
                                    <option value="{{ $periode->id }}">{{ $periode->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Type d'évaluation -->
                    <div class="mb-3 wow animate__animated animate__fadeIn animate__delay-1s">
                        <label for="type_evaluation" class="form-label">Type d'évaluation</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-pen"></i></span>
                            <select class="form-select" name="type_evaluation" id="type_evaluation" required>
                                <option value="interro1">Interrogation 1</option>
                                <option value="interro2">Interrogation 2</option>
                                <option value="interro3">Interrogation 3</option>
                                <option value="devoir1">Devoir 1</option>
                                <option value="devoir2">Devoir 2</option>
                            </select>
                        </div>
                    </div>

                    <!-- Description de la réclamation -->
                    <div class="mb-3 wow animate__animated animate__fadeIn animate__delay-2s">
                        <label for="description" class="form-label">Description de la réclamation</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                            <textarea class="form-control" name="description" id="description" rows="5" required></textarea>
                        </div>
                        <small class="text-muted mt-2">Décrivez en détail la raison de votre demande de
                            modification.</small>
                    </div>

                    <!-- Actions -->
                    <div class="text-end mt-4 wow animate__animated animate__fadeIn animate__delay-2.5s">

                           <a href="{{ route('professeur.dashboard') }}" class="btn btn-outline-dark me-md-2">
                                    <i class="fas fa-tachometer-alt me-1"></i> Retour a l'acceuil
                                </a>

                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Envoyer à l'administration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
