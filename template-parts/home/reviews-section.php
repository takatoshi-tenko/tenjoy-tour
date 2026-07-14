<?php

/**
 * お客様の声セクション（ホームページ）
 * tenjoy_review CPTの承認済みレビューを表示 ＋ 投稿フォーム
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
                <span
                  class="star-icon"><?php echo tenjoy_icon('star'); // phpcs:ignore WordPress.Security.EscapeOutput 
                                    ?></span>
              <?php endfor; ?>
            </div>
            <p class="review-content"><?php echo esc_html($r['content']); ?></p>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <div class="reviews-more-link">
      <a href="<?php echo esc_url(home_url('/testimonials/')); ?>" class="btn btn-outline">
        <?php tenjoy_e('reviews_04'); ?>
      </a>
    </div>

    <!-- レビュー投稿フォーム -->
    <div class="review-form-wrap">
      <h3 class="review-form-title"><?php tenjoy_e('testimonials_page_03'); ?></h3>
      <form id="review-form" class="review-form" novalidate>
        <div class="review-form-row">
          <div class="review-form-field">
            <label for="review-author"><?php tenjoy_e('contact_13'); ?> <span aria-hidden="true">*</span></label>
            <input type="text" id="review-author" name="author" required placeholder="例: David Chen">
          </div>
          <div class="review-form-field">
            <label for="review-country"><?php tenjoy_e('testimonials_page_04'); ?></label>
            <input type="text" id="review-country" name="country" placeholder="例: 台湾">
          </div>
        </div>
        <div class="review-form-field">
          <label><?php tenjoy_e('testimonials_page_05'); ?></label>
          <div class="review-star-input" role="radiogroup" aria-label="<?php tenjoy_attr_e('testimonials_page_06'); ?>">
            <?php for ($i = 5; $i >= 1; $i--) : ?>
              <input type="radio" id="star-<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>"
                <?php echo $i === 5 ? 'checked' : ''; ?>>
              <label for="star-<?php echo $i; ?>" aria-label="<?php echo $i; ?>星">★</label>
            <?php endfor; ?>
          </div>
        </div>
        <div class="review-form-field">
          <label for="review-content"><?php tenjoy_e('testimonials_page_07'); ?> <span
              aria-hidden="true">*</span></label>
          <textarea id="review-content" name="content" rows="4" required
            placeholder="<?php tenjoy_attr_e('testimonials_page_08'); ?>"></textarea>
        </div>
        <div id="review-form-msg" class="review-form-msg" hidden></div>
        <button type="submit" class="btn btn-primary"><?php tenjoy_e('contact_23'); ?></button>
      </form>
    </div>

  </div>
</section>