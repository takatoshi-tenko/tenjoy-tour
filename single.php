<?php
/**
 * ブログ詳細（投稿詳細）
 *
 * @package tenjoy-tour
 */

get_header();
?>

<main id="main" class="site-main" role="main">
  <?php while (have_posts()) : the_post(); ?>

  <div class="container">
    <div class="single-news-wrap">

      <nav class="single-news-breadcrumb" aria-label="<?php tenjoy_attr_e('common_02'); ?>">
        <a href="<?php echo esc_url(tenjoy_front_page_url()); ?>"><?php tenjoy_e('footer_03'); ?></a>
        <span class="single-news-breadcrumb-sep">/</span>
        <a href="<?php echo esc_url(tenjoy_posts_page_url()); ?>"><?php tenjoy_e('footer_06'); ?></a>
        <span class="single-news-breadcrumb-sep">/</span>
        <span><?php the_title(); ?></span>
      </nav>

      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header>
          <div class="single-news-meta">
            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
              <?php echo esc_html(get_the_date()); ?>
            </time>
            <?php
              $categories = get_the_category();
              if ($categories) :
              ?>
            <span class="single-news-category"><?php echo esc_html($categories[0]->name); ?></span>
            <?php endif; ?>
          </div>
          <h1 class="single-news-title"><?php the_title(); ?></h1>
        </header>

        <div class="entry-content">
          <?php the_content(); ?>
        </div>

        <footer class="single-news-footer">
          <a href="<?php echo esc_url(tenjoy_posts_page_url()); ?>" class="btn btn-outline">
            <?php tenjoy_e('common_03'); ?>
          </a>
        </footer>
      </article>

    </div>
  </div>

  <?php endwhile; ?>
</main>

<?php get_footer(); ?>