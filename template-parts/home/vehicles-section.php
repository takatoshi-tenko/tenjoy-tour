<?php
/**
 * 車両紹介セクション
 *
 * @package tenjoy-tour
 */

$vehicles = [
  [
    'setting_key'  => 'tenjoy_vehicle_bus',
    'alt'          => 'Tour Bus',
    'default_name' => __('大型バス', 'tenjoy-tour'),
    'default_desc' => __('大人数でのご移動に最適です（最大45名）', 'tenjoy-tour'),
  ],
  [
    'setting_key'  => 'tenjoy_vehicle_van',
    'alt'          => 'Van',
    'default_name' => __('ワゴン車', 'tenjoy-tour'),
    'default_desc' => __('中人数のグループに最適です（最大10名）', 'tenjoy-tour'),
  ],
  [
    'setting_key'  => 'tenjoy_vehicle_sedan',
    'alt'          => 'Sedan',
    'default_name' => __('高級セダン', 'tenjoy-tour'),
    'default_desc' => __('少人数でのプライベート移動に（最大4名）', 'tenjoy-tour'),
  ],
  [
    'setting_key'  => 'tenjoy_vehicle_minivan',
    'alt'          => 'Minivan',
    'default_name' => __('ミニバン', 'tenjoy-tour'),
    'default_desc' => __('小グループに最適な快適移動（最大8名）', 'tenjoy-tour'),
  ],
];
?>
<section class="vehicles-section">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title"><?php esc_html_e('車両紹介', 'tenjoy-tour'); ?></h2>
      <p class="section-subtitle">
        <?php esc_html_e('快適で安全な移動のため、様々なタイプの車両をご用意しています', 'tenjoy-tour'); ?>
      </p>
    </div>
    <div class="vehicles-grid">
      <?php foreach ($vehicles as $vehicle) : ?>
        <div class="vehicle-card">
          <div class="vehicle-img-wrap">
            <?php $vehicle_url = tenjoy_customizer_image_url($vehicle['setting_key'], 'tenjoy-card'); ?>
            <?php if ($vehicle_url) : ?>
            <img
              src="<?php echo esc_url($vehicle_url); ?>"
              alt="<?php echo esc_attr($vehicle['alt']); ?>"
              class="vehicle-img"
              loading="lazy">
            <?php endif; ?>
          </div>
          <h3 class="vehicle-name"><?php echo esc_html((string) get_theme_mod($vehicle['setting_key'] . '_name', $vehicle['default_name'])); ?></h3>
          <p class="vehicle-desc"><?php echo esc_html((string) get_theme_mod($vehicle['setting_key'] . '_desc', $vehicle['default_desc'])); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
