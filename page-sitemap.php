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
            <li><a href="<?php echo esc_url(tenjoy_front_page_url()); ?>"><?php tenjoy_e('sitemap_03'); ?></a></li>
            <li><a href="<?php echo esc_url(tenjoy_page_url('company', '/company/')); ?>"><?php tenjoy_e('nav_05'); ?></a></li>
            <li><a href="<?php echo esc_url(tenjoy_page_url('staff', '/staff/')); ?>"><?php tenjoy_e('footer_05'); ?></a></li>
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
            <li><a href="<?php echo esc_url(tenjoy_page_url('contact', '/contact/')); ?>"><?php tenjoy_e('nav_06'); ?></a></li>
          </ul>
        </section>

        <section>
          <h2 class="sitemap-section-title"><?php tenjoy_e('sitemap_06'); ?></h2>
          <ul class="sitemap-links">
            <li><a href="<?php echo esc_url(tenjoy_page_url('faq', '/faq/')); ?>"><?php tenjoy_e('faq_01'); ?></a></li>
            <li><a href="<?php echo esc_url(tenjoy_page_url('reviews', '/reviews/')); ?>"><?php tenjoy_e('nav_04'); ?></a></li>
          </ul>
        </section>

        <section>
          <h2 class="sitemap-section-title"><?php tenjoy_e('footer_06'); ?></h2>
          <ul class="sitemap-links">
            <li>
              <a href="<?php echo esc_url(tenjoy_posts_page_url()); ?>"><?php tenjoy_e('sitemap_07'); ?></a>
            </li>
          </ul>
        </section>

        <section>
          <h2 class="sitemap-section-title"><?php tenjoy_e('sitemap_08'); ?></h2>
          <ul class="sitemap-links">
            <li><a href="<?php echo esc_url(tenjoy_page_url('privacy-policy', '/privacy-policy/')); ?>"><?php tenjoy_e('sitemap_09'); ?></a></li>
          </ul>
        </section>

      </div>
    </div>
  </div>

</main>

<?php get_footer(); ?>