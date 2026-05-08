<?php
/**
 * 予約ページ
 * Template Name: ツアー予約
 *
 * @package tenjoy-tour
 */

get_header();

// ツアー一覧をCPTから取得
$tour_options = get_posts([
  'post_type'      => 'tours',
  'posts_per_page' => -1,
  'post_status'    => 'publish',
  'orderby'        => 'menu_order',
  'order'          => 'ASC',
]);
?>

<main id="main" class="site-main booking-page" role="main">

  <!-- ページヒーロー -->
  <section class="contact-hero">
    <div class="container">
      <div class="contact-hero-inner">
        <h1 class="contact-hero-title"><?php esc_html_e('ツアー予約', 'tenjoy-tour'); ?></h1>
        <p class="contact-hero-desc">
          <?php esc_html_e('お客様のご要望に合わせた最適なゴルフツアーをご提案いたします', 'tenjoy-tour'); ?>
        </p>
      </div>
    </div>
  </section>

  <!-- 予約の流れ -->
  <section class="booking-steps-section">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title"><?php esc_html_e('予約の流れ', 'tenjoy-tour'); ?></h2>
        <p class="section-subtitle">
          <?php esc_html_e('簡単3ステップで、あなたにぴったりのゴルフツアーをご予約いただけます', 'tenjoy-tour'); ?>
        </p>
      </div>
      <div class="booking-steps">
        <div class="booking-step">
          <div class="booking-step-num">1</div>
          <h3 class="booking-step-title"><?php esc_html_e('お問い合わせ', 'tenjoy-tour'); ?></h3>
          <p class="booking-step-desc">
            <?php esc_html_e('フォームからご希望のツアーや日程をお知らせください', 'tenjoy-tour'); ?>
          </p>
        </div>
        <div class="booking-step">
          <div class="booking-step-num">2</div>
          <h3 class="booking-step-title"><?php esc_html_e('プラン提案', 'tenjoy-tour'); ?></h3>
          <p class="booking-step-desc">
            <?php esc_html_e('24時間以内に専門スタッフから最適なプランをご提案', 'tenjoy-tour'); ?>
          </p>
        </div>
        <div class="booking-step">
          <div class="booking-step-num">3</div>
          <h3 class="booking-step-title"><?php esc_html_e('ご予約確定', 'tenjoy-tour'); ?></h3>
          <p class="booking-step-desc">
            <?php esc_html_e('プラン内容にご納得いただけましたら、ご予約を確定', 'tenjoy-tour'); ?>
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- 予約フォーム -->
  <section class="booking-form-section">
    <div class="container">
      <div class="booking-form-inner">

        <?php if (function_exists('wpcf7_contact_form')) : ?>
          <?php echo do_shortcode('[contact-form-7 id="booking" title="ツアー予約"]'); ?>
        <?php else : ?>
        <div class="booking-form-wrap">
          <h2 class="booking-form-title"><?php esc_html_e('予約フォーム', 'tenjoy-tour'); ?></h2>
          <form method="post" action="<?php echo esc_url(home_url('/booking/')); ?>" class="contact-form" novalidate>
            <?php wp_nonce_field('tenjoy_booking', 'tenjoy_booking_nonce'); ?>

            <div class="contact-form-row">
              <div class="form-group">
                <label class="form-label" for="booking-name">
                  <?php esc_html_e('お名前', 'tenjoy-tour'); ?> <span class="required">*</span>
                </label>
                <input type="text" id="booking-name" name="booking_name" class="form-control" required
                  placeholder="<?php esc_attr_e('山田 太郎', 'tenjoy-tour'); ?>">
              </div>
              <div class="form-group">
                <label class="form-label" for="booking-email">
                  <?php esc_html_e('メールアドレス', 'tenjoy-tour'); ?> <span class="required">*</span>
                </label>
                <input type="email" id="booking-email" name="booking_email" class="form-control" required
                  placeholder="example@email.com">
              </div>
            </div>

            <div class="contact-form-row">
              <div class="form-group">
                <label class="form-label" for="booking-phone">
                  <?php esc_html_e('電話番号', 'tenjoy-tour'); ?> <span class="required">*</span>
                </label>
                <input type="tel" id="booking-phone" name="booking_phone" class="form-control" required
                  placeholder="+81-90-1234-5678">
              </div>
              <div class="form-group">
                <label class="form-label" for="booking-pax">
                  <?php esc_html_e('参加人数', 'tenjoy-tour'); ?> <span class="required">*</span>
                </label>
                <input type="number" id="booking-pax" name="booking_pax" class="form-control" required
                  min="1" placeholder="2">
              </div>
            </div>

            <div class="form-group">
              <label class="form-label" for="booking-tour">
                <?php esc_html_e('ご希望のツアー', 'tenjoy-tour'); ?> <span class="required">*</span>
              </label>
              <select id="booking-tour" name="booking_tour" class="form-control" required>
                <option value=""><?php esc_html_e('ツアーを選択してください', 'tenjoy-tour'); ?></option>
                <?php if ($tour_options) : ?>
                  <?php foreach ($tour_options as $tour) : ?>
                    <option value="<?php echo esc_attr((string) $tour->ID); ?>">
                      <?php echo esc_html($tour->post_title); ?>
                    </option>
                  <?php endforeach; ?>
                <?php endif; ?>
                <option value="custom"><?php esc_html_e('カスタムツアー（ご相談ください）', 'tenjoy-tour'); ?></option>
              </select>
            </div>

            <div class="contact-form-row">
              <div class="form-group">
                <label class="form-label" for="booking-start">
                  <?php esc_html_e('ご希望の開始日', 'tenjoy-tour'); ?> <span class="required">*</span>
                </label>
                <input type="date" id="booking-start" name="booking_start" class="form-control" required>
              </div>
              <div class="form-group">
                <label class="form-label" for="booking-end">
                  <?php esc_html_e('ご希望の終了日', 'tenjoy-tour'); ?>
                </label>
                <input type="date" id="booking-end" name="booking_end" class="form-control">
              </div>
            </div>

            <div class="form-group">
              <label class="form-label" for="booking-message">
                <?php esc_html_e('ご要望・ご質問', 'tenjoy-tour'); ?>
              </label>
              <textarea id="booking-message" name="booking_message" class="form-control" rows="5"
                placeholder="<?php esc_attr_e('ご要望やご質問があればお聞かせください', 'tenjoy-tour'); ?>"></textarea>
            </div>

            <div class="form-submit">
              <button type="submit" class="btn btn-primary btn-lg">
                <?php esc_html_e('予約リクエストを送信', 'tenjoy-tour'); ?>
              </button>
            </div>
            <p class="contact-form-note">
              <?php esc_html_e('送信後、24時間以内にご連絡いたします', 'tenjoy-tour'); ?>
            </p>
          </form>
        </div>
        <?php endif; ?>

      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
