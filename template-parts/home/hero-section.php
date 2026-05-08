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
    if ($hero_url) :
    ?>
    <img
      src="<?php echo esc_url($hero_url); ?>"
      alt="<?php esc_attr_e('ゴルフコース', 'tenjoy-tour'); ?>"
      class="hero-img"
      loading="eager"
      decoding="async">
    <?php endif; ?>
  </div>
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <div class="container">
      <div class="hero-text">
        <h1 class="hero-title">
          <?php esc_html_e('日本のゴルフ手配専門', 'tenjoy-tour'); ?>
        </h1>
        <p class="hero-subtitle">
          <?php esc_html_e('訪日ゴルファーの皆様へ、ゴルフ場予約・送迎を完全サポート', 'tenjoy-tour'); ?>
        </p>
        <div class="hero-cta">
          <a href="#contact" class="btn btn-primary btn-lg">
            <?php esc_html_e('お問い合わせ', 'tenjoy-tour'); ?>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
