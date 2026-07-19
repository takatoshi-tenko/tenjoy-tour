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
        <h1 class="contact-hero-title"><?php tenjoy_e('nav_06'); ?></h1>
        <p class="contact-hero-desc">
          <?php tenjoy_e('contact_01'); ?>
        </p>
      </div>
    </div>
  </section>

  <!-- 連絡先情報カード -->
  <section class="contact-info-section">
    <div class="container">
      <div class="contact-info-grid">

        <div class="contact-info-card">
          <div class="contact-info-icon">
            <?php echo tenjoy_icon('phone'); // phpcs:ignore WordPress.Security.EscapeOutput 
            ?></div>
          <h3 class="contact-info-title"><?php tenjoy_e('contact_02'); ?></h3>
          <a href="tel:+81312345678" class="contact-info-value">+81-3-1234-5678</a>
          <p class="contact-info-note"><?php tenjoy_e('contact_03'); ?></p>
        </div>

        <div class="contact-info-card">
          <div class="contact-info-icon">
            <?php echo tenjoy_icon('mail'); // phpcs:ignore WordPress.Security.EscapeOutput 
            ?></div>
          <h3 class="contact-info-title"><?php tenjoy_e('contact_04'); ?></h3>
          <a href="mailto:info@tenjoy-tour.com" class="contact-info-value">info@tenjoy-tour.com</a>
          <p class="contact-info-note"><?php tenjoy_e('contact_05'); ?></p>
        </div>

        <div class="contact-info-card">
          <div class="contact-info-icon">
            <?php echo tenjoy_icon('map-pin'); // phpcs:ignore WordPress.Security.EscapeOutput 
            ?></div>
          <h3 class="contact-info-title"><?php tenjoy_e('contact_06'); ?></h3>
          <p class="contact-info-value"><?php tenjoy_e('contact_07'); ?></p>
          <p class="contact-info-note"><?php tenjoy_e('contact_08'); ?></p>
        </div>

        <div class="contact-info-card">
          <div class="contact-info-icon">
            <?php echo tenjoy_icon('clock'); // phpcs:ignore WordPress.Security.EscapeOutput 
            ?></div>
          <h3 class="contact-info-title"><?php tenjoy_e('contact_09'); ?></h3>
          <p class="contact-info-value"><?php tenjoy_e('contact_03'); ?></p>
          <p class="contact-info-note"><?php tenjoy_e('contact_10'); ?></p>
        </div>

      </div>
    </div>
  </section>

  <!-- お問い合わせフォーム -->
  <section class="contact-form-section">
    <div class="container">
      <div class="contact-form-wrap">
        <div class="section-header">
          <h2 class="section-title"><?php tenjoy_e('contact_11'); ?></h2>
          <p class="section-subtitle">
            <?php tenjoy_e('contact_12'); ?>
          </p>
        </div>

        <?php
        // Contact Form 7 がある場合はショートコードで表示
        if (function_exists('wpcf7_contact_form')) :
          echo do_shortcode('[contact-form-7 id="contact" title="お問い合わせ"]');
        else :
        ?>
          <div class="contact-form-card">
            <form method="post" action="<?php echo esc_url(tenjoy_page_url('contact', '/contact/')); ?>" class="contact-form" novalidate>
              <?php wp_nonce_field('tenjoy_contact', 'tenjoy_contact_nonce'); ?>

              <div class="contact-form-row">
                <div class="form-group">
                  <label class="form-label" for="contact-name">
                    <?php tenjoy_e('contact_13'); ?> <span class="required">*</span>
                  </label>
                  <input type="text" id="contact-name" name="contact_name" class="form-control" required
                    placeholder="<?php tenjoy_attr_e('contact_14'); ?>">
                </div>
                <div class="form-group">
                  <label class="form-label" for="contact-email">
                    <?php tenjoy_e('contact_15'); ?> <span class="required">*</span>
                  </label>
                  <input type="email" id="contact-email" name="contact_email" class="form-control" required
                    placeholder="example@email.com">
                </div>
              </div>

              <div class="form-group">
                <label class="form-label" for="contact-phone">
                  <?php tenjoy_e('contact_16'); ?>
                </label>
                <input type="tel" id="contact-phone" name="contact_phone" class="form-control"
                  placeholder="+81-3-1234-5678">
              </div>

              <div class="form-group">
                <label class="form-label" for="contact-prefecture">
                  <?php tenjoy_e('contact_17'); ?> <span class="required">*</span>
                </label>
                <select id="contact-prefecture" name="contact_prefecture" class="form-control" required>
                  <option value=""><?php tenjoy_e('contact_18'); ?></option>
                  <?php foreach (tenjoy_get_contact_prefectures() as $prefecture) : ?>
                    <option value="<?php echo esc_attr($prefecture); ?>"><?php echo esc_html($prefecture); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <label class="form-label" for="contact-visit-date">
                  <?php tenjoy_e('contact_19'); ?> <span class="required">*</span>
                </label>
                <input type="date" id="contact-visit-date" name="contact_visit_date" class="form-control" required>
                <p class="form-hint">
                  <?php tenjoy_e('contact_20'); ?>
                </p>
              </div>

              <div class="form-group">
                <label class="form-label" for="contact-message">
                  <?php tenjoy_e('contact_21'); ?>
                </label>
                <textarea id="contact-message" name="contact_message" class="form-control" rows="6"
                  placeholder="<?php tenjoy_attr_e('contact_22'); ?>"></textarea>
              </div>

              <div class="form-submit">
                <button type="submit" class="btn btn-primary btn-lg">
                  <?php tenjoy_e('contact_23'); ?>
                </button>
              </div>
              <p class="contact-form-note">
                <?php tenjoy_e('contact_24'); ?>
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
          <h2 class="section-title"><?php tenjoy_e('contact_25'); ?></h2>
        </div>
        <div class="contact-faq-list">
          <div class="contact-faq-item">
            <h3 class="contact-faq-q"><?php tenjoy_e('contact_26'); ?></h3>
            <p class="contact-faq-a">
              <?php tenjoy_e('contact_27'); ?>
            </p>
          </div>
          <div class="contact-faq-item">
            <h3 class="contact-faq-q"><?php tenjoy_e('contact_28'); ?></h3>
            <p class="contact-faq-a">
              <?php tenjoy_e('contact_29'); ?>
            </p>
          </div>
          <div class="contact-faq-item">
            <h3 class="contact-faq-q"><?php tenjoy_e('contact_30'); ?></h3>
            <p class="contact-faq-a">
              <?php tenjoy_e('contact_31'); ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>