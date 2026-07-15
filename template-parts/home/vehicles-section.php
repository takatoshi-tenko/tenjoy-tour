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
      <?php
          $gallery_raw = (string) get_post_meta($vehicle->ID, 'vehicle_gallery', true);
          $gallery_ids = $gallery_raw ? array_filter(array_map('intval', explode(',', $gallery_raw))) : [];
          $main_image_url = $gallery_ids ? wp_get_attachment_image_url((int) reset($gallery_ids), 'tenjoy-vehicle-card') : '';
          ?>
      <div class="vehicle-card">
        <?php if (count($gallery_ids) > 1) : ?>
        <div class="vehicle-img-wrap vehicle-swiper swiper">
          <div class="swiper-wrapper">
            <?php foreach ($gallery_ids as $img_id) : ?>
            <?php $img_url = wp_get_attachment_image_url((int) $img_id, 'tenjoy-vehicle-card'); ?>
            <?php if ($img_url) : ?>
            <div class="swiper-slide">
              <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_the_title($vehicle)); ?>"
                class="vehicle-img" loading="lazy">
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
          <div class="swiper-pagination"></div>
        </div>
        <?php elseif ($main_image_url) : ?>
        <div class="vehicle-img-wrap">
          <img src="<?php echo esc_url($main_image_url); ?>" alt="<?php echo esc_attr(get_the_title($vehicle)); ?>"
            class="vehicle-img" loading="lazy">
        </div>
        <?php elseif (has_post_thumbnail($vehicle)) : ?>
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