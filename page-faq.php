<?php

/**
 * テンプレート: よくあるご質問（/faq）
 * 固定ページのスラッグが「faq」のときに使用。
 * FAQ は「よくあるご質問」投稿タイプと「FAQカテゴリ」で管理。
 *
 * @package Friend2026
 */

get_header();

$faq_categories = get_terms(array(
	'taxonomy'   => 'faq_category',
	'hide_empty' => true,
	'orderby'    => 'term_id',
	'order'      => 'ASC',
));
?>

<main id="main" class="site-main page-faq" role="main">
  <div class="page-faq-header">
    <div class="container">
      <p class="page-faq-label">FAQ</p>
      <h1 class="page-faq-title">よくあるご質問</h1>
      <p class="page-faq-desc">お客様からよくいただくご質問をまとめました。</p>
    </div>
  </div>

  <div class="container page-faq-body">
    <?php if (! empty($faq_categories) && ! is_wp_error($faq_categories)) : ?>
    <?php foreach ($faq_categories as $term) : ?>
    <?php
				$faq_posts = get_posts(array(
					'post_type'      => 'faq',
					'posts_per_page' => -1,
					'orderby'        => 'menu_order title',
					'order'          => 'ASC',
					'tax_query'      => array(array(
						'taxonomy' => 'faq_category',
						'field'    => 'term_id',
						'terms'    => $term->term_id,
					)),
					'post_status'    => 'publish',
				));
				if (empty($faq_posts)) {
					continue;
				}
				?>
    <section class="page-faq-category" aria-labelledby="faq-cat-<?php echo esc_attr($term->term_id); ?>">
      <h2 id="faq-cat-<?php echo esc_attr($term->term_id); ?>" class="page-faq-category-title">
        <?php echo esc_html($term->name); ?></h2>
      <div class="page-faq-list" role="list">
        <?php foreach ($faq_posts as $post) : setup_postdata($post); ?>
        <div class="page-faq-item" role="listitem">
          <button type="button" class="page-faq-question" aria-expanded="false"
            aria-controls="faq-answer-<?php echo esc_attr($post->ID); ?>"
            id="faq-question-<?php echo esc_attr($post->ID); ?>" data-faq-toggle>
            <span class="page-faq-question-text"><?php the_title(); ?></span>
            <span class="page-faq-question-icon" aria-hidden="true"></span>
          </button>
          <div class="page-faq-answer" id="faq-answer-<?php echo esc_attr($post->ID); ?>" role="region"
            aria-labelledby="faq-question-<?php echo esc_attr($post->ID); ?>" hidden>
            <div class="page-faq-answer-inner">
              <?php the_content(); ?>
            </div>
          </div>
        </div>
        <?php endforeach;
						wp_reset_postdata(); ?>
      </div>
    </section>
    <?php endforeach; ?>
    <?php else : ?>
    <p class="page-faq-empty">FAQはまだ登録されていません。管理画面の「よくあるご質問」から追加してください。</p>
    <?php endif; ?>

    <div class="page-faq-cta">
      <p class="page-faq-cta-title">解決しない場合は</p>
      <p class="page-faq-cta-desc">上記以外のご質問がございましたら、お気軽にお問い合わせください。</p>
      <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-cta page-faq-cta-btn">お問い合わせはこちら<span
          class="page-faq-cta-arrow" aria-hidden="true"></span></a>
    </div>
  </div>
</main>

<?php
get_footer();