<?php

/**
 * ヘッダー
 *
 * @package tenjoy-tour
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <link rel="icon" type="image/png"
    href="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>">
  <link rel="apple-touch-icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <header class="site-header" role="banner">
    <div class="header-inner">

      <!-- ロゴ -->
      <a href="<?php echo esc_url(tenjoy_front_page_url()); ?>" class="site-logo">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>"
          alt="<?php bloginfo('name'); ?>" width="48" height="48" loading="eager">
        <span class="site-logo-name">TENJOY-TOUR</span>
      </a>

      <!-- デスクトップナビ -->
      <nav class="site-nav" aria-label="<?php tenjoy_attr_e('header_01'); ?>">
        <?php
        wp_nav_menu([
          'theme_location' => 'primary',
          'menu_class'     => 'nav-menu',
          'container'      => false,
          'fallback_cb'    => 'tenjoy_fallback_nav',
        ]);
        ?>
      </nav>

      <!-- 右側コントロール -->
      <div class="header-controls">

        <!-- 言語切替（Polylang） -->
        <?php if (function_exists('pll_the_languages')) : ?>
          <div class="lang-switcher" aria-label="<?php tenjoy_attr_e('header_02'); ?>">
            <button class="lang-switcher-toggle" aria-expanded="false" aria-controls="lang-menu">
              <?php
              $tenjoy_curlang = function_exists('pll_current_language') ? pll_current_language('OBJECT') : false;
              ?>
              <?php if ($tenjoy_curlang) : ?>
                <?php echo $tenjoy_curlang->get_display_flag('alt'); // phpcs:ignore WordPress.Security.EscapeOutput 
                ?>
              <?php else : ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <circle cx="12" cy="12" r="10" />
                  <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                  <path d="M2 12h20" />
                </svg>
              <?php endif; ?>
              <span class="sr-only"><?php tenjoy_e('header_02'); ?></span>
            </button>
            <ul id="lang-menu" class="lang-menu" hidden>
              <?php
              pll_the_languages([
                'show_flags'            => 1,
                'show_names'            => 1,
                'dropdown'              => 0,
                'echo'                  => 1,
                'hide_if_no_translation' => 0,
              ]);
              ?>
            </ul>
          </div>
        <?php endif; ?>

        <!-- ハンバーガーボタン（SP） -->
        <button type="button" class="nav-toggle" aria-label="<?php tenjoy_attr_e('header_03'); ?>" aria-expanded="false"
          aria-controls="mobile-menu">
          <span class="nav-toggle-bar"></span>
          <span class="nav-toggle-bar"></span>
          <span class="nav-toggle-bar"></span>
        </button>
      </div>
    </div><!-- /.header-inner -->

    <!-- モバイルメニュー -->
    <div id="mobile-menu" class="mobile-menu" aria-hidden="true" hidden>
      <nav aria-label="<?php tenjoy_attr_e('header_04'); ?>">
        <?php
        wp_nav_menu([
          'theme_location' => 'primary',
          'menu_class'     => 'mobile-nav-menu',
          'container'      => false,
          'fallback_cb'    => 'tenjoy_fallback_mobile_nav',
        ]);
        ?>
      </nav>

      <!-- モバイル言語切替 -->
      <?php if (function_exists('pll_the_languages')) : ?>
        <div class="mobile-lang-switcher">
          <?php
          pll_the_languages([
            'show_flags'            => 1,
            'show_names'            => 1,
            'dropdown'              => 0,
            'echo'                  => 1,
            'hide_if_no_translation' => 0,
          ]);
          ?>
        </div>
      <?php endif; ?>
    </div><!-- /#mobile-menu -->

  </header><!-- /.site-header -->

  <div id="page" class="site">