<?php

/**
 * アクティビティ詳細ページ
 *
 * @package tenjoy-tour
 */

get_header();

$category    = (string) get_post_meta(get_the_ID(), 'activity_category', true);
$customer    = (string) get_post_meta(get_the_ID(), 'activity_customer', true);
$has_golf    = (bool)   get_post_meta(get_the_ID(), 'activity_has_golf', true);
$course_name = (string) get_post_meta(get_the_ID(), 'activity_course_name', true);
$duration    = (string) get_post_meta(get_the_ID(), 'activity_duration', true);
$location    = (string) get_post_meta(get_the_ID(), 'activity_location', true);
$price       = (string) get_post_meta(get_the_ID(), 'activity_price', true);
$gallery_raw = (string) get_post_meta(get_the_ID(), 'activity_gallery', true);
$gallery_ids = $gallery_raw ? array_filter(array_map('intval', explode(',', $gallery_raw))) : [];
?>

<main id="main" class="site-main" role="main">
  <?php while (have_posts()) : the_post(); ?>

    <div class="container">
      <div class="activity-single">

        <!-- 戻るボタン -->
        <a href="<?php echo esc_url(get_post_type_archive_link('activities')); ?>" class="activity-back-link">
          <?php echo tenjoy_icon('arrow-left'); // phpcs:ignore WordPress.Security.EscapeOutput 
          ?>
          <?php tenjoy_e('activity_single_01'); ?>
        </a>

        <!-- バッジ行 -->
        <div class="activity-single-badges">
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
          <span class="activity-badge activity-badge--date">
            <?php echo tenjoy_icon('calendar'); // phpcs:ignore WordPress.Security.EscapeOutput 
            ?>
            <?php echo esc_html(get_the_date('Y年m月d日')); ?>
          </span>
          <?php if ($customer) : ?>
            <span class="activity-badge activity-badge--customer">
              <?php echo tenjoy_icon('user'); // phpcs:ignore WordPress.Security.EscapeOutput 
              ?>
              <?php echo esc_html($customer); ?>
            </span>
          <?php endif; ?>
        </div>

        <h1 class="activity-single-title"><?php the_title(); ?></h1>

        <!-- アイキャッチ -->
        <?php
        $single_img_position = (string) get_post_meta(get_the_ID(), 'activity_image_position', true) ?: 'center';
        if (! in_array($single_img_position, ['top', 'center', 'bottom'], true)) {
          $single_img_position = 'center';
        }
        ?>
        <?php if (has_post_thumbnail()) : ?>
          <div class="activity-single-thumbnail">
            <?php the_post_thumbnail('tenjoy-hero', [
              'alt' => get_the_title(),
              'class' => 'activity-single-img',
              'style' => 'object-position: center ' . esc_attr($single_img_position) . ';',
            ]); ?>
          </div>
        <?php endif; ?>

        <!-- メタ情報 -->
        <?php if ($location || $duration || $price || $course_name) : ?>
          <dl class="activity-single-meta">
            <?php if ($location) : ?>
              <div class="activity-meta-item">
                <dt><?php tenjoy_e('activity_single_03'); ?></dt>
                <dd><?php echo esc_html($location); ?></dd>
              </div>
            <?php endif; ?>
            <?php if ($duration) : ?>
              <div class="activity-meta-item">
                <dt><?php tenjoy_e('activity_single_04'); ?></dt>
                <dd><?php echo esc_html($duration); ?></dd>
              </div>
            <?php endif; ?>
            <?php if ($price) : ?>
              <div class="activity-meta-item">
                <dt><?php tenjoy_e('activity_single_05'); ?></dt>
                <dd><?php echo esc_html($price); ?></dd>
              </div>
            <?php endif; ?>
            <?php if ($course_name) : ?>
              <div class="activity-meta-item">
                <dt><?php tenjoy_e('nav_02'); ?></dt>
                <dd><?php echo esc_html($course_name); ?></dd>
              </div>
            <?php endif; ?>
          </dl>
        <?php endif; ?>

        <!-- 本文 -->
        <div class="entry-content activity-single-content">
          <?php the_content(); ?>
        </div>

        <!-- ギャラリー -->
        <?php if ($gallery_ids) : ?>
          <?php
          $gallery_lightbox_urls = [];
          foreach ($gallery_ids as $attachment_id) {
            $full_url = wp_get_attachment_image_url($attachment_id, 'large');
            if ($full_url) {
              $gallery_lightbox_urls[] = $full_url;
            }
          }
          $gallery_lightbox_json = esc_attr((string) wp_json_encode($gallery_lightbox_urls));
          ?>
          <section class="activity-gallery">
            <h2 class="activity-gallery-title"><?php tenjoy_e('activity_single_06'); ?></h2>
            <div class="activity-gallery-grid">
              <?php foreach ($gallery_ids as $i => $attachment_id) : ?>
                <?php $img_url = wp_get_attachment_image_url($attachment_id, 'tenjoy-card'); ?>
                <?php if ($img_url) : ?>
                  <div class="activity-gallery-item">
                    <img src="<?php echo esc_url($img_url); ?>"
                      alt="<?php echo esc_attr(get_post_meta($attachment_id, '_wp_attachment_image_alt', true)); ?>"
                      loading="lazy" class="activity-gallery-img activity-lightbox-trigger"
                      data-lightbox-images="<?php echo $gallery_lightbox_json; ?>"
                      data-lightbox-index="<?php echo (int) $i; ?>">
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </section>
        <?php endif; ?>

      </div>
    </div>

    <!-- CTA -->
    <div class="courses-cta-section">
      <div class="container">
        <div class="courses-cta-inner">
          <h2 class="courses-cta-title"><?php tenjoy_e('activity_single_07'); ?></h2>
          <p class="courses-cta-desc">
            <?php tenjoy_e('activity_single_10'); ?>
          </p>
          <div class="courses-cta-buttons">
            <a href="<?php echo esc_url(tenjoy_page_url('contact', '/contact/')); ?>" class="btn btn-primary btn-lg">
              <?php tenjoy_e('activity_single_08'); ?>
            </a>
          </div>
        </div>
      </div>
    </div>

  <?php endwhile; ?>
</main>

<?php get_footer(); ?>