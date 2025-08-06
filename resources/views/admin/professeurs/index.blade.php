@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-primary">
            <i class="bi bi-person-badge me-2"></i>Liste des professeurs
        </h3>
        <div class="input-group" style="max-width: 300px;">
            <input type="text" class="form-control" placeholder="🔍 Rechercher..." id="searchInput">
            <button class="btn btn-outline-secondary" type="button">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <div class="table-responsive animate__animated animate__fadeInUp">
        <table class="table table-striped table-hover align-middle shadow-sm rounded" id="usersTable">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Téléphone</th>
                    <th>Date de naissance</th>
                    <th>Email</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($professeurs as $prof)
                    <tr>
                        <td>{{ $prof->user->nom }}</td>
                        <td>{{ $prof->user->prenom }}</td>
                        <td>{{ $prof->user->telephone }}</td>
                        <td>{{ $prof->user->date_de_naissance }}</td>
                        <td>{{ $prof->user->email }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.professeurs.affectation', $prof->id) }}"
                               class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-journal-plus me-1"></i>Affecter
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('searchInput').addEventListener('keyup', function () {
        const value = this.value.toLowerCase();
        const rows = document.querySelectorAll('#usersTable tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(value) ? '' : 'none';
        });
    });
</script>
@endsection
