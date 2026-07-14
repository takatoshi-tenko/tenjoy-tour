<?php
/**
 * ゴルフ場詳細ページ
 * course_has_detail が false の場合はアーカイブにリダイレクト
 *
 * @package tenjoy-tour
 */

// 詳細ページ不可の場合はリダイレクト
if (get_the_ID() && !(bool) get_post_meta(get_the_ID(), 'course_has_detail', true)) {
  wp_safe_redirect(get_post_type_archive_link('courses'));
  exit;
}

get_header();

$prefecture = get_post_meta(get_the_ID(), 'course_prefecture', true);
$address    = get_post_meta(get_the_ID(), 'course_address', true);
$holes      = get_post_meta(get_the_ID(), 'course_holes', true);
$green_fee  = get_post_meta(get_the_ID(), 'course_green_fee', true);
$caddie     = get_post_meta(get_the_ID(), 'course_caddie', true);
$cart       = get_post_meta(get_the_ID(), 'course_cart', true);
$website    = get_post_meta(get_the_ID(), 'course_website', true);
$map_embed  = get_post_meta(get_the_ID(), 'course_map_embed', true);
?>

<main id="main" class="site-main" role="main">
  <?php while (have_posts()) : the_post(); ?>

  <div class="container">
    <div class="course-single">
      <div class="course-single-layout">

        <!-- メインコンテンツ -->
        <div class="course-single-main">
          <h1 class="course-single-title"><?php the_title(); ?></h1>

          <?php if (has_post_thumbnail()) : ?>
          <div class="course-single-thumbnail">
            <?php the_post_thumbnail('tenjoy-hero', ['alt' => get_the_title()]); ?>
          </div>
          <?php endif; ?>

          <div class="entry-content">
            <?php the_content(); ?>
          </div>

          <?php if ($map_embed && tenjoy_is_valid_map_embed_url($map_embed)) : ?>
          <div class="course-map-section">
            <h2 class="course-map-title"><?php tenjoy_e('course_single_14'); ?></h2>
            <div class="course-map-wrap">
              <iframe
                src="<?php echo esc_url($map_embed); ?>"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                allowfullscreen></iframe>
            </div>
          </div>
          <?php endif; ?>
        </div>

        <!-- サイドバー：コース情報 -->
        <aside class="course-sidebar">
          <h3 class="course-sidebar-title"><?php tenjoy_e('course_single_03'); ?></h3>
          <dl class="course-specs">
            <?php if ($prefecture) : ?>
            <div class="course-spec-item">
              <dt><?php tenjoy_e('course_single_04'); ?></dt>
              <dd><?php echo esc_html($prefecture); ?></dd>
            </div>
            <?php endif; ?>
            <?php if ($address) : ?>
            <div class="course-spec-item">
              <dt><?php tenjoy_e('course_single_05'); ?></dt>
              <dd><?php echo esc_html($address); ?></dd>
            </div>
            <?php endif; ?>
            <?php if ($holes) : ?>
            <div class="course-spec-item">
              <dt><?php tenjoy_e('course_single_06'); ?></dt>
              <dd><?php echo esc_html((string) $holes); ?>H</dd>
            </div>
            <?php endif; ?>
            <?php if ($green_fee) : ?>
            <div class="course-spec-item">
              <dt><?php tenjoy_e('course_single_07'); ?></dt>
              <dd><?php echo esc_html($green_fee); ?></dd>
            </div>
            <?php endif; ?>
            <?php if ($caddie !== '') : ?>
            <div class="course-spec-item">
              <dt><?php tenjoy_e('course_single_08'); ?></dt>
              <dd>
                <?php echo $caddie ? esc_html(tenjoy__('course_single_09')) : esc_html(tenjoy__('course_single_10')); ?>
              </dd>
            </div>
            <?php endif; ?>
            <?php if ($cart) : ?>
            <div class="course-spec-item">
              <dt><?php tenjoy_e('course_single_11'); ?></dt>
              <dd><?php echo esc_html($cart); ?></dd>
            </div>
            <?php endif; ?>
            <?php if ($website) : ?>
            <div class="course-spec-item">
              <dt><?php tenjoy_e('course_single_12'); ?></dt>
              <dd>
                <a href="<?php echo esc_url($website); ?>" target="_blank" rel="noopener noreferrer">
                  <?php tenjoy_e('course_single_13'); ?>
                </a>
              </dd>
            </div>
            <?php endif; ?>
          </dl>
        </aside>

      </div>
    </div>
  </div>

  <!-- CTA -->
  <div class="courses-cta-section">
    <div class="container">
      <div class="courses-cta-inner">
        <h2 class="courses-cta-title"><?php tenjoy_e('course_single_15'); ?></h2>
        <p class="courses-cta-desc">
          <?php tenjoy_e('course_single_16'); ?>
        </p>
        <div class="courses-cta-buttons">
          <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary btn-lg">
            <?php tenjoy_e('course_single_01'); ?>
          </a>
          <a href="<?php echo esc_url(get_post_type_archive_link('courses')); ?>" class="btn btn-outline">
            <?php tenjoy_e('course_single_02'); ?>
          </a>
        </div>
      </div>
    </div>
  </div>

  <?php endwhile; ?>
</main>

<?php get_footer(); ?>