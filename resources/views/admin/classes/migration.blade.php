@extends('layouts.admin')
<br> <br> <br> <br> <br> <br>
<br> <br> <br> <br> <br> <br>
@section('content')
    <h2>Migrer les élèves admissibles de la classe {{ $classe->nom }}</h2>

    @if($eleves->isEmpty())
        <p>Aucun élève avec une moyenne annuelle ≥ 10.</p>
    @else
        <form method="POST" action="{{ route('admin.classes.migrer', $classe->id) }}">
            @csrf

            <table class="table">
                <thead>
                    <tr>
                        <th>Sélectionner</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Moyenne annuelle</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eleves as $eleve)
                        <tr>
                            <td><input type="checkbox" name="eleves[]" value="{{ $eleve->id }}" checked></td>
                            <td>{{ $eleve->nom }}</td>
                            <td>{{ $eleve->prenom }}</td>
                            <td>{{ $eleve->moyenne_annuelle }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <label for="nouvelle_classe_id">Nouvelle classe :</label>
            <select name="nouvelle_classe_id" required>
                @foreach($autresClasses as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-success mt-3">Confirmer la migration</button>
        </form>
    @endif
@endsection
