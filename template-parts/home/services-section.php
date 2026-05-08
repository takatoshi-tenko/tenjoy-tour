<?php
/**
 * サービスセクション
 *
 * @package tenjoy-tour
 */

$services = [
  [
    'icon'        => 'calendar',
    'title'       => __('ゴルフ場予約', 'tenjoy-tour'),
    'description' => __('日本全国の名門ゴルフコースの予約を代行。お客様のご希望に合わせた最適なコースをご提案します。', 'tenjoy-tour'),
  ],
  [
    'icon'        => 'car',
    'title'       => __('空港送迎', 'tenjoy-tour'),
    'description' => __('空港からゴルフ場への送迎サービス。安全で快適な移動をサポートします。', 'tenjoy-tour'),
  ],
  [
    'icon'        => 'map-pin',
    'title'       => __('現地サポート', 'tenjoy-tour'),
    'description' => __('滞在中の困りごとや追加手配など、現地での24時間サポート体制を整えています。', 'tenjoy-tour'),
  ],
];
?>
<section id="services" class="services-section">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title"><?php esc_html_e('提供サービス', 'tenjoy-tour'); ?></h2>
      <p class="section-subtitle">
        <?php esc_html_e('日本でのゴルフを快適に楽しんでいただくため、あらゆる手配をサポートいたします', 'tenjoy-tour'); ?>
      </p>
    </div>
    <div class="services-grid">
      <?php foreach ($services as $service) : ?>
        <div class="service-card">
          <div class="service-icon">
            <?php echo tenjoy_icon(esc_attr($service['icon'])); // phpcs:ignore WordPress.Security.EscapeOutput ?>
          </div>
          <h3 class="service-title"><?php echo esc_html($service['title']); ?></h3>
          <p class="service-desc"><?php echo esc_html($service['description']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
