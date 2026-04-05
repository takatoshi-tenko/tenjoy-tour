<?php

/**
 * 物件一覧アーカイブ
 * GET: type, recommended, openhouse, pricedown, new, orderby（price-low / price-high）
 *
 * @package Friend2026
 */

get_header();

$current_type = isset($_GET['type']) ? sanitize_text_field(wp_unslash($_GET['type'])) : '';
$current_tag  = '';
if (! empty($_GET['recommended']) && $_GET['recommended'] === '1') {
	$current_tag = 'recommended';
} elseif (! empty($_GET['openhouse']) && $_GET['openhouse'] === '1') {
	$current_tag = 'openhouse';
} elseif (! empty($_GET['pricedown']) && $_GET['pricedown'] === '1') {
	$current_tag = 'pricedown';
} elseif (! empty($_GET['new']) && $_GET['new'] === '1') {
	$current_tag = 'new';
}

$base_url = get_post_type_archive_link('property');
$type_filters = array(
	''            => 'すべて',
	'new-house'   => '新築一戸建て',
	'used-house'  => '中古一戸建て',
	'apartment'   => 'マンション',
	'land'        => '土地',
);
?>

<main id="main" class="site-main archive-property" role="main">
	<div class="archive-property-header">
		<div class="container">
			<p class="archive-property-label">Property</p>
			<h1 class="archive-property-title">物件一覧</h1>
			<p class="archive-property-desc">ご希望の条件で物件を検索できます。</p>
			<p class="archive-property-count"><?php echo (int) $wp_query->found_posts; ?>件の物件が見つかりました</p>
		</div>
	</div>

	<div class="container archive-property-body">
		<!-- フィルター -->
		<div class="archive-property-filters">
			<div class="archive-property-filter-group">
				<?php foreach ($type_filters as $slug => $label) : ?>
					<?php
					$url = $slug === '' ? $base_url : add_query_arg('type', $slug, $base_url);
					$active = ($current_type === $slug);
					?>
					<a href="<?php echo esc_url($url); ?>"
						class="archive-property-badge <?php echo $active ? 'is-active' : ''; ?>"><?php echo esc_html($label); ?></a>
				<?php endforeach; ?>
			</div>
			<div class="archive-property-filter-group">
				<a href="<?php echo esc_url($base_url); ?>"
					class="archive-property-badge <?php echo $current_tag === '' ? 'is-active' : ''; ?>">すべて</a>
				<a href="<?php echo esc_url(add_query_arg('new', '1', $base_url)); ?>"
					class="archive-property-badge <?php echo $current_tag === 'new' ? 'is-active' : ''; ?>">新着</a>
				<a href="<?php echo esc_url(add_query_arg('recommended', '1', $base_url)); ?>"
					class="archive-property-badge <?php echo $current_tag === 'recommended' ? 'is-active' : ''; ?>">おすすめ</a>
				<a href="<?php echo esc_url(add_query_arg('pricedown', '1', $base_url)); ?>"
					class="archive-property-badge <?php echo $current_tag === 'pricedown' ? 'is-active' : ''; ?>">値下げ</a>
				<a href="<?php echo esc_url(add_query_arg('openhouse', '1', $base_url)); ?>"
					class="archive-property-badge <?php echo $current_tag === 'openhouse' ? 'is-active' : ''; ?>">オープンハウス</a>
				<?php if ($current_type !== '' || $current_tag !== '') : ?>
					<a href="<?php echo esc_url($base_url); ?>"
						class="archive-property-badge archive-property-badge-clear">フィルターをクリア</a>
				<?php endif; ?>
			</div>
		</div>

		<!-- 並び替え・表示切替 -->
		<div class="archive-property-toolbar">
			<span class="archive-property-toolbar-count"><?php echo (int) $wp_query->found_posts; ?>件</span>
			<div class="archive-property-toolbar-right">
				<?php
				$current_order = isset($_GET['orderby']) ? sanitize_text_field(wp_unslash($_GET['orderby'])) : '';
				$sort_url_default = remove_query_arg('orderby');
				$sort_url_low = add_query_arg('orderby', 'price-low');
				$sort_url_high = add_query_arg('orderby', 'price-high');
				?>
				<div class="archive-property-sort-wrap">
					<select class="archive-property-sort-select" aria-label="並び替え" onchange="if(this.value) location.href=this.value;">
						<option value="<?php echo esc_url($sort_url_default); ?>" <?php selected($current_order, ''); ?>>デフォルト</option>
						<option value="<?php echo esc_url($sort_url_low); ?>" <?php selected($current_order, 'price-low'); ?>>価格が安い順</option>
						<option value="<?php echo esc_url($sort_url_high); ?>" <?php selected($current_order, 'price-high'); ?>>価格が高い順</option>
					</select>
				</div>
				<div class="archive-property-view-toggle" role="group" aria-label="表示切替">
					<button type="button" class="archive-property-view-btn is-active" data-view="grid" aria-pressed="true" title="グリッド表示">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
					</button>
					<button type="button" class="archive-property-view-btn" data-view="list" aria-pressed="false" title="リスト表示">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
					</button>
				</div>
			</div>
		</div>

		<?php if (have_posts()) : ?>
			<div class="archive-property-grid" id="archive-property-grid">
				<?php
				set_query_var('show_description', true);
				while (have_posts()) :
					the_post();
					get_template_part('template-parts/property/property-card');
				endwhile;
				?>
			</div>
			<?php
			the_posts_pagination(array(
				'mid_size'  => 2,
				'prev_text' => '前へ',
				'next_text' => '次へ',
				'class'     => 'archive-property-pagination',
			));
			?>
		<?php else : ?>
			<div class="archive-property-empty">
				<p>条件に一致する物件が見つかりませんでした</p>
				<a href="<?php echo esc_url($base_url); ?>" class="btn btn-outline-accent">フィルターをクリア</a>
			</div>
		<?php endif; ?>
	</div>
</main>

<script>
	(function() {
		var key = 'friend2026_property_view';
		var grid = document.getElementById('archive-property-grid');
		var btns = document.querySelectorAll('.archive-property-view-btn');
		if (!grid || !btns.length) return;

		function setView(view) {
			grid.classList.toggle('archive-property-view-list', view === 'list');
			try {
				localStorage.setItem(key, view);
			} catch (e) {}
			btns.forEach(function(b) {
				var isList = b.getAttribute('data-view') === 'list';
				b.classList.toggle('is-active', isList === (view === 'list'));
				b.setAttribute('aria-pressed', isList === (view === 'list') ? 'true' : 'false');
			});
		}
		try {
			var saved = localStorage.getItem(key);
			if (saved === 'list' || saved === 'grid') setView(saved);
		} catch (e) {}
		btns.forEach(function(b) {
			b.addEventListener('click', function() {
				setView(this.getAttribute('data-view'));
			});
		});
	})();
</script>

<?php
get_footer();
