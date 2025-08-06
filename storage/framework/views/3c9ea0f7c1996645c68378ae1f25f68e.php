<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <br><br><br>
        <div class="card shadow-lg border-light">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Nouvelle réclamation pour <?php echo e($eleve->user->nom); ?> <?php echo e($eleve->user->prenom); ?>

                </h3>
            </div>
            <br>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger mt-4">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>


            <div class="card-body">
                <form action="<?php echo e(route('reclamations.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="eleve_id" value="<?php echo e($eleve->id); ?>">

                    <!-- Matière -->
                    <div class="mb-3 wow animate__animated animate__fadeIn animate__delay-0.5s">
                        <label for="matiere_id" class="form-label">Matière concernée</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                            <select class="form-select" name="matiere_id" id="matiere_id" required>
                                <?php $__currentLoopData = $matieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $matiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($matiere->id); ?>"><?php echo e($matiere->nom); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <!-- Période académique -->
                    <div class="mb-3 wow animate__animated animate__fadeIn animate__delay-1s">
                        <label for="periode_id" class="form-label">Période académique</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            <select class="form-select" name="periode_id" id="periode_id" required>
                                <?php $__currentLoopData = $periodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $periode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($periode->id); ?>"><?php echo e($periode->nom); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <!-- Type d'évaluation -->
                    <div class="mb-3 wow animate__animated animate__fadeIn animate__delay-1s">
                        <label for="type_evaluation" class="form-label">Type d'évaluation</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-pen"></i></span>
                            <select class="form-select" name="type_evaluation" id="type_evaluation" required>
                                <option value="interro1">Interrogation 1</option>
                                <option value="interro2">Interrogation 2</option>
                                <option value="interro3">Interrogation 3</option>
                                <option value="devoir1">Devoir 1</option>
                                <option value="devoir2">Devoir 2</option>
                            </select>
                        </div>
                    </div>

                    <!-- Description de la réclamation -->
                    <div class="mb-3 wow animate__animated animate__fadeIn animate__delay-2s">
                        <label for="description" class="form-label">Description de la réclamation</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                            <textarea class="form-control" name="description" id="description" rows="5" required></textarea>
                        </div>
                        <small class="text-muted mt-2">Décrivez en détail la raison de votre demande de
                            modification.</small>
                    </div>

                    <!-- Actions -->
                    <div class="text-end mt-4 wow animate__animated animate__fadeIn animate__delay-2.5s">

                           <a href="<?php echo e(route('professeur.dashboard')); ?>" class="btn btn-outline-dark me-md-2">
                                    <i class="fas fa-tachometer-alt me-1"></i> Retour a l'acceuil
                                </a>

                        <a href="<?php echo e(url()->previous()); ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Envoyer à l'administration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sayajin/Documents/Gestion_note/resources/views/professeur/reclamations/create.blade.php ENDPATH**/ ?>