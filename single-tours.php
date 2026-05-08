<?php
/**
 * ツアー詳細ページ
 *
 * @package tenjoy-tour
 */

get_header();

$destination = get_post_meta(get_the_ID(), 'tour_destination', true);
$duration    = get_post_meta(get_the_ID(), 'tour_duration', true);
$price       = get_post_meta(get_the_ID(), 'tour_price', true);
$includes    = get_post_meta(get_the_ID(), 'tour_includes', true);
$min_pax     = get_post_meta(get_the_ID(), 'tour_min_pax', true);
?>

<main id="main" class="site-main" role="main">
  <?php while (have_posts()) : the_post(); ?>

    <div class="container">
      <div class="tour-single">

        <div class="tour-single-header">
          <h1 class="tour-single-title"><?php the_title(); ?></h1>
        </div>

        <?php if (has_post_thumbnail()) : ?>
          <div class="tour-single-thumbnail">
            <?php the_post_thumbnail('tenjoy-hero', ['alt' => get_the_title()]); ?>
          </div>
        <?php endif; ?>

        <?php if ($destination || $duration || $price || $includes || $min_pax) : ?>
          <dl class="tour-single-meta">
            <?php if ($destination) : ?>
              <div class="tour-meta-item">
                <dt><?php esc_html_e('目的地', 'tenjoy-tour'); ?></dt>
                <dd><?php echo esc_html($destination); ?></dd>
              </div>
            <?php endif; ?>
            <?php if ($duration) : ?>
              <div class="tour-meta-item">
                <dt><?php esc_html_e('期間', 'tenjoy-tour'); ?></dt>
                <dd><?php echo esc_html($duration); ?></dd>
              </div>
            <?php endif; ?>
            <?php if ($price) : ?>
              <div class="tour-meta-item">
                <dt><?php esc_html_e('料金', 'tenjoy-tour'); ?></dt>
                <dd><?php echo esc_html($price); ?></dd>
              </div>
            <?php endif; ?>
            <?php if ($includes) : ?>
              <div class="tour-meta-item">
                <dt><?php esc_html_e('含まれるもの', 'tenjoy-tour'); ?></dt>
                <dd><?php echo esc_html($includes); ?></dd>
              </div>
            <?php endif; ?>
            <?php if ($min_pax) : ?>
              <div class="tour-meta-item">
                <dt><?php esc_html_e('最小人数', 'tenjoy-tour'); ?></dt>
                <dd><?php echo esc_html((string) $min_pax); ?><?php esc_html_e('名〜', 'tenjoy-tour'); ?></dd>
              </div>
            <?php endif; ?>
          </dl>
        <?php endif; ?>

        <div class="entry-content">
          <?php the_content(); ?>
        </div>

        <div class="tour-single-cta">
          <a href="<?php echo esc_url(home_url('/booking/')); ?>" class="btn btn-primary btn-lg">
            <?php esc_html_e('このツアーを予約する', 'tenjoy-tour'); ?>
          </a>
          <a href="<?php echo esc_url(get_post_type_archive_link('tours')); ?>" class="btn btn-outline">
            <?php esc_html_e('ツアー一覧に戻る', 'tenjoy-tour'); ?>
          </a>
        </div>

      </div>
    </div>

  <?php endwhile; ?>
</main>

<?php get_footer(); ?>
