<?php $__env->startSection('content'); ?>
    <div class="professor-eleves">
        <div class="container py-5">
            <div class="card shadow-lg animate__animated animate__fadeIn">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">
                        <i class="fas fa-users-class me-2"></i>
                        Élèves de <?php echo e($classe->nom ?? 'Classe inconnue'); ?> - Année <?php echo e($annee->libelle ?? 'Année inconnue'); ?>

                    </h3>
                </div>

                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if($periodes->isEmpty() || $affectations->isEmpty()): ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Aucune période académique ou matière disponible pour cette classe.
                        </div>
                    <?php else: ?>
                        <form id="filterForm" method="GET"
                            action="<?php echo e(route('professeur.classe.eleves', ['anneeId' => $annee->id, 'classeId' => $classe->id])); ?>">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"><i class="fas fa-calendar-week me-2"></i>Période
                                                académique</h5>
                                            <select class="form-select" name="periode_id" id="periodeSelect"
                                                onchange="this.form.submit()">
                                                <?php $__currentLoopData = $periodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $periode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($periode->id); ?>"
                                                        <?php echo e($selectedPeriodeId == $periode->id ? 'selected' : ''); ?>>
                                                        <?php echo e($periode->nom); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"><i class="fas fa-book me-2"></i>Matière</h5>
                                            <select class="form-select" name="matiere_id" id="matiereSelect"
                                                onchange="this.form.submit()">
                                                <?php $__currentLoopData = $affectations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $affectation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($affectation->matiere): ?>
                                                        <option value="<?php echo e($affectation->matiere->id); ?>"
                                                            data-coefficient="<?php echo e($affectation->matiere->coefficient ?? 1); ?>"
                                                            <?php echo e($selectedMatiereId == $affectation->matiere->id ? 'selected' : ''); ?>>
                                                            <?php echo e($affectation->matiere->nom); ?> (Coeff:
                                                            <?php echo e($affectation->matiere->coefficient ?? 1); ?>)
                                                        </option>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <form id="notesForm" action="<?php echo e(route('professeur.notes.enregistrer')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="annee_academique_id" value="<?php echo e($annee->id); ?>">
                            <input type="hidden" name="classe_id" value="<?php echo e($classe->id); ?>">
                            <input type="hidden" name="matiere_id" id="matiereId" value="<?php echo e($selectedMatiereId); ?>">
                            <input type="hidden" name="periode_id" id="periodeId" value="<?php echo e($selectedPeriodeId); ?>">

                            <div class="table-responsive">
                                <table class="table table-hover animate__animated animate__fadeInUp">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Actions</th>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Interro 1</th>
                                            <th>Interro 2</th>
                                            <th>Interro 3</th>
                                            <th>Devoir 1</th>
                                            <th>Devoir 2</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $eleves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eleve): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <?php if($eleve->user): ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="<?php echo e(route('reclamations.create', ['eleve' => $eleve->id])); ?>"
                                                               class="btn btn-sm btn-primary">
                                                                Réclamer
                                                            </a>

                                                            <a href="<?php echo e(route('reclamations.suivi', ['eleve_id' => $eleve->id, 'classeId' => $classe->id, 'anneeId' => $annee->id])); ?>"
                                                                class="btn btn-sm btn-info">
                                                                <i class="fas fa-eye"></i> Suivi
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td><?php echo e($eleve->user->nom ?? ''); ?></td>
                                                    <td><?php echo e($eleve->user->prenom ?? ''); ?></td>
                                                    <?php $__currentLoopData = ['interro1', 'interro2', 'interro3', 'devoir1', 'devoir2']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <td>
                                                            <?php
                                                                $noteKey = $eleve->id . '_' . $type;
                                                                $existingNote = $notesExistantes[$noteKey] ?? null;
                                                            ?>

                                                            <input type="number" class="form-control note-input"
                                                                name="notes[<?php echo e($eleve->id); ?>][<?php echo e($type); ?>]"
                                                                min="0" max="20" step="0.01"
                                                                value="<?php echo e($existingNote ? number_format($existingNote->valeur, 2) : ''); ?>"
                                                                <?php echo e($existingNote && $existingNote->is_locked ? 'disabled' : ''); ?>>
                                                        </td>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="8" class="text-center text-muted">Aucun élève dans cette
                                                    classe</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-end mt-4">
                                <center>
                                    <button type="submit"
                                        class="btn btn-primary btn-lg px-4 animate__animated animate__pulse"
                                        style="max-width: 100%;">
                                        <i class="fas fa-save me-2"></i> Enregistrer les notes
                                    </button>
                                    <a href="<?php echo e(route('professeur.statistiques.show', ['anneeId' => $annee->id, 'classeId' => $classe->id])); ?>"
                                        class="btn btn-info btn-lg px-4 me-2" style="max-width: 100%;">
                                        <i class="fas fa-chart-bar me-2"></i> &nbsp; Voir les statistiques
                                    </a>
                                </center>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Validation des notes (limiter à 20)
            const noteInputs = document.querySelectorAll('.note-input');
            noteInputs.forEach(input => {
                input.addEventListener('input', function() {
                    let val = parseFloat(this.value);
                    if (val > 20) {
                        this.value = 20;
                    } else if (val < 0) {
                        this.value = 0;
                    }
                });
            });

            // Soumission formulaire : désactiver bouton et spinner
            const form = document.getElementById('notesForm');
            if (form) {
                form.addEventListener('submit', function() {
                    const button = this.querySelector('button[type="submit"]');
                    if (button) {
                        button.disabled = true;
                        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Enregistrement...';
                    }
                });
            }
        });
    </script>

    <style>
        .professor-eleves {
            background: url('../images/image_3.png') no-repeat center center fixed;
            background-size: cover;
            min-height: calc(100vh - 80px);
            padding-top: 80px;
        }

        .note-input {
            max-width: 80px;
            text-align: center;
        }

        .is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .table th {
            white-space: nowrap;
            vertical-align: middle;
        }

        .card {
            border-radius: 10px;
            overflow: hidden;
        }

        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }

        .average-cell {
            font-weight: bold;
            background-color: #f8f9fa;
        }

        @media (max-width: 768px) {
            .btn {
                padding-top: 10px;
                margin-top: 10px;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sayajin/Documents/Gestion_note/resources/views/professeur/eleves.blade.php ENDPATH**/ ?>