<?php

/**
 * Template Name: 会社概要
 *
 * @package tenjoy-tour
 */

get_header();

$pid = get_the_ID();
$co  = [
  'name'           => (string) get_post_meta($pid, 'company_name', true)           ?: 'TENJOY-TOUR 株式会社',
  'representative' => (string) get_post_meta($pid, 'company_representative', true) ?: '天孝 高俊',
  'founded'        => (string) get_post_meta($pid, 'company_founded', true)        ?: '2023年5月26日',
  'capital'        => (string) get_post_meta($pid, 'company_capital', true)        ?: '800万円',
  'employees'      => (string) get_post_meta($pid, 'company_employees', true)      ?: '5名',
  'address'        => (string) get_post_meta($pid, 'company_address', true)        ?: '福岡市東区',
  'phone'          => (string) get_post_meta($pid, 'company_phone', true)          ?: '090-9561-3388',
  'fax'            => (string) get_post_meta($pid, 'company_fax', true),
  'email'          => (string) get_post_meta($pid, 'company_email', true)          ?: 'info@tenjoy-tour.com',
  'languages'      => (string) get_post_meta($pid, 'company_languages', true)      ?: '日本語・中国語・韓国語・英語',
  'hours'          => (string) get_post_meta($pid, 'company_hours', true)          ?: '09:00 〜 18:00（年中無休）',
];
?>

<main id="main" class="site-main" role="main">

  <div class="archive-header">
    <div class="container">
      <h1 class="archive-title"><?php tenjoy_e('nav_05'); ?></h1>
      <p class="archive-desc"><?php tenjoy_e('company_01'); ?></p>
    </div>
  </div>

  <div class="company-page">
    <div class="container">
      <div class="company-page-layout">

        <!-- 代表挨拶 -->
        <section class="company-greeting">
          <div class="company-greeting-deco" aria-hidden="true">"</div>
          <div class="company-greeting-inner">
            <p class="company-greeting-lead"><?php tenjoy_e('company_02'); ?></p>
            <h2 class="company-greeting-title"><?php tenjoy_e('company_03'); ?></h2>
            <div class="company-greeting-body">
              <p><?php tenjoy_e('company_04'); ?></p>
              <p><?php tenjoy_e('company_05'); ?></p>
            </div>
            <p class="company-greeting-sign">
              <?php tenjoy_e('company_06'); ?><?php echo esc_html($co['representative']); ?></p>
          </div>
        </section>

        <!-- 基本情報 -->
        <section class="company-info-section">
          <h2 class="company-section-title"><?php tenjoy_e('company_07'); ?></h2>
          <dl class="company-info-table">
            <div class="company-info-row">
              <dt><?php tenjoy_e('company_08'); ?></dt>
              <dd><?php echo esc_html($co['name']); ?></dd>
            </div>
            <div class="company-info-row">
              <dt><?php tenjoy_e('company_09'); ?></dt>
              <dd><?php echo esc_html($co['representative']); ?></dd>
            </div>
            <div class="company-info-row">
              <dt><?php tenjoy_e('company_10'); ?></dt>
              <dd><?php echo esc_html($co['founded']); ?></dd>
            </div>
            <div class="company-info-row">
              <dt><?php tenjoy_e('company_11'); ?></dt>
              <dd><?php echo esc_html($co['capital']); ?></dd>
            </div>
            <div class="company-info-row">
              <dt><?php tenjoy_e('company_12'); ?></dt>
              <dd><?php echo esc_html($co['employees']); ?></dd>
            </div>
            <div class="company-info-row">
              <dt><?php tenjoy_e('company_13'); ?></dt>
              <dd><?php echo esc_html($co['address']); ?></dd>
            </div>
            <div class="company-info-row">
              <dt><?php tenjoy_e('contact_16'); ?></dt>
              <dd><a
                  href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $co['phone'])); ?>"><?php echo esc_html($co['phone']); ?></a>
              </dd>
            </div>
            <?php if ($co['fax']) : ?>
              <div class="company-info-row">
                <dt>FAX</dt>
                <dd><?php echo esc_html($co['fax']); ?></dd>
              </div>
            <?php endif; ?>
            <div class="company-info-row">
              <dt>E-mail</dt>
              <dd><a href="mailto:<?php echo esc_attr($co['email']); ?>"><?php echo esc_html($co['email']); ?></a></dd>
            </div>
            <div class="company-info-row">
              <dt><?php tenjoy_e('company_14'); ?></dt>
              <dd><?php echo esc_html($co['languages']); ?></dd>
            </div>
            <div class="company-info-row">
              <dt><?php tenjoy_e('contact_09'); ?></dt>
              <dd><?php echo esc_html($co['hours']); ?></dd>
            </div>
          </dl>
        </section>

        <!-- 事業内容 -->
        <section class="company-info-section">
          <h2 class="company-section-title"><?php tenjoy_e('company_15'); ?></h2>
          <div class="company-services-grid">
            <div class="company-service-card">
              <div class="company-service-icon">
                <?php echo tenjoy_icon('flag'); // phpcs:ignore WordPress.Security.EscapeOutput 
                ?>
              </div>
              <h3 class="company-service-name"><?php tenjoy_e('company_16'); ?></h3>
              <p class="company-service-desc"><?php tenjoy_e('company_17'); ?></p>
            </div>
            <div class="company-service-card">
              <div class="company-service-icon">
                <?php echo tenjoy_icon('message-square'); // phpcs:ignore WordPress.Security.EscapeOutput 
                ?>
              </div>
              <h3 class="company-service-name"><?php tenjoy_e('company_18'); ?></h3>
              <p class="company-service-desc"><?php tenjoy_e('company_19'); ?></p>
            </div>
            <div class="company-service-card">
              <div class="company-service-icon">
                <?php echo tenjoy_icon('map-pin'); // phpcs:ignore WordPress.Security.EscapeOutput 
                ?>
              </div>
              <h3 class="company-service-name"><?php tenjoy_e('company_20'); ?></h3>
              <p class="company-service-desc"><?php tenjoy_e('company_21'); ?></p>
            </div>
            <div class="company-service-card">
              <div class="company-service-icon">
                <?php echo tenjoy_icon('car'); // phpcs:ignore WordPress.Security.EscapeOutput 
                ?>
              </div>
              <h3 class="company-service-name"><?php tenjoy_e('company_22'); ?></h3>
              <p class="company-service-desc"><?php tenjoy_e('company_23'); ?></p>
            </div>
          </div>
        </section>

        <!-- サービスエリア -->
        <section class="company-info-section">
          <h2 class="company-section-title"><?php tenjoy_e('company_24'); ?></h2>
          <p><?php tenjoy_e('service_area_01'); ?></p>
          <p class="service-area-ref-title"><?php tenjoy_e('service_area_02'); ?></p>
          <ul class="service-area-ref-list">
            <li>
              <?php tenjoy_e('service_area_03'); ?><a href="https://golf-in-japan.com/" target="_blank" rel="noopener noreferrer"><?php tenjoy_e('service_area_04'); ?></a>
            </li>
            <li>
              <?php tenjoy_e('service_area_05'); ?><a href="https://www.booking.com/index.ko.html?label=gen173nr-1BCAEoggI46AdIM1gEaH2IAQGYARW4AQfIAQzYAQHoAQGIAgGoAgO4Arzs-6MGwAIB0gIkNGI3Mjg2ZDAtMTQ0Yi00ZmRmLWI4OTUtMzcyYWRhYzUyNjYz2AIF4AIB&sid=0dcd94148e8430db9d304eba912b1473&keep_landing=1&sb_price_type=total&lang=ko&soz=1&lang_changed=1" target="_blank" rel="noopener noreferrer"><?php tenjoy_e('service_area_06'); ?></a>
            </li>
          </ul>
          <p class="service-area-note"><?php tenjoy_e('service_area_07'); ?></p>
        </section>

        <!-- WP管理画面から追加編集できる本文エリア -->
        <?php while (have_posts()) : the_post(); ?>
          <?php if (get_the_content()) : ?>
            <section class="company-content-section">
              <div class="entry-content">
                <?php the_content(); ?>
              </div>
            </section>
          <?php endif; ?>
        <?php endwhile; ?>

        <!-- CTA -->
        <div class="company-cta">
          <p class="company-cta-title"><?php tenjoy_e('company_31'); ?></p>
          <p class="company-cta-text"><?php tenjoy_e('company_32'); ?></p>
          <div class="company-cta-buttons">
            <a href="<?php echo esc_url(tenjoy_page_url('contact', '/contact/')); ?>" class="btn btn-primary btn-lg">
              <?php tenjoy_e('nav_06'); ?>
            </a>
            <a href="<?php echo esc_url(get_post_type_archive_link('courses')); ?>" class="btn btn-outline btn-lg">
              <?php tenjoy_e('company_33'); ?>
            </a>
          </div>
        </div>

      </div>
    </div>
  </div>

</main>

<?php get_footer(); ?>