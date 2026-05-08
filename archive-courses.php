<?php
/**
 * ゴルフ場一覧ページ
 *
 * @package tenjoy-tour
 */

get_header();
?>

<main id="main" class="site-main" role="main">

  <div class="archive-header">
    <div class="container">
      <h1 class="archive-title"><?php esc_html_e('ゴルフ場一覧', 'tenjoy-tour'); ?></h1>
      <p class="archive-desc">
        <?php esc_html_e('日本全国の厳選されたゴルフコースをご紹介します', 'tenjoy-tour'); ?>
      </p>
    </div>
  </div>

  <div class="courses-archive">
    <div class="container">
      <?php if (have_posts()) : ?>
        <div class="courses-grid">
          <?php while (have_posts()) : the_post(); ?>
            <?php
            $rating      = (float) get_post_meta(get_the_ID(), 'course_rating', true);
            $visit_count = (int)   get_post_meta(get_the_ID(), 'course_visit_count', true);
            $region      = (string) get_post_meta(get_the_ID(), 'course_region', true);
            $tags_raw    = (string) get_post_meta(get_the_ID(), 'course_tags', true);
            $tags        = $tags_raw ? array_filter(array_map('trim', explode(',', $tags_raw))) : [];
            $prefecture  = (string) get_post_meta(get_the_ID(), 'course_prefecture', true);
            $holes       = (string) get_post_meta(get_the_ID(), 'course_holes', true);
            $has_detail  = (bool)   get_post_meta(get_the_ID(), 'course_has_detail', true);
            ?>
            <article class="course-card">
              <div class="course-card-img-wrap">
                <?php if (has_post_thumbnail()) : ?>
                  <?php the_post_thumbnail('tenjoy-card', ['class' => 'course-card-img', 'alt' => get_the_title()]); ?>
                <?php else : ?>
                  <div class="course-card-img-placeholder"></div>
                <?php endif; ?>

                <?php if ($rating > 0) : ?>
                  <div class="course-badge-overlay course-badge-rating">
                    <span class="star-inline">★</span>
                    <?php echo esc_html(number_format($rating, 1)); ?>
                  </div>
                <?php endif; ?>

                <?php if ($visit_count > 0) : ?>
                  <div class="course-badge-overlay course-badge-visits">
                    <?php echo esc_html($visit_count); ?><?php esc_html_e('回訪問', 'tenjoy-tour'); ?>
                  </div>
                <?php endif; ?>
              </div>

              <div class="course-card-body">
                <div class="course-card-header">
                  <h2 class="course-card-name">
                    <?php if ($has_detail) : ?>
                      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <?php else : ?>
                      <?php the_title(); ?>
                    <?php endif; ?>
                  </h2>
                  <?php if ($region || $prefecture) : ?>
                    <span class="course-region-badge"><?php echo esc_html($region ?: $prefecture); ?></span>
                  <?php endif; ?>
                </div>

                <p class="course-card-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20, '...')); ?></p>

                <?php if ($tags) : ?>
                  <div class="course-tags">
                    <?php foreach ($tags as $tag) : ?>
                      <span class="course-tag"><?php echo esc_html($tag); ?></span>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>

                <div class="course-card-footer">
                  <?php if ($holes) : ?>
                    <span class="course-meta-item"><?php echo esc_html($holes); ?>H</span>
                  <?php endif; ?>
                  <?php if ($has_detail) : ?>
                    <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                      <?php esc_html_e('詳細を見る', 'tenjoy-tour'); ?>
                    </a>
                  <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-outline">
                      <?php esc_html_e('お問い合わせ', 'tenjoy-tour'); ?>
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </article>
          <?php endwhile; ?>
        </div>

        <?php tenjoy_pagination(); ?>

      <?php else : ?>
        <p class="archive-empty"><?php esc_html_e('ゴルフ場情報は準備中です。', 'tenjoy-tour'); ?></p>
      <?php endif; ?>
    </div>

    <!-- CTA -->
    <div class="courses-cta-section">
      <div class="container">
        <div class="courses-cta-inner">
          <h2 class="courses-cta-title"><?php esc_html_e('ご希望のゴルフ場が見つかりましたか？', 'tenjoy-tour'); ?></h2>
          <p class="courses-cta-desc">
            <?php esc_html_e('ゴルフ場の予約から交通手配まで、お気軽にご相談ください。', 'tenjoy-tour'); ?>
          </p>
          <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary btn-lg">
            <?php esc_html_e('無料でお問い合わせ', 'tenjoy-tour'); ?>
          </a>
        </div>
      </div>
    </div>
  </div>

</main>

<?php get_footer(); ?>
