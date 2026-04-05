<?php

/**
 * テンプレート: お問い合わせ（/contact）
 * フォーム送信 → 管理画面に保存 + 送信先メールに通知
 *
 * @package Friend2026
 */

$contact_errors = array();
$contact_sent   = false;
$contact_post   = array(
	'inquiry_type'   => '',
	'last_name'      => '',
	'first_name'     => '',
	'furigana_last'  => '',
	'furigana_first' => '',
	'email'          => '',
	'phone'          => '',
	'message'        => '',
);

if (isset($_GET['contact']) && $_GET['contact'] === 'sent') {
	$contact_sent = true;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['friend2026_contact_nonce'])) {
	$result = friend2026_contact_form_submit();
	if (! empty($result['success'])) {
		wp_safe_redirect(home_url('/contact/?contact=sent'));
		exit;
	}
	if (! empty($result['errors'])) {
		$contact_errors = $result['errors'];
		$contact_post['inquiry_type']   = isset($_POST['inquiry_type']) ? sanitize_text_field(wp_unslash($_POST['inquiry_type'])) : '';
		$contact_post['last_name']      = isset($_POST['last_name']) ? sanitize_text_field(wp_unslash($_POST['last_name'])) : '';
		$contact_post['first_name']     = isset($_POST['first_name']) ? sanitize_text_field(wp_unslash($_POST['first_name'])) : '';
		$contact_post['furigana_last']  = isset($_POST['furigana_last']) ? sanitize_text_field(wp_unslash($_POST['furigana_last'])) : '';
		$contact_post['furigana_first'] = isset($_POST['furigana_first']) ? sanitize_text_field(wp_unslash($_POST['furigana_first'])) : '';
		$contact_post['email']          = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
		$contact_post['phone']          = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
		$contact_post['message']       = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';
	}
}

get_header();

// お問い合わせページ左カラムの表示（サイト掲載用に固定）
$contact_email = 'info@friend-fudosan.jp';
$tel             = '0120-123-456';
$hours           = '9:00〜19:00（水曜定休）';
$address         = "〒183-0005 東京都府中市若松町1-2-7 3F";
?>

<main id="main" class="site-main page-contact" role="main">
  <div class="page-contact-header">
    <div class="container">
      <p class="page-contact-label">Contact</p>
      <h1 class="page-contact-title">お問い合わせ</h1>
      <p class="page-contact-desc">物件に関するご質問、ご相談など、お気軽にお問い合わせください。</p>
    </div>
  </div>

  <div class="container page-contact-body">
    <div class="page-contact-grid">
      <div class="page-contact-info">
        <div class="page-contact-info-box">
          <h2 class="page-contact-info-title">お電話でのお問い合わせ</h2>
          <p class="page-contact-tel"><a
              href="tel:<?php echo esc_attr(preg_replace('/[^0-9+\-]/', '', $tel)); ?>"><?php echo esc_html($tel); ?></a>
          </p>
          <p class="page-contact-hours">受付時間: <?php echo esc_html($hours); ?></p>
        </div>
        <div class="page-contact-info-box">
          <h2 class="page-contact-info-title">店舗情報</h2>
          <p class="page-contact-address"><span class="page-contact-icon" aria-hidden="true"></span>
            <?php echo nl2br(esc_html($address)); ?></p>
          <p class="page-contact-email"><span class="page-contact-icon" aria-hidden="true"></span>メール
            <?php echo esc_html($contact_email); ?></p>
          <p class="page-contact-hours"><span class="page-contact-icon" aria-hidden="true"></span>営業時間
            <?php echo esc_html($hours); ?></p>
        </div>
      </div>

      <div class="page-contact-form-wrap">
        <?php if ($contact_sent) : ?>
        <div class="page-contact-sent">
          <p>お問い合わせいただきありがとうございます。<br>内容を確認のうえ、ご連絡いたします。</p>
        </div>
        <?php else : ?>
        <?php if (! empty($contact_errors)) : ?>
        <ul class="page-contact-errors">
          <?php foreach ($contact_errors as $err) : ?>
          <li><?php echo esc_html($err); ?></li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <form class="page-contact-form" method="post" action="<?php echo esc_url(home_url('/contact/')); ?>">
          <?php wp_nonce_field('friend2026_contact', 'friend2026_contact_nonce'); ?>

          <div class="page-contact-field">
            <label class="page-contact-label-required">お問い合わせ種別 <span>*</span></label>
            <div class="page-contact-radios">
              <label><input type="radio" name="inquiry_type" value="property"
                  <?php checked($contact_post['inquiry_type'] !== '' ? $contact_post['inquiry_type'] : 'property', 'property'); ?>>
                物件について</label>
              <label><input type="radio" name="inquiry_type" value="consultation"
                  <?php checked($contact_post['inquiry_type'], 'consultation'); ?>> 無料相談予約</label>
              <label><input type="radio" name="inquiry_type" value="other"
                  <?php checked($contact_post['inquiry_type'], 'other'); ?>> その他</label>
            </div>
          </div>

          <div class="page-contact-row">
            <div class="page-contact-field">
              <label for="contact-last_name">お名前 (姓) <span>*</span></label>
              <input type="text" id="contact-last_name" name="last_name"
                value="<?php echo esc_attr($contact_post['last_name']); ?>" placeholder="山田" required>
            </div>
            <div class="page-contact-field">
              <label for="contact-first_name">お名前 (名) <span>*</span></label>
              <input type="text" id="contact-first_name" name="first_name"
                value="<?php echo esc_attr($contact_post['first_name']); ?>" placeholder="太郎" required>
            </div>
          </div>

          <div class="page-contact-row">
            <div class="page-contact-field">
              <label for="contact-furigana_last">フリガナ (姓)</label>
              <input type="text" id="contact-furigana_last" name="furigana_last"
                value="<?php echo esc_attr($contact_post['furigana_last']); ?>" placeholder="ヤマダ">
            </div>
            <div class="page-contact-field">
              <label for="contact-furigana_first">フリガナ (名)</label>
              <input type="text" id="contact-furigana_first" name="furigana_first"
                value="<?php echo esc_attr($contact_post['furigana_first']); ?>" placeholder="タロウ">
            </div>
          </div>

          <div class="page-contact-field">
            <label for="contact-email">メールアドレス <span>*</span></label>
            <input type="email" id="contact-email" name="email" value="<?php echo esc_attr($contact_post['email']); ?>"
              placeholder="example@email.com" required>
          </div>

          <div class="page-contact-field">
            <label for="contact-phone">電話番号 <span>*</span></label>
            <input type="tel" id="contact-phone" name="phone" value="<?php echo esc_attr($contact_post['phone']); ?>"
              placeholder="090-1234-5678" required>
          </div>

          <div class="page-contact-field">
            <label for="contact-message">お問い合わせ内容 <span>*</span></label>
            <textarea id="contact-message" name="message" rows="6" placeholder="ご質問やご相談内容をご記入ください"
              required><?php echo esc_textarea($contact_post['message']); ?></textarea>
          </div>

          <div class="page-contact-field page-contact-field-checkbox">
            <label>
              <input type="checkbox" name="agree_privacy" value="1" required>
              プライバシーポリシーに同意します <span>*</span>
            </label>
          </div>

          <p class="page-contact-submit"><button type="submit" class="btn btn-cta">送信する</button></p>
        </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
</main>

<?php
get_footer();