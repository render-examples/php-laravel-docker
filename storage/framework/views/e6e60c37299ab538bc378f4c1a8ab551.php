<?php $__env->startSection('content'); ?>
<div class="professor-classes">
    <div class="container py-5">
        <div class="card shadow-lg animate__animated animate__fadeIn">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="fas fa-chalkboard-teacher me-2"></i>
                    Mes Classes - Année <?php echo e($annee->libelle); ?>

                </h3>
                <span class="badge bg-light text-primary fs-6"><?php echo e($classes->count()); ?> classes</span>
            </div>

            <div class="card-body">
                <?php if($classes->isEmpty()): ?>
                <div class="alert alert-info animate__animated animate__fadeIn">
                    <i class="fas fa-info-circle me-2"></i>
                    Vous n'êtes affecté à aucune classe pour cette année académique.
                </div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover animate__animated animate__fadeInUp">
                        <thead class="table-light">
                            <tr>
                                <th>Classe</th>
                                <th>Série</th>
                                <th>Matières</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classeId => $affectations): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $classe = $affectations->first()->classe; ?>
                            <tr>
                                <td><?php echo e($classe->nom); ?></td>
                                <td><?php echo e($classe->serie ?? 'N/A'); ?></td>
                                <td>
                                    <?php $__currentLoopData = $affectations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $affectation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge bg-secondary me-1"><?php echo e($affectation->matiere->nom); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('professeur.classe.eleves', ['anneeId' => $annee->id, 'classeId' => $classe->id])); ?>"
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-users me-1"></i> Voir les élèves
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .professor-classes {
        background: url('../images/image_3.png') no-repeat center center fixed;
        background-size: cover;
        min-height: calc(100vh - 80px);
        padding-top: 80px;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.1);
    }

    .badge {
        font-size: 0.9em;
        padding: 0.5em 0.75em;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sayajin/Documents/Gestion_note/resources/views/professeur/classes.blade.php ENDPATH**/ ?>