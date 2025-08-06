@extends('layouts.app')
<style>
    .container.py-5 {
        /*background: url('../images/image_7.png') no-repeat center center fixed;
   */
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(5px);
        padding: 2rem;
        margin-top: 2rem;
        margin-bottom: 2rem;
    }

    /* Cartes des années scolaires */
    .annee-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
        background-color: rgba(255, 255, 255, 0.85);
        overflow: hidden;
        position: relative;
    }

    .annee-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #3498db, #2c3e50);
    }

    .annee-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
        border-color: #3498db;
    }

    .annee-card .card-body {
        padding: 2rem 1rem;
        position: relative;
        z-index: 1;
    }

    /* Titres */
    h2 {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
    }

    h3 {
        color: #3498db;
        border-bottom: 2px solid #3498db;
        padding-bottom: 0.5rem;
        display: inline-block;
    }

    /* Texte */
    .text-muted {
        color: #7f8c8d !important;
    }

    /* Alertes */
    .alert {
        border-radius: 10px;
    }

    /* Animation des cartes */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .col-md-4 {
        animation: fadeInUp 0.5s ease-out forwards;
        opacity: 0;
    }


    .col-md-4:nth-child(1) {
        animation-delay: 0.1s;
    }

    .col-md-4:nth-child(2) {
        animation-delay: 0.2s;
    }

    .col-md-4:nth-child(3) {
        animation-delay: 0.3s;
    }

    .col-md-4:nth-child(4) {
        animation-delay: 0.4s;
    }

    .col-md-4:nth-child(5) {
        animation-delay: 0.5s;
    }

    /* Responsive */
    @media (max-width: 768px) {
        body {
            background-attachment: scroll;
        }

        .container.py-5 {
            margin-top: 1rem;
            margin-bottom: 1rem;
            padding: 1.5rem;
        }
    }
</style>
@section('content')
  
    <br> <br> <br> <br>
    <div class="container py-5">
          <a href="{{ route('profile.editeleve') }}" class="text-decoration-none">
        Modifier mon compte
    </a>

        <div class="row mb-4">
            <div class="col">
                <h2 class="text-center">Bienvenue {{ $eleve->user->prenom }} {{ $eleve->user->nom }}</h2>
                <p class="text-center text-muted">Classe: {{ $eleve->classe->nom ?? 'Non spécifiée' }}</p>
            </div>
        </div>

        <h3 class="mb-4">Sélectionnez une année scolaire</h3>

        @if ($annees->isEmpty())
            <div class="alert alert-info">
                Aucun bulletin disponible pour le moment.
            </div>
        @else
            <div class="row g-4">
                @foreach ($annees as $annee)
                    <div class="col-md-4">
                        <a href="{{ route('bulletin.show', $annee->id) }}" class="text-decoration-none">
                            <div class="card annee-card h-100 shadow-sm border-primary">
                                <div class="card-body text-center">
                                    <h4 class="card-title">{{ $annee->libelle }}</h4>
                                    <p class="text-muted">📘 Cliquez pour voir le bulletin</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Effet de survol amélioré pour les cartes
            const cards = document.querySelectorAll('.annee-card');

            cards.forEach(card => {
                // Effet au survol
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                    this.style.boxShadow = '0 20px 30px rgba(0, 0, 0, 0.15)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.boxShadow = '0 15px 25px rgba(0, 0, 0, 0.1)';
                });

                // Effet au clic
                card.addEventListener('mousedown', function() {
                    this.style.transform = 'translateY(-2px)';
                });

                card.addEventListener('mouseup', function() {
                    this.style.transform = 'translateY(-8px)';
                });
            });

            // Animation du titre
            const title = document.querySelector('h2');
            if (title) {
                title.style.opacity = '0';
                title.style.transform = 'translateY(-20px)';
                title.style.transition = 'all 0.8s ease-out';

                setTimeout(() => {
                    title.style.opacity = '1';
                    title.style.transform = 'translateY(0)';
                }, 300);
            }

            // Effet de parallaxe sur l'image de fond
            window.addEventListener('scroll', function() {
                const scrollPosition = window.pageYOffset;
                document.body.style.backgroundPositionY = `${scrollPosition * 0.5}px`;
            });

            // Ajout d'une icône de chargement avant le chargement de la page
            window.addEventListener('beforeunload', function() {
                document.body.innerHTML = `
            <div style="
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
                background: rgba(255,255,255,0.9);
                z-index: 9999;
            ">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Chargement...</span>
                </div>
            </div>
        `;
            });
        });
    </script>
@endsection
@endsection
