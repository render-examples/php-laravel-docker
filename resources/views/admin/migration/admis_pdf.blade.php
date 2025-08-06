<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Élèves Admis - {{ $classe->nom }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h3>Élèves Admis (Moyenne ≥ 10)</h3>
    <p>Classe : {{ $classe->nom }}</p>
    <p>Année : {{ $annee->libelle }}</p>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Moyenne Générale</th>
            </tr>
        </thead>
        <tbody>
            @foreach($elevesAdmis as $eleve)
                <tr>
                    <td>{{ $eleve->user->nom }}</td>
                    <td>{{ $eleve->user->prenom }}</td>
                    <td>{{ number_format($eleve->moyenne_generale, 2) }}/20</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
