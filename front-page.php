<?php

/**
 * トップページ用テンプレート
 *
 * @package Friend2026
 */

get_header();
?>

<main id="main" class="site-main front-page" role="main">
	<?php
	get_template_part('template-parts/home/hero-section');
	get_template_part('template-parts/home/recommended-properties');
	get_template_part('template-parts/home/openhouse-properties');
	get_template_part('template-parts/home/news-section');
	get_template_part('template-parts/home/features-section');
	get_template_part('template-parts/home/cta-section');
	?>
</main>

<?php
get_footer();
