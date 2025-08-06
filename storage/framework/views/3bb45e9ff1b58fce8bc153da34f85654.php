<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <br><br>
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">
                    <i class="fas fa-clipboard-list me-2"></i>
                    Suivi des réclamations
                </h3>
            </div>

            <div class="card-body">
                <?php if($reclamations->isEmpty()): ?>
                    <div class="alert alert-info wow animate__animated animate__fadeIn animate__delay-0.5s">
                        <i class="fas fa-info-circle me-2"></i>
                        Vous n'avez aucune réclamation en cours.
                    </div>
                <?php else: ?>
                    <div class="table-responsive wow animate__animated animate__fadeIn animate__delay-0.3s">
                        <table class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Élève</th>
                                    <th>Matière</th>
                                    <th>Période</th>
                                    <th>Évaluation</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $reclamations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reclamation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($reclamation->created_at->format('d/m/Y H:i')); ?></td>
                                        <td><?php echo e($reclamation->eleve->user->nom); ?> <?php echo e($reclamation->eleve->user->prenom); ?>

                                        </td>
                                        <td><?php echo e($reclamation->matiere->nom); ?></td>
                                        <td><?php echo e($reclamation->periode->nom); ?></td>
                                        <td><?php echo e(ucfirst($reclamation->type_evaluation)); ?>

                                            (<?php echo e($reclamation->note->nom_evaluation ?? 'N/A'); ?>)</td>
                                        <td>
                                            <span
                                                class="badge bg-<?php echo e($reclamation->statut == 'resolue' ? 'success' : ($reclamation->statut == 'rejetee' ? 'danger' : 'warning')); ?>">
                                                <?php echo e(ucfirst(str_replace('_', ' ', $reclamation->statut))); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                data-bs-target="#detailsModal<?php echo e($reclamation->id); ?>">
                                                <i class="fas fa-eye"></i> Détails
                                            </button>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <a href="<?php echo e(url()->previous()); ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Retour
                        </a>
                    </div>

                    <!-- Modals en dehors de la table -->
                    <?php $__currentLoopData = $reclamations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reclamation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="modal fade wow animate__animated animate__fadeIn animate__delay-1.5s"
                            id="detailsModal<?php echo e($reclamation->id); ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title">Détails de la réclamation -
                                            <?php echo e($reclamation->eleve->user->nom); ?> <?php echo e($reclamation->eleve->user->prenom); ?>

                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <h6>Description :</h6>
                                            <p><?php echo e($reclamation->description); ?></p>
                                        </div>

                                        <?php if($reclamation->reponse_admin): ?>
                                            <div class="mb-3">
                                                <h6>Réponse de l'administration :</h6>
                                                <div class="p-3 bg-light rounded">
                                                    <p><?php echo e($reclamation->reponse_admin); ?></p>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Informations :</h6>
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <strong>Date création :</strong>
                                                        <?php echo e($reclamation->created_at->format('d/m/Y H:i')); ?>

                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Dernière mise à jour :</strong>
                                                        <?php echo e($reclamation->updated_at->format('d/m/Y H:i')); ?>

                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Statut :</strong>
                                                        <span
                                                            class="badge bg-<?php echo e($reclamation->statut == 'resolue' ? 'success' : ($reclamation->statut == 'rejetee' ? 'danger' : 'warning')); ?>">
                                                            <?php echo e(ucfirst(str_replace('_', ' ', $reclamation->statut))); ?>

                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Note concernée :</h6>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <p><strong>Valeur :</strong>
                                                            <?php echo e($reclamation->note->valeur ?? 'N/A'); ?></p>
                                                        <p><strong>Type :</strong> <?php echo e($reclamation->type_evaluation); ?></p>
                                                        <p><strong>Statut :</strong>
                                                            <?php if($reclamation->note && $reclamation->note->is_locked): ?>
                                                                <span class="badge bg-danger">Verrouillée</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-success">Déverrouillée</span>
                                                            <?php endif; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sayajin/Documents/Gestion_note/resources/views/professeur/reclamations/suivi.blade.php ENDPATH**/ ?>