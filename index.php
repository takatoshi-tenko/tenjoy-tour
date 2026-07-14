<?php
/**
 * フォールバックテンプレート
 * 他のテンプレートが存在しない場合に使用される
 *
 * @package tenjoy-tour
 */

get_header();
?>

<main id="main" class="site-main" role="main">
  <div class="container">
    <div class="page-content-wrap">
      <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
          <?php the_title('<h1 class="single-news-title">', '</h1>'); ?>
        </header>
        <div class="entry-content">
          <?php the_content(); ?>
        </div>
      </article>
      <?php endwhile; ?>
      <?php else : ?>
      <p class="archive-empty"><?php tenjoy_e('common_01'); ?></p>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>