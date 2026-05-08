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
      <h1 class="archive-title"><?php esc_html_e('サイトマップ', 'tenjoy-tour'); ?></h1>
      <p class="archive-desc">
        <?php esc_html_e('サイト内のページ一覧です', 'tenjoy-tour'); ?>
      </p>
    </div>
  </div>

  <div class="sitemap-page">
    <div class="container">
      <div class="sitemap-grid">

        <section>
          <h2 class="sitemap-section-title"><?php esc_html_e('メイン', 'tenjoy-tour'); ?></h2>
          <ul class="sitemap-links">
            <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('トップページ', 'tenjoy-tour'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/company/')); ?>"><?php esc_html_e('会社概要', 'tenjoy-tour'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/staff/')); ?>"><?php esc_html_e('スタッフ紹介', 'tenjoy-tour'); ?></a></li>
          </ul>
        </section>

        <section>
          <h2 class="sitemap-section-title"><?php esc_html_e('ツアー', 'tenjoy-tour'); ?></h2>
          <ul class="sitemap-links">
            <li><a href="<?php echo esc_url(get_post_type_archive_link('tours')); ?>"><?php esc_html_e('ツアー一覧', 'tenjoy-tour'); ?></a></li>
            <li><a href="<?php echo esc_url(get_post_type_archive_link('courses')); ?>"><?php esc_html_e('ゴルフ場一覧', 'tenjoy-tour'); ?></a></li>
            <li><a href="<?php echo esc_url(get_post_type_archive_link('activities')); ?>"><?php esc_html_e('アクティビティ一覧', 'tenjoy-tour'); ?></a></li>
          </ul>
        </section>

        <section>
          <h2 class="sitemap-section-title"><?php esc_html_e('予約・お問い合わせ', 'tenjoy-tour'); ?></h2>
          <ul class="sitemap-links">
            <li><a href="<?php echo esc_url(home_url('/booking/')); ?>"><?php esc_html_e('ツアー予約', 'tenjoy-tour'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('お問い合わせ', 'tenjoy-tour'); ?></a></li>
          </ul>
        </section>

        <section>
          <h2 class="sitemap-section-title"><?php esc_html_e('サポート', 'tenjoy-tour'); ?></h2>
          <ul class="sitemap-links">
            <li><a href="<?php echo esc_url(home_url('/faq/')); ?>"><?php esc_html_e('よくある質問', 'tenjoy-tour'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/testimonials/')); ?>"><?php esc_html_e('お客様の声', 'tenjoy-tour'); ?></a></li>
          </ul>
        </section>

        <section>
          <h2 class="sitemap-section-title"><?php esc_html_e('ブログ', 'tenjoy-tour'); ?></h2>
          <ul class="sitemap-links">
            <li>
              <?php
              $blog_url = get_permalink(get_option('page_for_posts'));
              if ($blog_url) :
              ?>
                <a href="<?php echo esc_url($blog_url); ?>"><?php esc_html_e('ブログ一覧', 'tenjoy-tour'); ?></a>
              <?php else : ?>
                <a href="<?php echo esc_url(home_url('/blog/')); ?>"><?php esc_html_e('ブログ一覧', 'tenjoy-tour'); ?></a>
              <?php endif; ?>
            </li>
          </ul>
        </section>

        <section>
          <h2 class="sitemap-section-title"><?php esc_html_e('その他', 'tenjoy-tour'); ?></h2>
          <ul class="sitemap-links">
            <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>"><?php esc_html_e('プライバシーポリシー', 'tenjoy-tour'); ?></a></li>
          </ul>
        </section>

      </div>
    </div>
  </div>

</main>

<?php get_footer(); ?>
