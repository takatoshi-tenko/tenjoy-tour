<?php

/**
 * トップページ: オープンハウス・現地販売会（最大3件）
 *
 * @package Friend2026
 */

$openhouse = new WP_Query(array(
	'post_type'      => 'property',
	'posts_per_page' => 3,
	'post_status'    => 'publish',
	'meta_key'       => 'property_open_house',
	'meta_value'     => '1',
	'orderby'        => array(
		'menu_order' => 'ASC',
		'date'       => 'DESC',
	),
));
$all_url = home_url('/properties/?openhouse=1');
?>

<section class="front-section front-openhouse">
	<div class="container">
		<div class="front-section-head">
			<div>
				<p class="front-section-label front-section-label-icon">Open House</p>
				<h2 class="front-section-title">オープンハウス・現地販売会</h2>
			</div>
			<a href="<?php echo esc_url($all_url); ?>" class="front-section-link front-section-link-desk">すべて見る</a>
		</div>
		<?php if ($openhouse->have_posts()) : ?>
			<div class="front-property-grid">
				<?php
				set_query_var('show_description', true);
				while ($openhouse->have_posts()) :
					$openhouse->the_post();
					get_template_part('template-parts/property/property-card');
				endwhile;
				wp_reset_postdata();
				?>
			</div>
			<div class="front-section-more front-section-more-mobile">
				<a href="<?php echo esc_url($all_url); ?>" class="btn btn-outline-accent">すべての現地販売会を見る</a>
			</div>
		<?php else : ?>
			<p class="front-section-empty">オープンハウス・現地販売会の物件は現在ありません。</p>
		<?php endif; ?>
	</div>
</section>
