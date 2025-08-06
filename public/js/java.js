
document.addEventListener('DOMContentLoaded', function () {

    const authTabs = document.querySelectorAll('.auth-tab');
    const authForms = document.querySelectorAll('.auth-form');

    authTabs.forEach(tab => {
        tab.addEventListener('click', function () {
            const formType = this.getAttribute('data-form');


            authTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            authForms.forEach(form => form.classList.remove('active'));
            document.getElementById(`${formType}-form`).classList.add('active');
        });
    });


    const animateElements = () => {
        const elements = document.querySelectorAll('.animate-on-scroll');
        const windowHeight = window.innerHeight;

        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const animationPoint = windowHeight - 100;

            if (elementPosition < animationPoint) {
                element.classList.add('animate__animated', 'animate__fadeInUp');
            }
        });
    };


    animateElements();


    window.addEventListener('scroll', animateElements);

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
});

//professseur

document.addEventListener('DOMContentLoaded', function () {
    // Limiter les notes à 20
    document.querySelectorAll('.note-input').forEach(input => {
        input.addEventListener('change', function () {
            if (parseFloat(this.value) > 20) {
                this.value = 20;
                alert('La note maximale est 20');
            }
        });
    });

    // Confirmation avant enregistrement
    const notesForm = document.getElementById('notesForm');
    if (notesForm) {
        notesForm.addEventListener('submit', function (e) {
            const hasNotes = Array.from(document.querySelectorAll('.note-input'))
                .some(input => input.value !== '');

            if (!hasNotes) {
                e.preventDefault();
                alert('Veuillez saisir au moins une note avant d\'enregistrer');
            }
        });
    }
});

function animateOnScroll() {
    const elements = document.querySelectorAll('.animate-on-scroll');

    elements.forEach(element => {
        const elementPosition = element.getBoundingClientRect().top;
        const screenPosition = window.innerHeight / 1.3;

        if (elementPosition < screenPosition) {
            element.classList.add('animate__animated', 'animate__fadeInUp');
        }
    });
}

window.addEventListener('scroll', animateOnScroll);
