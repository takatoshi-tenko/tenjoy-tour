<?php

/**
 * トップページ
 *
 * @package tenjoy-tour
 */

get_header();
?>

<main id="main" class="site-main front-page" role="main">

  <?php get_template_part('template-parts/home/hero-section'); ?>
  <?php get_template_part('template-parts/home/services-section'); ?>
  <?php get_template_part('template-parts/home/staff-section'); ?>
  <?php get_template_part('template-parts/home/vehicles-section'); ?>
  <?php get_template_part('template-parts/home/company-section'); ?>
  <?php get_template_part('template-parts/home/reviews-section'); ?>
  <?php get_template_part('template-parts/home/contact-qr-section'); ?>

</main>

<?php get_footer(); ?>