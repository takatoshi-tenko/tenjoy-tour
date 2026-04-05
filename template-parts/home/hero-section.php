<?php

/**
 * トップページ: ヒーロー
 *
 * @package Friend2026
 */

$properties_url = home_url('/properties/');
$contact_url    = home_url('/contact/');
?>

<section class="front-hero">
  <div class="front-hero-bg"></div>
  <div class="container front-hero-inner">
    <div class="front-hero-content">
      <div class="front-hero-logo">
        <img src="<?php echo esc_url(FRIEND2026_URI . '/assets/images/logo.png'); ?>" alt="<?php bloginfo('name'); ?>"
          width="120" height="120" loading="eager">
      </div>
      <p class="front-hero-label">To the Plus Future</p>
      <h1 class="front-hero-title">
        <span class="front-hero-title-serif">理想の住まいに</span><br class="front-hero-br-mobile">
        <span class="front-hero-title-accent">プラス</span><span class="front-hero-title-serif">の価値を</span>
      </h1>
      <p class="front-hero-desc">
        東京23区・多摩エリアを中心に、新築一戸建て、中古一戸建て、マンション、土地など<br class="front-hero-br-desk">
        お客様の理想の住まい探しをサポートいたします。
      </p>
      <div class="front-hero-cta">
        <a href="<?php echo esc_url($properties_url); ?>" class="btn btn-accent btn-lg">
          掲載物件一覧を見る
        </a>
        <a href="<?php echo esc_url($contact_url); ?>" class="btn btn-outline-hero btn-lg">
          無料相談予約
        </a>
      </div>
      <div class="front-hero-quick">
        <a href="<?php echo esc_url($properties_url . '?type=new-house'); ?>" class="front-hero-quick-item">新築一戸建て</a>
        <a href="<?php echo esc_url($properties_url . '?type=apartment'); ?>" class="front-hero-quick-item">マンション</a>
        <a href="<?php echo esc_url($properties_url . '?type=used-house'); ?>" class="front-hero-quick-item">中古一戸建て</a>
        <a href="<?php echo esc_url($properties_url . '?type=land'); ?>" class="front-hero-quick-item">土地</a>
      </div>
    </div>
  </div>
</section>