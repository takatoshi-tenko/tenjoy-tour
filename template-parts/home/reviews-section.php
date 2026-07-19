<?php

/**
 * お客様の声セクション（ホームページ）
 * tenjoy_review CPTの承認済みレビューを表示（投稿フォームはお客様の声ページのみ）
 *
 * @package tenjoy-tour
 */

$reviews_query = new WP_Query([
  'post_type'      => 'tenjoy_review',
  'post_status'    => 'publish',
  'posts_per_page' => 3,
  'orderby'        => 'date',
  'order'          => 'DESC',
  'no_found_rows'  => true,
]);

// フォールバック用静的レビュー
$fallback_reviews = [
  [
    'author' => 'David Chen',
    'country' => '台湾',
    'date' => '2024-01-15',
    'rating' => 5,
    'content' => tenjoy__('reviews_01')
  ],
  [
    'author' => 'Kim Min-ho',
    'country' => '韓国',
    'date' => '2024-02-03',
    'rating' => 5,
    'content' => tenjoy__('reviews_02')
  ],
  [
    'author' => 'Wang Lei',
    'country' => '中国',
    'date' => '2024-02-20',
    'rating' => 5,
    'content' => tenjoy__('reviews_03')
  ],
];
?>
<section id="reviews" class="reviews-section">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title"><?php tenjoy_e('nav_04'); ?></h2>
      <p class="section-subtitle">
        <?php tenjoy_e('testimonials_page_01'); ?>
      </p>
    </div>

    <!-- レビュー一覧 -->
    <div class="reviews-grid">
      <?php if ($reviews_query->have_posts()) : ?>
        <?php while ($reviews_query->have_posts()) : $reviews_query->the_post(); ?>
          <?php
          $rating  = (int) get_post_meta(get_the_ID(), 'review_rating', true) ?: 5;
          $country = (string) get_post_meta(get_the_ID(), 'review_country', true);
          ?>
          <article class="review-card">
            <div class="review-header">
              <div class="review-avatar">
                <span class="review-avatar-fallback"><?php echo esc_html(mb_substr(get_the_title(), 0, 1)); ?></span>
              </div>
              <div>
                <p class="review-author"><?php the_title(); ?></p>
                <p class="review-date">
                  <?php if ($country) echo esc_html($country) . ' · '; ?>
                  <?php echo esc_html(get_the_date('Y-m-d')); ?>
                </p>
              </div>
            </div>
            <div class="review-stars" aria-label="<?php echo esc_attr($rating); ?>星">
              <?php for ($i = 1; $i <= 5; $i++) : ?>
                <span class="star-icon<?php echo $i <= $rating ? '' : ' star-empty'; ?>">
                  <?php echo tenjoy_icon('star'); // phpcs:ignore WordPress.Security.EscapeOutput 
                  ?>
                </span>
              <?php endfor; ?>
            </div>
            <p class="review-content"><?php the_excerpt(); ?></p>
          </article>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      <?php else : ?>
        <?php foreach ($fallback_reviews as $r) : ?>
          <article class="review-card">
            <div class="review-header">
              <div class="review-avatar">
                <span class="review-avatar-fallback"><?php echo esc_html(mb_substr($r['author'], 0, 1)); ?></span>
              </div>
              <div>
                <p class="review-author"><?php echo esc_html($r['author']); ?></p>
                <p class="review-date"><?php echo esc_html($r['country']); ?> · <?php echo esc_html($r['date']); ?></p>
              </div>
            </div>
            <div class="review-stars" aria-label="5星">
              <?php for ($i = 0; $i < 5; $i++) : ?>
                <span class="star-icon"><?php echo tenjoy_icon('star'); // phpcs:ignore WordPress.Security.EscapeOutput 
                                        ?></span>
              <?php endfor; ?>
            </div>
            <p class="review-content"><?php echo esc_html($r['content']); ?></p>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <div class="reviews-more-link">
      <a href="<?php echo esc_url(tenjoy_page_url('reviews', '/reviews/')); ?>" class="btn btn-outline">
        <?php tenjoy_e('reviews_04'); ?>
      </a>
    </div>

  </div>
</section>