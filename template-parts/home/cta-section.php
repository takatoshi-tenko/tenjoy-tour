<?php

/**
 * トップページ: CTA（お問い合わせ・電話）
 *
 * @package Friend2026
 */

$contact_url = home_url('/contact/');
?>

<section class="front-section front-cta">
	<div class="container">
		<div class="front-cta-inner">
			<h2 class="front-cta-title">理想の住まい探しは<br class="front-cta-br-mobile">お気軽にご相談ください</h2>
			<p class="front-cta-desc">
				経験豊富なスタッフが、物件探しから購入まで丁寧にご案内いたします。<br class="front-cta-br-desk">
				お客様一人ひとりのライフスタイルに合わせた最適な提案をお約束します。
			</p>
			<div class="front-cta-buttons">
				<a href="tel:0120-123-456" class="front-cta-btn front-cta-btn-phone">
					<span class="front-cta-btn-icon-wrap" aria-hidden="true">
						<span class="front-cta-btn-icon">📞</span>
					</span>
					<div class="front-cta-btn-text">
						<span class="front-cta-btn-label">お電話でのお問い合わせ</span>
						<span class="front-cta-btn-value">0120-123-456</span>
					</div>
					<span class="front-cta-btn-chevron" aria-hidden="true"></span>
				</a>
				<a href="<?php echo esc_url($contact_url); ?>" class="front-cta-btn front-cta-btn-mail">
					<span class="front-cta-btn-icon-wrap" aria-hidden="true">
						<span class="front-cta-btn-icon">✉</span>
					</span>
					<div class="front-cta-btn-text">
						<span class="front-cta-btn-label">メールでのお問い合わせ</span>
						<span class="front-cta-btn-value">お問い合わせフォーム</span>
					</div>
					<span class="front-cta-btn-chevron" aria-hidden="true"></span>
				</a>
			</div>
			<div class="front-cta-booking">
				<a href="<?php echo esc_url($contact_url); ?>" class="btn front-cta-booking-btn">
					<span class="front-cta-booking-text">無料相談を予約する</span>
					<span class="front-cta-booking-arrow" aria-hidden="true">→</span>
				</a>
			</div>
			<p class="front-cta-hours">営業時間: 9:00〜19:00（水曜定休）</p>
		</div>
	</div>
</section>
