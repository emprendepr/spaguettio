/**
 * Spaguettio Modern Theme - JavaScript
 * Animaciones y funcionalidades interactivas
 */

(function() {
    'use strict';

    // Esperar a que el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    function init() {
        // Solo ejecutar en la landing page
        if (!document.body.classList.contains('spaguettio-landing')) {
            return;
        }

        initSmoothScroll();
        initFormInteractions();
        initIntersectionObserver();
        initParallax();
    }

    /**
     * Smooth scroll para enlaces internos
     */
    function initSmoothScroll() {
        const links = document.querySelectorAll('a[href^="#"]');
        
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                // Ignorar enlaces vacíos o solo con #
                if (href === '#' || href === '') {
                    return;
                }

                const target = document.querySelector(href);
                
                if (target) {
                    e.preventDefault();
                    
                    const headerHeight = document.querySelector('.spaguettio-header')?.offsetHeight || 0;
                    const targetPosition = target.offsetTop - headerHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    /**
     * Interacciones del formulario
     */
    function initFormInteractions() {
        const form = document.querySelector('.spaguettio-form');
        
        if (!form) {
            return;
        }

        // Validación en tiempo real
        const inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
        
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateInput(this);
            });

            input.addEventListener('input', function() {
                if (this.classList.contains('error')) {
                    validateInput(this);
                }
            });
        });

        // Validación de contraseñas coincidentes
        const password = form.querySelector('#password');
        const passwordConfirm = form.querySelector('#password_confirm');

        if (password && passwordConfirm) {
            passwordConfirm.addEventListener('blur', function() {
                if (this.value !== password.value) {
                    this.setCustomValidity('Las contraseñas no coinciden');
                    this.classList.add('error');
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('error');
                }
            });
        }

        // Animación de las opciones de género
        const genderOptions = form.querySelectorAll('.spaguettio-gender-option');
        
        genderOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Añadir animación de selección
                const span = this.querySelector('span');
                if (span) {
                    span.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        span.style.transform = 'scale(1)';
                    }, 100);
                }
            });
        });

        // Prevenir envío si hay errores
        form.addEventListener('submit', function(e) {
            let hasErrors = false;

            inputs.forEach(input => {
                if (!validateInput(input)) {
                    hasErrors = true;
                }
            });

            if (hasErrors) {
                e.preventDefault();
                // Scroll al primer error
                const firstError = form.querySelector('.error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    }

    /**
     * Validar un input individual
     */
    function validateInput(input) {
        const value = input.value.trim();
        
        // Validación básica
        if (input.hasAttribute('required') && !value) {
            input.classList.add('error');
            return false;
        }

        // Validación de email
        if (input.type === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                input.classList.add('error');
                return false;
            }
        }

        // Validación de username (sin espacios)
        if (input.id === 'username') {
            if (value.includes(' ')) {
                input.classList.add('error');
                return false;
            }
        }

        // Validación de contraseña (mínimo 6 caracteres)
        if (input.type === 'password' && input.id === 'password') {
            if (value.length < 6) {
                input.classList.add('error');
                return false;
            }
        }

        input.classList.remove('error');
        return true;
    }

    /**
     * Intersection Observer para animaciones de scroll
     */
    function initIntersectionObserver() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observar elementos que deben animarse
        const animatedElements = document.querySelectorAll(
            '.spaguettio-feature-card, .spaguettio-stat, .spaguettio-register-content, .spaguettio-cta-content'
        );

        animatedElements.forEach(el => {
            observer.observe(el);
        });
    }

    /**
     * Efecto parallax sutil en el hero
     */
    function initParallax() {
        const circle = document.querySelector('.spaguettio-circle');
        
        if (!circle) {
            return;
        }

        let ticking = false;

        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    const scrollY = window.scrollY;
                    const parallaxSpeed = 0.5;
                    
                    // Solo aplicar parallax en la sección hero
                    if (scrollY < window.innerHeight) {
                        circle.style.transform = `translateY(${scrollY * parallaxSpeed}px) rotate(${scrollY * 0.1}deg)`;
                    }
                    
                    ticking = false;
                });
                
                ticking = true;
            }
        });
    }

    /**
     * Agregar clase de error al CSS para inputs inválidos
     */
    const style = document.createElement('style');
    style.textContent = `
        .spaguettio-form input.error {
            border-color: #ff4444 !important;
            box-shadow: 0 0 20px rgba(255, 68, 68, 0.2) !important;
        }
    `;
    document.head.appendChild(style);

})();
