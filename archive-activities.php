<?php

/**
 * アクティビティ一覧ページ
 *
 * @package tenjoy-tour
 */

get_header();
?>

<main id="main" class="site-main" role="main">

  <div class="archive-header">
    <div class="container">
      <h1 class="archive-title"><?php tenjoy_e('nav_03'); ?></h1>
      <p class="archive-desc">
        <?php tenjoy_e('activities_archive_01'); ?>
      </p>
    </div>
  </div>

  <div class="activities-archive">
    <div class="container">
      <?php if (have_posts()) : ?>
      <div class="activities-grid">
        <?php while (have_posts()) : the_post(); ?>
        <?php
            $customer    = (string) get_post_meta(get_the_ID(), 'activity_customer', true);
            $has_golf    = (bool)   get_post_meta(get_the_ID(), 'activity_has_golf', true);
            $course_name = (string) get_post_meta(get_the_ID(), 'activity_course_name', true);
            $category    = (string) get_post_meta(get_the_ID(), 'activity_category', true);
            $location    = (string) get_post_meta(get_the_ID(), 'activity_location', true);
            $img_position = (string) get_post_meta(get_the_ID(), 'activity_image_position', true) ?: 'center';
            if (! in_array($img_position, ['top', 'center', 'bottom'], true)) {
              $img_position = 'center';
            }
            ?>
        <a href="<?php the_permalink(); ?>" class="activity-card">
          <div class="activity-card-img-wrap">
            <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('tenjoy-card', [
              'class' => 'activity-card-img',
              'alt' => get_the_title(),
              'loading' => 'lazy',
              'style' => 'object-position: center ' . esc_attr($img_position) . ';',
            ]); ?>
            <?php else : ?>
            <div class="activity-card-img-placeholder"></div>
            <?php endif; ?>

            <div class="activity-card-badges">
              <?php if ($has_golf) : ?>
              <span class="activity-badge activity-badge--golf">
                <?php echo tenjoy_icon('golf'); // phpcs:ignore WordPress.Security.EscapeOutput 
                      ?>
                <?php tenjoy_e('activity_single_02'); ?>
              </span>
              <?php endif; ?>
              <?php if ($category) : ?>
              <span class="activity-badge activity-badge--category"><?php echo esc_html($category); ?></span>
              <?php endif; ?>
            </div>
          </div>

          <div class="activity-card-body">
            <h2 class="activity-card-title"><?php the_title(); ?></h2>

            <div class="activity-card-meta">
              <?php if ($customer) : ?>
              <span class="activity-meta-customer">
                <?php echo tenjoy_icon('user'); // phpcs:ignore WordPress.Security.EscapeOutput 
                      ?>
                <?php echo esc_html($customer); ?>
              </span>
              <?php endif; ?>
              <span class="activity-meta-date">
                <?php echo tenjoy_icon('calendar'); // phpcs:ignore WordPress.Security.EscapeOutput 
                    ?>
                <?php echo esc_html(get_the_date('Y-m-d')); ?>
              </span>
              <?php if ($location) : ?>
              <span class="activity-meta-location">
                <?php echo tenjoy_icon('map-pin'); // phpcs:ignore WordPress.Security.EscapeOutput 
                      ?>
                <?php echo esc_html($location); ?>
              </span>
              <?php endif; ?>
            </div>

            <p class="activity-card-excerpt"><?php the_excerpt(); ?></p>

            <?php if ($course_name) : ?>
            <p class="activity-card-course"><?php echo esc_html($course_name); ?></p>
            <?php endif; ?>
          </div>
        </a>
        <?php endwhile; ?>
      </div>

      <?php tenjoy_pagination(); ?>

      <?php else : ?>
      <p class="archive-empty"><?php tenjoy_e('activities_archive_02'); ?></p>
      <?php endif; ?>
    </div>
  </div>

</main>

<?php get_footer(); ?>