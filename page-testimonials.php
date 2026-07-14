<?php

/**
 * Template Name: お客様の声
 *
 * @package tenjoy-tour
 */

get_header();

$paged = max(1, get_query_var('paged'));

$reviews_query = new WP_Query([
  'post_type'      => 'tenjoy_review',
  'post_status'    => 'publish',
  'posts_per_page' => 12,
  'paged'          => $paged,
  'orderby'        => 'date',
  'order'          => 'DESC',
]);
?>

<main id="main" class="site-main" role="main">

  <div class="archive-header">
    <div class="container">
      <h1 class="archive-title"><?php tenjoy_e('nav_04'); ?></h1>
      <p class="archive-desc">
        <?php tenjoy_e('testimonials_page_01'); ?>
      </p>
    </div>
  </div>

  <div class="testimonials-page">
    <div class="container">

      <?php if ($reviews_query->have_posts()) : ?>
        <div class="reviews-grid">
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
                    <?php if ($country) : ?><?php echo esc_html($country); ?> · <?php endif; ?>
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
        </div>

        <?php tenjoy_pagination($reviews_query); ?>

      <?php else : ?>
        <p class="archive-empty"><?php tenjoy_e('testimonials_page_02'); ?></p>
      <?php endif; ?>

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
            <div class="review-star-input" role="radiogroup"
              aria-label="<?php tenjoy_attr_e('testimonials_page_06'); ?>">
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
  </div>

</main>

<?php get_footer(); ?>