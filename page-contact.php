<?php
/**
 * お問い合わせページ
 * Template Name: お問い合わせ
 *
 * @package tenjoy-tour
 */

get_header();
?>

<main id="main" class="site-main contact-page" role="main">

  <!-- ページヒーロー -->
  <section class="contact-hero">
    <div class="container">
      <div class="contact-hero-inner">
        <h1 class="contact-hero-title"><?php esc_html_e('お問い合わせ', 'tenjoy-tour'); ?></h1>
        <p class="contact-hero-desc">
          <?php esc_html_e('ご質問やご相談がございましたら、お気軽にお問い合わせください', 'tenjoy-tour'); ?>
        </p>
      </div>
    </div>
  </section>

  <!-- 連絡先情報カード -->
  <section class="contact-info-section">
    <div class="container">
      <div class="contact-info-grid">

        <div class="contact-info-card">
          <div class="contact-info-icon"><?php echo tenjoy_icon('phone'); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
          <h3 class="contact-info-title"><?php esc_html_e('電話でのお問い合わせ', 'tenjoy-tour'); ?></h3>
          <a href="tel:+81312345678" class="contact-info-value">+81-3-1234-5678</a>
          <p class="contact-info-note"><?php esc_html_e('平日 9:00 - 18:00', 'tenjoy-tour'); ?></p>
        </div>

        <div class="contact-info-card">
          <div class="contact-info-icon"><?php echo tenjoy_icon('mail'); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
          <h3 class="contact-info-title"><?php esc_html_e('メールでのお問い合わせ', 'tenjoy-tour'); ?></h3>
          <a href="mailto:info@tenjoy-tour.com" class="contact-info-value">info@tenjoy-tour.com</a>
          <p class="contact-info-note"><?php esc_html_e('24時間受付', 'tenjoy-tour'); ?></p>
        </div>

        <div class="contact-info-card">
          <div class="contact-info-icon"><?php echo tenjoy_icon('map-pin'); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
          <h3 class="contact-info-title"><?php esc_html_e('本社所在地', 'tenjoy-tour'); ?></h3>
          <p class="contact-info-value"><?php esc_html_e('東京都港区赤坂1-2-3 TENJOYビル 5F', 'tenjoy-tour'); ?></p>
          <p class="contact-info-note"><?php esc_html_e('地下鉄赤坂駅より徒歩3分', 'tenjoy-tour'); ?></p>
        </div>

        <div class="contact-info-card">
          <div class="contact-info-icon"><?php echo tenjoy_icon('clock'); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
          <h3 class="contact-info-title"><?php esc_html_e('営業時間', 'tenjoy-tour'); ?></h3>
          <p class="contact-info-value"><?php esc_html_e('平日 9:00 - 18:00', 'tenjoy-tour'); ?></p>
          <p class="contact-info-note"><?php esc_html_e('土日祝日休業', 'tenjoy-tour'); ?></p>
        </div>

      </div>
    </div>
  </section>

  <!-- お問い合わせフォーム -->
  <section class="contact-form-section">
    <div class="container">
      <div class="contact-form-wrap">
        <div class="section-header">
          <h2 class="section-title"><?php esc_html_e('お問い合わせフォーム', 'tenjoy-tour'); ?></h2>
          <p class="section-subtitle">
            <?php esc_html_e('以下のフォームからお問い合わせください。24時間以内にご返信いたします。', 'tenjoy-tour'); ?>
          </p>
        </div>

        <?php
        // Contact Form 7 がある場合はショートコードで表示
        if (function_exists('wpcf7_contact_form')) :
          echo do_shortcode('[contact-form-7 id="contact" title="お問い合わせ"]');
        else :
        ?>
        <div class="contact-form-card">
          <form method="post" action="<?php echo esc_url(home_url('/contact/')); ?>" class="contact-form" novalidate>
            <?php wp_nonce_field('tenjoy_contact', 'tenjoy_contact_nonce'); ?>

            <div class="contact-form-row">
              <div class="form-group">
                <label class="form-label" for="contact-name">
                  <?php esc_html_e('お名前', 'tenjoy-tour'); ?> <span class="required">*</span>
                </label>
                <input type="text" id="contact-name" name="contact_name" class="form-control" required
                  placeholder="<?php esc_attr_e('山田 太郎', 'tenjoy-tour'); ?>">
              </div>
              <div class="form-group">
                <label class="form-label" for="contact-email">
                  <?php esc_html_e('メールアドレス', 'tenjoy-tour'); ?> <span class="required">*</span>
                </label>
                <input type="email" id="contact-email" name="contact_email" class="form-control" required
                  placeholder="example@email.com">
              </div>
            </div>

            <div class="form-group">
              <label class="form-label" for="contact-phone">
                <?php esc_html_e('電話番号', 'tenjoy-tour'); ?>
              </label>
              <input type="tel" id="contact-phone" name="contact_phone" class="form-control"
                placeholder="+81-3-1234-5678">
            </div>

            <div class="form-group">
              <label class="form-label" for="contact-subject">
                <?php esc_html_e('件名', 'tenjoy-tour'); ?> <span class="required">*</span>
              </label>
              <input type="text" id="contact-subject" name="contact_subject" class="form-control" required
                placeholder="<?php esc_attr_e('お問い合わせの件名', 'tenjoy-tour'); ?>">
            </div>

            <div class="form-group">
              <label class="form-label" for="contact-message">
                <?php esc_html_e('お問い合わせ内容', 'tenjoy-tour'); ?> <span class="required">*</span>
              </label>
              <textarea id="contact-message" name="contact_message" class="form-control" rows="6" required
                placeholder="<?php esc_attr_e('お問い合わせ内容を詳しくご記入ください', 'tenjoy-tour'); ?>"></textarea>
            </div>

            <div class="form-submit">
              <button type="submit" class="btn btn-primary btn-lg">
                <?php esc_html_e('送信する', 'tenjoy-tour'); ?>
              </button>
            </div>
            <p class="contact-form-note">
              <?php esc_html_e('営業日24時間以内にご返信いたします', 'tenjoy-tour'); ?>
            </p>
          </form>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- FAQ（簡易版） -->
  <section class="contact-faq-section">
    <div class="container">
      <div class="contact-faq-wrap">
        <div class="section-header">
          <h2 class="section-title"><?php esc_html_e('よくあるご質問', 'tenjoy-tour'); ?></h2>
        </div>
        <div class="contact-faq-list">
          <div class="contact-faq-item">
            <h3 class="contact-faq-q"><?php esc_html_e('キャンセル料はかかりますか？', 'tenjoy-tour'); ?></h3>
            <p class="contact-faq-a">
              <?php esc_html_e('ツアー開始日の30日前まで無料でキャンセルいただけます。30日以内の場合はツアー代金の50%、7日以内の場合は100%のキャンセル料が発生いたします。', 'tenjoy-tour'); ?>
            </p>
          </div>
          <div class="contact-faq-item">
            <h3 class="contact-faq-q"><?php esc_html_e('ツアー代金に何が含まれていますか？', 'tenjoy-tour'); ?></h3>
            <p class="contact-faq-a">
              <?php esc_html_e('ゴルフプレイ費、宿泊費、朝食・昼食、空港送迎、専門ガイド、旅行保険が含まれています。航空券は含まれておりませんので、別途ご手配ください。', 'tenjoy-tour'); ?>
            </p>
          </div>
          <div class="contact-faq-item">
            <h3 class="contact-faq-q"><?php esc_html_e('初心者でも参加できますか？', 'tenjoy-tour'); ?></h3>
            <p class="contact-faq-a">
              <?php esc_html_e('はい、もちろん歓迎いたします。経験豊富なスタッフがサポートし、初心者の方でも楽しめるコースを選定しています。', 'tenjoy-tour'); ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
