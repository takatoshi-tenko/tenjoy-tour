<?php

/**
 * 会社情報・サービスエリアセクション
 *
 * @package tenjoy-tour
 */

$co_name    = tenjoy_get_company_meta('company_name', 'TENJOY-TOUR');
$co_address = tenjoy_get_company_meta('company_address', tenjoy__('company_home_02'));
$co_fax     = tenjoy_get_company_meta('company_fax', '');
$co_email   = tenjoy_get_company_meta('company_email', 'info@tenjoy-tour.com');
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
              <dd><?php echo esc_html($co_name); ?></dd>
            </div>
            <div class="info-item">
              <dt><?php tenjoy_e('company_13'); ?></dt>
              <dd><?php echo esc_html($co_address); ?></dd>
            </div>
            <?php if ($co_fax) : ?>
              <div class="info-item">
                <dt>FAX</dt>
                <dd><?php echo esc_html($co_fax); ?></dd>
              </div>
            <?php endif; ?>
            <div class="info-item">
              <dt>E-mail</dt>
              <dd><a href="mailto:<?php echo esc_attr($co_email); ?>"><?php echo esc_html($co_email); ?></a></dd>
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
              <span class="area-icon"><?php echo tenjoy_icon('map-pin'); // phpcs:ignore WordPress.Security.EscapeOutput 
                                      ?></span>
              <div>
                <strong><?php tenjoy_e('company_home_04'); ?></strong>
                <p><?php tenjoy_e('company_home_05'); ?></p>
              </div>
            </li>
            <li class="area-item">
              <span class="area-icon"><?php echo tenjoy_icon('map-pin'); // phpcs:ignore WordPress.Security.EscapeOutput 
                                      ?></span>
              <div>
                <strong><?php tenjoy_e('company_home_06'); ?></strong>
                <p><?php tenjoy_e('company_home_07'); ?></p>
              </div>
            </li>
            <li class="area-item">
              <span class="area-icon"><?php echo tenjoy_icon('map-pin'); // phpcs:ignore WordPress.Security.EscapeOutput 
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