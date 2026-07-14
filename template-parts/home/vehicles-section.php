<?php

/**
 * 車両紹介セクション
 *
 * @package tenjoy-tour
 */

$vehicles = get_posts([
  'post_type'      => 'vehicles',
  'posts_per_page' => -1,
  'post_status'    => 'publish',
  'orderby'        => 'menu_order',
  'order'          => 'ASC',
]);
?>
<section class="vehicles-section">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title"><?php tenjoy_e('vehicles_09'); ?></h2>
      <p class="section-subtitle">
        <?php tenjoy_e('vehicles_10'); ?>
      </p>
    </div>
    <?php if ($vehicles) : ?>
      <div class="vehicles-grid">
        <?php foreach ($vehicles as $vehicle) : ?>
          <div class="vehicle-card">
            <?php if (has_post_thumbnail($vehicle)) : ?>
              <div class="vehicle-img-wrap">
                <?php
                echo get_the_post_thumbnail($vehicle, 'tenjoy-vehicle-card', [
                  'class'   => 'vehicle-img',
                  'alt'     => esc_attr(get_the_title($vehicle)),
                  'loading' => 'lazy',
                ]);
                ?>
              </div>
            <?php endif; ?>
            <h3 class="vehicle-name"><?php echo esc_html(get_the_title($vehicle)); ?></h3>
            <?php $desc = get_post_meta($vehicle->ID, 'vehicle_desc', true); ?>
            <?php if ($desc) : ?>
              <p class="vehicle-desc"><?php echo esc_html((string) $desc); ?></p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>