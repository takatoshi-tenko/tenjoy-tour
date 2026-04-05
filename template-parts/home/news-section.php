<?php

/**
 * トップページ: ニュース（最新4件）＋ 値下げ・新着件数リンク
 *
 * @package Friend2026
 */

$news = new WP_Query(array(
	'post_type'      => 'post',
	'posts_per_page' => 4,
	'post_status'    => 'publish',
	'orderby'        => 'date',
	'order'          => 'DESC',
));

$news_url = function_exists('friend2026_get_news_archive_url') ? friend2026_get_news_archive_url() : home_url('/');

// 値下げ・新着件数（物件 CPT の meta_query）
$pricedown = new WP_Query(array(
	'post_type'   => 'property',
	'post_status' => 'publish',
	'fields'      => 'ids',
	'meta_query'  => array(array('key' => 'property_is_price_down', 'value' => '1')),
));
$new_count = new WP_Query(array(
	'post_type'   => 'property',
	'post_status' => 'publish',
	'fields'      => 'ids',
	'meta_query'  => array(array('key' => 'property_is_new', 'value' => '1')),
));
$pricedown_count = $pricedown->found_posts;
$new_count_num   = $new_count->found_posts;
?>

<section class="front-section front-news">
	<div class="container">
		<div class="front-news-grid">
			<div class="front-news-main">
				<div class="front-section-head">
					<div>
						<p class="front-section-label">News</p>
						<h2 class="front-section-title">ニュース</h2>
					</div>
					<a href="<?php echo esc_url($news_url); ?>" class="front-section-link">一覧を見る</a>
				</div>
				<div class="front-news-list">
					<?php if ($news->have_posts()) : ?>
						<?php
						$index = 0;
						$total = $news->post_count;
						while ($news->have_posts()) :
							$news->the_post();
							$last = ($index === $total - 1);
							?>
						<a href="<?php the_permalink(); ?>" class="front-news-item <?php echo $last ? '' : 'front-news-item-border'; ?>">
							<time class="front-news-date"><?php echo esc_html(get_the_date()); ?></time>
							<span class="front-news-title"><?php the_title(); ?></span>
						</a>
							<?php
							$index++;
						endwhile;
						wp_reset_postdata();
						?>
					<?php else : ?>
						<p class="front-section-empty">ニュースはまだありません。</p>
					<?php endif; ?>
				</div>
			</div>
			<div class="front-news-side">
				<div class="front-news-box">
					<h3 class="front-news-box-title">値下げ物件</h3>
					<a href="<?php echo esc_url(home_url('/properties/?pricedown=1')); ?>" class="front-news-box-link">
						<span class="front-news-box-num front-news-box-num-down"><?php echo (int) $pricedown_count; ?></span>
						<span class="front-news-box-unit">件の物件</span>
					</a>
				</div>
				<div class="front-news-box">
					<h3 class="front-news-box-title">新着物件</h3>
					<a href="<?php echo esc_url(home_url('/properties/?new=1')); ?>" class="front-news-box-link">
						<span class="front-news-box-num front-news-box-num-new"><?php echo (int) $new_count_num; ?></span>
						<span class="front-news-box-unit">件の物件</span>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
