<?php

/**
 * テンプレート: 会社概要（/company）
 * 固定ページのスラッグが「company」のときに使用。
 * 表示内容は「会社情報・店舗」メニューから編集。
 *
 * @package Friend2026
 */

get_header();

$d = friend2026_get_company_data();
$branches = ! empty($d['branches']) ? $d['branches'] : array();
?>

<main id="main" class="site-main page-company" role="main">
  <div class="page-company-header">
    <div class="container">
      <p class="page-company-label"><?php echo esc_html($d['heading_label']); ?></p>
      <h1 class="page-company-title"><?php echo esc_html($d['heading_title']); ?></h1>
      <p class="page-company-desc"><?php echo nl2br(esc_html($d['heading_description'])); ?></p>
    </div>
  </div>

  <div class="container page-company-body">
    <?php if ($d['philosophy_catchphrase'] || $d['philosophy_description']) : ?>
    <section class="page-company-section page-company-philosophy">
      <h2 class="page-company-section-title"><?php echo esc_html($d['section_title_philosophy']); ?></h2>
      <?php if ($d['philosophy_catchphrase']) : ?>
      <p class="page-company-philosophy-catch"><?php echo esc_html($d['philosophy_catchphrase']); ?></p>
      <?php endif; ?>
      <?php if ($d['philosophy_description']) : ?>
      <div class="page-company-philosophy-desc"><?php echo nl2br(esc_html($d['philosophy_description'])); ?></div>
      <?php endif; ?>
    </section>
    <?php endif; ?>

    <?php if (! empty($d['promises'])) : ?>
    <section class="page-company-section page-company-promises">
      <h2 class="page-company-section-title"><?php echo esc_html($d['section_title_promises']); ?></h2>
      <div class="page-company-promises-grid">
        <?php
				$icons = array('lock', 'people', 'chart');
				foreach ($d['promises'] as $i => $p) :
					if (empty($p['title']) && empty($p['text'])) {
						continue;
					}
					$icon = isset($icons[ $i ]) ? $icons[ $i ] : 'check';
				?>
        <div class="page-company-promise-card">
          <span class="page-company-promise-icon page-company-promise-icon-<?php echo esc_attr($icon); ?>"
            aria-hidden="true"></span>
          <h3 class="page-company-promise-title"><?php echo esc_html($p['title']); ?></h3>
          <p class="page-company-promise-text"><?php echo esc_html($p['text']); ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>

    <section class="page-company-section page-company-info">
      <h2 class="page-company-section-title"><?php echo esc_html($d['section_title_company']); ?></h2>
      <dl class="page-company-info-list">
        <?php if ($d['company_name']) : ?><dt>会社名</dt>
        <dd><?php echo esc_html($d['company_name']); ?></dd><?php endif; ?>
        <?php if ($d['company_representative']) : ?><dt>代表取締役</dt>
        <dd><?php echo esc_html($d['company_representative']); ?></dd><?php endif; ?>
        <?php if ($d['company_established']) : ?><dt>設立</dt>
        <dd><?php echo esc_html($d['company_established']); ?></dd><?php endif; ?>
        <?php if ($d['company_capital']) : ?><dt>資本金</dt>
        <dd><?php echo esc_html($d['company_capital']); ?></dd><?php endif; ?>
        <?php if ($d['company_employees']) : ?><dt>従業員数</dt>
        <dd><?php echo esc_html($d['company_employees']); ?></dd><?php endif; ?>
        <?php if ($d['company_business']) : ?><dt>事業内容</dt>
        <dd><?php echo nl2br(esc_html($d['company_business'])); ?></dd><?php endif; ?>
        <?php if ($d['company_license']) : ?><dt>免許番号</dt>
        <dd><?php echo esc_html($d['company_license']); ?></dd><?php endif; ?>
        <?php if ($d['company_affiliations']) : ?><dt>所属団体</dt>
        <dd><?php echo nl2br(esc_html($d['company_affiliations'])); ?></dd><?php endif; ?>
      </dl>
    </section>

    <?php if (! empty($branches)) : ?>
    <section id="access" class="page-company-section page-company-branches">
      <h2 class="page-company-section-title"><?php echo esc_html($d['section_title_branches']); ?></h2>
      <div class="page-company-branches-grid">
        <?php foreach ($branches as $b) :
					$b = wp_parse_args($b, array('name' => '', 'address' => '', 'phone' => '', 'access' => '', 'hours' => '', 'map_url' => ''));
					if ($b['name'] === '' && $b['address'] === '') {
						continue;
					}
				?>
        <div class="page-company-branch-card">
          <h3 class="page-company-branch-name"><?php echo esc_html($b['name']); ?></h3>
          <ul class="page-company-branch-details">
            <?php if ($b['address']) : ?>
            <li class="page-company-branch-address">
              <span class="page-company-branch-icon" aria-hidden="true"></span>
              <?php echo nl2br(esc_html($b['address'])); ?>
            </li>
            <?php endif; ?>
            <?php if ($b['phone']) : ?>
            <li class="page-company-branch-phone">
              <span class="page-company-branch-icon" aria-hidden="true"></span>
              <a
                href="tel:<?php echo esc_attr(preg_replace('/[^0-9+\-]/', '', $b['phone'])); ?>"><?php echo esc_html($b['phone']); ?></a>
            </li>
            <?php endif; ?>
            <?php if ($b['access']) : ?>
            <li class="page-company-branch-access">
              <span class="page-company-branch-icon" aria-hidden="true"></span>
              <?php echo esc_html($b['access']); ?>
            </li>
            <?php endif; ?>
            <?php if ($b['hours']) : ?>
            <li class="page-company-branch-hours">
              <span class="page-company-branch-icon" aria-hidden="true"></span>
              <?php echo esc_html($b['hours']); ?>
            </li>
            <?php endif; ?>
          </ul>
          <?php if (! empty($b['map_url'])) : ?>
          <div class="page-company-branch-map-embed">
            <iframe src="<?php echo esc_url($b['map_url']); ?>" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="<?php echo esc_attr($b['name']); ?>の地図"></iframe>
          </div>
          <?php else : ?>
          <div class="page-company-branch-map-placeholder">地図を表示</div>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>
  </div>
</main>

<?php
get_footer();