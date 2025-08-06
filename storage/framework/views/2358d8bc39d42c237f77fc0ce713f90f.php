<?php $__env->startSection('content'); ?>
    <div class="professor-dashboard">
        <br><br><br><br>
        
        <div class="professor-hero bg-dark text-white py-5 mb-5">
            <div class="container text-center">
                <h1 class="display-4 animate__animated animate__fadeInDown">Espace Professeur</h1>
                <p class="lead animate__animated animate__fadeInUp">
                    Bienvenue, <?php echo e(Auth::user()->nom); ?> <?php echo e(Auth::user()->prenom); ?>

                </p>
                <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-outline-light mt-3">
                    <i class="fas fa-user-edit me-2"></i> Modifier mon profil
                </a>
            </div>
        </div>

        <div class="container">
            
            <div class="mb-5">
                <div class="card shadow-lg border-0 animate__animated animate__fadeInLeft">
                    <div class="card-header bg-primary text-white">
                        <h3><i class="fas fa-chalkboard-teacher me-2"></i> Gestion des Classes et Notes</h3>
                    </div>
                    <div class="card-body row">
                        <?php $__currentLoopData = $annees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $annee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4 mb-4">
                                <div class="card border-primary h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-calendar-alt fa-3x text-primary mb-3"></i>
                                        <h4><?php echo e($annee->libelle); ?></h4>
                                        <p class="text-muted">Gérer vos classes et notes</p>
                                        <a href="<?php echo e(route('professeur.classes', $annee->id)); ?>" class="btn btn-primary">
                                            <i class="fas fa-arrow-right me-2"></i> Accéder
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    
    <style>
        .professor-dashboard {
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .professor-hero {
            background: url('/images/professor-bg.jpg') center/cover no-repeat;
            position: relative;
        }

        .professor-hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(124, 122, 122, 0.6);
            z-index: 0;
        }

        .professor-hero .container {
            position: relative;
            z-index: 1;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sayajin/Documents/Gestion_note/resources/views/professeur/dashboard.blade.php ENDPATH**/ ?>