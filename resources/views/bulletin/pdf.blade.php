<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Bulletin Scolaire -{{ $eleve->user->prenom }} {{ $eleve->user->nom }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 15px;
            font-size: 12px;
        }

        .container {
            width: 100%;
            max-width: 100%;
        }

        .period-title {
            color: #2c3e50;
            font-size: 16px;
            margin: 15px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #3498db;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .table th {
            background-color: #34495e;
            color: white;
            padding: 8px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #ddd;
        }

        .table td {
            padding: 6px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 10px;
            min-width: 30px;
        }

        .bg-success {
            background-color: #27ae60;
            color: white;
        }

        .bg-danger {
            background-color: #e74c3c;
            color: white;
        }

        .bg-warning {
            background-color: #f39c12;
            color: white;
        }

        .bg-primary {
            background-color: #3498db;
            color: white;
        }

        .bg-info {
            background-color: #2980b9;
            color: white;
        }

        .bg-secondary {
            background-color: #7f8c8d;
            color: white;
        }

        .text-dark {
            color: #2c3e50 !important;
        }

        .text-white {
            color: white !important;
        }

        .text-start {
            text-align: left !important;
        }

        .fw-bold {
            font-weight: bold !important;
        }

        .results-summary {
            margin-top: 15px;
            padding: 10px;
            background-color: #ecf0f1;
            border-radius: 5px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 18px;
        }

        .student-info {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .page-break {
            page-break-after: always;
        }

        .no-break {
            page-break-inside: avoid;
        }

        @page {
            margin: 15mm;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header no-break">
            <h1>BULLETIN SCOLAIRE</h1>
            <p>Année Scolaire: {{ $annee->libelle }}</p>
        </div>

        <div class="student-info no-break">
            <strong>Élève:</strong> {{ $eleve->user->prenom }} {{ $eleve->user->nom }} <br>
            <strong>Classe:</strong> {{ $eleve->classe->nom ?? 'Non spécifiée' }}
        </div>

        @if ($bulletins->isEmpty())
            <div style="text-align: center; padding: 20px;">
                Aucun bulletin disponible pour cette année scolaire.
            </div>
        @else
            @php
                $groupes = $bulletins->groupBy('periode_id');
                $totalPeriodes = count($groupes);
                $sommeMoyennesPeriodes = 0;
            @endphp

            @foreach ($groupes as $periodeId => $bulletinsParMatiere)
                @php
                    $periode = $bulletinsParMatiere->first()->periode;
                    $totalCoefficients = 0;
                    $totalMoyennesCoeff = 0;
                @endphp

                <h4 class="period-title no-break">Période : {{ $periode->nom }}</h4>

                <table class="table table-striped no-break">
                    <thead>
                        <tr>
                            <th>Matière</th>
                            <th>Interro 1</th>
                            <th>Interro 2</th>
                            <th>Interro 3</th>
                            <th>Moy Interros</th>
                            <th>Devoir 1</th>
                            <th>Devoir 2</th>
                            <th>Moy Devoirs</th>
                            <th>Moyenne</th>
                            <th>Coeff</th>
                            <th>Moy Coeff</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bulletinsParMatiere as $bulletin)
                            @php
                                $noteData = $notes[$bulletin->periode_id][$bulletin->matiere_id] ?? [
                                    'interro1' => null,
                                    'interro2' => null,
                                    'interro3' => null,
                                    'devoir1' => null,
                                    'devoir2' => null,
                                    'moy_interros' => 0,
                                    'moy_devoirs' => 0,
                                    'moyenne' => 0,
                                    'coefficient' => 1,
                                    'moyenne_coeff' => 0
                                ];
                                
                                $totalCoefficients += $noteData['coefficient'];
                                $totalMoyennesCoeff += $noteData['moyenne_coeff'];
                            @endphp
                            <tr>
                                <td class="text-start">{{ $bulletin->matiere->nom }}</td>
                                <td>{{ $noteData['interro1'] ? number_format($noteData['interro1'], 2) : '-' }}</td>
                                <td>{{ $noteData['interro2'] ? number_format($noteData['interro2'], 2) : '-' }}</td>
                                <td>{{ $noteData['interro3'] ? number_format($noteData['interro3'], 2) : '-' }}</td>
                                <td class="fw-bold">{{ number_format($noteData['moy_interros'], 2) }}</td>
                                <td>{{ $noteData['devoir1'] ? number_format($noteData['devoir1'], 2) : '-' }}</td>
                                <td>{{ $noteData['devoir2'] ? number_format($noteData['devoir2'], 2) : '-' }}</td>
                                <td class="fw-bold">{{ number_format($noteData['moy_devoirs'], 2) }}</td>
                                <td class="fw-bold">{{ number_format($noteData['moyenne'], 2) }}</td>
                                <td>{{ $noteData['coefficient'] }}</td>
                                <td class="fw-bold">{{ number_format($noteData['moyenne_coeff'], 2) }}</td>
                            </tr>
                        @endforeach

                        @php
                            $moyennePeriodique = $totalCoefficients > 0 ? $totalMoyennesCoeff / $totalCoefficients : 0;
                            $sommeMoyennesPeriodes += $moyennePeriodique;
                        @endphp

                        <tr style="background-color: #f0f8ff;">
                            <td colspan="8" class="text-end fw-bold">Totaux :</td>
                            <td class="fw-bold">{{ number_format($moyennePeriodique, 2) }}</td>
                            <td class="fw-bold">{{ $totalCoefficients }}</td>
                            <td class="fw-bold">{{ number_format($totalMoyennesCoeff, 2) }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="results-summary no-break">
                    <p><strong>Moyenne Générale de la Période :</strong>
                        <span class="badge bg-info">{{ number_format($moyennePeriodique, 2) }}/20</span>
                    </p>
                    <p><strong>Rang Général de la Période :</strong>
                        <span class="badge bg-secondary">{{ $bulletinsParMatiere->first()->rang_periodique ?? '-' }}</span>
                    </p>
                </div>

                @if (!$loop->last)
                    <div class="page-break"></div>
                @endif
            @endforeach
        @endif

        @php
            $moyenneAnnuelle = $totalPeriodes > 0 ? $sommeMoyennesPeriodes / $totalPeriodes : 0;
        @endphp

        <div class="results-summary no-break">
            <p><strong>Moyenne Annuelle:</strong>
                <span class="badge bg-primary" style="font-size: 14px;">
                    {{ number_format($moyenneAnnuelle, 2) }}/20
                </span>
            </p>
            <p><strong>Rang Annuel:</strong>
                <span class="badge bg-secondary" style="font-size: 14px;">
                    {{ $rangAnnuel ?? '-' }}
                </span>
            </p>
        </div>

        <div>
            <p><strong>Effectif de la classe:</strong> {{ $effectifClasse }} élèves</p>
            <p><strong>Nombre de périodes:</strong> {{ $totalPeriodes }}</p>
        </div>
    </div>
    <div style="margin-top: 30px; text-align: center; font-size: 10px; color: #7f8c8d;">
        Document généré le {{ now()->format('d/m/Y à H:i') }} - Valable uniquement avec le cachet de l'établissement
    </div>
</body>

</html>
