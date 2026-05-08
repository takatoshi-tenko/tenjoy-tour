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
  'languages'      => (string) get_post_meta($pid, 'company_languages', true)      ?: '日本語・中国語・韓国語・英語',
  'hours'          => (string) get_post_meta($pid, 'company_hours', true)          ?: '09:00 〜 18:00（年中無休）',
];
?>

<main id="main" class="site-main" role="main">

  <div class="archive-header">
    <div class="container">
      <h1 class="archive-title"><?php esc_html_e('会社概要', 'tenjoy-tour'); ?></h1>
      <p class="archive-desc"><?php esc_html_e('TENJOY-TOUR について', 'tenjoy-tour'); ?></p>
    </div>
  </div>

  <div class="company-page">
    <div class="container">
      <div class="company-page-layout">

        <!-- 代表挨拶 -->
        <section class="company-greeting">
          <div class="company-greeting-deco" aria-hidden="true">"</div>
          <div class="company-greeting-inner">
            <p class="company-greeting-lead"><?php esc_html_e('Have a good tour. Have a good trip !', 'tenjoy-tour'); ?></p>
            <h2 class="company-greeting-title"><?php esc_html_e('訪日ゴルファーの皆様へ', 'tenjoy-tour'); ?></h2>
            <div class="company-greeting-body">
              <p><?php esc_html_e('TENJOY-TOURは、日本でのゴルフ旅行を心から楽しんでいただくために設立されました。ゴルフ場の予約・送迎・ガイドなど、旅行に関わるすべての手配を私たちにお任せください。', 'tenjoy-tour'); ?></p>
              <p><?php esc_html_e('日本語・中国語・韓国語・英語に対応したスタッフが、お客様一人ひとりに寄り添いながら、最高のゴルフ旅行をサポートいたします。', 'tenjoy-tour'); ?></p>
            </div>
            <p class="company-greeting-sign"><?php esc_html_e('代表取締役　', 'tenjoy-tour'); ?><?php echo esc_html($co['representative']); ?></p>
          </div>
        </section>

        <!-- 基本情報 -->
        <section class="company-info-section">
          <h2 class="company-section-title"><?php esc_html_e('基本情報', 'tenjoy-tour'); ?></h2>
          <dl class="company-info-table">
            <div class="company-info-row">
              <dt><?php esc_html_e('会社名', 'tenjoy-tour'); ?></dt>
              <dd><?php echo esc_html($co['name']); ?></dd>
            </div>
            <div class="company-info-row">
              <dt><?php esc_html_e('代表者', 'tenjoy-tour'); ?></dt>
              <dd><?php echo esc_html($co['representative']); ?></dd>
            </div>
            <div class="company-info-row">
              <dt><?php esc_html_e('設立', 'tenjoy-tour'); ?></dt>
              <dd><?php echo esc_html($co['founded']); ?></dd>
            </div>
            <div class="company-info-row">
              <dt><?php esc_html_e('資本金', 'tenjoy-tour'); ?></dt>
              <dd><?php echo esc_html($co['capital']); ?></dd>
            </div>
            <div class="company-info-row">
              <dt><?php esc_html_e('従業員数', 'tenjoy-tour'); ?></dt>
              <dd><?php echo esc_html($co['employees']); ?></dd>
            </div>
            <div class="company-info-row">
              <dt><?php esc_html_e('所在地', 'tenjoy-tour'); ?></dt>
              <dd><?php echo esc_html($co['address']); ?></dd>
            </div>
            <div class="company-info-row">
              <dt><?php esc_html_e('電話番号', 'tenjoy-tour'); ?></dt>
              <dd><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $co['phone'])); ?>"><?php echo esc_html($co['phone']); ?></a></dd>
            </div>
            <div class="company-info-row">
              <dt><?php esc_html_e('対応言語', 'tenjoy-tour'); ?></dt>
              <dd><?php echo esc_html($co['languages']); ?></dd>
            </div>
            <div class="company-info-row">
              <dt><?php esc_html_e('営業時間', 'tenjoy-tour'); ?></dt>
              <dd><?php echo esc_html($co['hours']); ?></dd>
            </div>
          </dl>
        </section>

        <!-- 事業内容 -->
        <section class="company-info-section">
          <h2 class="company-section-title"><?php esc_html_e('事業内容', 'tenjoy-tour'); ?></h2>
          <div class="company-services-grid">
            <div class="company-service-card">
              <div class="company-service-icon">
                <?php echo tenjoy_icon('flag'); // phpcs:ignore WordPress.Security.EscapeOutput ?>
              </div>
              <h3 class="company-service-name"><?php esc_html_e('旅行業', 'tenjoy-tour'); ?></h3>
              <p class="company-service-desc"><?php esc_html_e('訪日外国人向けのゴルフ旅行・観光ツアーの企画・手配を行います。', 'tenjoy-tour'); ?></p>
            </div>
            <div class="company-service-card">
              <div class="company-service-icon">
                <?php echo tenjoy_icon('message-square'); // phpcs:ignore WordPress.Security.EscapeOutput ?>
              </div>
              <h3 class="company-service-name"><?php esc_html_e('翻訳・通訳', 'tenjoy-tour'); ?></h3>
              <p class="company-service-desc"><?php esc_html_e('中国語・韓国語・英語に対応した翻訳・通訳サービスを提供します。', 'tenjoy-tour'); ?></p>
            </div>
            <div class="company-service-card">
              <div class="company-service-icon">
                <?php echo tenjoy_icon('map-pin'); // phpcs:ignore WordPress.Security.EscapeOutput ?>
              </div>
              <h3 class="company-service-name"><?php esc_html_e('観光ガイド', 'tenjoy-tour'); ?></h3>
              <p class="company-service-desc"><?php esc_html_e('経験豊富なガイドが日本各地の観光スポットをご案内します。', 'tenjoy-tour'); ?></p>
            </div>
            <div class="company-service-card">
              <div class="company-service-icon">
                <?php echo tenjoy_icon('car'); // phpcs:ignore WordPress.Security.EscapeOutput ?>
              </div>
              <h3 class="company-service-name"><?php esc_html_e('送迎・チャーター', 'tenjoy-tour'); ?></h3>
              <p class="company-service-desc"><?php esc_html_e('空港・ゴルフ場間の送迎から長距離チャーターまで対応します。', 'tenjoy-tour'); ?></p>
            </div>
          </div>
        </section>

        <!-- サービスエリア -->
        <section class="company-info-section">
          <h2 class="company-section-title"><?php esc_html_e('サービスエリア', 'tenjoy-tour'); ?></h2>
          <div class="company-area-grid">
            <div class="company-area-card">
              <h3 class="company-area-name"><?php esc_html_e('九州エリア', 'tenjoy-tour'); ?></h3>
              <p class="company-area-desc"><?php esc_html_e('福岡・佐賀・長崎・熊本・大分・宮崎・鹿児島', 'tenjoy-tour'); ?></p>
            </div>
            <div class="company-area-card">
              <h3 class="company-area-name"><?php esc_html_e('関西・中国エリア', 'tenjoy-tour'); ?></h3>
              <p class="company-area-desc"><?php esc_html_e('大阪・京都・兵庫・広島・岡山・山口', 'tenjoy-tour'); ?></p>
            </div>
            <div class="company-area-card">
              <h3 class="company-area-name"><?php esc_html_e('全国対応', 'tenjoy-tour'); ?></h3>
              <p class="company-area-desc"><?php esc_html_e('上記以外のエリアもご相談ください。全国のゴルフ場への手配が可能です。', 'tenjoy-tour'); ?></p>
            </div>
          </div>
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
          <p class="company-cta-title"><?php esc_html_e('ご不明な点はお気軽にお問い合わせください', 'tenjoy-tour'); ?></p>
          <p class="company-cta-text"><?php esc_html_e('WeChat・Kakao Talk・LINE・WhatsApp でもご連絡いただけます。', 'tenjoy-tour'); ?></p>
          <div class="company-cta-buttons">
            <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary btn-lg">
              <?php esc_html_e('お問い合わせ', 'tenjoy-tour'); ?>
            </a>
            <a href="<?php echo esc_url(home_url('/courses/')); ?>" class="btn btn-outline btn-lg">
              <?php esc_html_e('ゴルフ場を見る', 'tenjoy-tour'); ?>
            </a>
          </div>
        </div>

      </div>
    </div>
  </div>

</main>

<?php get_footer(); ?>
