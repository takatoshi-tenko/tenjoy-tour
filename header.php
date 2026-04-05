<?php

/**
 * ヘッダー
 *
 * @package Friend2026
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php /* タブアイコン（ファビコン）・ホーム画面用 */ ?>
  <link rel="icon" type="image/png" href="<?php echo esc_url(FRIEND2026_URI . '/assets/images/logo.png'); ?>">
  <link rel="apple-touch-icon" href="<?php echo esc_url(FRIEND2026_URI . '/assets/images/logo.png'); ?>">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <header class="site-header" role="banner">
    <!-- Top bar（PCのみ） -->
    <div class="header-top-bar" aria-hidden="true">
      <div class="header-inner">
        <p class="header-catch">東京23区・多摩エリアの不動産情報</p>
        <div class="header-top-right">
          <a href="tel:0120-123-456" class="header-tel">0120-123-456</a>
          <span class="header-hours">受付時間: 9:00〜19:00</span>
        </div>
      </div>
    </div>

    <!-- Main navigation -->
    <nav class="site-nav" aria-label="メインメニュー">
      <div class="header-inner">
        <div class="nav-row">
          <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
            <img src="<?php echo esc_url(FRIEND2026_URI . '/assets/images/logo.png'); ?>"
              alt="<?php bloginfo('name'); ?>" width="50" height="50" loading="eager">
            <div class="site-logo-text">
              <span class="site-logo-label">有限会社</span>
              <span class="site-logo-name">ふれんど 東京支社</span>
            </div>
          </a>

          <ul class="nav-menu nav-menu-desktop">
            <li><a href="<?php echo esc_url(home_url('/properties/')); ?>">物件一覧</a></li>
            <li><a href="<?php echo esc_url(home_url('/company/')); ?>">会社概要</a></li>
            <li><a href="<?php echo esc_url(home_url('/staff/')); ?>">スタッフ紹介</a></li>
            <li><a href="<?php echo esc_url(home_url('/faq/')); ?>">よくあるご質問</a></li>
            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">お問い合わせ</a></li>
          </ul>

          <div class="nav-cta">
            <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-cta">無料相談予約</a>
          </div>

          <button type="button" class="nav-toggle" aria-label="メニューを開く" aria-expanded="false"
            aria-controls="mobile-menu">
            <span class="nav-toggle-icon"></span>
          </button>
        </div>

        <div id="mobile-menu" class="nav-menu nav-menu-mobile" aria-hidden="true" hidden>
          <ul>
            <li><a href="<?php echo esc_url(home_url('/properties/')); ?>">物件一覧</a></li>
            <li><a href="<?php echo esc_url(home_url('/company/')); ?>">会社概要</a></li>
            <li><a href="<?php echo esc_url(home_url('/staff/')); ?>">スタッフ紹介</a></li>
            <li><a href="<?php echo esc_url(home_url('/faq/')); ?>">よくあるご質問</a></li>
            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">お問い合わせ</a></li>
          </ul>
          <div class="mobile-menu-footer">
            <a href="tel:0120-123-456" class="mobile-tel">0120-123-456</a>
            <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-cta">無料相談予約</a>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <div id="page" class="site">