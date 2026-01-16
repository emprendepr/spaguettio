/**
 * Spaguettio Modern Theme - JavaScript
 * Interactive features for the landing page
 */

(function() {
    'use strict';
    
    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
    function init() {
        // Only run on landing page
        if (!document.querySelector('.spaguettio-landing')) {
            return;
        }
        
        initSmoothScroll();
        initParallax();
        initFormInteractions();
        initGenderSelection();
    }
    
    /**
     * Smooth scroll for anchor links
     */
    function initSmoothScroll() {
        const anchors = document.querySelectorAll('a[href^="#"]');
        
        anchors.forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                
                // Skip if href is just "#"
                if (href === '#') {
                    e.preventDefault();
                    return;
                }
                
                const target = document.querySelector(href);
                
                if (target) {
                    e.preventDefault();
                    
                    // Get header height for offset
                    const header = document.querySelector('.landing-header');
                    const headerHeight = header ? header.offsetHeight : 0;
                    
                    // Calculate position with offset
                    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight - 20;
                    
                    // Smooth scroll to target
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }
    
    /**
     * Parallax effect on scroll
     */
    function initParallax() {
        const parallaxElements = document.querySelectorAll('.explore-label');
        
        if (parallaxElements.length === 0) {
            return;
        }
        
        let ticking = false;
        
        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    const scrolled = window.pageYOffset;
                    
                    parallaxElements.forEach(element => {
                        element.style.transform = `translateY(${scrolled * 0.3}px)`;
                    });
                    
                    ticking = false;
                });
                
                ticking = true;
            }
        });
    }
    
    /**
     * Form input interactions
     */
    function initFormInteractions() {
        const formInputs = document.querySelectorAll('.form-group input, .form-group select');
        
        formInputs.forEach(input => {
            // Focus effect
            input.addEventListener('focus', function() {
                const formGroup = this.closest('.form-group');
                if (formGroup) {
                    formGroup.style.transform = 'translateY(-2px)';
                }
            });
            
            // Blur effect
            input.addEventListener('blur', function() {
                const formGroup = this.closest('.form-group');
                if (formGroup) {
                    formGroup.style.transform = 'translateY(0)';
                }
            });
        });
        
        // Form validation feedback
        const form = document.querySelector('.ossn-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Clear previous error messages
                const existingErrors = form.querySelectorAll('.validation-error');
                existingErrors.forEach(error => error.remove());
                
                let hasErrors = false;
                
                const emailInput = form.querySelector('input[name="email"]');
                const emailConfirm = form.querySelector('input[name="email_confirm"]');
                
                if (emailInput && emailConfirm) {
                    if (emailInput.value !== emailConfirm.value) {
                        e.preventDefault();
                        showValidationError(emailConfirm, 'Los correos electrónicos no coinciden');
                        emailConfirm.focus();
                        hasErrors = true;
                    }
                }
                
                const termsCheckbox = form.querySelector('input[name="terms"]');
                if (termsCheckbox && !termsCheckbox.checked) {
                    e.preventDefault();
                    showValidationError(termsCheckbox, 'Debes aceptar los términos y condiciones');
                    hasErrors = true;
                }
                
                if (hasErrors) {
                    return false;
                }
            });
        }
        
        // Helper function to show validation errors
        function showValidationError(element, message) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'validation-error';
            errorDiv.textContent = message;
            errorDiv.style.color = 'var(--primary-color)';
            errorDiv.style.fontSize = '12px';
            errorDiv.style.marginTop = '5px';
            
            const formGroup = element.closest('.form-group');
            if (formGroup) {
                formGroup.appendChild(errorDiv);
            }
        }
    }
    
    /**
     * Gender radio selection visual feedback
     */
    function initGenderSelection() {
        const genderOptions = document.querySelectorAll('.gender-option');
        
        genderOptions.forEach(option => {
            option.addEventListener('click', function() {
                const radio = this.querySelector('input[type="radio"]');
                
                if (radio) {
                    radio.checked = true;
                    
                    // Visual feedback: remove active class from all, add to clicked
                    genderOptions.forEach(opt => {
                        opt.classList.remove('active');
                    });
                    
                    this.classList.add('active');
                }
            });
        });
    }
    
    /**
     * Add entrance animations on scroll
     */
    function initScrollAnimations() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, {
            threshold: 0.1
        });
        
        // Observe cards and sections
        const elements = document.querySelectorAll('.feature-card, .stat-card, .form-card');
        elements.forEach(el => observer.observe(el));
    }
    
    // Initialize scroll animations if IntersectionObserver is supported
    if ('IntersectionObserver' in window) {
        initScrollAnimations();
    }
    
})();
