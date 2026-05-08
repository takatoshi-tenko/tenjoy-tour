<?php
/**
 * 会社情報・サービスエリアセクション
 *
 * @package tenjoy-tour
 */
?>
<section class="company-section">
  <div class="container">
    <div class="company-grid">

      <!-- 会社情報 -->
      <div class="company-info">
        <h2 class="subsection-title"><?php esc_html_e('会社情報', 'tenjoy-tour'); ?></h2>
        <div class="info-card">
          <dl class="info-list">
            <div class="info-item">
              <dt><?php esc_html_e('会社名', 'tenjoy-tour'); ?></dt>
              <dd>TENJOY-TOUR</dd>
            </div>
            <div class="info-item">
              <dt><?php esc_html_e('所在地', 'tenjoy-tour'); ?></dt>
              <dd><?php esc_html_e('日本、東京、渋谷区', 'tenjoy-tour'); ?></dd>
            </div>
            <div class="info-item">
              <dt>FAX</dt>
              <dd>+81 03 1234 5678</dd>
            </div>
            <div class="info-item">
              <dt>E-mail</dt>
              <dd><a href="mailto:info@tenjoy-tour.com">info@tenjoy-tour.com</a></dd>
            </div>
          </dl>
        </div>
        <div class="section-cta" style="text-align:left;margin-top:1.25rem;">
          <a href="<?php echo esc_url(home_url('/company/')); ?>" class="btn btn-outline">
            <?php esc_html_e('会社概要を見る →', 'tenjoy-tour'); ?>
          </a>
        </div>
      </div>

      <!-- サービスエリア -->
      <div class="service-area">
        <h2 class="subsection-title"><?php esc_html_e('サービスエリア', 'tenjoy-tour'); ?></h2>
        <div class="info-card">
          <ul class="area-list">
            <li class="area-item">
              <span class="area-icon"><?php echo tenjoy_icon('map-pin'); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
              <div>
                <strong><?php esc_html_e('関東エリア', 'tenjoy-tour'); ?></strong>
                <p><?php esc_html_e('東京、神奈川、千葉、埼玉、茨城、群馬、栃木', 'tenjoy-tour'); ?></p>
              </div>
            </li>
            <li class="area-item">
              <span class="area-icon"><?php echo tenjoy_icon('map-pin'); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
              <div>
                <strong><?php esc_html_e('関西エリア', 'tenjoy-tour'); ?></strong>
                <p><?php esc_html_e('大阪、京都、兵庫、奈良、和歌山、滋賀', 'tenjoy-tour'); ?></p>
              </div>
            </li>
            <li class="area-item">
              <span class="area-icon"><?php echo tenjoy_icon('map-pin'); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
              <div>
                <strong><?php esc_html_e('その他の地域', 'tenjoy-tour'); ?></strong>
                <p><?php esc_html_e('お問い合わせください', 'tenjoy-tour'); ?></p>
              </div>
            </li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</section>
