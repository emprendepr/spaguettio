// Parallax effect for mockups on scroll
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const desktop = document.querySelector('.mockup-desktop');
    const mobile = document.querySelector('.mockup-mobile');
    
    if (desktop && mobile && window.innerWidth > 1024) {
        // Apply parallax only on desktop screens
        desktop.style.transform = `translateY(${scrolled * 0.1}px)`;
        mobile.style.transform = `translateY(${scrolled * 0.15}px) rotate(2deg)`;
    }
});

// Smooth scroll for CTA buttons (if needed for internal navigation)
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Form validation (basic example)
const registrationForm = document.querySelector('.registration-form');
if (registrationForm) {
    registrationForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const inputs = registrationForm.querySelectorAll('.form-input');
        let isValid = true;
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.style.borderColor = '#ff5f56';
            } else {
                input.style.borderColor = 'rgba(200, 255, 0, 0.1)';
            }
        });
        
        if (isValid) {
            // Form is valid, you can submit it here
            console.log('Form is valid and ready to submit');
            alert('¡Gracias por registrarte! Te contactaremos pronto.');
        } else {
            alert('Por favor completa todos los campos');
        }
    });
}

// Add hover effect enhancement for mock cards
const mockCards = document.querySelectorAll('.mock-card');
mockCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.borderColor = '#c8ff00';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.borderColor = 'rgba(200, 255, 0, 0.1)';
    });
});

// Reset parallax on window resize to avoid issues
let resizeTimer;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        const desktop = document.querySelector('.mockup-desktop');
        const mobile = document.querySelector('.mockup-mobile');
        
        if (window.innerWidth <= 1024) {
            if (desktop) desktop.style.transform = '';
            if (mobile) mobile.style.transform = '';
        }
    }, 250);
});
