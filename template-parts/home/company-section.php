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
        <div class="info-card service-area-card">
          <p><?php tenjoy_e('service_area_01'); ?></p>
          <p class="service-area-ref-title"><?php tenjoy_e('service_area_02'); ?></p>
          <ul class="service-area-ref-list">
            <li>
              <?php tenjoy_e('service_area_03'); ?><a href="https://golf-in-japan.com/" target="_blank"
                rel="noopener noreferrer"><?php tenjoy_e('service_area_04'); ?></a>
            </li>
            <li>
              <?php tenjoy_e('service_area_05'); ?><a
                href="https://www.booking.com/index.ko.html?label=gen173nr-1BCAEoggI46AdIM1gEaH2IAQGYARW4AQfIAQzYAQHoAQGIAgGoAgO4Arzs-6MGwAIB0gIkNGI3Mjg2ZDAtMTQ0Yi00ZmRmLWI4OTUtMzcyYWRhYzUyNjYz2AIF4AIB&sid=0dcd94148e8430db9d304eba912b1473&keep_landing=1&sb_price_type=total&lang=ko&soz=1&lang_changed=1"
                target="_blank" rel="noopener noreferrer"><?php tenjoy_e('service_area_06'); ?></a>
            </li>
          </ul>
          <p class="service-area-note"><?php tenjoy_e('service_area_07'); ?></p>
        </div>
      </div>

      <!-- 料金表 -->
      <div class="price-list">
        <h2 class="subsection-title"><?php tenjoy_e('price_list_01'); ?></h2>
        <div class="info-card">
          <p class="price-list-desc"><?php tenjoy_e('price_list_02'); ?></p>
          <?php $price_list_url = get_theme_mod('tenjoy_price_list_url', ''); ?>
          <?php if ($price_list_url) : ?>
            <a href="<?php echo esc_url($price_list_url); ?>" class="price-list-link" target="_blank"
              rel="noopener noreferrer">
              <?php tenjoy_e('price_list_03'); ?>
            </a>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
</section>