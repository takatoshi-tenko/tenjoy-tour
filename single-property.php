<?php

/**
 * 物件詳細
 *
 * @package Friend2026
 */

get_header();
?>

<main id="main" class="site-main single-property" role="main">
	<?php while (have_posts()) : the_post(); ?>
		<?php
		$id       = get_the_ID();
		$title    = get_the_title();
		$price    = get_post_meta($id, 'property_price_label', true);
		$addr     = get_post_meta($id, 'property_address', true);
		$station  = get_post_meta($id, 'property_station', true);
		$walk     = get_post_meta($id, 'property_walk_minutes', true);
		$plan     = get_post_meta($id, 'property_floor_plan', true);
		$b_area   = get_post_meta($id, 'property_building_area', true);
		$l_area   = get_post_meta($id, 'property_land_area', true);
		$built    = get_post_meta($id, 'property_built_year', true);
		$floors   = get_post_meta($id, 'property_floors', true);
		$units    = get_post_meta($id, 'property_total_units', true);
		$desc     = get_post_meta($id, 'property_description', true);
		$features_raw = get_post_meta($id, 'property_features', true);
		$features = $features_raw ? array_map('trim', explode(',', $features_raw)) : array();

		$types = get_the_terms($id, 'property_type');
		$type_label = $types && ! is_wp_error($types) && ! empty($types) ? $types[0]->name : '';

		$details = array();
		if ($type_label) $details[] = array('label' => '物件種別', 'value' => $type_label);
		if ($addr) $details[] = array('label' => '所在地', 'value' => $addr);
		if ($station && $walk !== '') $details[] = array('label' => '交通', 'value' => $station . ' 徒歩' . (int) $walk . '分');
		if ($plan) $details[] = array('label' => '間取り', 'value' => $plan);
		if ($b_area) $details[] = array('label' => '建物面積', 'value' => $b_area . '㎡');
		if ($l_area) $details[] = array('label' => '土地面積', 'value' => $l_area . '㎡');
		if ($built) $details[] = array('label' => '築年', 'value' => $built . '年');
		if ($floors) $details[] = array('label' => '階数', 'value' => $floors . '階建');
		if ($units) $details[] = array('label' => '総戸数', 'value' => $units . '戸');

		$archive_url = get_post_type_archive_link('property');
		?>

		<!-- パンくず -->
		<div class="single-property-breadcrumb">
			<div class="container">
				<nav class="single-property-breadcrumb-inner" aria-label="パンくず">
					<a href="<?php echo esc_url(home_url('/')); ?>">ホーム</a>
					<span class="single-property-breadcrumb-sep">/</span>
					<a href="<?php echo esc_url($archive_url); ?>">物件一覧</a>
					<span class="single-property-breadcrumb-sep">/</span>
					<span class="single-property-breadcrumb-current"><?php echo esc_html($title); ?></span>
				</nav>
			</div>
		</div>

		<div class="container single-property-body">
			<a href="<?php echo esc_url($archive_url); ?>" class="single-property-back">← 物件一覧に戻る</a>

			<div class="single-property-layout">
				<div class="single-property-main">
					<?php get_template_part('template-parts/property/image-gallery'); ?>

					<div class="single-property-header">
						<?php if ($type_label) : ?>
							<span class="single-property-type-badge"><?php echo esc_html($type_label); ?></span>
						<?php endif; ?>
						<h1 class="single-property-title"><?php echo esc_html($title); ?></h1>
						<?php if ($price) : ?>
							<p class="single-property-price"><?php echo esc_html($price); ?></p>
						<?php endif; ?>
					</div>

					<!-- キー情報（アイコン付き） -->
					<div class="single-property-keyinfo">
						<?php if ($station || $walk !== '') : ?>
							<div class="single-property-keyinfo-item">
								<span class="single-property-keyinfo-icon" aria-hidden="true">
									<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/></svg>
								</span>
								<div class="single-property-keyinfo-inner">
									<span class="single-property-keyinfo-label">最寄駅</span>
									<p class="single-property-keyinfo-value"><?php echo esc_html($station); ?> 徒歩<?php echo (int) $walk; ?>分</p>
								</div>
							</div>
						<?php endif; ?>
						<?php if ($plan) : ?>
							<div class="single-property-keyinfo-item">
								<span class="single-property-keyinfo-icon" aria-hidden="true">
									<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
								</span>
								<div class="single-property-keyinfo-inner">
									<span class="single-property-keyinfo-label">間取り</span>
									<p class="single-property-keyinfo-value"><?php echo esc_html($plan); ?></p>
								</div>
							</div>
						<?php endif; ?>
						<?php if ($b_area) : ?>
							<div class="single-property-keyinfo-item">
								<span class="single-property-keyinfo-icon" aria-hidden="true">
									<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
								</span>
								<div class="single-property-keyinfo-inner">
									<span class="single-property-keyinfo-label">建物面積</span>
									<p class="single-property-keyinfo-value"><?php echo (int) $b_area; ?>㎡</p>
								</div>
							</div>
						<?php endif; ?>
						<?php if ($l_area) : ?>
							<div class="single-property-keyinfo-item">
								<span class="single-property-keyinfo-icon" aria-hidden="true">
									<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s-8-4.5-8-11.5A8 8 0 0 1 12 2a8 8 0 0 1 8 8.5C20 17.5 12 22 12 22z"/></svg>
								</span>
								<div class="single-property-keyinfo-inner">
									<span class="single-property-keyinfo-label">土地面積</span>
									<p class="single-property-keyinfo-value"><?php echo (int) $l_area; ?>㎡</p>
								</div>
							</div>
						<?php endif; ?>
					</div>

					<?php if ($desc) : ?>
						<div class="single-property-card">
							<h2 class="single-property-card-title">物件紹介</h2>
							<div class="single-property-card-body">
								<p class="single-property-desc"><?php echo nl2br(esc_html($desc)); ?></p>
							</div>
						</div>
					<?php endif; ?>

					<?php if (! empty($features)) : ?>
						<div class="single-property-card">
							<h2 class="single-property-card-title">設備・特徴</h2>
							<div class="single-property-card-body">
								<div class="single-property-features">
									<?php foreach ($features as $f) : ?>
										<span class="single-property-feature-tag"><?php echo esc_html($f); ?></span>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<?php if (! empty($details)) : ?>
						<div class="single-property-card">
							<h2 class="single-property-card-title">物件概要</h2>
							<div class="single-property-card-body">
								<dl class="single-property-details">
									<?php foreach ($details as $d) : ?>
										<div class="single-property-detail-row">
											<dt><?php echo esc_html($d['label']); ?></dt>
											<dd><?php echo esc_html($d['value']); ?></dd>
										</div>
									<?php endforeach; ?>
								</dl>
							</div>
						</div>
					<?php endif; ?>

					<?php if (get_the_content()) : ?>
						<div class="single-property-content entry-content">
							<?php the_content(); ?>
						</div>
					<?php endif; ?>
				</div>

				<div class="single-property-sidebar-wrap">
					<?php get_template_part('template-parts/property/sidebar-contact'); ?>
				</div>
			</div>
		</div>
	<?php endwhile; ?>
</main>

<script>
(function() {
	var galleryEl = document.getElementById('property-gallery');
	var lightbox = document.getElementById('property-gallery-lightbox');
	if (!galleryEl || !lightbox) return;
	var raw = galleryEl.getAttribute('data-gallery');
	if (!raw) return;
	var images = [];
	try { images = JSON.parse(raw); } catch (e) { return; }
	if (images.length === 0) return;

	var mainWrap = galleryEl.querySelector('.single-property-gallery-main');
	var mainImg = galleryEl.querySelector('.single-property-gallery-current');
	var thumbs = galleryEl.querySelectorAll('.single-property-gallery-thumb');
	var lbImg = lightbox.querySelector('.property-gallery-lightbox-img');
	var lbCurrent = lightbox.querySelector('.property-gallery-lightbox-current');
	var lbTotal = lightbox.querySelector('.property-gallery-lightbox-total');
	var lbClose = lightbox.querySelector('.property-gallery-lightbox-close');
	var lbPrev = lightbox.querySelector('.property-gallery-lightbox-prev');
	var lbNext = lightbox.querySelector('.property-gallery-lightbox-next');

	var currentIndex = 0;

	function setMainImage(index) {
		if (index < 0) index = images.length - 1;
		if (index >= images.length) index = 0;
		currentIndex = index;
		if (mainImg) {
			mainImg.src = images[index].full;
			mainImg.setAttribute('data-index', index);
		}
		thumbs.forEach(function(t, i) {
			t.classList.toggle('is-active', i === index);
		});
	}

	function openLightbox(index) {
		currentIndex = index;
		lbImg.src = images[index].full;
		lbImg.alt = '画像' + (index + 1);
		lbImg.setAttribute('data-index', index);
		lbCurrent.textContent = index + 1;
		if (lbTotal) lbTotal.textContent = images.length;
		lightbox.hidden = false;
		document.body.style.overflow = 'hidden';
		lbClose.focus();
	}

	function closeLightbox() {
		lightbox.hidden = true;
		document.body.style.overflow = '';
	}

	function showLightboxIndex(index) {
		if (index < 0) index = images.length - 1;
		if (index >= images.length) index = 0;
		currentIndex = index;
		lbImg.src = images[index].full;
		lbImg.setAttribute('data-index', index);
		lbCurrent.textContent = index + 1;
	}

	// 大きい画像をクリック → 画面全体に拡大
	if (mainWrap) {
		mainWrap.addEventListener('click', function() { openLightbox(currentIndex); });
		mainWrap.addEventListener('keydown', function(e) {
			if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openLightbox(currentIndex); }
		});
	}
	// 下のプレビューをクリック → その画像を大きく表示（拡大はしない）
	thumbs.forEach(function(thumb, i) {
		thumb.addEventListener('click', function(e) {
			e.stopPropagation();
			setMainImage(i);
		});
	});

	// 拡大時: 右上×で閉じる、左右矢印で前後
	lbClose.addEventListener('click', closeLightbox);
	lbPrev.addEventListener('click', function() { showLightboxIndex(currentIndex - 1); });
	lbNext.addEventListener('click', function() { showLightboxIndex(currentIndex + 1); });
	lightbox.addEventListener('click', function(e) {
		if (e.target === lightbox) closeLightbox();
	});
	document.addEventListener('keydown', function(e) {
		if (lightbox.hidden) return;
		if (e.key === 'Escape') closeLightbox();
		if (e.key === 'ArrowLeft') { e.preventDefault(); showLightboxIndex(currentIndex - 1); }
		if (e.key === 'ArrowRight') { e.preventDefault(); showLightboxIndex(currentIndex + 1); }
	});
	lbImg.addEventListener('click', function(e) { e.stopPropagation(); });
})();
</script>
<script>
(function() {
	var btn = document.querySelector('.single-property-contact-share');
	if (!btn) return;
	btn.addEventListener('click', function() {
		var url = this.getAttribute('data-url') || '';
		var title = this.getAttribute('data-title') || document.title;
		if (navigator.share) {
			navigator.share({ title: title, url: url }).catch(function() {});
		} else {
			try {
				navigator.clipboard.writeText(url);
				btn.textContent = 'コピーしました';
				setTimeout(function() { btn.textContent = 'この物件を共有'; }, 2000);
			} catch (e) {
				window.prompt('URLをコピーしてください', url);
			}
		}
	});
})();
</script>

<?php
get_footer();
