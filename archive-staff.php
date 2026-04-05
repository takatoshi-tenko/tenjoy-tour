<?php

/**
 * スタッフ一覧アーカイブ
 *
 * @package Friend2026
 */

get_header();
?>

<main id="main" class="site-main archive-staff" role="main">
  <div class="archive-staff-header">
    <div class="container">
      <p class="archive-staff-label">Staff</p>
      <h1 class="archive-staff-title">スタッフ紹介</h1>
      <div class="archive-staff-desc">
        <?php echo get_the_archive_description() ? wp_kses_post(get_the_archive_description()) : '経験豊富なスタッフが、お客様の理想の住まい探しを全力でサポートいたします。'; ?>
      </div>
    </div>
  </div>

  <div class="container archive-staff-body">
    <?php if (have_posts()) : ?>
    <div class="staff-grid">
      <?php
				while (have_posts()) :
					the_post();
					get_template_part('template-parts/staff/staff-card');
				endwhile;
				?>
    </div>
    <?php
			the_posts_pagination(array(
				'mid_size'  => 2,
				'prev_text' => '前へ',
				'next_text' => '次へ',
				'class'     => 'archive-staff-pagination',
			));
			?>
    <?php else : ?>
    <div class="archive-staff-empty">
      <p>スタッフ情報はまだ登録されていません。</p>
    </div>
    <?php endif; ?>
  </div>
</main>

<?php
get_footer();