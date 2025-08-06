@extends('layouts.app')

@section('content')
    <style>
        /* Style général */
        .bulletin-container {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* En-tête du bulletin */
        .bulletin-header {
            background: linear-gradient(135deg, #3498db, #2c3e50);
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
        }

        .bulletin-header h2 {
            margin: 0;
            font-weight: 700;
        }

        /* Tableau des notes */
        .bulletin-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 30px;
        }

        .bulletin-table th {
            background-color: #343a40;
            color: white;
            padding: 12px;
            text-align: center;
            position: sticky;
            top: 0;
        }

        .bulletin-table td {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .bulletin-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .bulletin-table tr:hover {
            background-color: #e9ecef;
            transition: background-color 0.3s;
        }

        /* Badges */
        .badge {
            font-size: 0.9em;
            padding: 5px 10px;
            border-radius: 50px;
            font-weight: 600;
        }

        /* Résultats */
        .results-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .results-container p {
            font-size: 1.1em;
            margin-bottom: 10px;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .bulletin-section {
            animation: fadeIn 0.6s ease-out forwards;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .bulletin-table {
                display: block;
                overflow-x: auto;
            }

            .bulletin-header h2 {
                font-size: 1.5em;
            }
        }
    </style>
    <br><br><br>
    <div class="container py-5">
        @if ($bulletins->isEmpty())
            <div class="alert alert-warning">
                Aucun bulletin disponible pour cette année scolaire.
            </div>
        @else
            <div class="text-end mb-4">
                <a href="{{ route('bulletin.download', $annee->id) }}" class="btn btn-primary">
                    <i class="fas fa-download"></i> Télécharger le bulletin (PDF)
                </a>
            </div>

            @php
                $groupes = $bulletins->groupBy('periode_id');
            @endphp

            @foreach ($groupes as $periodeId => $bulletinsParMatiere)
                @php
                    $periode = $bulletinsParMatiere->first()->periode;
                    $moyennePeriodique = $bulletinsParMatiere->first()->moyenne_periodique ?? 0;
                    $rangPeriodique = $bulletinsParMatiere->first()->rang_periodique ?? '-';
                @endphp

                <h4 class="mt-4">🗓️ Période : <strong>{{ $periode->nom }}</strong></h4>

                <table class="table table-striped table-hover table-bordered align-middle text-center bulletin-table">
                    <thead class="table-dark">
                        <tr>
                            <th>Matière</th>
                            <th>Interro 1</th>
                            <th>Interro 2</th>
                            <th>Interro 3</th>
                            <th>Devoir 1</th>
                            <th>Devoir 2</th>
                            <th class="bg-primary text-white">Moyenne</th>
                            <th>Coefficient</th>
                            <th>Rang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bulletinsParMatiere as $bulletin)
                            <tr>
                                <td class="fw-bold text-start">{{ $bulletin->matiere->nom }}</td>

                                @foreach (['interro1', 'interro2', 'interro3', 'devoir1', 'devoir2'] as $type)
                                    @php
                                        $valeur =
                                            $notes[$bulletin->periode_id][$bulletin->matiere_id][$type]->valeur ?? null;
                                    @endphp
                                    <td>
                                        @if ($valeur !== null)
                                            <span
                                                class="badge
                                            {{ $valeur >= 15 ? 'bg-success' : ($valeur < 10 ? 'bg-danger' : 'bg-warning text-dark') }}">
                                                {{ number_format($valeur, 2) }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endforeach

                                <td class="bg-primary text-white fw-bold">
                                    {{ number_format($bulletin->moyenne, 2) }}
                                </td>
                                <td>{{ $bulletin->coefficient ?? 1 }}</td>
                                <td>{{ $bulletin->rang }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3 mb-5">
                    <p><strong>Moyenne Générale de la Période :</strong>
                        <span class="badge bg-info text-dark">{{ number_format($moyennePeriodique, 2) }}/20</span>
                    </p>
                    <p><strong>Rang Général de la Période :</strong>
                        <span class="badge bg-secondary">{{ $rangPeriodique }}</span>
                    </p>
                </div>
            @endforeach
        @endif


    @section('scripts')
        <script src="https://kit.fontawesome.com/your-kit-code.js" crossorigin="anonymous"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Animation au chargement
                const sections = document.querySelectorAll('.bulletin-section');
                sections.forEach((section, index) => {
                    section.style.animationDelay = `${index * 0.1}s`;
                });

                // Tooltip pour les notes
                const badges = document.querySelectorAll('.badge');
                badges.forEach(badge => {
                    badge.addEventListener('mouseenter', function() {
                        const note = parseFloat(this.textContent);
                        let appreciation = '';

                        if (note >= 16) appreciation = 'Excellent';
                        else if (note >= 14) appreciation = 'Très bien';
                        else if (note >= 12) appreciation = 'Bien';
                        else if (note >= 10) appreciation = 'Passable';
                        else appreciation = 'Insuffisant';

                        this.setAttribute('title', `${appreciation} (${note}/20)`);
                    });
                });

                // Tri des matières
                const sortButton = document.createElement('button');
                sortButton.className = 'btn btn-outline-primary mb-3';
                sortButton.textContent = 'Trier par moyenne';
                sortButton.addEventListener('click', function() {
                    const table = document.querySelector('.bulletin-table tbody');
                    const rows = Array.from(table.querySelectorAll('tr'));

                    rows.sort((a, b) => {
                        const aNote = parseFloat(a.querySelector('td:nth-child(7)').textContent);
                        const bNote = parseFloat(b.querySelector('td:nth-child(7)').textContent);
                        return bNote - aNote;
                    });

                    rows.forEach(row => table.appendChild(row));
                });

                document.querySelector('.container.py-5').prepend(sortButton);

                // Impression du bulletin
                const printButton = document.createElement('button');
                printButton.className = 'btn btn-outline-secondary mb-3 ms-2';
                printButton.innerHTML = '<i class="fas fa-print"></i> Imprimer';
                printButton.addEventListener('click', function() {
                    window.print();
                });
                document.querySelector('.container.py-5').prepend(printButton);
            });
        </script>
    @endsection
@endsection
