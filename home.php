<?php

/**
 * ブログ一覧（投稿一覧）
 * 表示設定で「投稿ページ」に指定した固定ページに適用される
 *
 * @package tenjoy-tour
 */

get_header();
?>

<main id="main" class="site-main" role="main">

  <div class="archive-header">
    <div class="container">
      <h1 class="archive-title"><?php tenjoy_e('footer_06'); ?></h1>
      <p class="archive-desc">
        <?php tenjoy_e('home_01'); ?>
      </p>
    </div>
  </div>

  <div class="archive-news-section">
    <div class="container">
      <?php if (have_posts()) : ?>
        <div class="news-list">
          <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('news-item'); ?>>
              <a href="<?php the_permalink(); ?>" class="news-item-link">
                <time class="news-item-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                  <?php echo esc_html(get_the_date()); ?>
                </time>
                <?php
                $categories = get_the_category();
                if ($categories) :
                ?>
                  <span class="news-item-category"><?php echo esc_html($categories[0]->name); ?></span>
                <?php endif; ?>
                <h2 class="news-item-title"><?php the_title(); ?></h2>
              </a>
            </article>
          <?php endwhile; ?>
        </div>

        <?php tenjoy_pagination(); ?>

      <?php else : ?>
        <div class="news-empty-wrap">
          <p class="news-empty"><?php tenjoy_e('home_02'); ?></p>
        </div>
      <?php endif; ?>
    </div>
  </div>

</main>

<?php get_footer(); ?>