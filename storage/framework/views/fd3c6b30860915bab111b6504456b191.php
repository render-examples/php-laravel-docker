<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>PGESEM | SchoolConnect</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">

    <style>
        * {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: #acbaca;
            transition: background 0.5s;
        }

        main {
            flex: 1;
        }

        /* Clock styles */
        .footer-clock-container {
            display: flex;
            justify-content: center;
            width: 100%;
            height: 50%;
            padding: 20px 0;
        }

        .clock-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .clock {
            position: relative;
            width: 100px;
            height: 40px;
            background: #c9d5e0;
            display: none;
            justify-content: center;
            align-items: center;
            border-radius: 30px;
            box-shadow: 15px 15px 20px -5px rgba(255, 255, 255, 0.15),
                inset 10px 10px 10px rgba(255, 255, 255, 0.75),
                -10px -10px 25px rgba(255, 255, 255, 0.55),
                inset -1px -1px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.5s;
        }

        .clock::before {
            content: '';
            position: absolute;
            width: 4px;
            height: 4px;
            background: #e91e63;
            border-radius: 50%;
            z-index: 10000;
            box-shadow: 0 0 0 1px #e91e63,
                0 0 0 3px #fff,
                0 0 5px 4px rgba(0, 0, 0, 0.15);
        }

        .clock .digits {
            position: absolute;
            inset: 20px;
            background: #152b4a;
            border-radius: 50%;
            box-shadow: 3px 3px 10px #152b4a66,
                inset 3px 3px 10px rgba(255, 255, 255, 0.55),
                -4px -4px 8px rgba(255, 255, 255, 1);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .clock .digits span {
            position: absolute;
            inset: 5px;
            text-align: center;
            color: #fff;
            font-size: 0.9rem;
            transform: rotate(calc(30deg * var(--i)));
            text-shadow: 0 0 3px rgba(255, 255, 255, 0.5);
        }

        .clock .digits span b {
            font-weight: 600;
            display: inline-block;
            transform: rotate(calc(-30deg * var(--i)));
        }

        .clock .digits::before {
            content: '';
            position: absolute;
            inset: 20px;
            background: linear-gradient(#2196f3, #e91e63);
            border-radius: 50%;
            animation: animate 2s linear infinite;
            opacity: 0.7;
        }

        @keyframes animate {
            0% {
                transform: rotate(360deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        .clock .digits::after {
            content: '';
            position: absolute;
            inset: 22px;
            background: #152b4a;
            border-radius: 50%;
        }

        .clock .digits .circle {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            z-index: 10;
        }

        .clock .digits .circle i {
            position: absolute;
            width: 2px;
            height: 50%;
            background: #fff;
            transform-origin: bottom;
            transform: scaleY(0.55);
            border-radius: 3px;
        }

        .clock .digits .circle#hr i {
            transform: scaleY(0.3);
            width: 4px;
            background: #f8f8f8;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.7);
        }

        .clock .digits .circle#min i {
            transform: scaleY(0.45);
            width: 3px;
            background: #2196f3;
            box-shadow: 0 0 5px rgba(33, 150, 243, 0.7);
        }

        .clock .digits .circle#sec i {
            transform: scaleY(0.55);
            width: 1px;
            background: #e91e63;
            box-shadow: 0 0 5px 1px #e91e63;
        }

        .digital-clock {
            font-size: 1.5rem;
            color: #152b4a;
            background: rgba(255, 255, 255, 0.3);
            padding: 10px 20px;
            border-radius: 10px;
            box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.1),
                inset 3px 3px 8px rgba(255, 255, 255, 0.5),
                -3px -3px 8px rgba(255, 255, 255, 0.5);
            display: flex;
            gap: 5px;
            align-items: center;
        }

        .date-display {
            font-size: 0.9rem;
            margin-top: 5px;
            color: #333;
            text-align: center;
        }

        .controls {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .controls button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            background: #c9d5e0;
            color: #152b4a;
            font-weight: 600;
            font-size: 0.8rem;
            cursor: pointer;
            box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.1),
                -3px -3px 5px rgba(255, 255, 255, 0.5);
            transition: all 0.3s;
        }

        .controls button:hover {
            background: #b8c4d0;
            transform: translateY(-1px);
        }

        .controls button:active {
            transform: translateY(0);
            box-shadow: inset 1px 1px 3px rgba(0, 0, 0, 0.1),
                inset -1px -1px 3px rgba(255, 255, 255, 0.5);
        }

        .theme-toggle {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 50px;
            height: 25px;
            background: #152b4a;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            padding: 0 5px;
            box-shadow: inset 1px 1px 3px rgba(0, 0, 0, 0.3),
                inset -1px -1px 3px rgba(255, 255, 255, 0.1);
        }

        .theme-toggle::before {
            content: '';
            position: absolute;
            width: 15px;
            height: 15px;
            background: #fff;
            border-radius: 50%;
            transition: transform 0.3s;
        }

        body.dark {
            background: #1a1a2e;
        }

        body.dark .clock {
            background: #2a2a3a;
            box-shadow: 15px 15px 20px -5px rgba(0, 0, 0, 0.3),
                inset 10px 10px 10px rgba(255, 255, 255, 0.1),
                -10px -10px 25px rgba(255, 255, 255, 0.1),
                inset -1px -1px 10px rgba(0, 0, 0, 0.4);
        }

        body.dark .digital-clock {
            color: #f8f8f8;
            background: rgba(0, 0, 0, 0.3);
        }

        body.dark .theme-toggle::before {
            transform: translateX(25px);
        }

        .tick {
            position: absolute;
            width: 1px;
            height: 5px;
            background: rgba(255, 255, 255, 0.7);
            transform-origin: bottom;
        }

        .tick.main {
            height: 8px;
            background: rgba(255, 255, 255, 0.9);
        }


        #dateDisplay {
            color: white;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-def fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                <i class="fas fa-shield-alt me-2"></i>PGESEM
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo e(url('/')); ?>">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fonctionnalités</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <?php if(auth()->guard()->guest()): ?>
                        <?php if(Route::has('login')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('login')); ?>">Connexion</a>
                            </li>
                        <?php endif; ?>

                        <?php if(Route::has('register')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('register')); ?>">Inscription</a>
                            </li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li class="nav-item">
                            <span class="nav-link text-white"><?php echo e(Auth::user()->name); ?></span>
                            <form action="<?php echo e(route('logout')); ?>" method="POST" class="ms-2">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Déconnexion
                                </button>
                            </form>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4" id='foot'>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="footer-def" id="footer">
        <br>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <a href="<?php echo e(url('/')); ?>" class="footer-logo">
                        <i class="fas fa-shield-alt me-2"></i>PGESEM
                    </a>

                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <div class="footer-links">
                        <h5>Liens</h5>
                        <ul>
                            <li><a href="<?php echo e(url('/')); ?>">Accueil</a></li>
                            <li><a href="#features">Services</a></li>
                            <li><a href="<?php echo e(route('register')); ?>">Inscription</a></li>
                            <li><a href="<?php echo e(route('login')); ?>">Connexion</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-links">
                        <h5>Services</h5>
                        <ul>
                            <li><a href="#">Gestion des cours</a></li>
                            <li><a href="#">Suivi des élèves</a></li>
                            <li><a href="#">Ressources pédagogiques</a></li>
                            <li><a href="#">Formations spécialisées</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-12">
                    <div class="footer-clock-container">
                        <div class="clock-container">
                            <div class="clock">
                                <div class="digits">
                                    <!-- All 12 hour markers -->
                                    <span style="--i:0;"><b>12</b></span>
                                    <span style="--i:1;"><b>1</b></span>
                                    <span style="--i:2;"><b>2</b></span>
                                    <span style="--i:3;"><b>3</b></span>
                                    <span style="--i:4;"><b>4</b></span>
                                    <span style="--i:5;"><b>5</b></span>
                                    <span style="--i:6;"><b>6</b></span>
                                    <span style="--i:7;"><b>7</b></span>
                                    <span style="--i:8;"><b>8</b></span>
                                    <span style="--i:9;"><b>9</b></span>
                                    <span style="--i:10;"><b>10</b></span>
                                    <span style="--i:11;"><b>11</b></span>

                                    <!-- Minute ticks -->
                                    <div id="ticks"></div>

                                    <div class="circle" id="hr"><i></i></div>
                                    <div class="circle" id="min"><i></i></div>
                                    <div class="circle" id="sec"><i></i></div>
                                </div>
                            </div>

                            <div class="digital-clock">
                                <span id="hours">00</span>:<span id="minutes">00</span>:<span
                                    id="seconds">00</span>
                                <span id="ampm">AM</span>
                            </div>

                            <div class="date-display" id="dateDisplay"></div>

                            <div class="controls">
                                <button id="formatToggle">12/24 Hour</button>
                                <button id="themeButton">Toggle Theme</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p class="mb-0">&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name', 'SchoolConnect')); ?> - Ministère de
                    la Défense. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo e(asset('js/java.js')); ?>"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Clock elements
            const hrHand = document.querySelector('#hr i');
            const minHand = document.querySelector('#min i');
            const secHand = document.querySelector('#sec i');
            const hoursDisplay = document.querySelector('#hours');
            const minutesDisplay = document.querySelector('#minutes');
            const secondsDisplay = document.querySelector('#seconds');
            const ampmDisplay = document.querySelector('#ampm');
            const dateDisplay = document.querySelector('#dateDisplay');
            const formatToggle = document.querySelector('#formatToggle');
            const themeButton = document.querySelector('#themeButton');
            const ticksContainer = document.querySelector('#ticks');

            // Settings
            let is24HourFormat = false;
            let isDarkTheme = false;

            // Create minute ticks
            function createTicks() {
                for (let i = 0; i < 60; i++) {
                    const tick = document.createElement('div');
                    tick.className = 'tick';

                    if (i % 5 === 0) {
                        tick.classList.add('main');
                    }
                    tick.style.transform = `rotate(${i * 6}deg) translateY(-70px)`;
                    ticksContainer.appendChild(tick);
                }
            }

            // Update clock function
            function updateClock() {
                const now = new Date();

                // Analog clock
                const hours = now.getHours();
                const minutes = now.getMinutes();
                const seconds = now.getSeconds();
                const milliseconds = now.getMilliseconds();

                // Smooth movement for analog hands
                const smoothSeconds = seconds + milliseconds / 1000;
                const smoothMinutes = minutes + smoothSeconds / 60;
                const smoothHours = (hours % 12) + smoothMinutes / 60;

                const hrRotation = smoothHours * 30;
                const minRotation = smoothMinutes * 6;
                const secRotation = smoothSeconds * 6;

                hrHand.style.transform = `rotate(${hrRotation}deg)`;
                minHand.style.transform = `rotate(${minRotation}deg)`;
                secHand.style.transform = `rotate(${secRotation}deg)`;

                // Digital clock
                let displayHours = hours;
                let ampm = 'AM';

                if (!is24HourFormat) {
                    if (displayHours >= 12) {
                        ampm = 'PM';
                        if (displayHours > 12) {
                            displayHours -= 12;
                        }
                    }
                    if (displayHours === 0) {
                        displayHours = 12;
                    }
                    ampmDisplay.style.display = 'block';
                } else {
                    ampmDisplay.style.display = 'none';
                }

                hoursDisplay.textContent = displayHours.toString().padStart(2, '0');
                minutesDisplay.textContent = minutes.toString().padStart(2, '0');
                secondsDisplay.textContent = seconds.toString().padStart(2, '0');
                ampmDisplay.textContent = ampm;

                // Date display
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                dateDisplay.textContent = now.toLocaleDateString(undefined, options);

                // Smooth animation
                requestAnimationFrame(updateClock);
            }

            // Toggle time format
            formatToggle.addEventListener('click', () => {
                is24HourFormat = !is24HourFormat;
                formatToggle.textContent = is24HourFormat ? '12 Hour' : '24 Hour';
            });

            // Toggle theme
            function toggleTheme() {
                isDarkTheme = !isDarkTheme;
                document.body.classList.toggle('dark', isDarkTheme);
                // Save preference to localStorage
                localStorage.setItem('clockTheme', isDarkTheme ? 'dark' : 'light');
            }

            themeButton.addEventListener('click', toggleTheme);

            // Check for saved theme preference
            function checkThemePreference() {
                const savedTheme = localStorage.getItem('clockTheme');
                if (savedTheme === 'dark') {
                    isDarkTheme = true;
                    document.body.classList.add('dark');
                }
            }

            // Initialize
            function init() {
                createTicks();
                checkThemePreference();
                updateClock();
            }

            init();
        });
    </script>



</body>

</html>
<?php /**PATH /home/sayajin/Documents/Gestion_note/resources/views/layouts/app.blade.php ENDPATH**/ ?>