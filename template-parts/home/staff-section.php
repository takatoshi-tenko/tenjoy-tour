<?php

/**
 * スタッフセクション（ホームページ）
 *
 * @package tenjoy-tour
 */

$staff_query = new WP_Query([
  'post_type'      => 'staff',
  'posts_per_page' => 3,
  'orderby'        => 'menu_order',
  'order'          => 'ASC',
  'no_found_rows'  => true,
]);
?>
<section class="staff-section">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title"><?php tenjoy_e('footer_05'); ?></h2>
      <p class="section-subtitle">
        <?php tenjoy_e('staff_page_01'); ?>
      </p>
    </div>
    <?php if ($staff_query->have_posts()) : ?>
    <div class="swiper staff-swiper">
      <div class="swiper-wrapper">
        <?php while ($staff_query->have_posts()) : $staff_query->the_post(); ?>
        <div class="swiper-slide">
          <div class="staff-card">
            <div class="staff-img-wrap">
              <?php if (has_post_thumbnail()) : ?>
              <?php
                    $img_position = tenjoy_sanitize_image_position(
                      (string) get_post_meta(get_the_ID(), 'staff_image_position', true)
                    );
                    the_post_thumbnail('tenjoy-card', [
                      'class'   => 'staff-img',
                      'loading' => 'lazy',
                      'style'   => 'object-position: ' . esc_attr($img_position) . ';',
                    ]);
                    ?>
              <?php else : ?>
              <div class="staff-img-placeholder" aria-hidden="true"></div>
              <?php endif; ?>
            </div>
            <h3 class="staff-name"><?php the_title(); ?></h3>
            <p class="staff-desc"><?php echo esc_html((string) get_post_meta(get_the_ID(), 'staff_role', true)); ?></p>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
    <?php wp_reset_postdata(); ?>
    <?php endif; ?>
    <div class="section-cta">
      <a href="<?php echo esc_url(tenjoy_page_url('staff', '/staff/')); ?>" class="btn btn-outline">
        <?php tenjoy_e('staff_home_01'); ?>
      </a>
    </div>
  </div>
</section>