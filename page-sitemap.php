<?php

/**
 * Template Name: サイトマップ
 *
 * @package tenjoy-tour
 */

get_header();
?>

<main id="main" class="site-main" role="main">

  <div class="archive-header">
    <div class="container">
      <h1 class="archive-title"><?php tenjoy_e('footer_02'); ?></h1>
      <p class="archive-desc">
        <?php tenjoy_e('sitemap_01'); ?>
      </p>
    </div>
  </div>

  <div class="sitemap-page">
    <div class="container">
      <div class="sitemap-grid">

        <section>
          <h2 class="sitemap-section-title"><?php tenjoy_e('sitemap_02'); ?></h2>
          <ul class="sitemap-links">
            <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php tenjoy_e('sitemap_03'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/company/')); ?>"><?php tenjoy_e('nav_05'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/staff/')); ?>"><?php tenjoy_e('footer_05'); ?></a></li>
          </ul>
        </section>

        <section>
          <h2 class="sitemap-section-title"><?php tenjoy_e('sitemap_04'); ?></h2>
          <ul class="sitemap-links">
            <li><a
                href="<?php echo esc_url(get_post_type_archive_link('courses')); ?>"><?php tenjoy_e('footer_04'); ?></a>
            </li>
            <li><a
                href="<?php echo esc_url(get_post_type_archive_link('activities')); ?>"><?php tenjoy_e('sitemap_05'); ?></a>
            </li>
          </ul>
        </section>

        <section>
          <h2 class="sitemap-section-title"><?php tenjoy_e('nav_06'); ?></h2>
          <ul class="sitemap-links">
            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php tenjoy_e('nav_06'); ?></a></li>
          </ul>
        </section>

        <section>
          <h2 class="sitemap-section-title"><?php tenjoy_e('sitemap_06'); ?></h2>
          <ul class="sitemap-links">
            <li><a href="<?php echo esc_url(home_url('/faq/')); ?>"><?php tenjoy_e('faq_01'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/testimonials/')); ?>"><?php tenjoy_e('nav_04'); ?></a></li>
          </ul>
        </section>

        <section>
          <h2 class="sitemap-section-title"><?php tenjoy_e('footer_06'); ?></h2>
          <ul class="sitemap-links">
            <li>
              <?php
              $blog_url = get_permalink(get_option('page_for_posts'));
              if ($blog_url) :
              ?>
                <a href="<?php echo esc_url($blog_url); ?>"><?php tenjoy_e('sitemap_07'); ?></a>
              <?php else : ?>
                <a href="<?php echo esc_url(home_url('/blog/')); ?>"><?php tenjoy_e('sitemap_07'); ?></a>
              <?php endif; ?>
            </li>
          </ul>
        </section>

        <section>
          <h2 class="sitemap-section-title"><?php tenjoy_e('sitemap_08'); ?></h2>
          <ul class="sitemap-links">
            <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>"><?php tenjoy_e('sitemap_09'); ?></a></li>
          </ul>
        </section>

      </div>
    </div>
  </div>

</main>

<?php get_footer(); ?>