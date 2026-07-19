<?php

/**
 * Template Name: スタッフ紹介
 *
 * @package tenjoy-tour
 */

get_header();

$staff_query = new WP_Query([
  'post_type'      => 'staff',
  'posts_per_page' => -1,
  'orderby'        => 'menu_order',
  'order'          => 'ASC',
]);
?>

<main id="main" class="site-main" role="main">

  <div class="archive-header">
    <div class="container">
      <h1 class="archive-title"><?php tenjoy_e('footer_05'); ?></h1>
      <p class="archive-desc">
        <?php tenjoy_e('staff_page_01'); ?>
      </p>
    </div>
  </div>

  <div class="staff-page">
    <div class="container">
      <?php if ($staff_query->have_posts()) : ?>
      <div class="staff-list">
        <?php while ($staff_query->have_posts()) : $staff_query->the_post(); ?>
        <?php
            $role      = get_post_meta(get_the_ID(), 'staff_role', true);
            $bio       = get_post_meta(get_the_ID(), 'staff_bio', true);
            $languages = get_post_meta(get_the_ID(), 'staff_languages', true);
            $email     = get_post_meta(get_the_ID(), 'staff_email', true);
            $phone     = get_post_meta(get_the_ID(), 'staff_phone', true);
            $langs     = $languages ? array_map('trim', explode(',', $languages)) : [];
            ?>
        <div class="staff-item">
          <div class="staff-item-img-wrap">
            <?php if (has_post_thumbnail()) : ?>
            <?php
                  $img_position = tenjoy_sanitize_image_position(
                    (string) get_post_meta(get_the_ID(), 'staff_image_position', true)
                  );
                  the_post_thumbnail('tenjoy-card', [
                    'alt'   => get_the_title(),
                    'style' => 'object-position: ' . esc_attr($img_position) . ';',
                  ]);
                  ?>
            <?php else : ?>
            <div class="staff-item-placeholder" aria-hidden="true">&#128100;</div>
            <?php endif; ?>
          </div>
          <div class="staff-item-body">
            <h2 class="staff-item-name"><?php the_title(); ?></h2>
            <?php if ($role) : ?>
            <p class="staff-item-role"><?php echo esc_html($role); ?></p>
            <?php endif; ?>
            <?php if ($bio) : ?>
            <p class="staff-item-bio"><?php echo esc_html($bio); ?></p>
            <?php endif; ?>
            <?php if ($langs) : ?>
            <div class="staff-item-languages">
              <?php foreach ($langs as $lang) : ?>
              <span class="badge"><?php echo esc_html($lang); ?></span>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <?php if ($email || $phone) : ?>
            <div class="staff-item-contact">
              <?php if ($email) : ?>
              <a href="mailto:<?php echo esc_attr($email); ?>" class="staff-item-contact-link">
                <?php echo tenjoy_icon('mail'); // phpcs:ignore WordPress.Security.EscapeOutput 
                        ?>
                <?php echo esc_html($email); ?>
              </a>
              <?php endif; ?>
              <?php if ($phone) : ?>
              <a href="tel:<?php echo esc_attr(preg_replace('/[^+\d]/', '', $phone)); ?>"
                class="staff-item-contact-link">
                <?php echo tenjoy_icon('phone'); // phpcs:ignore WordPress.Security.EscapeOutput 
                        ?>
                <?php echo esc_html($phone); ?>
              </a>
              <?php endif; ?>
            </div>
            <?php endif; ?>
          </div>
        </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      </div>
      <?php else : ?>
      <p class="archive-empty"><?php tenjoy_e('staff_page_02'); ?></p>
      <?php endif; ?>
    </div>
  </div>

</main>

<?php get_footer(); ?>