@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Utilisateurs Actifs</h1>
            <div>
                <a href="{{ route('admin.users.pending') }}" class="btn btn-secondary">
                    <i class="fas fa-user-clock me-1"></i> Voir les demandes
                </a>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-white">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h6 class="m-0 font-weight-bold text-primary">Liste des utilisateurs actifs</h6>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Rechercher..." id="searchInput">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
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
                    <div class="alert alert-info">Aucun utilisateur actif pour le moment.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="usersTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Date d'activation</th>
                                    <th>Statut</th>
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
                                            @elseif($user->is_admin)
                                                <span class="badge bg-danger">Admin</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $user->is_active ? 'success' : 'warning' }}">
                                                {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                            </span>
                                        </td>
                                        <td class="d-flex">
                                            <a href="{{ route('admin.users.show', $user->id) }}"
                                                class="btn btn-sm btn-info mr-2">
                                                <i class="fas fa-eye"></i>
                                            </a> &nbsp; &nbsp; &nbsp;


                                            @if (!$user->is_admin)
                                                <form action="{{ route('admin.users.deactivate', $user->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Êtes-vous sûr de vouloir désactiver ce compte ?')">
                                                    @csrf

                                                    <button type="submit" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-toggle-off"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            const rows = document.querySelectorAll('#usersTable tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(value) ? '' : 'none';
            });
        });
    </script>
@endsection
