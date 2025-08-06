<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="card shadow-lg">
            <div class="card-header bg-admin">
                <h3 class="mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Réclamations en attente de traitement
                </h3>
                <br>
                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
            </div>

            <div class="card-body">
                <?php if($reclamations->isEmpty()): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Aucune réclamation en attente de traitement.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">

                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Professeur</th>
                                    <th>Élève</th>
                                    <th>Matière</th>
                                    <th>Période</th>
                                    <th>Évaluation</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $reclamations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reclamation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($reclamation->created_at->format('d/m/Y H:i')); ?></td>
                                        <td><?php echo e($reclamation->professeur->user->nom ?? 'N/A'); ?></td>
                                        <td><?php echo e($reclamation->eleve->user->nom); ?> <?php echo e($reclamation->eleve->user->prenom); ?>

                                        </td>
                                        <td><?php echo e($reclamation->matiere->nom); ?></td>
                                        <td><?php echo e($reclamation->periode->nom); ?></td>
                                        <td><?php echo e(ucfirst($reclamation->type_evaluation)); ?>

                                            (<?php echo e($reclamation->note->nom_evaluation ?? 'N/A'); ?>)
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#traitementModal<?php echo e($reclamation->id); ?>">
                                                <i class="fas fa-edit"></i> Traiter
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Traitement -->
                                    <div class="modal fade" id="traitementModal<?php echo e($reclamation->id); ?>" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title">Traitement de la réclamation</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="<?php echo e(route('admin.reclamations.unlock', $reclamation)); ?>"
                                                    method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <h6>Description :</h6>
                                                            <p><?php echo e($reclamation->description); ?></p>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <h6>Note actuelle :</h6>
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <p><strong>Valeur :</strong>
                                                                            <?php echo e($reclamation->note->valeur ?? 'N/A'); ?></p>
                                                                        <p><strong>Statut :</strong>
                                                                            <?php if($reclamation->note && $reclamation->note->is_locked): ?>
                                                                                <span
                                                                                    class="badge bg-danger">Verrouillée</span>
                                                                            <?php else: ?>
                                                                                <span
                                                                                    class="badge bg-success">Déverrouillée</span>
                                                                            <?php endif; ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6>Informations :</h6>
                                                                <ul class="list-group">
                                                                    <li class="list-group-item">
                                                                        <strong>Professeur :</strong>
                                                                        <?php echo e($reclamation->professeur->user->nom ?? 'N/A'); ?>

                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <strong>Date création :</strong>
                                                                        <?php echo e($reclamation->created_at->format('d/m/Y H:i')); ?>

                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="action" class="form-label">Action</label>
                                                            <select class="form-select" name="action" id="action"
                                                                required>
                                                                <option value="accept">Accepter (déverrouiller la note)
                                                                </option>
                                                                <option value="reject">Rejeter (maintenir verrouillée)
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="reponse_admin" class="form-label">Réponse à envoyer
                                                                au professeur</label>
                                                            <textarea class="form-control" name="reponse_admin" id="reponse_admin" rows="3" required></textarea>
                                                            <small class="text-muted">Cette réponse sera envoyée au
                                                                professeur qui a fait la demande</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Annuler</button>
                                                        <button type="submit" class="btn btn-primary">Valider la
                                                            décision</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <?php echo e($reclamations->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sayajin/Documents/Gestion_note/resources/views/admin/reclamations/index.blade.php ENDPATH**/ ?>