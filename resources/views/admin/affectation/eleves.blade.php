@extends('layouts.admin')

@section('content')
    <div class="container py-4">
<div class="mb-4 text-center">
    <h2 class="fw-bold text-white bg-primary p-3 rounded shadow-sm">
        👨‍🎓 Affecter les élèves à la classe <span class="text-dark">{{ $classe->nom }}</span><br>
        pour l’année scolaire <span class="text-dark">{{ $annee->libelle }}</span>
    </h2>
</div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        @if ($eleves->isEmpty())
            <p>Aucun élève actif non affecté disponible pour cette classe et cette année.</p>
        @else
            <div class="mb-3">
                <input type="search" class="form-control form-control-lg" id="search-eleves"
                    placeholder="Rechercher un élève par nom ou email...">
            </div>

            <form action="{{ route('admin.affectation.assigner') }}" method="POST" id="affectation-form">
                @csrf
                <input type="hidden" name="classe_id" value="{{ $classe->id }}">
                <input type="hidden" name="annee_id" value="{{ $annee->id }}">

                <div id="eleves-list" class="row g-3" style="max-height: 500px; overflow-y: auto;">

                    @foreach ($eleves as $eleve)
                        <div class="col-md-6 col-lg-4 eleve-item" data-name="{{ strtolower($eleve->getFullName()) }}"
                            data-email="{{ strtolower($eleve->email) }}">
                            <div class="card shadow-sm h-100 border-primary">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-1">{{ $eleve->getFullName() }}</h5>
                                        <p class="card-text text-muted mb-0">{{ $eleve->email }}</p>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="eleves[]" value="{{ $eleve->id }}"
                                            class="form-check-input eleve-checkbox" id="eleve{{ $eleve->id }}">
                                        <label for="eleve{{ $eleve->id }}" class="form-check-label ms-2"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success btn-lg shadow-sm">
                        <i class="fas fa-check-circle me-2"></i> Affecter les élèves sélectionnés
                    </button>
                </div>
            </form>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-eleves');
            const eleveItems = Array.from(document.querySelectorAll('.eleve-item'));
            const checkedIds = new Set();

            // Garder les sélections même
            function updateCheckedIds() {
                checkedIds.clear();
                document.querySelectorAll('.eleve-checkbox:checked').forEach(cb => {
                    checkedIds.add(cb.value);
                });
            }

            // Appliquer le filtre
            function filterEleves() {
                const term = searchInput.value.trim().toLowerCase();

                eleveItems.forEach(item => {
                    const name = item.getAttribute('data-name');
                    const email = item.getAttribute('data-email');
                    if (name.includes(term) || email.includes(term)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                        // Décoche les élèves non visibles mais déjà cochés
                        const checkbox = item.querySelector('.eleve-checkbox');
                        if (checkbox.checked && !checkedIds.has(checkbox.value)) {
                            checkbox.checked = false;
                        }
                    }
                });
            }

            // Initialisation des checkbox + gestion du set checkedIds
            document.querySelectorAll('.eleve-checkbox').forEach(cb => {
                cb.addEventListener('change', () => {
                    if (cb.checked) {
                        checkedIds.add(cb.value);
                    } else {
                        checkedIds.delete(cb.value);
                    }
                });
            });

            // Filtrage
            searchInput.addEventListener('input', () => {
                updateCheckedIds();
                filterEleves();
            });

            // Initial filtre au chargement
            filterEleves();
        });
    </script>
@endsection
