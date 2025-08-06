@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h3>Années scolaires</h3>
        <a href="{{ route('admin.annees.create') }}" class="btn btn-success mb-3">+ Nouvelle année</a>
        <table class="table table-bordered">
            <thead>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <tr>
                    <th>Nom</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($annees as $annee)
                    <tr>
                        <td>{{ $annee->libelle }}</td>
                        <td>
                            <a href="{{ route('admin.annees.edit', $annee->id) }}" class="btn btn-sm btn-warning"> <i
                                    class="fas fa-pen"></i> Modifier</a>
                        </td>

                        <td>
                            <form action="{{ route('admin.annees.delete', $annee->id) }}" method="POST"
                                onsubmit="return confirm('Supprimer cette année scolaire ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"> <i class="fas fa-trash"></i>
                                    Supprimer</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
