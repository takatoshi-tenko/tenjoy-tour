<?php

/**
 * 物件詳細: 画像ギャラリー
 * 1枚目を大きく表示、2枚目以降は下に小さいプレビュー（改行して表示）。
 * 画像押下で画面全体に拡大、左右矢印で前後移動、右上×で閉じる。
 *
 * @package Friend2026
 */

$id = get_the_ID();
$is_new = (bool) get_post_meta($id, 'property_is_new', true);
$is_rec = (bool) get_post_meta($id, 'property_is_recommended', true);
$is_down = (bool) get_post_meta($id, 'property_is_price_down', true);
$open = (bool) get_post_meta($id, 'property_open_house', true);

// 表示する画像ID一覧（アイキャッチ + property_gallery_ids、重複なし・順序保持）
$gallery_ids = array();
if (has_post_thumbnail()) {
	$gallery_ids[] = get_post_thumbnail_id();
}
$meta_ids = get_post_meta($id, 'property_gallery_ids', true);
if ($meta_ids) {
	$ids = array_filter(array_map('intval', explode(',', $meta_ids)));
	foreach ($ids as $aid) {
		if (! in_array($aid, $gallery_ids, true)) {
			$gallery_ids[] = $aid;
		}
	}
}
if (empty($gallery_ids)) {
	$gallery_ids = array(); // 0枚のときはプレースホルダーのみ
}

$gallery_data = array();
foreach ($gallery_ids as $aid) {
	$full = wp_get_attachment_image_url($aid, 'large');
	$thumb = wp_get_attachment_image_url($aid, 'thumbnail');
	if ($full) {
		$gallery_data[] = array(
			'id'    => $aid,
			'full'  => $full,
			'thumb' => $thumb ? $thumb : $full,
		);
	}
}
$gallery_json = wp_json_encode($gallery_data);
$count = count($gallery_data);
?>

<div class="single-property-gallery" id="property-gallery" data-gallery="<?php echo esc_attr($gallery_json); ?>">
	<div class="single-property-gallery-main" role="button" tabindex="0" aria-label="画像を拡大表示">
		<?php if ($count > 0) : ?>
			<?php
			$first = $gallery_data[0];
			$src   = $first['full'];
			$alt   = get_post_meta($first['id'], '_wp_attachment_image_alt', true);
			?>
			<img class="single-property-gallery-img single-property-gallery-current" src="<?php echo esc_url($src); ?>"
				alt="<?php echo esc_attr($alt ?: get_the_title()); ?>"
				data-index="0">
		<?php else : ?>
			<div class="single-property-gallery-placeholder"></div>
		<?php endif; ?>
		<div class="single-property-gallery-badges">
			<?php if ($is_new) : ?><span class="property-badge property-badge-new">NEW</span><?php endif; ?>
			<?php if ($is_rec) : ?><span class="property-badge property-badge-rec">おすすめ</span><?php endif; ?>
			<?php if ($is_down) : ?><span class="property-badge property-badge-down">値下げ</span><?php endif; ?>
			<?php if ($open) : ?><span class="property-badge property-badge-open">現地販売会</span><?php endif; ?>
		</div>
		<?php if ($count > 0) : ?>
			<span class="single-property-gallery-count">全<?php echo (int) $count; ?>枚</span>
		<?php endif; ?>
	</div>

	<?php if ($count > 0) : ?>
	<div class="single-property-gallery-thumbs" aria-label="ギャラリープレビュー">
		<?php foreach ($gallery_data as $i => $img) : ?>
			<button type="button" class="single-property-gallery-thumb <?php echo $i === 0 ? 'is-active' : ''; ?>"
				data-index="<?php echo (int) $i; ?>"
				aria-label="画像<?php echo (int) $i + 1; ?>を表示">
				<img src="<?php echo esc_url($img['thumb']); ?>" alt="" width="80" height="80" loading="lazy">
			</button>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</div>

<?php if ($count > 0) : ?>
<!-- ライトボックス（拡大・スライド） -->
<div id="property-gallery-lightbox" class="property-gallery-lightbox" role="dialog" aria-modal="true" aria-label="画像ギャラリー" hidden>
	<button type="button" class="property-gallery-lightbox-close" aria-label="閉じる">&times;</button>
	<button type="button" class="property-gallery-lightbox-prev" aria-label="前の画像">&lsaquo;</button>
	<button type="button" class="property-gallery-lightbox-next" aria-label="次の画像">&rsaquo;</button>
	<div class="property-gallery-lightbox-inner">
		<img class="property-gallery-lightbox-img" src="" alt="" data-index="0">
	</div>
	<p class="property-gallery-lightbox-counter"><span class="property-gallery-lightbox-current">1</span> / <span class="property-gallery-lightbox-total"><?php echo (int) $count; ?></span></p>
</div>
<?php endif; ?>
