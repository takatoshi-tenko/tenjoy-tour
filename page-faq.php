<?php
/**
 * Template Name: よくある質問
 *
 * @package tenjoy-tour
 */

get_header();

$faq_posts = get_posts([
    'post_type'      => 'faq',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'post_status'    => 'publish',
]);
?>

<main id="main" class="site-main" role="main">

  <div class="archive-header">
    <div class="container">
      <h1 class="archive-title"><?php esc_html_e('よくある質問', 'tenjoy-tour'); ?></h1>
      <p class="archive-desc">
        <?php esc_html_e('お客様からよくいただくご質問をまとめました', 'tenjoy-tour'); ?>
      </p>
    </div>
  </div>

  <div class="faq-page">
    <div class="container">

      <?php if (! empty($faq_posts)) : ?>
        <div class="faq-list" id="faq-list">
          <?php foreach ($faq_posts as $post) : setup_postdata($post); ?>
            <div class="faq-item">
              <button
                type="button"
                class="faq-question"
                aria-expanded="false"
                aria-controls="faq-answer-<?php echo esc_attr((string) $post->ID); ?>"
                data-faq-toggle
              >
                <span class="faq-question-text"><?php the_title(); ?></span>
                <span class="faq-question-icon" aria-hidden="true"></span>
              </button>
              <div
                class="faq-answer"
                id="faq-answer-<?php echo esc_attr((string) $post->ID); ?>"
                hidden
              >
                <div class="faq-answer-inner">
                  <?php the_content(); ?>
                </div>
              </div>
            </div>
          <?php endforeach; wp_reset_postdata(); ?>
        </div>

      <?php else : ?>
        <p class="news-empty" style="text-align:center;">
          <?php esc_html_e('FAQはまだ登録されていません。管理画面の「よくある質問」から追加してください。', 'tenjoy-tour'); ?>
        </p>
      <?php endif; ?>

      <div class="faq-cta">
        <p class="faq-cta-title"><?php esc_html_e('解決しない場合は', 'tenjoy-tour'); ?></p>
        <p class="faq-cta-desc">
          <?php esc_html_e('上記以外のご質問がございましたら、お気軽にお問い合わせください。', 'tenjoy-tour'); ?>
        </p>
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary">
          <?php esc_html_e('お問い合わせはこちら', 'tenjoy-tour'); ?>
        </a>
      </div>

    </div>
  </div>

</main>

<?php get_footer(); ?>
