<?php
/**
 * お問い合わせ QRコードセクション
 *
 * @package tenjoy-tour
 */

$messengers = [
  [
    'setting_key' => 'tenjoy_qr_kakao',
    'icon_key'    => 'tenjoy_icon_kakao',
    'name'        => 'Kakao Talk',
    'color'       => '#FEE500',
    'text'        => '#3C1E1E',
    'desc'        => __('韓国で人気', 'tenjoy-tour'),
    'cta'         => __('カカオトークで連絡', 'tenjoy-tour'),
    'icon'        => 'message-circle',
  ],
  [
    'setting_key' => 'tenjoy_qr_wechat',
    'icon_key'    => 'tenjoy_icon_wechat',
    'name'        => 'WeChat',
    'color'       => '#07C160',
    'text'        => '#fff',
    'desc'        => __('中国で人気', 'tenjoy-tour'),
    'cta'         => __('WeChatで連絡', 'tenjoy-tour'),
    'icon'        => 'message-circle',
  ],
  [
    'setting_key' => 'tenjoy_qr_instagram',
    'icon_key'    => 'tenjoy_icon_instagram',
    'name'        => 'Instagram',
    'color'       => '#e6683c',
    'text'        => '#fff',
    'desc'        => __('写真・動画を公開中', 'tenjoy-tour'),
    'cta'         => __('Instagramでフォロー', 'tenjoy-tour'),
    'icon'        => 'instagram',
  ],
  [
    'setting_key' => 'tenjoy_qr_line',
    'icon_key'    => 'tenjoy_icon_line',
    'name'        => 'LINE',
    'color'       => '#00B900',
    'text'        => '#fff',
    'desc'        => __('日本で人気', 'tenjoy-tour'),
    'cta'         => __('LINEで連絡', 'tenjoy-tour'),
    'icon'        => 'message-circle',
  ],
  [
    'setting_key' => 'tenjoy_qr_whatsapp',
    'icon_key'    => 'tenjoy_icon_whatsapp',
    'name'        => 'WhatsApp',
    'color'       => '#25D366',
    'text'        => '#fff',
    'desc'        => __('世界中で人気', 'tenjoy-tour'),
    'cta'         => __('WhatsAppで連絡', 'tenjoy-tour'),
    'icon'        => 'phone',
  ],
];
?>
<section id="contact" class="contact-qr-section">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title"><?php esc_html_e('今すぐお問い合わせ', 'tenjoy-tour'); ?></h2>
      <p class="section-subtitle">
        <?php esc_html_e('お好みのメッセージアプリでQRコードをスキャンして、簡単にお問い合わせいただけます', 'tenjoy-tour'); ?>
      </p>
    </div>

    <div class="messenger-grid">
      <?php foreach ($messengers as $m) : ?>
        <div class="messenger-card">
          <?php $icon_url = tenjoy_customizer_image_url($m['icon_key'], 'thumbnail'); ?>
          <div class="messenger-icon-wrap" style="background-color: <?php echo esc_attr($m['color']); ?>; color: <?php echo esc_attr($m['text']); ?>">
            <?php if ($icon_url) : ?>
              <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($m['name']); ?>" width="28" height="28" loading="lazy">
            <?php else : ?>
              <?php echo tenjoy_icon(esc_attr($m['icon'])); // phpcs:ignore WordPress.Security.EscapeOutput ?>
            <?php endif; ?>
          </div>
          <h3 class="messenger-name"><?php echo esc_html($m['name']); ?></h3>
          <p class="messenger-desc"><?php echo esc_html($m['desc']); ?></p>
          <?php $qr_url = tenjoy_customizer_image_url($m['setting_key'], 'full'); ?>
          <?php if ($qr_url) : ?>
          <div class="messenger-qr">
            <img
              src="<?php echo esc_url($qr_url); ?>"
              alt="<?php echo esc_attr($m['name']); ?> QR Code"
              width="160"
              height="160"
              loading="lazy">
          </div>
          <?php endif; ?>
          <p class="messenger-cta"><?php echo esc_html($m['cta']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="contact-note">
      <p class="contact-note-title"><?php esc_html_e('迅速な対応をお約束します', 'tenjoy-tour'); ?></p>
      <p class="contact-note-text">
        <?php esc_html_e('メッセージを受信次第、できるだけ早くご返信いたします。お気軽にお問い合わせください。', 'tenjoy-tour'); ?>
      </p>
    </div>
  </div>
</section>
