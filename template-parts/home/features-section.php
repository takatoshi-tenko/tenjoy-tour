<?php

/**
 * トップページ: 5つのつよみ（静的ブロック）
 *
 * @package Friend2026
 */

$features = array(
	array(
		'title'       => 'ライフプランニング・サポート',
		'description' => 'ファイナンシャルアドバイザーと連携し、お客様の将来設計に合わせたご提案・アドバイスをします。',
	),
	array(
		'title'       => 'オプション設備サービス',
		'description' => '住宅オプション工事の専門店と提携し、住宅購入からオプション工事までワンストップでサポートします。',
	),
	array(
		'title'       => '物件情報のクオリティ',
		'description' => '情報の量と質にこだわった物件情報をお客様に随時お届けします。未公開物件も多数ご用意。',
	),
	array(
		'title'       => 'ローンシミュレーション',
		'description' => 'お客様に寄り添う住宅ローンシミュレーションで、無理のない資金計画をご提案いたします。',
	),
	array(
		'title'       => '買い替え相談・フロー',
		'description' => '買取保証とインスペクションで買い替えの不安を解消。スムーズな住み替えをサポートします。',
	),
);
?>

<section class="front-section front-features">
  <div class="container">
    <div class="front-section-head front-section-head-center">
      <p class="front-section-label">Feature</p>
      <h2 class="front-section-title"><span class="front-section-title-accent">5つ</span>のつよみ</h2>
    </div>
    <div class="front-features-grid">
      <?php foreach ($features as $f) : ?>
      <div class="front-feature-card">
        <div class="front-feature-icon"></div>
        <div class="front-feature-body">
          <h3 class="front-feature-title"><?php echo esc_html($f['title']); ?></h3>
          <p class="front-feature-desc"><?php echo esc_html($f['description']); ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>