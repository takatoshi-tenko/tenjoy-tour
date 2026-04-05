<?php

/**
 * テンプレート: サイトマップ（HTML）
 * functions.php の /sitemap リライト、またはスラッグ「sitemap」の固定ページで使用。
 * Next の /sitemap と同様のセクション構成でリンク一覧を出力する。
 *
 * @package Friend2026
 */

get_header();

$home_url       = home_url('/');
$properties_url = get_post_type_archive_link('property');
$news_url       = function_exists('friend2026_get_news_archive_url') ? friend2026_get_news_archive_url() : $home_url;
?>

<main id="main" class="site-main page-sitemap" role="main">
	<div class="page-sitemap-header">
		<div class="container">
			<p class="page-sitemap-label">Sitemap</p>
			<h1 class="page-sitemap-title">サイトマップ</h1>
			<p class="page-sitemap-desc">サイト内のページ一覧です。</p>
		</div>
	</div>

	<div class="container page-sitemap-body">
		<div class="page-sitemap-grid">
			<section class="page-sitemap-section">
				<h2 class="page-sitemap-section-title">メインページ</h2>
				<ul class="page-sitemap-links">
					<li><a href="<?php echo esc_url($home_url); ?>">トップページ</a></li>
				</ul>
			</section>

			<section class="page-sitemap-section">
				<h2 class="page-sitemap-section-title">物件一覧</h2>
				<ul class="page-sitemap-links">
					<li><a href="<?php echo esc_url($properties_url); ?>">物件一覧</a></li>
					<li><a href="<?php echo esc_url(add_query_arg('type', 'new-house', $properties_url)); ?>">新築一戸建て</a></li>
					<li><a href="<?php echo esc_url(add_query_arg('type', 'used-house', $properties_url)); ?>">中古一戸建て</a></li>
					<li><a href="<?php echo esc_url(add_query_arg('type', 'apartment', $properties_url)); ?>">マンション</a></li>
					<li><a href="<?php echo esc_url(add_query_arg('type', 'land', $properties_url)); ?>">土地</a></li>
					<li><a href="<?php echo esc_url(add_query_arg('recommended', '1', $properties_url)); ?>">おすすめ物件</a></li>
					<li><a href="<?php echo esc_url(add_query_arg('new', '1', $properties_url)); ?>">新着物件</a></li>
					<li><a href="<?php echo esc_url(add_query_arg('pricedown', '1', $properties_url)); ?>">値下げ物件</a></li>
					<li><a href="<?php echo esc_url(add_query_arg('openhouse', '1', $properties_url)); ?>">オープンハウス・現地販売会</a></li>
				</ul>
			</section>

			<section class="page-sitemap-section">
				<h2 class="page-sitemap-section-title">会社情報</h2>
				<ul class="page-sitemap-links">
					<li><a href="<?php echo esc_url(home_url('/company/')); ?>">会社概要</a></li>
					<li><a href="<?php echo esc_url(home_url('/company/#access')); ?>">店舗案内・アクセス</a></li>
				</ul>
			</section>

			<section class="page-sitemap-section">
				<h2 class="page-sitemap-section-title">スタッフ</h2>
				<ul class="page-sitemap-links">
					<li><a href="<?php echo esc_url(home_url('/staff/')); ?>">スタッフ紹介</a></li>
				</ul>
			</section>

			<section class="page-sitemap-section">
				<h2 class="page-sitemap-section-title">お問い合わせ・サポート</h2>
				<ul class="page-sitemap-links">
					<li><a href="<?php echo esc_url(home_url('/contact/')); ?>">お問い合わせ</a></li>
					<li><a href="<?php echo esc_url(home_url('/faq/')); ?>">よくあるご質問</a></li>
				</ul>
			</section>

			<section class="page-sitemap-section">
				<h2 class="page-sitemap-section-title">ニュース</h2>
				<ul class="page-sitemap-links">
					<li><a href="<?php echo esc_url($news_url); ?>">ニュース一覧</a></li>
				</ul>
			</section>

			<section class="page-sitemap-section">
				<h2 class="page-sitemap-section-title">法的情報</h2>
				<ul class="page-sitemap-links">
					<li><a href="<?php echo esc_url(home_url('/privacy/')); ?>">プライバシーポリシー</a></li>
					<li><a href="<?php echo esc_url(home_url('/personal-info/')); ?>">個人情報取扱に関する説明</a></li>
				</ul>
			</section>
		</div>
	</div>
</main>

<?php
get_footer();
