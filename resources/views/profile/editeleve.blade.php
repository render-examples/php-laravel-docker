@extends('layouts.app')

@section('content')
    <br><br><br><br>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h3><i class="fas fa-user-edit me-2"></i> Modifier mon profil</h3>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" value="{{ $user->nom }}"
                                    readonly>
                            </div>

                            <div class="mb-3">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input type="text" class="form-control" id="prenom" value="{{ $user->prenom }}"
                                    readonly>
                            </div>

                            <div class="mb-3">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="text" class="form-control @error('telephone') is-invalid @enderror"
                                    id="telephone" name="telephone" value="{{ old('telephone', $user->telephone) }}">
                                @error('telephone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="date_de_naissance" class="form-label">Date de naissance actuelle</label>
                                <input type="text" class="form-control" value="{{ $user->date_de_naissance }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="new_date_de_naissance" class="form-label">Nouvelle date de naissance (laisser
                                    vide si inchangée)</label>
                                <input type="date" class="form-control @error('date_de_naissance') is-invalid @enderror"
                                    id="new_date_de_naissance" name="date_de_naissance"
                                    value="{{ old('date_de_naissance') }}">

                                @error('date_de_naissance')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('bulletin.index') }}" class="btn btn-outline-dark me-md-2">
                                    <i class="fas fa-tachometer-alt me-1"></i> Retour a l'acceuil
                                </a>

                                <button type="submit" class="btn btn-primary"
                                    onclick="return confirm('Seuls les champs remplis seront modifiés. Continuer?')">
                                    <i class="fas fa-save me-1"></i> Enregistrer les modifications
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border-radius: 10px;
            overflow: hidden;
        }

        .card-header {
            font-weight: 600;
        }

        .form-control:read-only {
            background-color: #f8f9fa;
        }
    </style>
@endsection
