<?php $__env->startSection('content'); ?>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="hero-content">
                        <h1 class="hero-title animate__animated animate__fadeInDown">Gestion notes</h1>
                        <p class="hero-subtitle animate__animated animate__fadeInDown animate-delay-1">
                            La plateforme éducative exclusive du Ministère de la Défense
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="<?php echo e(route('register')); ?>"
                                class="btn btn-def animate__animated animate__fadeInUp animate-delay-2">
                                <i class="fas fa-user-plus me-2"></i> S'inscrire
                            </a>
                            <a href="<?php echo e(route('login')); ?>"
                                class="btn btn-def-outline animate__animated animate__fadeInUp animate-delay-2">
                                <i class="fas fa-sign-in-alt me-2"></i> Se connecter
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container">
            <div class="section-title">
                <h2 class="animate__animated animate__fadeIn">Nos Services</h2>
            </div>

            <div class="row g-4">
                <div class="col-md-4 animate__animated animate__fadeInUp">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h3>Gestion des Cours</h3>
                        <p>
                            Système complet de gestion des cours, emplois du temps et ressources pédagogiques pour les
                            instructeurs.
                        </p>
                    </div>
                </div>

                <div class="col-md-4 animate__animated animate__fadeInUp animate-delay-1">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <h3>Encadrement</h3>
                        <p>
                            Suivi personnalisé des élèves avec statistiques de performance et rapports détaillés.
                        </p>
                    </div>
                </div>

                <div class="col-md-4 animate__animated animate__fadeInUp animate-delay-2">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-medal"></i>
                        </div>
                        <h3>Excellence</h3>
                        <p>
                            Outils dédiés à l'atteinte de l'excellence académique et opérationnelle selon les standards
                            militaires.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Carousel Section -->
    <section class="carousel-section">
        <div class="container-fluid px-4">
            <div class="section-title text-center">
                <h2 class="text-white animate__animated animate__fadeIn">Voir plus</h2>
            </div>

            <div class="row justify-content-center gx-4">
                <!-- Carousel 1 -->
                <div class="col-md-4">
                    <div id="carousel1" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?php echo e(asset('images/image_1.png')); ?>" class="d-block w-100 carousel-img"
                                    alt="Image 1">
                            </div>
                            <div class="carousel-item">
                                <img src="<?php echo e(asset('images/image_2.png')); ?>" class="d-block w-100 carousel-img"
                                    alt="Image 2">
                            </div>
                              <div class="carousel-item">
                                <img src="<?php echo e(asset('images/image_8.png')); ?>" class="d-block w-100 carousel-img"
                                    alt="Image 8">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel1"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel1"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <!-- Carousel 2 -->
                <div class="col-md-4">
                    <div id="carousel2" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?php echo e(asset('images/image_7.png')); ?>" class="d-block w-100 carousel-img"
                                    alt="Image 7">
                            </div>
                            <div class="carousel-item">
                                <img src="<?php echo e(asset('images/image_6.png')); ?>" class="d-block w-100 carousel-img"
                                    alt="Image 6">
                            </div>
                              <div class="carousel-item">
                                <img src="<?php echo e(asset('images/image_9.png')); ?>" class="d-block w-100 carousel-img"
                                    alt="Image 9">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel2"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel2"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <!-- Carousel 3 -->
                <div class="col-md-4">
                    <div id="carousel3" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?php echo e(asset('images/image_5.png')); ?>" class="d-block w-100 carousel-img"
                                    alt="Image 5">
                            </div>
                            <div class="carousel-item">
                                <img src="<?php echo e(asset('images/image_3.png')); ?>" class="d-block w-100 carousel-img"
                                    alt="Image 3">
                            </div>
                               <div class="carousel-item">
                                <img src="<?php echo e(asset('images/image_10.png')); ?>" class="d-block w-100 carousel-img"
                                    alt="Image 10">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel3"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel3"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-light">
        <div class="container">
            <div class="section-title">
                <h2 class="animate__animated animate__fadeIn">Contact</h2>
            </div>

            <div class="row g-4">
                <div class="col-md-4 animate__animated animate__fadeInLeft">
                    <div class="card border-0 shadow-sm h-100" id="contact">
                        <div class="card-body text-center p-4">
                            <a href="https://maps.app.goo.gl/RdquSAeSLBFDTfeh6" target="_Blank">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 mb-3 mx-auto"
                                    style="width: 70px; height: 70px;">
                                    <i class="fas fa-map-marker-alt fs-3"></i>
                                </div>
                            </a>
                            <h5>Adresse</h5>
                            <p class="text-muted mb-0">Ministère de la Défense</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 animate__animated animate__fadeInUp">
                    <a href="tel:+229019484958" class="text-decoration-none text-dark">
                        <div class="card border-0 shadow-sm h-100" id="contact">
                            <div class="card-body text-center p-4">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 mb-3 mx-auto"
                                    style="width: 70px; height: 70px;">
                                    <i class="fas fa-phone-alt fs-3"></i>
                                </div>
                                <h5>Téléphone</h5>
                                <p class="text-muted mb-0">+229 019484958</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 animate__animated animate__fadeInRight">
                    <a href="mailto:agoliganange15@gmail.com" class="text-decoration-none text-dark">
                        <div class="card border-0 shadow-sm h-100" id="contact">
                            <div class="card-body text-center p-4">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 mb-3 mx-auto"
                                    style="width: 70px; height: 70px;">
                                    <i class="fas fa-envelope fs-3"></i>
                                </div>
                                <h5>Email</h5>
                                <p class="text-muted mb-0">ministere@gmail.com</p>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sayajin/Documents/Gestion_note/resources/views/index.blade.php ENDPATH**/ ?>