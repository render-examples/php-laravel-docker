<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <title>Admin | Espace</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Custom CSS -->
    <link href="<?php echo e(asset('css/admin.css')); ?>" rel="stylesheet" />

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
        }

        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: #212529;
            color: white;
            overflow-y: auto;
            padding-top: 1rem;
            z-index: 1030;
        }


        .main-content {
            margin-left: 250px;
            padding: 1rem;
        }


        @media (max-width: 767.98px) {
            #sidebar {
                position: fixed;
                left: -250px;
                transition: left 0.3s ease;
            }

            #sidebar.show {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .btn-toggle-sidebar {
                display: inline-block;
            }
        }

        @media (min-width: 768px) {
            .btn-toggle-sidebar {
                display: none;
            }
        }

        #sidebar .nav-link {
            color: #ddd;
        }

        #sidebar .nav-link.active,
        #sidebar .nav-link:hover {
            background-color: #0d6efd;
            color: white;
        }
    </style>

    <?php echo $__env->yieldContent('styles'); ?>
</head>

<body class="admin-dashboard">


    <nav id="sidebar">
        <div class="sidebar-header px-3">
            <br>
            <h4 class="text-center">
                <i class="fas fa-user-shield me-2"></i>Admin Panel
            </h4>
        </div>
        <br><br>
        <ul class="nav flex-column px-2">
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo e(route('admin.dashboard')); ?>">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.users.pending')); ?>">
                    <i class="fas fa-user-clock me-2"></i>Demandes en attente
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.annees.index')); ?>">
                    <i class="fas fa-calendar me-2"></i>Modifier/Ajouter années
                </a>
            </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.periodes.index')); ?>">
                    <i class="fas fa-calendar-alt me-2"></i>Modifier/Ajouter période
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('professeurs.index')); ?>">
                    <i class="fas fa-chalkboard-teacher me-2"></i>Affectation professeurs
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.affectation.annees')); ?>">
                    <i class="fas fa-user-graduate me-2"></i>Affectation élèves
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.users.active')); ?>">
                    <i class="fas fa-users me-2"></i>Utilisateurs actifs
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.users.index')); ?>">
                    <i class="fas fa-users-cog me-2"></i>Gestion des Utilisateurs
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.reclamations.admin')); ?>">
                    <i class="fas fa-envelope-open-text me-2"></i>Réclamations
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.resultats')); ?>">
                    <i class="fas fa-user-graduate me-2"></i>Liste des élèves admis/échoué
                </a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-cog me-2"></i>Paramètres
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Profil</a></li>
                    <li>
                        <a href="<?php echo e(route('profile.admin.edit')); ?>" class="dropdown-item">
                            <i class="fas fa-user-edit me-2"></i> Modifier mon profil
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Déconnexion
                        </a>
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                            <?php echo csrf_field(); ?>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>


    <div class="main-content">

        <nav class="navbar navbar-expand navbar-light bg-light mb-3">
            <div class="container-fluid">


                <button class="btn btn-dark btn-toggle-sidebar d-md-none" type="button" aria-label="Ouvrir menu">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="ms-auto d-flex align-items-center">
                    <span class="me-3">Bienvenue, <?php echo e(Auth::user()->prenom ?? Auth::user()->name); ?></span>
                    <img src="<?php echo e(asset('images/image_1.png')); ?>" alt="Avatar" class="rounded-circle"
                        width="40" />
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    <script src="<?php echo e(asset('js/java.js')); ?>"></script>

    <script>
        const btnToggle = document.querySelector('.btn-toggle-sidebar');
        const sidebar = document.getElementById('sidebar');

        btnToggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });


        document.addEventListener('click', (e) => {
            if (
                window.innerWidth < 768 &&
                sidebar.classList.contains('show') &&
                !sidebar.contains(e.target) &&
                !btnToggle.contains(e.target)
            ) {
                sidebar.classList.remove('show');
            }
        });
    </script>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html>
<?php /**PATH /home/sayajin/Documents/Gestion_note/resources/views/layouts/admin.blade.php ENDPATH**/ ?>