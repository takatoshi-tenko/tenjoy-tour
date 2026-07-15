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
    'desc'        => tenjoy__('contact_qr_01'),
    'cta'         => tenjoy__('contact_qr_02'),
    'icon'        => 'kakao',
  ],
  [
    'setting_key' => 'tenjoy_qr_wechat',
    'icon_key'    => 'tenjoy_icon_wechat',
    'name'        => 'WeChat',
    'color'       => '#07C160',
    'text'        => '#fff',
    'desc'        => tenjoy__('contact_qr_03'),
    'cta'         => tenjoy__('contact_qr_04'),
    'icon'        => 'message-circle',
  ],
  [
    'setting_key' => 'tenjoy_qr_instagram',
    'icon_key'    => 'tenjoy_icon_instagram',
    'name'        => 'Instagram',
    'color'       => '#e6683c',
    'text'        => '#fff',
    'desc'        => tenjoy__('contact_qr_05'),
    'cta'         => tenjoy__('contact_qr_06'),
    'icon'        => 'instagram',
  ],
  [
    'setting_key' => 'tenjoy_qr_line',
    'icon_key'    => 'tenjoy_icon_line',
    'name'        => 'LINE',
    'color'       => '#00B900',
    'text'        => '#fff',
    'desc'        => tenjoy__('contact_qr_07'),
    'cta'         => tenjoy__('contact_qr_08'),
    'icon'        => 'line',
  ],
  [
    'setting_key' => 'tenjoy_qr_whatsapp',
    'icon_key'    => 'tenjoy_icon_whatsapp',
    'name'        => 'WhatsApp',
    'color'       => '#25D366',
    'text'        => '#fff',
    'desc'        => tenjoy__('contact_qr_09'),
    'cta'         => tenjoy__('contact_qr_10'),
    'icon'        => 'phone',
  ],
];
?>
<section id="contact" class="contact-qr-section">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title"><?php tenjoy_e('contact_qr_11'); ?></h2>
      <p class="section-subtitle">
        <?php tenjoy_e('contact_qr_12'); ?>
      </p>
    </div>

    <div class="messenger-grid">
      <?php foreach ($messengers as $m) : ?>
        <div class="messenger-card">
          <?php $icon_url = tenjoy_customizer_image_url($m['icon_key'], 'thumbnail'); ?>
          <div class="messenger-icon-wrap"
            style="background-color: <?php echo esc_attr($m['color']); ?>; color: <?php echo esc_attr($m['text']); ?>">
            <?php if ($icon_url) : ?>
              <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($m['name']); ?>" width="28" height="28"
                loading="lazy">
            <?php else : ?>
              <?php echo tenjoy_icon(esc_attr($m['icon'])); // phpcs:ignore WordPress.Security.EscapeOutput 
              ?>
            <?php endif; ?>
          </div>
          <h3 class="messenger-name"><?php echo esc_html($m['name']); ?></h3>
          <p class="messenger-desc"><?php echo esc_html($m['desc']); ?></p>
          <?php $qr_url = tenjoy_customizer_image_url($m['setting_key'], 'full'); ?>
          <?php if ($qr_url) : ?>
            <div class="messenger-qr">
              <img src="<?php echo esc_url($qr_url); ?>" alt="<?php echo esc_attr($m['name']); ?> QR Code" width="160"
                height="160" loading="lazy">
            </div>
          <?php endif; ?>
          <p class="messenger-cta"><?php echo esc_html($m['cta']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="contact-note">
      <p class="contact-note-title"><?php tenjoy_e('contact_qr_13'); ?></p>
      <p class="contact-note-text">
        <?php tenjoy_e('contact_qr_14'); ?>
      </p>
    </div>
  </div>
</section>