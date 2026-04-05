<?php

/**
 * トップページ: おすすめ物件（最大3件）
 *
 * @package Friend2026
 */

$recommended = new WP_Query(array(
	'post_type'      => 'property',
	'posts_per_page' => 3,
	'post_status'    => 'publish',
	'meta_key'       => 'property_is_recommended',
	'meta_value'     => '1',
	'orderby'        => array(
		'menu_order' => 'ASC',
		'date'       => 'DESC',
	),
));
$all_url = home_url('/properties/?recommended=1');
?>

<section class="front-section front-recommended">
	<div class="container">
		<div class="front-section-head">
			<div>
				<p class="front-section-label">Pick up</p>
				<h2 class="front-section-title">最新のおすすめ物件</h2>
			</div>
			<a href="<?php echo esc_url($all_url); ?>" class="front-section-link front-section-link-desk">すべて見る</a>
		</div>
		<?php if ($recommended->have_posts()) : ?>
			<div class="front-property-grid">
				<?php
				set_query_var('show_description', true);
				while ($recommended->have_posts()) :
					$recommended->the_post();
					get_template_part('template-parts/property/property-card');
				endwhile;
				wp_reset_postdata();
				?>
			</div>
			<div class="front-section-more front-section-more-mobile">
				<a href="<?php echo esc_url($all_url); ?>" class="btn btn-outline-accent">すべてのおすすめ物件を見る</a>
			</div>
		<?php else : ?>
			<p class="front-section-empty">おすすめ物件は現在ありません。</p>
		<?php endif; ?>
	</div>
</section>
