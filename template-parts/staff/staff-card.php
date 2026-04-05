<?php

/**
 * スタッフカード（一覧用）
 *
 * @package Friend2026
 */

$id    = get_the_ID();
$name  = get_the_title();
$phonetic = get_post_meta($id, 'staff_name_phonetic', true);
$branch   = get_post_meta($id, 'staff_branch', true);
$role     = get_post_meta($id, 'staff_role', true);
$experience = get_post_meta($id, 'staff_experience_years', true);
$qualifications = get_post_meta($id, 'staff_qualifications', true);
$specialties    = get_post_meta($id, 'staff_specialties', true);
$bio    = get_post_meta($id, 'staff_bio', true);

$qual_list = $qualifications ? array_map('trim', explode(',', $qualifications)) : array();
$spec_list  = $specialties ? array_map('trim', explode(',', $specialties)) : array();
?>

<article class="staff-card">
	<div class="staff-card-image">
		<?php if (has_post_thumbnail()) : ?>
			<?php the_post_thumbnail('medium_large', array('class' => 'staff-card-img', 'loading' => 'lazy')); ?>
		<?php else : ?>
			<div class="staff-card-placeholder" aria-hidden="true">
				<svg class="staff-card-placeholder-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
					<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
				</svg>
			</div>
		<?php endif; ?>
	</div>

	<div class="staff-card-body">
		<?php if ($branch || $role) : ?>
			<div class="staff-card-tags">
				<?php if ($branch) : ?>
					<span class="staff-card-tag staff-card-tag-branch"><?php echo esc_html($branch); ?></span>
				<?php endif; ?>
				<?php if ($role) : ?>
					<span class="staff-card-tag staff-card-tag-role"><?php echo esc_html($role); ?></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<h2 class="staff-card-name"><?php echo esc_html($name); ?></h2>
		<?php if ($phonetic) : ?>
			<p class="staff-card-phonetic"><?php echo esc_html($phonetic); ?></p>
		<?php endif; ?>

		<?php if ($experience !== '' && $experience !== false) : ?>
			<p class="staff-card-experience">
				<span class="staff-card-experience-icon" aria-hidden="true"></span>
				経験年数: <?php echo esc_html($experience); ?>
			</p>
		<?php endif; ?>

		<?php if (! empty($qual_list)) : ?>
			<div class="staff-card-section">
				<h3 class="staff-card-section-title">保有資格</h3>
				<div class="staff-card-tag-list staff-card-tag-list-qual">
					<?php foreach ($qual_list as $q) : ?>
						<span class="staff-card-tag-pill"><?php echo esc_html($q); ?></span>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if (! empty($spec_list)) : ?>
			<div class="staff-card-section">
				<h3 class="staff-card-section-title">得意分野</h3>
				<div class="staff-card-tag-list staff-card-tag-list-spec">
					<?php foreach ($spec_list as $s) : ?>
						<span class="staff-card-tag-pill"><?php echo esc_html($s); ?></span>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ($bio) : ?>
			<div class="staff-card-bio">
				<span class="staff-card-bio-quote" aria-hidden="true">"</span>
				<div class="staff-card-bio-text"><?php echo nl2br(esc_html($bio)); ?></div>
			</div>
		<?php endif; ?>
	</div>
</article>
