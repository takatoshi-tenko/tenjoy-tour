<?php

/**
 * 投稿詳細（ニュース詳細）
 * 本文は投稿エディタで HTML として入力。Markdown を使う場合はプラグインで変換可能。
 *
 * @package Friend2026
 */

get_header();
?>

<main id="main" class="site-main single-news" role="main">
	<?php while (have_posts()) : the_post(); ?>
		<?php
		$news_url = function_exists('friend2026_get_news_archive_url') ? friend2026_get_news_archive_url() : home_url('/');
		?>

		<!-- パンくず・戻る -->
		<div class="single-news-breadcrumb">
			<div class="container">
				<nav class="single-news-breadcrumb-inner" aria-label="パンくず">
					<a href="<?php echo esc_url(home_url('/')); ?>">ホーム</a>
					<span class="single-news-breadcrumb-sep">/</span>
					<a href="<?php echo esc_url($news_url); ?>">ニュース</a>
					<span class="single-news-breadcrumb-sep">/</span>
					<span class="single-news-breadcrumb-current"><?php the_title(); ?></span>
				</nav>
			</div>
		</div>

		<div class="container single-news-body">
			<a href="<?php echo esc_url($news_url); ?>" class="single-news-back">← ニュース一覧に戻る</a>

			<article id="post-<?php the_ID(); ?>" <?php post_class('news-single'); ?>>
				<header class="entry-header news-single-header">
					<div class="news-single-meta">
						<time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
						<?php
						$categories = get_the_category();
						if ($categories) :
						?>
							<span class="news-single-category"><?php echo esc_html($categories[0]->name); ?></span>
						<?php endif; ?>
					</div>
					<?php the_title('<h1 class="entry-title news-single-title">', '</h1>'); ?>
				</header>

				<div class="entry-content news-single-content prose">
					<?php the_content(); ?>
				</div>

				<footer class="news-single-footer">
					<a href="<?php echo esc_url($news_url); ?>" class="btn btn-outline">ニュース一覧に戻る</a>
				</footer>
			</article>
		</div>
	<?php endwhile; ?>
</main>

<?php
get_footer();
