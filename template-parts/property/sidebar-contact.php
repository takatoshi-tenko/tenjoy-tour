<?php

/**
 * 物件詳細: サイドバーお問い合わせカード
 *
 * @package Friend2026
 */

$contact_url = home_url('/contact/');
$property_id = get_the_ID();
$contact_with_property = add_query_arg('property', $property_id, $contact_url);
$current_url = get_permalink($property_id);
$share_title = get_the_title($property_id);
?>

<div class="single-property-contact-card">
	<h3 class="single-property-contact-title">お問い合わせ</h3>
	<p class="single-property-contact-desc">この物件について詳しく知りたい方は、お気軽にお問い合わせください。</p>
	<a href="<?php echo esc_url($contact_with_property); ?>" class="btn btn-accent single-property-contact-btn">
		<svg class="single-property-contact-btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
		お問い合わせ
	</a>
	<a href="tel:0120-123-456" class="btn btn-outline single-property-contact-tel">
		<svg class="single-property-contact-btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
		0120-123-456
	</a>
	<button type="button" class="btn btn-outline single-property-contact-share" data-url="<?php echo esc_attr($current_url); ?>" data-title="<?php echo esc_attr($share_title); ?>">
		<svg class="single-property-contact-btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
		この物件を共有
	</button>
	<p class="single-property-contact-hours">営業時間: 9:00〜19:00（水曜定休）</p>
</div>
