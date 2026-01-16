<?php
/**
 * Modern Landing Page for Spaguettio
 * Only shown to non-logged users
 * 
 * @package Spaguettio Modern Theme
 */

// Security check - only show to non-logged users
if(ossn_isLoggedin()) {
    return;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spaguettio - La Red Social para Parejas</title>
</head>
<body class="spaguettio-landing">

    <!-- Header -->
    <header class="landing-header">
        <div class="container">
            <div class="header-content">
                <div class="logo-section">
                    <h1 class="logo">SPAGUETTIO <span class="beta-badge">Beta</span></h1>
                </div>
                <nav class="header-nav">
                    <a href="<?php echo ossn_site_url('login'); ?>" class="btn btn-outline">Login</a>
                    <a href="#register-form" class="btn btn-primary smooth-scroll">Registrarse</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-grid">
                <!-- Left Column: Content -->
                <div class="hero-content">
                    <div class="hero-title-wrapper">
                        <h2 class="hero-title">
                            LET'S CONNECT<br>
                            THE DIGITAL WORLD<br>
                            IN A <span class="highlight">CIRCLE</span>
                        </h2>
                        <div class="animated-circle"></div>
                    </div>
                    
                    <p class="hero-subtitle">
                        La red social más elegante y discreta para parejas modernas. 
                        Conéctate, verifica tu relación y explora una comunidad exclusiva.
                    </p>

                    <div class="hero-buttons">
                        <a href="#register-form" class="btn btn-primary btn-large smooth-scroll">Get Started Now</a>
                        <a href="#features" class="btn btn-outline btn-large smooth-scroll">Explorar Más</a>
                    </div>

                    <!-- Services List -->
                    <div class="services-list">
                        <h3 class="services-title">Servicios Exclusivos:</h3>
                        <ul class="services-grid">
                            <li><span class="bullet">●</span> Verificación de Parejas</li>
                            <li><span class="bullet">●</span> Chat Seguro</li>
                            <li><span class="bullet">●</span> Eventos Exclusivos</li>
                            <li><span class="bullet">●</span> Galería Privada</li>
                            <li><span class="bullet">●</span> Comunidad Global</li>
                            <li><span class="bullet">●</span> Privacidad Total</li>
                        </ul>
                    </div>
                </div>

                <!-- Right Column: Registration Form -->
                <div class="hero-form" id="register-form">
                    <div class="form-card">
                        <h3 class="form-title">Únete Ahora</h3>
                        <p class="form-subtitle">Crea tu cuenta en segundos</p>
                        
                        <form action="<?php echo ossn_site_url('action/user/register'); ?>" method="post" class="ossn-form">
                            <?php echo ossn_plugin_view('input/security_token'); ?>
                            
                            <div class="form-group">
                                <input type="text" 
                                       name="firstname" 
                                       placeholder="Nombre" 
                                       required 
                                       class="form-control" />
                            </div>

                            <div class="form-group">
                                <input type="text" 
                                       name="lastname" 
                                       placeholder="Apellido" 
                                       required 
                                       class="form-control" />
                            </div>

                            <div class="form-group">
                                <input type="email" 
                                       name="email" 
                                       placeholder="Email" 
                                       required 
                                       class="form-control" />
                            </div>

                            <div class="form-group">
                                <input type="email" 
                                       name="email_confirm" 
                                       placeholder="Confirmar Email" 
                                       required 
                                       class="form-control" />
                            </div>

                            <div class="form-group">
                                <input type="text" 
                                       name="username" 
                                       placeholder="Usuario" 
                                       required 
                                       class="form-control" />
                            </div>

                            <div class="form-group">
                                <input type="password" 
                                       name="password" 
                                       placeholder="Contraseña" 
                                       required 
                                       class="form-control" />
                            </div>

                            <!-- Gender Selection -->
                            <div class="form-group">
                                <label class="form-label">Género:</label>
                                <div class="gender-options">
                                    <label class="gender-option">
                                        <input type="radio" name="gender" value="male" required />
                                        <span class="gender-text">Masculino</span>
                                    </label>
                                    <label class="gender-option">
                                        <input type="radio" name="gender" value="female" required />
                                        <span class="gender-text">Femenino</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Birthdate -->
                            <div class="form-group">
                                <label class="form-label">Fecha de Nacimiento:</label>
                                <input type="date" 
                                       name="birthdate" 
                                       required 
                                       class="form-control"
                                       max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>" />
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="form-group checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="terms" required />
                                    <span>Acepto los <a href="#" class="link">términos y condiciones</a></span>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                Crear Cuenta
                            </button>

                            <p class="form-footer">
                                ¿Ya tienes cuenta? <a href="<?php echo ossn_site_url('login'); ?>" class="link">Inicia sesión</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Decorative Label -->
        <div class="explore-label">EXPLORE MORE POPULAR</div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="section-title">¿Por qué Spaguettio?</h2>
            <p class="section-subtitle">Descubre las ventajas de nuestra plataforma exclusiva</p>

            <div class="features-grid">
                <!-- Feature 1 -->
                <div class="feature-card">
                    <div class="feature-icon">💑</div>
                    <h3 class="feature-title">Parejas Verificadas</h3>
                    <p class="feature-description">
                        Sistema de verificación único que garantiza autenticidad y seguridad en cada conexión.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h3 class="feature-title">Privacidad Total</h3>
                    <p class="feature-description">
                        Control absoluto sobre tu información. Tu privacidad es nuestra prioridad máxima.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card">
                    <div class="feature-icon">🌐</div>
                    <h3 class="feature-title">Comunidad Global</h3>
                    <p class="feature-description">
                        Conéctate con parejas de todo el mundo en un ambiente seguro y respetuoso.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card">
                    <div class="feature-icon">📸</div>
                    <h3 class="feature-title">Galería Privada</h3>
                    <p class="feature-description">
                        Comparte momentos especiales solo con quien tú decides. Control total de visibilidad.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card">
                    <div class="feature-icon">📅</div>
                    <h3 class="feature-title">Eventos Exclusivos</h3>
                    <p class="feature-description">
                        Accede a eventos privados, reuniones y actividades diseñadas para la comunidad.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card">
                    <div class="feature-icon">💬</div>
                    <h3 class="feature-title">Chat Seguro</h3>
                    <p class="feature-description">
                        Comunicación encriptada y segura. Mensajería diseñada para tu tranquilidad.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">50K+</div>
                    <div class="stat-label">Miembros Activos</div>
                </div>

                <div class="stat-card">
                    <div class="stat-number">15K+</div>
                    <div class="stat-label">Parejas Verificadas</div>
                </div>

                <div class="stat-card">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Satisfacción</div>
                </div>

                <div class="stat-card">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Soporte</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title">Únete a la comunidad hoy</h2>
            <p class="cta-description">
                Miles de parejas ya confían en Spaguettio. Descubre una nueva forma de conectar.
            </p>
            <div class="cta-buttons">
                <a href="#register-form" class="btn btn-primary btn-large smooth-scroll">Comenzar Ahora</a>
                <a href="#features" class="btn btn-outline btn-large smooth-scroll">Saber Más</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="landing-footer">
        <div class="container">
            <div class="footer-grid">
                <!-- Brand Column -->
                <div class="footer-col">
                    <h3 class="footer-brand">SPAGUETTIO</h3>
                    <p class="footer-description">
                        La red social más elegante para parejas modernas. Privacidad, seguridad y comunidad.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Facebook">F</a>
                        <a href="#" class="social-link" aria-label="Twitter">T</a>
                        <a href="#" class="social-link" aria-label="Instagram">I</a>
                        <a href="#" class="social-link" aria-label="LinkedIn">L</a>
                    </div>
                </div>

                <!-- Producto Column -->
                <div class="footer-col">
                    <h4 class="footer-title">Producto</h4>
                    <ul class="footer-links">
                        <li><a href="#">Características</a></li>
                        <li><a href="#">Precios</a></li>
                        <li><a href="#">Seguridad</a></li>
                        <li><a href="#">Roadmap</a></li>
                    </ul>
                </div>

                <!-- Compañía Column -->
                <div class="footer-col">
                    <h4 class="footer-title">Compañía</h4>
                    <ul class="footer-links">
                        <li><a href="#">Sobre Nosotros</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Carreras</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>

                <!-- Recursos Column -->
                <div class="footer-col">
                    <h4 class="footer-title">Recursos</h4>
                    <ul class="footer-links">
                        <li><a href="#">Centro de Ayuda</a></li>
                        <li><a href="#">Comunidad</a></li>
                        <li><a href="#">Guías</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>

                <!-- Legal Column -->
                <div class="footer-col">
                    <h4 class="footer-title">Legal</h4>
                    <ul class="footer-links">
                        <li><a href="#">Términos</a></li>
                        <li><a href="#">Privacidad</a></li>
                        <li><a href="#">Cookies</a></li>
                        <li><a href="#">Licencias</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p class="copyright">
                    © <?php echo date('Y'); ?> Spaguettio. Todos los derechos reservados.
                </p>
                <p class="powered-by">
                    Powered by <a href="https://www.opensource-socialnetwork.org/" target="_blank" rel="noopener">OSSN</a>
                </p>
            </div>
        </div>
    </footer>

</body>
</html>
