<?php

/**
 * 物件カード（一覧・トップ用）
 * ループ内で使用。$show_description を true にすると説明文を表示。
 *
 * @package Friend2026
 * @param bool $show_description 説明文を表示するか（省略時 false）※ set_query_var('show_description', true) で渡す
 */

$show_description = (bool) get_query_var('show_description', false);

$id     = get_the_ID();
$title  = get_the_title();
$price  = get_post_meta($id, 'property_price_label', true);
$addr   = get_post_meta($id, 'property_address', true);
$station = get_post_meta($id, 'property_station', true);
$walk   = get_post_meta($id, 'property_walk_minutes', true);
$plan   = get_post_meta($id, 'property_floor_plan', true);
$b_area = get_post_meta($id, 'property_building_area', true);
$l_area = get_post_meta($id, 'property_land_area', true);
$desc   = get_post_meta($id, 'property_description', true);
$is_new = (bool) get_post_meta($id, 'property_is_new', true);
$is_rec = (bool) get_post_meta($id, 'property_is_recommended', true);
$is_down = (bool) get_post_meta($id, 'property_is_price_down', true);
$open   = (bool) get_post_meta($id, 'property_open_house', true);

$types = get_the_terms($id, 'property_type');
$type_label = $types && ! is_wp_error($types) && ! empty($types) ? $types[0]->name : '';

$features_raw = get_post_meta($id, 'property_features', true);
$features = $features_raw ? array_map('trim', explode(',', $features_raw)) : array();

// 1枚目の画像：アイキャッチ → なければ property_gallery_ids の先頭
$first_image_id = null;
if (has_post_thumbnail()) {
	$first_image_id = get_post_thumbnail_id();
} else {
	$gallery_ids = get_post_meta($id, 'property_gallery_ids', true);
	if ($gallery_ids) {
		$ids = array_filter(array_map('intval', explode(',', $gallery_ids)));
		if (! empty($ids)) {
			$first_image_id = $ids[0];
		}
	}
}
?>
<a href="<?php the_permalink(); ?>" class="property-card">
	<div class="property-card-image">
		<?php if ($first_image_id) : ?>
			<?php echo wp_get_attachment_image($first_image_id, 'medium_large', false, array('class' => 'property-card-img')); ?>
		<?php else : ?>
			<div class="property-card-placeholder"></div>
		<?php endif; ?>
		<div class="property-card-badges">
			<?php if ($is_new) : ?><span class="property-badge property-badge-new">NEW</span><?php endif; ?>
			<?php if ($is_rec) : ?><span class="property-badge property-badge-rec">おすすめ</span><?php endif; ?>
			<?php if ($is_down) : ?><span class="property-badge property-badge-down">値下げ</span><?php endif; ?>
			<?php if ($open) : ?><span class="property-badge property-badge-open">現地販売会</span><?php endif; ?>
		</div>
		<?php if ($type_label) : ?>
			<span class="property-card-type"><?php echo esc_html($type_label); ?></span>
		<?php endif; ?>
	</div>
	<div class="property-card-body">
		<?php if ($price) : ?>
			<p class="property-card-price"><?php echo esc_html($price); ?></p>
		<?php endif; ?>
		<h3 class="property-card-title"><?php echo esc_html($title); ?></h3>
		<div class="property-card-details">
			<?php if ($station && $walk !== '') : ?>
				<p class="property-card-detail property-card-detail-line">
					<span class="property-card-detail-icon" aria-hidden="true">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z" />
							<line x1="4" y1="22" x2="4" y2="15" />
						</svg>
					</span>
					<?php echo esc_html($station); ?> 徒歩<?php echo (int) $walk; ?>分
				</p>
			<?php endif; ?>
			<?php if ($addr) : ?>
				<p class="property-card-detail property-card-detail-line">
					<span class="property-card-detail-icon" aria-hidden="true">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
							<circle cx="12" cy="10" r="3" />
						</svg>
					</span>
					<?php echo esc_html($addr); ?>
				</p>
			<?php endif; ?>
			<?php if ($plan || $b_area || $l_area) : ?>
				<p class="property-card-detail property-card-detail-line">
					<span class="property-card-detail-icon" aria-hidden="true">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
							<polyline points="9 22 9 12 15 12 15 22" />
						</svg>
					</span>
					<?php
					$parts = array();
					if ($plan) $parts[] = $plan;
					if ($b_area) $parts[] = '建物' . $b_area . '㎡';
					if ($l_area) $parts[] = '土地' . $l_area . '㎡';
					echo esc_html(implode('/ ', $parts));
					?>
				</p>
			<?php endif; ?>
		</div>
		<?php if (! empty($features)) : ?>
			<div class="property-card-tags">
				<?php foreach (array_slice($features, 0, 6) as $f) : ?>
					<span class="property-card-tag"><?php echo esc_html($f); ?></span>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</a>