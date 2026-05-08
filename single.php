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

        <nav class="single-news-breadcrumb" aria-label="<?php esc_attr_e('パンくず', 'tenjoy-tour'); ?>">
          <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('ホーム', 'tenjoy-tour'); ?></a>
          <span class="single-news-breadcrumb-sep">/</span>
          <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>"><?php esc_html_e('ブログ', 'tenjoy-tour'); ?></a>
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
            <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn-outline">
              <?php esc_html_e('ブログ一覧に戻る', 'tenjoy-tour'); ?>
            </a>
          </footer>
        </article>

      </div>
    </div>

  <?php endwhile; ?>
</main>

<?php get_footer(); ?>
