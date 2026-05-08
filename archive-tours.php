<?php
/**
 * ツアー一覧ページ
 *
 * @package tenjoy-tour
 */

get_header();
?>

<main id="main" class="site-main" role="main">

  <div class="archive-header">
    <div class="container">
      <h1 class="archive-title"><?php esc_html_e('ツアー一覧', 'tenjoy-tour'); ?></h1>
      <p class="archive-desc">
        <?php esc_html_e('日本のゴルフを最大限に楽しめる厳選ツアーをご用意しています', 'tenjoy-tour'); ?>
      </p>
    </div>
  </div>

  <div class="tours-archive">
    <div class="container">
      <?php if (have_posts()) : ?>
        <div class="tours-list">
          <?php while (have_posts()) : the_post(); ?>
            <?php
            $destination = get_post_meta(get_the_ID(), 'tour_destination', true);
            $duration    = get_post_meta(get_the_ID(), 'tour_duration', true);
            $price       = get_post_meta(get_the_ID(), 'tour_price', true);
            $min_pax     = get_post_meta(get_the_ID(), 'tour_min_pax', true);
            $rating      = get_post_meta(get_the_ID(), 'tour_rating', true);
            $featured    = (bool) get_post_meta(get_the_ID(), 'tour_featured', true);
            ?>
            <a href="<?php the_permalink(); ?>" class="tour-card<?php echo $featured ? ' tour-card--featured' : ''; ?>">
              <div class="tour-card-img">
                <?php if ($featured) : ?>
                  <span class="tour-card-badge"><?php esc_html_e('おすすめ', 'tenjoy-tour'); ?></span>
                <?php endif; ?>
                <?php if (has_post_thumbnail()) : ?>
                  <?php the_post_thumbnail('tenjoy-card', ['alt' => get_the_title()]); ?>
                <?php else : ?>
                  <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholder.jpg'); ?>"
                    alt="<?php the_title_attribute(); ?>">
                <?php endif; ?>
              </div>
              <div class="tour-card-body">
                <div class="tour-card-meta">
                  <?php if ($destination) : ?>
                    <span><?php echo tenjoy_icon('map-pin'); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo esc_html($destination); ?></span>
                  <?php endif; ?>
                  <?php if ($duration) : ?>
                    <span><?php echo tenjoy_icon('calendar'); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo esc_html($duration); ?></span>
                  <?php endif; ?>
                  <?php if ($min_pax) : ?>
                    <span><?php echo esc_html((string) $min_pax); ?><?php esc_html_e('名〜', 'tenjoy-tour'); ?></span>
                  <?php endif; ?>
                </div>
                <h2 class="tour-card-title"><?php the_title(); ?></h2>
                <p class="tour-card-excerpt"><?php the_excerpt(); ?></p>
                <div class="tour-card-footer">
                  <?php if ($rating) : ?>
                    <span class="tour-card-rating">
                      <?php echo tenjoy_icon('star'); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                      <?php echo esc_html($rating); ?>
                    </span>
                  <?php endif; ?>
                  <?php if ($price) : ?>
                    <span class="tour-card-price"><?php echo esc_html($price); ?></span>
                  <?php endif; ?>
                </div>
              </div>
            </a>
          <?php endwhile; ?>
        </div>

        <?php tenjoy_pagination(); ?>

      <?php else : ?>
        <p class="archive-empty"><?php esc_html_e('ツアー情報は準備中です。', 'tenjoy-tour'); ?></p>
      <?php endif; ?>
    </div>
  </div>

</main>

<?php get_footer(); ?>
