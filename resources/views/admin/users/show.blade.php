@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Détails de l'utilisateur</h1>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Retour
            </a>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 font-weight-bold text-primary">Profil</h6>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('images/default-avatar.png') }}"
                            class="rounded-circle mb-3" width="150" height="150">

                        <h4>{{ $user->prenom }} {{ $user->nom }}</h4>
                        <p class="text-muted">{{ $user->email }}</p>

                        <div class="mb-3">
                            <span class="badge bg-{{ $user->is_active ? 'success' : 'warning' }}">
                                {{ $user->is_active ? 'Compte actif' : 'Compte inactif' }}
                            </span>
                            @if ($user->is_admin)
                                <span class="badge bg-danger ms-1">Administrateur</span>
                            @endif
                        </div>

                        <hr>
                        <p class="mb-1"><strong>Créé le :</strong> {{ $user->created_at->format('d/m/Y') }}</p>
                        <p><strong>Dernière mise à jour :</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 font-weight-bold text-primary">Informations complémentaires</h6>
                    </div>

                    <br>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card-body">
                        @if ($user)
                            <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i>Informations utilisateur</h5>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <p><strong>Téléphone :</strong> {{ $user->telephone ?? 'Non spécifié' }}</p>
                                    <p><strong>Email :</strong> {{ $user->email ?? 'Non spécifié' }}</p>
                                    <p><strong>Date de naissance :</strong>
                                        {{ $user->date_de_naissance ? $user->date_de_naissance->format('d/m/Y') : 'Non spécifiée' }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        <div class="d-flex justify-content-end gap-2">
                            @if (!$user->is_active && !$user->is_admin)
                                <form method="POST" action="{{ route('admin.users.approve', $user->id) }}"
                                    class="d-inline">
                                    @csrf

                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i> Approuver
                                    </button>
                                </form>
                            @endif

                            @if (!$user->is_admin)
                                <form action="{{ route('admin.users.deactivate', $user->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir désactiver ce compte ?')">
                                    @csrf

                                    <button type="submit" class="btn btn-warning btn-sm">
                                        <i class="fas fa-toggle-off"></i> Désactiver
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
