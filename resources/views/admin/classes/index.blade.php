@extends('layouts.admin')
<br> <br> <br> <br> <br> <br>
<br> <br> <br>

@section('content')
    <h2>Liste des Classes</h2>
<br> <br> <br> <br> <br>
    @foreach($classes as $classe)
        <div style="margin-bottom: 10px">
            <strong>{{ $classe->nom }}</strong>
            <a href="{{ route('admin.classes.eleves', ['anneeId'=>$annee->id,'classeId'=>$classe->id]) }} " class="btn btn-primary">Voir les élèves</a>
        </div>
    @endforeach
@endsection
