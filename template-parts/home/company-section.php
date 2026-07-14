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
        <h2 class="subsection-title"><?php tenjoy_e('company_home_01'); ?></h2>
        <div class="info-card">
          <dl class="info-list">
            <div class="info-item">
              <dt><?php tenjoy_e('company_08'); ?></dt>
              <dd>TENJOY-TOUR</dd>
            </div>
            <div class="info-item">
              <dt><?php tenjoy_e('company_13'); ?></dt>
              <dd><?php tenjoy_e('company_home_02'); ?></dd>
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
            <?php tenjoy_e('company_home_03'); ?>
          </a>
        </div>
      </div>

      <!-- サービスエリア -->
      <div class="service-area">
        <h2 class="subsection-title"><?php tenjoy_e('company_24'); ?></h2>
        <div class="info-card">
          <ul class="area-list">
            <li class="area-item">
              <span
                class="area-icon"><?php echo tenjoy_icon('map-pin'); // phpcs:ignore WordPress.Security.EscapeOutput 
                                  ?></span>
              <div>
                <strong><?php tenjoy_e('company_home_04'); ?></strong>
                <p><?php tenjoy_e('company_home_05'); ?></p>
              </div>
            </li>
            <li class="area-item">
              <span
                class="area-icon"><?php echo tenjoy_icon('map-pin'); // phpcs:ignore WordPress.Security.EscapeOutput 
                                  ?></span>
              <div>
                <strong><?php tenjoy_e('company_home_06'); ?></strong>
                <p><?php tenjoy_e('company_home_07'); ?></p>
              </div>
            </li>
            <li class="area-item">
              <span
                class="area-icon"><?php echo tenjoy_icon('map-pin'); // phpcs:ignore WordPress.Security.EscapeOutput 
                                  ?></span>
              <div>
                <strong><?php tenjoy_e('company_home_08'); ?></strong>
                <p><?php tenjoy_e('company_home_09'); ?></p>
              </div>
            </li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</section>