<?php

/**
 * ヒーローセクション
 *
 * @package tenjoy-tour
 */
?>
<section class="hero-section">
  <div class="hero-bg">
    <?php
    $hero_url = tenjoy_customizer_image_url(
      'tenjoy_hero_image',
      'tenjoy-hero',
      get_template_directory_uri() . '/assets/images/hero-golf.jpg'
    );
    $hero_position = get_theme_mod('tenjoy_hero_image_position', 'center center');
    if ($hero_url) :
    ?>
      <img src="<?php echo esc_url($hero_url); ?>" alt="<?php tenjoy_attr_e('hero_01'); ?>" class="hero-img"
        style="object-position: <?php echo esc_attr($hero_position); ?>;" loading="eager" decoding="async">
    <?php endif; ?>
  </div>
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <div class="container">
      <div class="hero-text">
        <h1 class="hero-title">
          <?php tenjoy_e('hero_02'); ?>
        </h1>
        <p class="hero-subtitle">
          <?php tenjoy_e('hero_03'); ?>
        </p>
        <div class="hero-cta">
          <a href="#contact" class="btn btn-primary btn-lg">
            <?php tenjoy_e('nav_06'); ?>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>