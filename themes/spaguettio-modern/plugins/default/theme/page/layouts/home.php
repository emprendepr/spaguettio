<?php
/**
 * Landing Page Home Layout - Spaguettio Modern Theme
 * Este layout se muestra solo para usuarios no logueados
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spaguettio - <?php echo ossn_print('spaguettio:hero:subtitle'); ?></title>
</head>
<body class="spaguettio-landing">
    <!-- Grid Background -->
    <div class="spaguettio-grid-bg"></div>

    <!-- Header -->
    <header class="spaguettio-header">
        <div class="container">
            <div class="spaguettio-header-content">
                <div class="spaguettio-logo">
                    <a href="<?php echo ossn_site_url(); ?>">
                        <h1>SPAGUETTIO</h1>
                    </a>
                </div>
                <nav class="spaguettio-nav">
                    <a href="#features"><?php echo ossn_print('spaguettio:nav:features'); ?></a>
                    <a href="#stats"><?php echo ossn_print('spaguettio:nav:stats'); ?></a>
                    <a href="#cta"><?php echo ossn_print('spaguettio:nav:join'); ?></a>
                    <a href="<?php echo ossn_site_url('login'); ?>" class="spaguettio-btn-outline">
                        <?php echo ossn_print('spaguettio:nav:login'); ?>
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="spaguettio-hero">
        <div class="container">
            <div class="spaguettio-hero-content">
                <div class="spaguettio-hero-left">
                    <h1 class="spaguettio-hero-title">
                        <span class="spaguettio-title-line"><?php echo ossn_print('spaguettio:hero:title:line1'); ?></span>
                        <span class="spaguettio-title-line"><?php echo ossn_print('spaguettio:hero:title:line2'); ?></span>
                        <span class="spaguettio-title-line"><?php echo ossn_print('spaguettio:hero:title:line3'); ?></span>
                        <span class="spaguettio-title-line"><?php echo ossn_print('spaguettio:hero:title:line4'); ?></span>
                        <span class="spaguettio-title-line spaguettio-highlight"><?php echo ossn_print('spaguettio:hero:title:line5'); ?></span>
                    </h1>
                    <p class="spaguettio-hero-subtitle">
                        <?php echo ossn_print('spaguettio:hero:subtitle'); ?>
                    </p>
                    <div class="spaguettio-hero-buttons">
                        <a href="#register" class="spaguettio-btn-primary">
                            <?php echo ossn_print('spaguettio:cta:primary'); ?>
                        </a>
                        <a href="#features" class="spaguettio-btn-secondary">
                            <?php echo ossn_print('spaguettio:cta:secondary'); ?>
                        </a>
                    </div>
                </div>
                <div class="spaguettio-hero-right">
                    <!-- Círculo animado -->
                    <div class="spaguettio-circle">
                        <svg viewBox="0 0 200 200" class="spaguettio-circle-svg">
                            <circle cx="100" cy="100" r="80" fill="none" stroke="currentColor" stroke-width="0.5" />
                            <circle cx="100" cy="100" r="60" fill="none" stroke="currentColor" stroke-width="0.5" />
                            <circle cx="100" cy="100" r="40" fill="none" stroke="currentColor" stroke-width="0.5" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Register Section -->
    <section id="register" class="spaguettio-register">
        <div class="container">
            <div class="spaguettio-register-content">
                <h2><?php echo ossn_print('spaguettio:register:title'); ?></h2>
                <p><?php echo ossn_print('spaguettio:register:subtitle'); ?></p>
                
                <form action="<?php echo ossn_site_url('action/user/register', true); ?>" method="post" class="spaguettio-form">
                    <?php echo ossn_view('input/securitytoken'); ?>
                    
                    <div class="spaguettio-form-row">
                        <div class="spaguettio-form-group">
                            <label for="first_name"><?php echo ossn_print('spaguettio:form:firstname'); ?></label>
                            <input type="text" id="first_name" name="first_name" required placeholder="<?php echo ossn_print('spaguettio:form:firstname:placeholder'); ?>">
                        </div>
                        <div class="spaguettio-form-group">
                            <label for="last_name"><?php echo ossn_print('spaguettio:form:lastname'); ?></label>
                            <input type="text" id="last_name" name="last_name" required placeholder="<?php echo ossn_print('spaguettio:form:lastname:placeholder'); ?>">
                        </div>
                    </div>

                    <div class="spaguettio-form-group">
                        <label for="username"><?php echo ossn_print('spaguettio:form:username'); ?></label>
                        <input type="text" id="username" name="username" required placeholder="<?php echo ossn_print('spaguettio:form:username:placeholder'); ?>">
                    </div>

                    <div class="spaguettio-form-group">
                        <label for="email"><?php echo ossn_print('spaguettio:form:email'); ?></label>
                        <input type="email" id="email" name="email" required placeholder="<?php echo ossn_print('spaguettio:form:email:placeholder'); ?>">
                    </div>

                    <div class="spaguettio-form-row">
                        <div class="spaguettio-form-group">
                            <label for="password"><?php echo ossn_print('spaguettio:form:password'); ?></label>
                            <input type="password" id="password" name="password" required placeholder="<?php echo ossn_print('spaguettio:form:password:placeholder'); ?>">
                        </div>
                        <div class="spaguettio-form-group">
                            <label for="password_confirm"><?php echo ossn_print('spaguettio:form:password:confirm'); ?></label>
                            <input type="password" id="password_confirm" name="password_confirm" required placeholder="<?php echo ossn_print('spaguettio:form:password:confirm:placeholder'); ?>">
                        </div>
                    </div>

                    <div class="spaguettio-form-group spaguettio-gender-select">
                        <label><?php echo ossn_print('spaguettio:form:gender'); ?></label>
                        <div class="spaguettio-gender-options">
                            <label class="spaguettio-gender-option">
                                <input type="radio" name="gender" value="male" required>
                                <span><?php echo ossn_print('spaguettio:form:gender:male'); ?></span>
                            </label>
                            <label class="spaguettio-gender-option">
                                <input type="radio" name="gender" value="female" required>
                                <span><?php echo ossn_print('spaguettio:form:gender:female'); ?></span>
                            </label>
                            <label class="spaguettio-gender-option">
                                <input type="radio" name="gender" value="couple" required>
                                <span><?php echo ossn_print('spaguettio:form:gender:couple'); ?></span>
                            </label>
                        </div>
                    </div>

                    <div class="spaguettio-form-group">
                        <label class="spaguettio-checkbox">
                            <input type="checkbox" name="terms" required>
                            <span><?php echo ossn_print('spaguettio:form:terms'); ?></span>
                        </label>
                    </div>

                    <button type="submit" class="spaguettio-btn-submit">
                        <?php echo ossn_print('spaguettio:form:submit'); ?>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="spaguettio-features">
        <div class="container">
            <h2 class="spaguettio-section-title"><?php echo ossn_print('spaguettio:features:title'); ?></h2>
            <div class="spaguettio-features-grid">
                <div class="spaguettio-feature-card">
                    <div class="spaguettio-feature-icon">🔒</div>
                    <h3><?php echo ossn_print('spaguettio:feature1:title'); ?></h3>
                    <p><?php echo ossn_print('spaguettio:feature1:desc'); ?></p>
                </div>
                <div class="spaguettio-feature-card">
                    <div class="spaguettio-feature-icon">💑</div>
                    <h3><?php echo ossn_print('spaguettio:feature2:title'); ?></h3>
                    <p><?php echo ossn_print('spaguettio:feature2:desc'); ?></p>
                </div>
                <div class="spaguettio-feature-card">
                    <div class="spaguettio-feature-icon">🌐</div>
                    <h3><?php echo ossn_print('spaguettio:feature3:title'); ?></h3>
                    <p><?php echo ossn_print('spaguettio:feature3:desc'); ?></p>
                </div>
                <div class="spaguettio-feature-card">
                    <div class="spaguettio-feature-icon">💬</div>
                    <h3><?php echo ossn_print('spaguettio:feature4:title'); ?></h3>
                    <p><?php echo ossn_print('spaguettio:feature4:desc'); ?></p>
                </div>
                <div class="spaguettio-feature-card">
                    <div class="spaguettio-feature-icon">✨</div>
                    <h3><?php echo ossn_print('spaguettio:feature5:title'); ?></h3>
                    <p><?php echo ossn_print('spaguettio:feature5:desc'); ?></p>
                </div>
                <div class="spaguettio-feature-card">
                    <div class="spaguettio-feature-icon">🎉</div>
                    <h3><?php echo ossn_print('spaguettio:feature6:title'); ?></h3>
                    <p><?php echo ossn_print('spaguettio:feature6:desc'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="spaguettio-stats">
        <div class="container">
            <div class="spaguettio-stats-grid">
                <div class="spaguettio-stat">
                    <div class="spaguettio-stat-number">10K+</div>
                    <div class="spaguettio-stat-label"><?php echo ossn_print('spaguettio:stat1:label'); ?></div>
                </div>
                <div class="spaguettio-stat">
                    <div class="spaguettio-stat-number">5K+</div>
                    <div class="spaguettio-stat-label"><?php echo ossn_print('spaguettio:stat2:label'); ?></div>
                </div>
                <div class="spaguettio-stat">
                    <div class="spaguettio-stat-number">50K+</div>
                    <div class="spaguettio-stat-label"><?php echo ossn_print('spaguettio:stat3:label'); ?></div>
                </div>
                <div class="spaguettio-stat">
                    <div class="spaguettio-stat-number">99.9%</div>
                    <div class="spaguettio-stat-label"><?php echo ossn_print('spaguettio:stat4:label'); ?></div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="cta" class="spaguettio-cta">
        <div class="container">
            <div class="spaguettio-cta-content">
                <h2><?php echo ossn_print('spaguettio:cta:title'); ?></h2>
                <p><?php echo ossn_print('spaguettio:cta:subtitle'); ?></p>
                <a href="#register" class="spaguettio-btn-cta">
                    <?php echo ossn_print('spaguettio:cta:button'); ?>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="spaguettio-footer">
        <div class="container">
            <div class="spaguettio-footer-content">
                <div class="spaguettio-footer-section">
                    <h3>SPAGUETTIO</h3>
                    <p><?php echo ossn_print('spaguettio:footer:about'); ?></p>
                </div>
                <div class="spaguettio-footer-section">
                    <h4><?php echo ossn_print('spaguettio:footer:links:title'); ?></h4>
                    <ul>
                        <li><a href="<?php echo ossn_site_url('about'); ?>"><?php echo ossn_print('spaguettio:footer:about:link'); ?></a></li>
                        <li><a href="<?php echo ossn_site_url('terms'); ?>"><?php echo ossn_print('spaguettio:footer:terms'); ?></a></li>
                        <li><a href="<?php echo ossn_site_url('privacy'); ?>"><?php echo ossn_print('spaguettio:footer:privacy'); ?></a></li>
                    </ul>
                </div>
                <div class="spaguettio-footer-section">
                    <h4><?php echo ossn_print('spaguettio:footer:social:title'); ?></h4>
                    <div class="spaguettio-social-links">
                        <a href="#" class="spaguettio-social-link">Facebook</a>
                        <a href="#" class="spaguettio-social-link">Twitter</a>
                        <a href="#" class="spaguettio-social-link">Instagram</a>
                    </div>
                </div>
            </div>
            <div class="spaguettio-footer-bottom">
                <p>&copy; 2026 Spaguettio. <?php echo ossn_print('spaguettio:footer:rights'); ?></p>
            </div>
        </div>
    </footer>
</body>
</html>
