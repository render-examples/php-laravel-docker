@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Liste des Périodes Académiques</h2>

        <a href="{{ route('admin.periodes.create') }}" class="btn btn-primary mb-3 animate__animated animate__fadeInDown">+
            Ajouter une période</a>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif


        <div class="table-responsive animate__animated animate__fadeIn">
            <table class="table table-striped table-hover shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Ordre</th>
                        <th>Nom</th>
                        <th>Date début</th>
                        <th>Date fin</th>
                        <th>Année académique</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($periodes as $periode)
                        <tr>
                            <td>{{ $periode->id }}</td>
                            <td>{{ $periode->nom }}</td>
                            <td>{{ $periode->date_debut }}</td>
                            <td>{{ $periode->date_fin }}</td>
                            <td>{{ $periode->annee->libelle }}</td>
                            <td>
                                <a href="{{ route('admin.periodes.edit', $periode->id) }}"
                                    class="btn btn-sm btn-warning">Modifier</a>
                                <form action="{{ route('admin.periodes.destroy', $periode->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Supprimer cette période ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
