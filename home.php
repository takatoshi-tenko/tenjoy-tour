<?php

/**
 * 投稿一覧（ニュース一覧）
 * 表示設定で「投稿ページ」を指定したとき、または /news/ 仮想 URL（投稿ページ未設定時）で表示。
 *
 * @package Friend2026
 */

get_header();
?>

<main id="main" class="site-main archive-news" role="main">
	<!-- ページヘッダー -->
	<div class="archive-news-header">
		<div class="container">
			<p class="archive-news-label">News</p>
			<h1 class="archive-news-title">ニュース</h1>
			<p class="archive-news-desc">最新のお知らせや物件情報をお届けします。</p>
		</div>
	</div>

	<div class="container archive-news-body">
		<?php if (have_posts()) : ?>
			<div class="news-list">
				<?php while (have_posts()) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class('news-item'); ?>>
						<a href="<?php the_permalink(); ?>" class="news-item-link">
							<time class="news-item-date"
								datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
							<?php
							$categories = get_the_category();
							if ($categories) :
							?>
								<span class="news-item-category"><?php echo esc_html($categories[0]->name); ?></span>
							<?php endif; ?>
							<h2 class="news-item-title"><?php the_title(); ?></h2>
						</a>
					</article>
				<?php endwhile; ?>
			</div>
			<?php
			$pagination_args = array(
				'mid_size'  => 2,
				'prev_text' => '前へ',
				'next_text' => '次へ',
				'class'     => 'news-pagination',
			);
			if ((int) get_query_var('friend2026_news_archive') === 1) {
				$pagination_args['base']   = user_trailingslashit(home_url('/news')) . 'page/%#%/';
				$pagination_args['format'] = '';
			}
			the_posts_pagination($pagination_args);
			?>
		<?php else : ?>
			<div class="news-empty-wrap">
				<p class="news-empty">ニュースはまだありません。</p>
			</div>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
