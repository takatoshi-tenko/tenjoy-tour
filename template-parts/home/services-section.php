<?php

/**
 * サービスセクション
 *
 * @package tenjoy-tour
 */

$services = [
  [
    'icon'        => 'calendar',
    'title'       => tenjoy__('services_01'),
    'description' => tenjoy__('services_02'),
  ],
  [
    'icon'        => 'car',
    'title'       => tenjoy__('services_03'),
    'description' => tenjoy__('services_04'),
  ],
  [
    'icon'        => 'map-pin',
    'title'       => tenjoy__('services_05'),
    'description' => tenjoy__('services_06'),
  ],
];
?>
<section id="services" class="services-section">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title"><?php tenjoy_e('services_07'); ?></h2>
      <p class="section-subtitle">
        <?php tenjoy_e('services_08'); ?>
      </p>
    </div>
    <div class="services-grid">
      <?php foreach ($services as $service) : ?>
        <div class="service-card">
          <div class="service-icon">
            <?php echo tenjoy_icon(esc_attr($service['icon'])); // phpcs:ignore WordPress.Security.EscapeOutput 
            ?>
          </div>
          <h3 class="service-title"><?php echo esc_html($service['title']); ?></h3>
          <p class="service-desc"><?php echo esc_html($service['description']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>