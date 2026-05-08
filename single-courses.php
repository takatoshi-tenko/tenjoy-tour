<?php
/**
 * ゴルフ場詳細ページ
 * course_has_detail が false の場合はアーカイブにリダイレクト
 *
 * @package tenjoy-tour
 */

// 詳細ページ不可の場合はリダイレクト
if (get_the_ID() && !(bool) get_post_meta(get_the_ID(), 'course_has_detail', true)) {
  wp_safe_redirect(get_post_type_archive_link('courses'));
  exit;
}

get_header();

$prefecture = get_post_meta(get_the_ID(), 'course_prefecture', true);
$address    = get_post_meta(get_the_ID(), 'course_address', true);
$holes      = get_post_meta(get_the_ID(), 'course_holes', true);
$green_fee  = get_post_meta(get_the_ID(), 'course_green_fee', true);
$caddie     = get_post_meta(get_the_ID(), 'course_caddie', true);
$cart       = get_post_meta(get_the_ID(), 'course_cart', true);
$website    = get_post_meta(get_the_ID(), 'course_website', true);
?>

<main id="main" class="site-main" role="main">
  <?php while (have_posts()) : the_post(); ?>

    <div class="container">
      <div class="course-single">
        <div class="course-single-layout">

          <!-- メインコンテンツ -->
          <div class="course-single-main">
            <h1 class="course-single-title"><?php the_title(); ?></h1>

            <?php if (has_post_thumbnail()) : ?>
              <div class="course-single-thumbnail">
                <?php the_post_thumbnail('tenjoy-hero', ['alt' => get_the_title()]); ?>
              </div>
            <?php endif; ?>

            <div class="entry-content">
              <?php the_content(); ?>
            </div>

            <div class="tour-single-cta" style="margin-top:2rem;">
              <a href="<?php echo esc_url(home_url('/booking/')); ?>" class="btn btn-primary btn-lg">
                <?php esc_html_e('このコースでツアーを予約する', 'tenjoy-tour'); ?>
              </a>
              <a href="<?php echo esc_url(get_post_type_archive_link('courses')); ?>" class="btn btn-outline">
                <?php esc_html_e('コース一覧に戻る', 'tenjoy-tour'); ?>
              </a>
            </div>
          </div>

          <!-- サイドバー：コース情報 -->
          <aside class="course-sidebar">
            <h3 class="course-sidebar-title"><?php esc_html_e('コース情報', 'tenjoy-tour'); ?></h3>
            <dl class="course-specs">
              <?php if ($prefecture) : ?>
                <div class="course-spec-item">
                  <dt><?php esc_html_e('都道府県', 'tenjoy-tour'); ?></dt>
                  <dd><?php echo esc_html($prefecture); ?></dd>
                </div>
              <?php endif; ?>
              <?php if ($address) : ?>
                <div class="course-spec-item">
                  <dt><?php esc_html_e('住所', 'tenjoy-tour'); ?></dt>
                  <dd><?php echo esc_html($address); ?></dd>
                </div>
              <?php endif; ?>
              <?php if ($holes) : ?>
                <div class="course-spec-item">
                  <dt><?php esc_html_e('ホール数', 'tenjoy-tour'); ?></dt>
                  <dd><?php echo esc_html((string) $holes); ?>H</dd>
                </div>
              <?php endif; ?>
              <?php if ($green_fee) : ?>
                <div class="course-spec-item">
                  <dt><?php esc_html_e('グリーンフィー', 'tenjoy-tour'); ?></dt>
                  <dd><?php echo esc_html($green_fee); ?></dd>
                </div>
              <?php endif; ?>
              <?php if ($caddie !== '') : ?>
                <div class="course-spec-item">
                  <dt><?php esc_html_e('キャディ', 'tenjoy-tour'); ?></dt>
                  <dd><?php echo $caddie ? esc_html__('あり', 'tenjoy-tour') : esc_html__('なし', 'tenjoy-tour'); ?></dd>
                </div>
              <?php endif; ?>
              <?php if ($cart) : ?>
                <div class="course-spec-item">
                  <dt><?php esc_html_e('カート', 'tenjoy-tour'); ?></dt>
                  <dd><?php echo esc_html($cart); ?></dd>
                </div>
              <?php endif; ?>
              <?php if ($website) : ?>
                <div class="course-spec-item">
                  <dt><?php esc_html_e('公式サイト', 'tenjoy-tour'); ?></dt>
                  <dd>
                    <a href="<?php echo esc_url($website); ?>" target="_blank" rel="noopener noreferrer">
                      <?php esc_html_e('外部サイトを開く', 'tenjoy-tour'); ?>
                    </a>
                  </dd>
                </div>
              <?php endif; ?>
            </dl>
          </aside>

        </div>
      </div>
    </div>

  <?php endwhile; ?>
</main>

<?php get_footer(); ?>
