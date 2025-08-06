@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Demandes en attente</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-white">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h6 class="m-0 font-weight-bold text-primary">Liste des demandes</h6>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                Filtre
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="?type=eleve">Élèves</a>
                                <a class="dropdown-item" href="?type=professeur">Professeurs</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('admin.users.pending') }}">Tous</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card-body">
                @if ($users->isEmpty())
                    <div class="alert alert-info">Aucune demande en attente pour le moment.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->prenom }} {{ $user->nom }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->eleve)
                                                <span class="badge bg-primary">Élève</span>
                                            @elseif($user->professeur)
                                                <span class="badge bg-success">Professeur</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                        <td>


                                            <div class="d-flex flex-column gap-2">

                                                <a href="{{ route('admin.users.show', $user->id) }}"
                                                    class="btn btn-sm btn-info mr-2">
                                                    <i class="fas fa-eye"></i> Details
                                                </a>


                                                <form method="POST" action="{{ route('admin.users.approve', $user->id) }}"
                                                    class="d-inline">
                                                    @csrf

                                                    <button type="submit" class="btn btn-success btn-sm w-100">
                                                        <i class="fas fa-check"></i> Approuver
                                                    </button>
                                                </form>

                                                <button class="btn btn-sm btn-danger" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#rejectForm-{{ $user->id }}" aria-expanded="false"
                                                    aria-controls="rejectForm-{{ $user->id }}">
                                                    <i class="fas fa-times"></i> Rejeter
                                                </button>

                                                <div class="collapse" id="rejectForm-{{ $user->id }}">
                                                    <form action="{{ route('admin.users.reject', $user->id) }}"
                                                        method="POST" class="mt-2">
                                                        @csrf

                                                        <div class="mb-2">
                                                            <textarea name="reason" class="form-control" placeholder="Motif du rejet" required></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-danger w-100">
                                                            Confirmer le rejet
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
