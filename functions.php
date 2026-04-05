<?php

/**
 * Friend 2026 テーマの関数定義
 *
 * @package Friend2026
 */

if (! defined('ABSPATH')) {
	exit;
}

define('FRIEND2026_VERSION', '0.1.0');
define('FRIEND2026_DIR', get_template_directory());
define('FRIEND2026_URI', get_template_directory_uri());

/**
 * テーマセットアップ
 */
function friend2026_setup()
{
	load_theme_textdomain('friend2026', FRIEND2026_DIR . '/languages');
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
	add_theme_support('custom-logo', array(
		'height'      => 60,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	));
}
add_action('after_setup_theme', 'friend2026_setup');

/**
 * スクリプト・スタイルの読み込み（フェーズ8: Google Fonts）
 */
function friend2026_scripts()
{
	$font_url = 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&display=swap';
	wp_enqueue_style(
		'friend2026-fonts',
		$font_url,
		array(),
		null
	);

	$style_file = get_stylesheet_directory() . '/style.css';
	$style_ver  = file_exists($style_file) ? (string) filemtime($style_file) : FRIEND2026_VERSION;
	wp_enqueue_style(
		'friend2026-style',
		get_stylesheet_uri(),
		array('friend2026-fonts'),
		$style_ver
	);

	$nav_file = FRIEND2026_DIR . '/assets/js/nav.js';
	$nav_ver  = file_exists($nav_file) ? (string) filemtime($nav_file) : FRIEND2026_VERSION;
	wp_enqueue_script(
		'friend2026-nav',
		FRIEND2026_URI . '/assets/js/nav.js',
		array(),
		$nav_ver,
		true
	);

	if (is_page('faq') || (int) get_query_var('friend2026_faq') === 1) {
		$faq_file = FRIEND2026_DIR . '/assets/js/faq-accordion.js';
		$faq_ver  = file_exists($faq_file) ? (string) filemtime($faq_file) : FRIEND2026_VERSION;
		wp_enqueue_script(
			'friend2026-faq',
			FRIEND2026_URI . '/assets/js/faq-accordion.js',
			array(),
			$faq_ver,
			true
		);
	}
}
add_action('wp_enqueue_scripts', 'friend2026_scripts');

/**
 * 管理画面：物件編集時にメディアピッカー（ギャラリー）用スクリプトを読み込む
 */
function friend2026_property_admin_scripts($hook)
{
	$screen = get_current_screen();
	if (! $screen || $screen->post_type !== 'property') {
		return;
	}
	if ($hook !== 'post.php' && $hook !== 'post-new.php') {
		return;
	}
	wp_enqueue_media();
}

add_action('admin_enqueue_scripts', 'friend2026_property_admin_scripts');

/**
 * カスタム投稿タイプ: 物件 (property)
 */
function friend2026_register_post_type_property()
{
	$labels = array(
		'name'               => '物件',
		'singular_name'      => '物件',
		'menu_name'          => '物件',
		'add_new'            => '新規追加',
		'add_new_item'       => '新規物件を追加',
		'edit_item'          => '物件を編集',
		'new_item'           => '新規物件',
		'view_item'          => '物件を表示',
		'search_items'       => '物件を検索',
		'not_found'          => '物件が見つかりません',
		'not_found_in_trash' => 'ゴミ箱に物件はありません',
	);

	$args = array(
		'labels'              => $labels,
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'query_var'           => true,
		'rewrite'             => array('slug' => 'properties'),
		'capability_type'     => 'post',
		'has_archive'         => true,
		'hierarchical'        => false,
		'menu_position'       => 4,
		'menu_icon'           => 'dashicons-building',
		'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
		'show_in_rest'        => true,
	);

	register_post_type('property', $args);
}
add_action('init', 'friend2026_register_post_type_property');

/**
 * 物件タイプ用タクソノミー（新築一戸建て / 中古一戸建て / マンション / 土地）
 */
function friend2026_register_taxonomy_property_type()
{
	$labels = array(
		'name'          => '物件タイプ',
		'singular_name' => '物件タイプ',
		'search_items'  => '物件タイプを検索',
		'all_items'     => 'すべての物件タイプ',
		'edit_item'     => '物件タイプを編集',
		'update_item'   => '更新',
		'add_new_item'  => '新規追加',
	);

	register_taxonomy('property_type', 'property', array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => array('slug' => 'property-type'),
		'show_in_rest'      => true,
	));
}
add_action('init', 'friend2026_register_taxonomy_property_type');

/**
 * カスタム投稿タイプ: スタッフ (staff)
 */
function friend2026_register_post_type_staff()
{
	$labels = array(
		'name'               => 'スタッフ',
		'singular_name'      => 'スタッフ',
		'menu_name'          => 'スタッフ紹介',
		'add_new'            => '新規追加',
		'add_new_item'       => '新規スタッフを追加',
		'edit_item'          => 'スタッフを編集',
		'new_item'           => '新規スタッフ',
		'view_item'          => 'スタッフを表示',
		'search_items'       => 'スタッフを検索',
		'not_found'          => 'スタッフが見つかりません',
		'not_found_in_trash' => 'ゴミ箱にスタッフはありません',
	);

	$args = array(
		'labels'              => $labels,
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'query_var'           => true,
		'rewrite'             => array('slug' => 'staff'),
		'capability_type'     => 'post',
		'has_archive'         => true,
		'hierarchical'        => false,
		'menu_position'       => 6,
		'menu_icon'           => 'dashicons-groups',
		'supports'            => array('title', 'thumbnail', 'editor', 'page-attributes'),
		'show_in_rest'        => true,
	);

	register_post_type('staff', $args);
}
add_action('init', 'friend2026_register_post_type_staff');

/**
 * 管理画面: 物件・スタッフ一覧に「表示順」列（menu_order）
 */
function friend2026_sort_column_headers($columns)
{
	$new = array();
	foreach ($columns as $key => $label) {
		$new[$key] = $label;
		if ($key === 'title') {
			$new['friend2026_sort'] = '表示順';
		}
	}
	return $new;
}

/**
 * @param string $column
 * @param int    $post_id
 */
function friend2026_sort_column_cell($column, $post_id)
{
	if ($column !== 'friend2026_sort') {
		return;
	}
	$post = get_post($post_id);
	if (! $post || ! in_array($post->post_type, array('property', 'staff'), true)) {
		return;
	}
	echo (int) $post->menu_order;
}

/**
 * @param array<string, string> $columns
 * @return array<string, string>
 */
function friend2026_sort_column_sortable($columns)
{
	$columns['friend2026_sort'] = 'menu_order';
	return $columns;
}

add_filter('manage_property_posts_columns', 'friend2026_sort_column_headers');
add_filter('manage_staff_posts_columns', 'friend2026_sort_column_headers');
add_action('manage_property_posts_custom_column', 'friend2026_sort_column_cell', 10, 2);
add_action('manage_staff_posts_custom_column', 'friend2026_sort_column_cell', 10, 2);
add_filter('manage_edit-property_sortable_columns', 'friend2026_sort_column_sortable');
add_filter('manage_edit-staff_sortable_columns', 'friend2026_sort_column_sortable');

/**
 * スタッフ一覧: 表示順（小さいほど先）→ 日付の新しい順
 */
function friend2026_staff_archive_query($query)
{
	if (is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive('staff')) {
		return;
	}
	$query->set(
		'orderby',
		array(
			'menu_order' => 'ASC',
			'date'       => 'DESC',
		)
	);
}
add_action('pre_get_posts', 'friend2026_staff_archive_query');

/**
 * スタッフ用カスタムフィールド登録（支店・役職・読み・経験年数・資格・得意分野・紹介文）
 */
function friend2026_register_staff_meta()
{
	$meta_keys = array(
		'staff_branch'           => array('type' => 'string', 'single' => true),
		'staff_role'             => array('type' => 'string', 'single' => true),
		'staff_name_phonetic'    => array('type' => 'string', 'single' => true),
		'staff_experience_years' => array('type' => 'string', 'single' => true),
		'staff_qualifications'   => array('type' => 'string', 'single' => true),
		'staff_specialties'      => array('type' => 'string', 'single' => true),
		'staff_bio'              => array('type' => 'string', 'single' => true),
	);

	foreach ($meta_keys as $key => $args) {
		register_post_meta('staff', $key, array(
			'show_in_rest'  => true,
			'single'        => $args['single'],
			'type'          => $args['type'],
			'auth_callback' => function () {
				return current_user_can('edit_posts');
			},
		));
	}
}
add_action('init', 'friend2026_register_staff_meta');

/**
 * スタッフ編集画面にメタボックスを追加
 */
function friend2026_staff_meta_box()
{
	add_meta_box(
		'friend2026_staff_details',
		'スタッフ情報',
		'friend2026_staff_meta_box_cb',
		'staff',
		'normal'
	);
}

function friend2026_staff_meta_box_cb($post)
{
	wp_nonce_field('friend2026_staff_meta', 'friend2026_staff_meta_nonce');
	$branch   = get_post_meta($post->ID, 'staff_branch', true);
	$role     = get_post_meta($post->ID, 'staff_role', true);
	$phonetic = get_post_meta($post->ID, 'staff_name_phonetic', true);
	$experience = get_post_meta($post->ID, 'staff_experience_years', true);
	$qual     = get_post_meta($post->ID, 'staff_qualifications', true);
	$spec     = get_post_meta($post->ID, 'staff_specialties', true);
	$bio      = get_post_meta($post->ID, 'staff_bio', true);
?>
<p><strong>タイトル</strong>にスタッフ名を入力してください。</p>
<table class="form-table" role="presentation">
  <tr>
    <th><label for="staff_branch">支店</label></th>
    <td><input type="text" id="staff_branch" name="staff_branch" value="<?php echo esc_attr($branch); ?>"
        class="regular-text" placeholder="例: 本店、府中支店"></td>
  </tr>
  <tr>
    <th><label for="staff_role">役職</label></th>
    <td><input type="text" id="staff_role" name="staff_role" value="<?php echo esc_attr($role); ?>" class="regular-text"
        placeholder="例: 代表取締役、営業部長"></td>
  </tr>
  <tr>
    <th><label for="staff_name_phonetic">名前の読み</label></th>
    <td><input type="text" id="staff_name_phonetic" name="staff_name_phonetic"
        value="<?php echo esc_attr($phonetic); ?>" class="regular-text" placeholder="例: やまだたろう"></td>
  </tr>
  <tr>
    <th><label for="staff_experience_years">経験年数</label></th>
    <td><input type="text" id="staff_experience_years" name="staff_experience_years"
        value="<?php echo esc_attr($experience); ?>" class="small-text" placeholder="例: 25年"></td>
  </tr>
  <tr>
    <th><label for="staff_qualifications">保有資格</label></th>
    <td><input type="text" id="staff_qualifications" name="staff_qualifications" value="<?php echo esc_attr($qual); ?>"
        class="large-text" placeholder="カンマ区切りで入力 例: 宅地建物取引士, 不動産鑑定士, 住宅ローンアドバイザー"></td>
  </tr>
  <tr>
    <th><label for="staff_specialties">得意分野</label></th>
    <td><input type="text" id="staff_specialties" name="staff_specialties" value="<?php echo esc_attr($spec); ?>"
        class="large-text" placeholder="カンマ区切りで入力 例: 投資物件, 高級住宅, ファミリー向け物件"></td>
  </tr>
  <tr>
    <th><label for="staff_bio">紹介文</label></th>
    <td><textarea id="staff_bio" name="staff_bio" rows="4"
        class="large-text"><?php echo esc_textarea($bio); ?></textarea></td>
  </tr>
</table>
<?php
}

function friend2026_staff_meta_box_save($post_id)
{
	if (! isset($_POST['friend2026_staff_meta_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['friend2026_staff_meta_nonce'])), 'friend2026_staff_meta')) {
		return;
	}
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	if (! current_user_can('edit_post', $post_id)) {
		return;
	}
	$keys = array('staff_branch', 'staff_role', 'staff_name_phonetic', 'staff_experience_years', 'staff_qualifications', 'staff_specialties', 'staff_bio');
	foreach ($keys as $key) {
		if (isset($_POST[$key])) {
			update_post_meta($post_id, $key, sanitize_textarea_field(wp_unslash($_POST[$key])));
		}
	}
}

add_action('add_meta_boxes', 'friend2026_staff_meta_box');
add_action('save_post_staff', 'friend2026_staff_meta_box_save');

/**
 * 物件編集画面：物件情報メタボックス（決まった形式で登録できる導線）
 */
function friend2026_property_meta_box()
{
	add_meta_box(
		'friend2026_property_details',
		'物件情報',
		'friend2026_property_meta_box_cb',
		'property',
		'normal'
	);
}

function friend2026_property_meta_box_cb($post)
{
	wp_nonce_field('friend2026_property_meta', 'friend2026_property_meta_nonce');

	$address     = get_post_meta($post->ID, 'property_address', true);
	$price_label = get_post_meta($post->ID, 'property_price_label', true);
	$price       = get_post_meta($post->ID, 'property_price', true);
	$station     = get_post_meta($post->ID, 'property_station', true);
	$walk        = get_post_meta($post->ID, 'property_walk_minutes', true);
	$plan        = get_post_meta($post->ID, 'property_floor_plan', true);
	$b_area      = get_post_meta($post->ID, 'property_building_area', true);
	$l_area      = get_post_meta($post->ID, 'property_land_area', true);
	$built       = get_post_meta($post->ID, 'property_built_year', true);
	$floors      = get_post_meta($post->ID, 'property_floors', true);
	$units       = get_post_meta($post->ID, 'property_total_units', true);
	$desc        = get_post_meta($post->ID, 'property_description', true);
	$features    = get_post_meta($post->ID, 'property_features', true);
	$is_new      = (bool) get_post_meta($post->ID, 'property_is_new', true);
	$is_rec      = (bool) get_post_meta($post->ID, 'property_is_recommended', true);
	$is_down     = (bool) get_post_meta($post->ID, 'property_is_price_down', true);
	$open_house  = (bool) get_post_meta($post->ID, 'property_open_house', true);
?>
<p class="description" style="margin-bottom:1em;">
  タイトルには<strong>物件名</strong>（例: 調布市飛田給3丁目）を入力してください。物件種別（新築一戸建て・中古一戸建て・マンション・土地）は右の<strong>「物件タイプ」</strong>で選択します。
</p>
<p class="description"
  style="margin-bottom:1em; padding:0.5rem 0.75rem; background:#fef3c7; border-left:4px solid #f59e0b; border-radius:4px;">
  <strong>物件一覧に画像を表示するには：</strong>
  右サイドバーの<strong>「アイキャッチ画像」</strong>を設定するか、下の<strong>「画像ギャラリー」</strong>に1枚以上追加してください。どちらも未設定の場合は一覧でプレースホルダーが表示されます。
</p>

<div class="friend2026-property-meta" style="display:grid; gap:1.5rem;">
  <section style="padding:1rem; background:#f8fafc; border-radius:8px;">
    <h4 style="margin:0 0 0.75rem; font-size:14px;">所在地・住所</h4>
    <table class="form-table" role="presentation">
      <tbody>
        <tr>
          <th><label for="property_address">所在地</label></th>
          <td>
            <input type="text" id="property_address" name="property_address" value="<?php echo esc_attr($address); ?>"
              class="large-text" placeholder="例: 東京都調布市飛田給3丁目">
            <p class="description">物件概要・一覧に表示されます。都道府県から番地まで入力してください。</p>
          </td>
        </tr>
      </tbody>
    </table>
  </section>

  <section style="padding:1rem; background:#f8fafc; border-radius:8px;">
    <h4 style="margin:0 0 0.75rem; font-size:14px;">価格</h4>
    <table class="form-table" role="presentation">
      <tbody>
        <tr>
          <th><label for="property_price_label">価格（表示用）</label></th>
          <td>
            <input type="text" id="property_price_label" name="property_price_label"
              value="<?php echo esc_attr($price_label); ?>" class="regular-text" placeholder="例: 6,199万円">
            <p class="description">画面にそのまま表示されます（例: 6,199万円）。</p>
          </td>
        </tr>
        <tr>
          <th><label for="property_price">価格（数値・ソート用）</label></th>
          <td>
            <input type="number" id="property_price" name="property_price" value="<?php echo esc_attr($price); ?>"
              class="small-text" min="0" step="1" placeholder="6199">
            <span>万円</span>
            <p class="description">一覧の「価格が安い順・高い順」で使用します。万円単位の数値のみ入力（例: 6199）。</p>
          </td>
        </tr>
      </tbody>
    </table>
  </section>

  <section style="padding:1rem; background:#f8fafc; border-radius:8px;">
    <h4 style="margin:0 0 0.75rem; font-size:14px;">交通・最寄駅</h4>
    <table class="form-table" role="presentation">
      <tbody>
        <tr>
          <th><label for="property_station">最寄駅</label></th>
          <td>
            <input type="text" id="property_station" name="property_station" value="<?php echo esc_attr($station); ?>"
              class="large-text" placeholder="例: 京王線「飛田給」駅">
            <p class="description">路線名・駅名を入力。表示時に「徒歩○分」を付けて「京王線「飛田給」駅 徒歩9分」のように出します。</p>
          </td>
        </tr>
        <tr>
          <th><label for="property_walk_minutes">徒歩分数</label></th>
          <td>
            <input type="number" id="property_walk_minutes" name="property_walk_minutes"
              value="<?php echo esc_attr($walk); ?>" class="small-text" min="0" max="999" placeholder="9">
            <span>分</span>
          </td>
        </tr>
      </tbody>
    </table>
  </section>

  <section style="padding:1rem; background:#f8fafc; border-radius:8px;">
    <h4 style="margin:0 0 0.75rem; font-size:14px;">間取り・面積（物件概要）</h4>
    <table class="form-table" role="presentation">
      <tbody>
        <tr>
          <th><label for="property_floor_plan">間取り</label></th>
          <td>
            <input type="text" id="property_floor_plan" name="property_floor_plan"
              value="<?php echo esc_attr($plan); ?>" class="regular-text" placeholder="例: 4LDK">
          </td>
        </tr>
        <tr>
          <th><label for="property_building_area">建物面積</label></th>
          <td>
            <input type="number" id="property_building_area" name="property_building_area"
              value="<?php echo esc_attr($b_area); ?>" class="small-text" min="0" step="0.1" placeholder="98.5">
            <span>㎡</span>
          </td>
        </tr>
        <tr>
          <th><label for="property_land_area">土地面積</label></th>
          <td>
            <input type="number" id="property_land_area" name="property_land_area"
              value="<?php echo esc_attr($l_area); ?>" class="small-text" min="0" step="0.1" placeholder="110.2">
            <span>㎡</span>
          </td>
        </tr>
        <tr>
          <th><label for="property_built_year">築年</label></th>
          <td>
            <input type="number" id="property_built_year" name="property_built_year"
              value="<?php echo esc_attr($built); ?>" class="small-text" min="0" placeholder="例: 2024">
            <span>年</span>
          </td>
        </tr>
        <tr>
          <th><label for="property_floors">階数</label></th>
          <td>
            <input type="number" id="property_floors" name="property_floors" value="<?php echo esc_attr($floors); ?>"
              class="small-text" min="0" placeholder="例: 2">
            <span>階建</span>
          </td>
        </tr>
        <tr>
          <th><label for="property_total_units">総戸数</label></th>
          <td>
            <input type="number" id="property_total_units" name="property_total_units"
              value="<?php echo esc_attr($units); ?>" class="small-text" min="0" placeholder="例: 10">
            <span>戸</span>
          </td>
        </tr>
      </tbody>
    </table>
  </section>

  <section style="padding:1rem; background:#f8fafc; border-radius:8px;">
    <h4 style="margin:0 0 0.75rem; font-size:14px;">物件紹介文</h4>
    <p>
      <label for="property_description" class="screen-reader-text">物件紹介文</label>
      <textarea id="property_description" name="property_description" rows="5" class="large-text" style="width:100%;"
        placeholder="例: ZEH水準仕様住宅。太陽光パネル搭載の邸宅が登場! …"><?php echo esc_textarea($desc); ?></textarea>
    </p>
    <p class="description">詳細ページの「物件紹介」に表示されます。</p>
  </section>

  <section style="padding:1rem; background:#f8fafc; border-radius:8px;">
    <h4 style="margin:0 0 0.75rem; font-size:14px;">設備・特徴</h4>
    <p>
      <label for="property_features" class="screen-reader-text">設備・特徴</label>
      <input type="text" id="property_features" name="property_features" value="<?php echo esc_attr($features); ?>"
        class="large-text" placeholder="例: ZEH水準仕様, 太陽光パネル搭載, 床暖房, LDK19帖超">
    </p>
    <p class="description">カンマ区切りで複数入力。一覧・詳細のタグとして表示されます。</p>
  </section>

  <section style="padding:1rem; background:#f8fafc; border-radius:8px;">
    <h4 style="margin:0 0 0.75rem; font-size:14px;">ステータスラベル</h4>
    <ul style="list-style:none; margin:0; padding:0; display:flex; flex-wrap:wrap; gap:1rem;">
      <li><label><input type="checkbox" name="property_is_new" value="1" <?php checked($is_new); ?>> NEW</label></li>
      <li><label><input type="checkbox" name="property_is_recommended" value="1" <?php checked($is_rec); ?>>
          おすすめ</label></li>
      <li><label><input type="checkbox" name="property_is_price_down" value="1" <?php checked($is_down); ?>> 値下げ</label>
      </li>
      <li><label><input type="checkbox" name="property_open_house" value="1" <?php checked($open_house); ?>>
          現地販売会</label></li>
    </ul>
    <p class="description">一覧・詳細のバッジ表示に使います。複数選択可。</p>
  </section>

  <section style="padding:1rem; background:#f0f9ff; border-radius:8px;">
    <h4 style="margin:0 0 0.75rem; font-size:14px;">画像ギャラリー（任意）</h4>
    <?php
			$gallery_ids_raw = get_post_meta($post->ID, 'property_gallery_ids', true);
			$gallery_ids_arr = $gallery_ids_raw ? array_filter(array_map('intval', explode(',', $gallery_ids_raw))) : array();
			?>
    <p class="description" style="margin-bottom:0.75rem;">
      <strong>画像IDの確認方法：</strong> 左メニュー「<strong>メディア →
        ライブラリ</strong>」を開き、一覧表示にすると各画像の「ID」が表示されます（表示オプションで「ID」列を有効にできる場合があります）。下の「<strong>画像を追加</strong>」から、この画面で直接メディアを選んで追加・削除できます。
    </p>
    <input type="hidden" id="property_gallery_ids" name="property_gallery_ids"
      value="<?php echo esc_attr($gallery_ids_raw); ?>">
    <div id="property-gallery-preview"
      style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:10px; min-height:40px;">
      <?php
				foreach ($gallery_ids_arr as $aid) {
					$src = wp_get_attachment_image_url($aid, 'thumbnail');
					if (! $src) {
						continue;
					}
				?>
      <div class="property-gallery-item" data-id="<?php echo (int) $aid; ?>"
        style="position:relative; width:80px; flex-shrink:0;">
        <img src="<?php echo esc_url($src); ?>" alt=""
          style="width:80px; height:80px; object-fit:cover; border-radius:4px; display:block; border:1px solid #ddd;">
        <span
          style="position:absolute; bottom:0; left:0; right:0; background:rgba(0,0,0,0.7); color:#fff; font-size:11px; text-align:center; padding:2px;">ID:
          <?php echo (int) $aid; ?></span>
        <button type="button" class="property-gallery-remove" aria-label="この画像を削除"
          style="position:absolute; top:2px; right:2px; width:22px; height:22px; padding:0; border:none; border-radius:4px; background:#dc2626; color:#fff; cursor:pointer; font-size:14px; line-height:1;">×</button>
      </div>
      <?php
				}
				?>
    </div>
    <p>
      <button type="button" id="property-gallery-add" class="button">画像を追加</button>
    </p>
    <p class="description">
      選択した画像が「全○枚」の枚数に含まれます。アイキャッチ画像＋ここで選んだ画像がギャラリー対象です。<strong>物件一覧のカードには、アイキャッチがなければここで選んだ1枚目が表示されます。</strong></p>
  </section>
</div>
<script>
(function() {
  var input = document.getElementById('property_gallery_ids');
  var preview = document.getElementById('property-gallery-preview');
  var addBtn = document.getElementById('property-gallery-add');
  if (!input || !preview || !addBtn) return;

  function getIds() {
    var val = (input.value || '').trim();
    return val ? val.split(',').map(function(s) {
      return s.trim();
    }).filter(Boolean) : [];
  }

  function setIds(ids) {
    input.value = ids.join(',');
  }

  function addThumb(id, url) {
    var wrap = document.createElement('div');
    wrap.className = 'property-gallery-item';
    wrap.setAttribute('data-id', id);
    wrap.style.cssText = 'position:relative; width:80px; flex-shrink:0;';
    wrap.innerHTML = '<img src="' + (url || '') +
      '" alt="" style="width:80px; height:80px; object-fit:cover; border-radius:4px; display:block; border:1px solid #ddd;">' +
      '<span style="position:absolute; bottom:0; left:0; right:0; background:rgba(0,0,0,0.7); color:#fff; font-size:11px; text-align:center; padding:2px;">ID: ' +
      id + '</span>' +
      '<button type="button" class="property-gallery-remove" aria-label="この画像を削除" style="position:absolute; top:2px; right:2px; width:22px; height:22px; padding:0; border:none; border-radius:4px; background:#dc2626; color:#fff; cursor:pointer; font-size:14px; line-height:1;">×</button>';
    preview.appendChild(wrap);
    wrap.querySelector('.property-gallery-remove').addEventListener('click', function() {
      var ids = getIds().filter(function(i) {
        return i !== String(id);
      });
      setIds(ids);
      wrap.remove();
    });
  }
  preview.addEventListener('click', function(e) {
    if (e.target.classList.contains('property-gallery-remove')) {
      var item = e.target.closest('.property-gallery-item');
      if (!item) return;
      var id = item.getAttribute('data-id');
      var ids = getIds().filter(function(i) {
        return i !== id;
      });
      setIds(ids);
      item.remove();
    }
  });
  addBtn.addEventListener('click', function() {
    var frame = wp.media({
      library: {
        type: 'image'
      },
      multiple: true,
      title: 'ギャラリー画像を選択',
      button: {
        text: '選択した画像を追加'
      }
    });
    var current = getIds();
    frame.on('select', function() {
      var selection = frame.state().get('selection');
      var newIds = [];
      selection.each(function(att) {
        var id = att.get('id');
        if (id && current.indexOf(String(id)) === -1) {
          current.push(String(id));
          newIds.push({
            id: id,
            url: att.get('sizes') && att.get('sizes').thumbnail ? att.get('sizes').thumbnail.url : att
              .get('url')
          });
        }
      });
      setIds(current);
      newIds.forEach(function(o) {
        addThumb(o.id, o.url);
      });
    });
    frame.open();
  });
})();
</script>
<?php
}

function friend2026_property_meta_box_save($post_id)
{
	if (! isset($_POST['friend2026_property_meta_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['friend2026_property_meta_nonce'])), 'friend2026_property_meta')) {
		return;
	}
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	if (! current_user_can('edit_post', $post_id)) {
		return;
	}

	$text_fields = array(
		'property_address',
		'property_price_label',
		'property_station',
		'property_floor_plan',
		'property_description',
		'property_features',
		'property_gallery_ids',
	);
	foreach ($text_fields as $key) {
		if (isset($_POST[$key])) {
			update_post_meta($post_id, $key, sanitize_textarea_field(wp_unslash($_POST[$key])));
		}
	}

	$num_fields = array(
		'property_price',
		'property_walk_minutes',
		'property_building_area',
		'property_land_area',
		'property_built_year',
		'property_floors',
		'property_total_units',
	);
	foreach ($num_fields as $key) {
		if (isset($_POST[$key]) && $_POST[$key] !== '') {
			update_post_meta($post_id, $key, (float) $_POST[$key]);
		}
	}

	$checkboxes = array(
		'property_is_new' => 'property_is_new',
		'property_is_recommended' => 'property_is_recommended',
		'property_is_price_down' => 'property_is_price_down',
		'property_open_house' => 'property_open_house',
	);
	foreach ($checkboxes as $post_key => $meta_key) {
		$value = isset($_POST[$post_key]) && $_POST[$post_key] === '1' ? '1' : '0';
		update_post_meta($post_id, $meta_key, $value);
	}
}

add_action('add_meta_boxes', 'friend2026_property_meta_box');
add_action('save_post_property', 'friend2026_property_meta_box_save');

/**
 * カスタム投稿タイプ: よくあるご質問 (faq)
 * タイトル = 質問、本文 = 回答。タクソノミー faq_category でカテゴリ分け。
 */
function friend2026_register_post_type_faq()
{
	$labels = array(
		'name'               => 'よくあるご質問',
		'singular_name'      => 'FAQ',
		'menu_name'          => 'よくあるご質問',
		'add_new'            => '新規追加',
		'add_new_item'       => '新規FAQを追加',
		'edit_item'          => 'FAQを編集',
		'new_item'           => '新規FAQ',
		'view_item'          => 'FAQを表示',
		'search_items'       => 'FAQを検索',
		'not_found'          => 'FAQが見つかりません',
		'not_found_in_trash' => 'ゴミ箱にFAQはありません',
	);

	$args = array(
		'labels'              => $labels,
		'public'              => false,
		'publicly_queryable'  => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'query_var'           => false,
		'capability_type'     => 'post',
		'has_archive'         => false,
		'hierarchical'        => false,
		'menu_position'       => 7,
		'menu_icon'           => 'dashicons-editor-help',
		'supports'            => array('title', 'editor', 'page-attributes'),
		'show_in_rest'        => true,
	);

	register_post_type('faq', $args);
}
add_action('init', 'friend2026_register_post_type_faq');

/**
 * FAQ カテゴリ用タクソノミー（〇〇について）
 */
function friend2026_register_taxonomy_faq_category()
{
	$labels = array(
		'name'          => 'FAQカテゴリ',
		'singular_name' => 'FAQカテゴリ',
		'search_items'  => 'カテゴリを検索',
		'all_items'     => 'すべてのカテゴリ',
		'edit_item'     => 'カテゴリを編集',
		'update_item'   => '更新',
		'add_new_item'  => '新規カテゴリ',
	);

	register_taxonomy('faq_category', 'faq', array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
	));
}
add_action('init', 'friend2026_register_taxonomy_faq_category');

/**
 * FAQ ページ用のデフォルトカテゴリを登録
 */
function friend2026_register_faq_categories()
{
	$categories = array('物件探しについて', '購入・契約について', 'サービスについて', 'その他');
	foreach ($categories as $cat_name) {
		if (! term_exists($cat_name, 'faq_category')) {
			wp_insert_term($cat_name, 'faq_category');
		}
	}
}
add_action('after_switch_theme', 'friend2026_register_faq_categories');
add_action('init', 'friend2026_register_faq_categories', 20);

/**
 * /faq を固定ページなしで表示（リライトで page-faq.php を表示）
 */
function friend2026_faq_rewrite_rules()
{
	add_rewrite_rule('^faq/?$', 'index.php?friend2026_faq=1', 'top');
}

function friend2026_faq_query_vars($vars)
{
	$vars[] = 'friend2026_faq';
	return $vars;
}

function friend2026_faq_template_include($template)
{
	if ((int) get_query_var('friend2026_faq') === 1) {
		return get_template_directory() . '/page-faq.php';
	}
	return $template;
}

function friend2026_faq_flush_on_activation()
{
	friend2026_faq_rewrite_rules();
	flush_rewrite_rules();
}
add_action('init', 'friend2026_faq_rewrite_rules');
add_action('after_switch_theme', 'friend2026_faq_flush_on_activation');
add_filter('query_vars', 'friend2026_faq_query_vars');
add_filter('template_include', 'friend2026_faq_template_include', 99);
add_filter('document_title_parts', function ($parts) {
	if ((int) get_query_var('friend2026_faq') === 1) {
		return array('title' => 'よくあるご質問', 'page' => '', 'tagline' => get_bloginfo('description'), 'site' => get_bloginfo('name'));
	}
	return $parts;
}, 99);

/**
 * カスタム投稿タイプ: お問い合わせ (inquiry) - 管理画面でのみ表示
 */
function friend2026_register_post_type_inquiry()
{
	$labels = array(
		'name'               => 'お問い合わせ',
		'singular_name'      => 'お問い合わせ',
		'menu_name'          => 'お問い合わせ',
		'add_new'            => '新規',
		'add_new_item'       => '新規お問い合わせ',
		'edit_item'          => 'お問い合わせを編集',
		'view_item'          => 'お問い合わせを表示',
		'search_items'       => 'お問い合わせを検索',
		'not_found'          => 'お問い合わせが見つかりません',
		'not_found_in_trash' => 'ゴミ箱にお問い合わせはありません',
	);

	$args = array(
		'labels'              => $labels,
		'public'              => false,
		'publicly_queryable'  => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'query_var'           => false,
		'capability_type'     => 'post',
		'has_archive'         => false,
		'hierarchical'        => false,
		'menu_position'       => 10,
		'menu_icon'           => 'dashicons-email-alt',
		'supports'            => array('title', 'editor'),
		'show_in_rest'        => false,
	);

	register_post_type('inquiry', $args);
}
add_action('init', 'friend2026_register_post_type_inquiry');

/**
 * お問い合わせフォーム送信処理（保存 + メール送信）
 */
function friend2026_contact_form_submit()
{
	if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ! isset($_POST['friend2026_contact_nonce'])) {
		return;
	}
	if (! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['friend2026_contact_nonce'])), 'friend2026_contact')) {
		return;
	}

	$type_labels = array(
		'property' => '物件について',
		'consultation' => '無料相談予約',
		'other' => 'その他',
	);

	$inquiry_type = isset($_POST['inquiry_type']) ? sanitize_text_field(wp_unslash($_POST['inquiry_type'])) : '';
	if (! in_array($inquiry_type, array('property', 'consultation', 'other'), true)) {
		$inquiry_type = 'other';
	}

	$last_name  = isset($_POST['last_name']) ? sanitize_text_field(wp_unslash($_POST['last_name'])) : '';
	$first_name = isset($_POST['first_name']) ? sanitize_text_field(wp_unslash($_POST['first_name'])) : '';
	$furigana_last  = isset($_POST['furigana_last']) ? sanitize_text_field(wp_unslash($_POST['furigana_last'])) : '';
	$furigana_first = isset($_POST['furigana_first']) ? sanitize_text_field(wp_unslash($_POST['furigana_first'])) : '';
	$email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
	$phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
	$message = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';
	$agree = isset($_POST['agree_privacy']) && $_POST['agree_privacy'] === '1';

	$errors = array();
	if ($last_name === '') {
		$errors[] = 'お名前（姓）を入力してください。';
	}
	if ($first_name === '') {
		$errors[] = 'お名前（名）を入力してください。';
	}
	if ($email === '' || ! is_email($email)) {
		$errors[] = '有効なメールアドレスを入力してください。';
	}
	if ($phone === '') {
		$errors[] = '電話番号を入力してください。';
	}
	if ($message === '') {
		$errors[] = 'お問い合わせ内容を入力してください。';
	}
	if (! $agree) {
		$errors[] = 'プライバシーポリシーに同意してください。';
	}

	if (! empty($errors)) {
		return array('success' => false, 'errors' => $errors);
	}

	$title = 'お問い合わせ: ' . $last_name . ' ' . $first_name . ' - ' . date_i18n('Y-m-d H:i');
	$post_id = wp_insert_post(array(
		'post_type'   => 'inquiry',
		'post_title'  => $title,
		'post_content' => $message,
		'post_status' => 'publish',
		'post_author' => 1,
	));

	if (is_wp_error($post_id)) {
		return array('success' => false, 'errors' => array('保存に失敗しました。'));
	}

	$meta = array(
		'inquiry_type'   => $inquiry_type,
		'last_name'     => $last_name,
		'first_name'    => $first_name,
		'furigana_last'  => $furigana_last,
		'furigana_first' => $furigana_first,
		'email'         => $email,
		'phone'         => $phone,
	);
	foreach ($meta as $key => $value) {
		update_post_meta($post_id, $key, $value);
	}

	$recipients = friend2026_get_contact_notification_emails();
	$subject    = '【お問い合わせ】' . $last_name . ' ' . $first_name . ' 様';
	$body       = "以下の内容でお問い合わせがありました。\n\n";
	$body      .= "お問い合わせ種別: " . (isset($type_labels[$inquiry_type]) ? $type_labels[$inquiry_type] : $inquiry_type) . "\n";
	$body      .= "お名前: " . $last_name . ' ' . $first_name . "\n";
	$body      .= "フリガナ: " . $furigana_last . ' ' . $furigana_first . "\n";
	$body      .= "メールアドレス: " . $email . "\n";
	$body      .= "電話番号: " . $phone . "\n\n";
	$body      .= "お問い合わせ内容:\n" . $message . "\n";
	$body      .= "\n--\nこのメールはサイトのお問い合わせフォームから送信されました。";

	$headers   = array('Content-Type: text/plain; charset=UTF-8');
	$headers[] = 'Reply-To: ' . $email;
	foreach ($recipients as $to) {
		wp_mail($to, $subject, $body, $headers);
	}

	return array('success' => true);
}

/**
 * /contact リライト（固定ページなしでお問い合わせページを表示）
 */
function friend2026_contact_rewrite_rules()
{
	add_rewrite_rule('^contact/?$', 'index.php?friend2026_contact=1', 'top');
}

function friend2026_contact_query_vars($vars)
{
	$vars[] = 'friend2026_contact';
	return $vars;
}

function friend2026_contact_template_include($template)
{
	if ((int) get_query_var('friend2026_contact') === 1) {
		return get_template_directory() . '/page-contact.php';
	}
	return $template;
}

add_action('init', 'friend2026_contact_rewrite_rules');
add_filter('query_vars', 'friend2026_contact_query_vars');
add_filter('template_include', 'friend2026_contact_template_include', 99);
add_filter('document_title_parts', function ($parts) {
	if ((int) get_query_var('friend2026_contact') === 1) {
		return array('title' => 'お問い合わせ', 'page' => '', 'tagline' => get_bloginfo('description'), 'site' => get_bloginfo('name'));
	}
	return $parts;
}, 99);

function friend2026_contact_flush_on_activation()
{
	friend2026_contact_rewrite_rules();
	flush_rewrite_rules();
}
add_action('after_switch_theme', 'friend2026_contact_flush_on_activation');

/**
 * /sitemap リライト（固定ページなしで page-sitemap.php を表示）
 *
 * page-sitemap.php は従来、スラッグ sitemap の固定ページがあるときのみ使われる。
 * フッターは /sitemap/ を指すため、contact / faq と同様に仮想 URL でテンプレートを出す。
 */
function friend2026_sitemap_rewrite_rules()
{
	add_rewrite_rule('^sitemap/?$', 'index.php?friend2026_sitemap=1', 'top');
}

function friend2026_sitemap_query_vars($vars)
{
	$vars[] = 'friend2026_sitemap';
	return $vars;
}

function friend2026_sitemap_template_include($template)
{
	if ((int) get_query_var('friend2026_sitemap') === 1) {
		return get_template_directory() . '/page-sitemap.php';
	}
	return $template;
}

add_action('init', 'friend2026_sitemap_rewrite_rules');
add_filter('query_vars', 'friend2026_sitemap_query_vars');
add_filter('template_include', 'friend2026_sitemap_template_include', 99);
add_filter('document_title_parts', function ($parts) {
	if ((int) get_query_var('friend2026_sitemap') === 1) {
		return array(
			'title'   => 'サイトマップ',
			'page'    => '',
			'tagline' => get_bloginfo('description'),
			'site'    => get_bloginfo('name'),
		);
	}
	return $parts;
}, 99);

function friend2026_sitemap_flush_on_activation()
{
	friend2026_sitemap_rewrite_rules();
	flush_rewrite_rules();
}
add_action('after_switch_theme', 'friend2026_sitemap_flush_on_activation');

/**
 * ニュース一覧の URL（投稿ページが設定されていればその固定ページ、なければ /news/ 仮想アーカイブ）
 */
function friend2026_get_news_archive_url()
{
	$page_id = (int) get_option('page_for_posts');
	if ($page_id > 0) {
		return get_permalink($page_id);
	}
	return trailingslashit(home_url('/news'));
}

/**
 * /news 投稿一覧（表示設定で「投稿ページ」未指定でも一覧を出す）
 *
 * 投稿ページを設定した場合は WordPress 標準の URL のみ使う（/news リライトは登録しない）。
 */
function friend2026_news_archive_rewrite_rules()
{
	if ((int) get_option('page_for_posts') > 0) {
		return;
	}
	add_rewrite_rule('^news/page/([0-9]{1,})/?$', 'index.php?friend2026_news_archive=1&paged=$matches[1]', 'top');
	add_rewrite_rule('^news/?$', 'index.php?friend2026_news_archive=1', 'top');
}

function friend2026_news_archive_query_vars($vars)
{
	$vars[] = 'friend2026_news_archive';
	return $vars;
}

function friend2026_news_archive_pre_get_posts($query)
{
	if (is_admin() || ! $query->is_main_query()) {
		return;
	}
	if ((int) get_query_var('friend2026_news_archive') !== 1) {
		return;
	}
	$query->set('post_type', 'post');
	$query->set('ignore_sticky_posts', true);
}

function friend2026_news_archive_template_include($template)
{
	if ((int) get_query_var('friend2026_news_archive') !== 1) {
		return $template;
	}
	return get_template_directory() . '/home.php';
}

add_action('init', 'friend2026_news_archive_rewrite_rules');
add_filter('query_vars', 'friend2026_news_archive_query_vars');
add_action('pre_get_posts', 'friend2026_news_archive_pre_get_posts');
add_filter('template_include', 'friend2026_news_archive_template_include', 99);
add_filter('pre_handle_404', function ($preempt, $wp_query) {
	if ($wp_query instanceof WP_Query && (int) $wp_query->get('friend2026_news_archive') === 1) {
		return true;
	}
	return $preempt;
}, 10, 2);
add_filter('document_title_parts', function ($parts) {
	if ((int) get_query_var('friend2026_news_archive') !== 1) {
		return $parts;
	}
	$paged = (int) get_query_var('paged');
	if ($paged > 1) {
		$parts['title'] = sprintf('%dページ目', $paged) . ' ‹ ニュース';
	} else {
		$parts['title'] = 'ニュース';
	}
	$parts['page']    = '';
	$parts['tagline'] = get_bloginfo('description');
	$parts['site']    = get_bloginfo('name');
	return $parts;
}, 99);

function friend2026_news_archive_flush_on_activation()
{
	friend2026_news_archive_rewrite_rules();
	flush_rewrite_rules();
}
add_action('after_switch_theme', 'friend2026_news_archive_flush_on_activation');

add_action(
	'update_option_page_for_posts',
	function ($old_value, $value) {
		if ((int) $old_value !== (int) $value) {
			flush_rewrite_rules(false);
		}
	},
	10,
	2
);

/**
 * お問い合わせ詳細を管理画面に表示するメタボックス
 */
function friend2026_inquiry_meta_box()
{
	add_meta_box('friend2026_inquiry_details', '送信内容', 'friend2026_inquiry_meta_box_cb', 'inquiry', 'normal');
}

function friend2026_inquiry_meta_box_cb($post)
{
	$last_name  = get_post_meta($post->ID, 'last_name', true);
	$first_name = get_post_meta($post->ID, 'first_name', true);
	$furigana_last  = get_post_meta($post->ID, 'furigana_last', true);
	$furigana_first = get_post_meta($post->ID, 'furigana_first', true);
	$email = get_post_meta($post->ID, 'email', true);
	$phone = get_post_meta($post->ID, 'phone', true);
	$type = get_post_meta($post->ID, 'inquiry_type', true);
	$type_labels = array('property' => '物件について', 'consultation' => '無料相談予約', 'other' => 'その他');
	$type_text = isset($type_labels[$type]) ? $type_labels[$type] : $type;
?>
<table class="form-table">
  <tr>
    <th>お問い合わせ種別</th>
    <td><?php echo esc_html($type_text); ?></td>
  </tr>
  <tr>
    <th>お名前</th>
    <td><?php echo esc_html($last_name . ' ' . $first_name); ?></td>
  </tr>
  <tr>
    <th>フリガナ</th>
    <td><?php echo esc_html($furigana_last . ' ' . $furigana_first); ?></td>
  </tr>
  <tr>
    <th>メールアドレス</th>
    <td><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></td>
  </tr>
  <tr>
    <th>電話番号</th>
    <td><?php echo esc_html($phone); ?></td>
  </tr>
</table>
<p><strong>お問い合わせ内容</strong></p>
<div style="background:#f9f9f9; padding:1em; border:1px solid #ddd;"><?php echo nl2br(esc_html($post->post_content)); ?>
</div>
<?php
}

add_action('add_meta_boxes', 'friend2026_inquiry_meta_box');

/**
 * ニュース用カテゴリ（投稿のデフォルトカテゴリとして使用）
 * 成約 / 新規公開 / お知らせ / イベント / その他 を登録
 */
function friend2026_register_news_categories()
{
	$categories = array('成約', '新規公開', 'お知らせ', 'イベント', 'その他');
	foreach ($categories as $cat_name) {
		if (! term_exists($cat_name, 'category')) {
			wp_insert_term($cat_name, 'category');
		}
	}
}
add_action('after_switch_theme', 'friend2026_register_news_categories');

/**
 * 物件用カスタムフィールドのメタキー登録（REST / 編集画面用）
 * 実際の入力は管理画面 or 後から ACF で。ここではキーだけ登録。
 */
function friend2026_register_property_meta()
{
	$meta_keys = array(
		'property_price'       => array('type' => 'number', 'single' => true),
		'property_price_label' => array('type' => 'string', 'single' => true),
		'property_address'     => array('type' => 'string', 'single' => true),
		'property_area'        => array('type' => 'string', 'single' => true),
		'property_station'      => array('type' => 'string', 'single' => true),
		'property_walk_minutes' => array('type' => 'number', 'single' => true),
		'property_building_area' => array('type' => 'number', 'single' => true),
		'property_land_area'    => array('type' => 'number', 'single' => true),
		'property_floor_plan'   => array('type' => 'string', 'single' => true),
		'property_built_year'   => array('type' => 'number', 'single' => true),
		'property_floors'       => array('type' => 'number', 'single' => true),
		'property_total_units' => array('type' => 'number', 'single' => true),
		'property_features'    => array('type' => 'string', 'single' => true),
		'property_description' => array('type' => 'string', 'single' => true),
		'property_is_new'       => array('type' => 'boolean', 'single' => true),
		'property_is_recommended' => array('type' => 'boolean', 'single' => true),
		'property_is_price_down' => array('type' => 'boolean', 'single' => true),
		'property_open_house'   => array('type' => 'boolean', 'single' => true),
		'property_gallery_ids'  => array('type' => 'string', 'single' => true),
	);

	foreach ($meta_keys as $key => $args) {
		register_post_meta('property', $key, array(
			'show_in_rest'  => true,
			'single'        => $args['single'],
			'type'          => $args['type'],
			'auth_callback' => function () {
				return current_user_can('edit_posts');
			},
		));
	}
}
add_action('init', 'friend2026_register_property_meta');

/**
 * 物件一覧のフィルター（GET パラメータ: recommended, openhouse, pricedown, new, type）
 */
function friend2026_property_archive_query($query)
{
	if (! is_admin() && $query->is_main_query() && $query->is_post_type_archive('property')) {
		$meta_query = array();

		if (! empty($_GET['recommended']) && $_GET['recommended'] === '1') {
			$meta_query[] = array('key' => 'property_is_recommended', 'value' => '1');
		}
		if (! empty($_GET['openhouse']) && $_GET['openhouse'] === '1') {
			$meta_query[] = array('key' => 'property_open_house', 'value' => '1');
		}
		if (! empty($_GET['pricedown']) && $_GET['pricedown'] === '1') {
			$meta_query[] = array('key' => 'property_is_price_down', 'value' => '1');
		}
		if (! empty($_GET['new']) && $_GET['new'] === '1') {
			$meta_query[] = array('key' => 'property_is_new', 'value' => '1');
		}

		if (! empty($meta_query)) {
			$query->set('meta_query', $meta_query);
		}

		$type = isset($_GET['type']) ? sanitize_text_field(wp_unslash($_GET['type'])) : '';
		if ($type !== '') {
			$query->set('tax_query', array(array(
				'taxonomy' => 'property_type',
				'field'    => 'slug',
				'terms'    => $type,
			)));
		}

		$orderby = isset($_GET['orderby']) ? sanitize_text_field(wp_unslash($_GET['orderby'])) : '';
		if ($orderby === 'price-low') {
			$query->set('meta_key', 'property_price');
			$query->set('orderby', 'meta_value_num');
			$query->set('order', 'ASC');
		} elseif ($orderby === 'price-high') {
			$query->set('meta_key', 'property_price');
			$query->set('orderby', 'meta_value_num');
			$query->set('order', 'DESC');
		} else {
			// 価格ソート以外は管理画面の「表示順」（menu_order）→ 日付の新しい順
			$query->set(
				'orderby',
				array(
					'menu_order' => 'ASC',
					'date'       => 'DESC',
				)
			);
		}
	}
}
add_action('pre_get_posts', 'friend2026_property_archive_query');

/**
 * iframe タグまたは文字列から地図の埋め込みURL（src）を取得する
 * そのままのURLが渡された場合はそのまま返す
 *
 * @param string $input 入力（iframe タグ全体 or 埋め込みURL）
 * @return string 埋め込み用URL（空の場合は ''）
 */
function friend2026_extract_embed_src($input)
{
	$input = trim((string) $input);
	if ($input === '') {
		return '';
	}
	// iframe タグ内の src="..." または src='...' を抽出
	if (preg_match('/src\s*=\s*["\']([^"\']+)["\']/i', $input, $m)) {
		return trim($m[1]);
	}
	// すでにURLのみの場合はそのまま
	return $input;
}

/** お問い合わせ通知メールの保存上限（乱用防止） */
const FRIEND2026_CONTACT_EMAIL_MAX = 50;

/**
 * POST から通知用メール一覧を取得（最大 FRIEND2026_CONTACT_EMAIL_MAX 件・重複除去）
 *
 * @param string $field_name フォームの name（既定: contact_emails）
 * @return string[]
 */
function friend2026_parse_contact_emails_post($field_name = 'contact_emails')
{
	$out = array();
	if (! isset($_POST[$field_name]) || ! is_array($_POST[$field_name])) {
		return $out;
	}
	foreach ($_POST[$field_name] as $raw) {
		$e = sanitize_email(wp_unslash($raw));
		if ($e !== '' && is_email($e)) {
			$out[] = $e;
		}
		if (count($out) >= FRIEND2026_CONTACT_EMAIL_MAX) {
			break;
		}
	}
	return array_values(array_unique($out));
}

/**
 * 管理画面: 転送先メール入力行（「メールアドレスを追加」で行を増やせる）
 *
 * @param string[] $emails 既存アドレス（空配列なら空行1つ）
 */
function friend2026_render_admin_contact_email_fields($emails)
{
	$rows = array();
	if (! empty($emails) && is_array($emails)) {
		foreach ($emails as $e) {
			$rows[] = is_string($e) ? $e : '';
		}
	}
	if (empty($rows)) {
		$rows = array('');
	}
	$max = (int) FRIEND2026_CONTACT_EMAIL_MAX;
?>
<div id="friend2026-contact-emails" class="friend2026-contact-emails" data-max="<?php echo esc_attr((string) $max); ?>">
  <ol style="margin:0; padding-left:0; list-style:none;">
    <?php foreach ($rows as $ev) : ?>
    <li class="friend2026-contact-email-row"
      style="display:flex; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:8px;">
      <input type="email" name="contact_emails[]" class="regular-text" value="<?php echo esc_attr($ev); ?>"
        placeholder="example@example.com" autocomplete="email" style="flex:1; min-width:12rem; max-width:28rem;">
      <button type="button" class="button friend2026-contact-email-remove" aria-label="この行を削除">削除</button>
    </li>
    <?php endforeach; ?>
  </ol>
  <p style="margin:8px 0 0;">
    <button type="button" class="button button-secondary" id="friend2026-contact-email-add">メールアドレスを追加</button>
  </p>
</div>
<script>
(function() {
  var root = document.getElementById('friend2026-contact-emails');
  if (!root) return;
  var max = parseInt(root.getAttribute('data-max'), 10) || 50;
  var list = root.querySelector('ol');
  var addBtn = document.getElementById('friend2026-contact-email-add');

  function rowCount() {
    return list ? list.querySelectorAll('.friend2026-contact-email-row').length : 0;
  }

  function bindRemove(li) {
    var btn = li.querySelector('.friend2026-contact-email-remove');
    if (!btn) return;
    btn.addEventListener('click', function() {
      if (rowCount() <= 1) {
        var inp = li.querySelector('input[type="email"]');
        if (inp) inp.value = '';
        return;
      }
      li.remove();
    });
  }
  if (list) {
    list.querySelectorAll('.friend2026-contact-email-row').forEach(bindRemove);
  }
  if (addBtn && list) {
    addBtn.addEventListener('click', function() {
      if (rowCount() >= max) return;
      var li = document.createElement('li');
      li.className = 'friend2026-contact-email-row';
      li.style.cssText = 'display:flex; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:8px;';
      li.innerHTML =
        '<input type="email" name="contact_emails[]" class="regular-text" value="" placeholder="example@example.com" autocomplete="email" style="flex:1; min-width:12rem; max-width:28rem;">' +
        '<button type="button" class="button friend2026-contact-email-remove" aria-label="この行を削除">削除</button>';
      list.appendChild(li);
      bindRemove(li);
    });
  }
})();
</script>
<?php
}

/**
 * お問い合わせ通知の送信先メール一覧（空のときは管理者メール 1 件）
 *
 * @return string[]
 */
function friend2026_get_contact_notification_emails()
{
	$d = friend2026_get_company_data();
	$list = array();
	if (! empty($d['contact_emails']) && is_array($d['contact_emails'])) {
		foreach ($d['contact_emails'] as $e) {
			$e = is_string($e) ? sanitize_email($e) : '';
			if ($e !== '' && is_email($e)) {
				$list[] = $e;
			}
		}
	}
	$list = array_values(array_unique($list));
	if (! empty($list)) {
		return $list;
	}
	$admin = get_option('admin_email');
	if ($admin && is_email($admin)) {
		return array($admin);
	}
	return array();
}

/**
 * 会社概要・店舗案内のオプション（管理画面から編集）
 */
function friend2026_get_company_data()
{
	$default = array(
		'heading_label'           => 'Company',
		'heading_title'           => '会社概要',
		'heading_description'     => '会社情報や店舗案内をご案内します。',
		'section_title_philosophy' => '企業理念',
		'section_title_promises'   => '私たちの約束',
		'section_title_company'    => '会社情報',
		'section_title_branches'   => '店舗案内・アクセス',
		'company_name'          => '有限会社ふれんど',
		'company_representative' => '山田 太郎',
		'company_established'     => '2015年4月1日',
		'company_capital'        => '5,000万円',
		'company_employees'      => '35名 (2025年1月現在)',
		'company_business'       => '不動産売買仲介、不動産賃貸仲介、不動産管理、リフォーム事業',
		'company_license'        => '宅地建物取引業者免許 東京都知事(1)第000000号',
		'company_affiliations'   => '(公社)全日本不動産協会会員、(公社)不動産保証協会会員',
		'contact_email'         => 'ariyasu@friend2026.co.jp',
		'contact_emails'        => array(),
		'philosophy_catchphrase' => '「住まい」にプラスの価値を。お客様の未来をつなぐ架け橋に。',
		'philosophy_description' => '私たちは、お客様の「住まい」に関するあらゆるご相談に、誠実かつ専門的な知識をもってお応えします。ライフスタイルや将来設計に合わせた最適な提案を通じ、お客様の未来につながる架け橋であり続けます。',
		'promises'               => array(
			array(
				'title' => '誠実な対応',
				'text'  => 'お取引の際は常に誠実さを心がけ、お客様に安心していただける対応を心がけています。',
			),
			array(
				'title' => 'お客様第一',
				'text'  => 'お客様の視点に立ち、最適なご提案をさせていただくことを目指しています。',
			),
			array(
				'title' => '専門性の追求',
				'text'  => '最新の知識を習得し、高度な専門サービスをご提供できるよう努めています。',
			),
		),
		'branches' => array(
			array(
				'name'     => '本店',
				'address'  => "〒183-0005\n東京都府中市若松町1-2-7 3F",
				'phone'    => '0120-123-456',
				'access'   => '京王線「府中」駅・JR南武線「府中本町」駅 徒歩圏内',
				'hours'    => '9:00~19:00 (水曜定休)',
				'map_url'  => '',
			),
		),
	);
	$saved  = get_option('friend2026_company_data', array());
	$result = wp_parse_args($saved, $default);
	foreach (
		array(
			'heading_label',
			'heading_title',
			'heading_description',
			'section_title_philosophy',
			'section_title_promises',
			'section_title_company',
			'section_title_branches',
		) as $heading_key
	) {
		if (! is_string($result[$heading_key]) || $result[$heading_key] === '') {
			$result[$heading_key] = $default[$heading_key];
		}
	}

	// 通知メール一覧（最大 FRIEND2026_CONTACT_EMAIL_MAX 件）と表示用 contact_email
	$emails = array();
	if (! empty($result['contact_emails']) && is_array($result['contact_emails'])) {
		foreach ($result['contact_emails'] as $e) {
			$e = is_string($e) ? sanitize_email($e) : '';
			if ($e !== '' && is_email($e)) {
				$emails[] = $e;
			}
			if (count($emails) >= FRIEND2026_CONTACT_EMAIL_MAX) {
				break;
			}
		}
	}
	$emails = array_values(array_unique($emails));
	if (empty($emails) && ! empty($result['contact_email'])) {
		$legacy = sanitize_email($result['contact_email']);
		if ($legacy !== '' && is_email($legacy)) {
			$emails[] = $legacy;
		}
	}
	$result['contact_emails'] = $emails;
	$result['contact_email']  = ! empty($emails[0]) ? $emails[0] : '';

	return $result;
}

function friend2026_company_admin_menu()
{
	add_menu_page(
		'会社情報・店舗',
		'会社情報・店舗',
		'manage_options',
		'friend2026-company',
		'friend2026_company_options_page',
		'dashicons-building',
		8
	);
}

function friend2026_company_options_page()
{
	if (! current_user_can('manage_options')) {
		return;
	}
	if (isset($_POST['friend2026_company_save']) && check_admin_referer('friend2026_company_options')) {
		$data = array(
			'heading_label'           => isset($_POST['heading_label']) ? sanitize_text_field(wp_unslash($_POST['heading_label'])) : '',
			'heading_title'           => isset($_POST['heading_title']) ? sanitize_text_field(wp_unslash($_POST['heading_title'])) : '',
			'heading_description'     => isset($_POST['heading_description']) ? sanitize_textarea_field(wp_unslash($_POST['heading_description'])) : '',
			'section_title_philosophy' => isset($_POST['section_title_philosophy']) ? sanitize_text_field(wp_unslash($_POST['section_title_philosophy'])) : '',
			'section_title_promises'   => isset($_POST['section_title_promises']) ? sanitize_text_field(wp_unslash($_POST['section_title_promises'])) : '',
			'section_title_company'    => isset($_POST['section_title_company']) ? sanitize_text_field(wp_unslash($_POST['section_title_company'])) : '',
			'section_title_branches'   => isset($_POST['section_title_branches']) ? sanitize_text_field(wp_unslash($_POST['section_title_branches'])) : '',
			'company_name'          => isset($_POST['company_name']) ? sanitize_text_field(wp_unslash($_POST['company_name'])) : '',
			'company_representative' => isset($_POST['company_representative']) ? sanitize_text_field(wp_unslash($_POST['company_representative'])) : '',
			'company_established'   => isset($_POST['company_established']) ? sanitize_text_field(wp_unslash($_POST['company_established'])) : '',
			'company_capital'       => isset($_POST['company_capital']) ? sanitize_text_field(wp_unslash($_POST['company_capital'])) : '',
			'company_employees'     => isset($_POST['company_employees']) ? sanitize_text_field(wp_unslash($_POST['company_employees'])) : '',
			'company_business'      => isset($_POST['company_business']) ? sanitize_textarea_field(wp_unslash($_POST['company_business'])) : '',
			'company_license'       => isset($_POST['company_license']) ? sanitize_text_field(wp_unslash($_POST['company_license'])) : '',
			'company_affiliations'  => isset($_POST['company_affiliations']) ? sanitize_textarea_field(wp_unslash($_POST['company_affiliations'])) : '',
			'contact_emails'        => friend2026_parse_contact_emails_post('contact_emails'),
			'philosophy_catchphrase' => isset($_POST['philosophy_catchphrase']) ? sanitize_text_field(wp_unslash($_POST['philosophy_catchphrase'])) : '',
			'philosophy_description' => isset($_POST['philosophy_description']) ? sanitize_textarea_field(wp_unslash($_POST['philosophy_description'])) : '',
			'promises'              => array(),
			'branches'              => array(),
		);
		for ($i = 0; $i < 3; $i++) {
			$data['promises'][] = array(
				'title' => isset($_POST['promise_title'][$i]) ? sanitize_text_field(wp_unslash($_POST['promise_title'][$i])) : '',
				'text'  => isset($_POST['promise_text'][$i]) ? sanitize_textarea_field(wp_unslash($_POST['promise_text'][$i])) : '',
			);
		}
		$branch_names = isset($_POST['branch_name']) && is_array($_POST['branch_name']) ? $_POST['branch_name'] : array();
		foreach ($branch_names as $idx => $name) {
			$name = sanitize_text_field(wp_unslash($name));
			if ($name === '') {
				continue;
			}
			$map_input = isset($_POST['branch_map_url'][$idx]) ? wp_unslash($_POST['branch_map_url'][$idx]) : '';
			$map_url   = friend2026_extract_embed_src($map_input);
			$map_url   = $map_url !== '' ? esc_url_raw($map_url) : '';

			$data['branches'][] = array(
				'name'    => $name,
				'address' => isset($_POST['branch_address'][$idx]) ? sanitize_textarea_field(wp_unslash($_POST['branch_address'][$idx])) : '',
				'phone'   => isset($_POST['branch_phone'][$idx]) ? sanitize_text_field(wp_unslash($_POST['branch_phone'][$idx])) : '',
				'access'  => isset($_POST['branch_access'][$idx]) ? sanitize_text_field(wp_unslash($_POST['branch_access'][$idx])) : '',
				'hours'   => isset($_POST['branch_hours'][$idx]) ? sanitize_text_field(wp_unslash($_POST['branch_hours'][$idx])) : '',
				'map_url' => $map_url,
			);
		}
		update_option('friend2026_company_data', $data);
		// 本番の Redis / Memcached 等で get_option が古い値を返す場合の対策
		wp_cache_delete('friend2026_company_data', 'options');
		echo '<div class="notice notice-success"><p>保存しました。</p></div>';
	}
	$d = friend2026_get_company_data();
?>
<div class="wrap">
  <h1>会社情報・店舗</h1>
  <p>会社概要ページ（/company）に表示する内容と、店舗案内・アクセスを編集できます。</p>
  <form method="post" action="">
    <?php wp_nonce_field('friend2026_company_options'); ?>
    <input type="hidden" name="friend2026_company_save" value="1">

    <h2 class="title">ページ見出し・セクションタイトル</h2>
    <p class="description">フロントの会社概要ページに表示される英字ラベル・タイトル・説明、各ブロックの見出し（h2）を変更できます。</p>
    <table class="form-table">
      <tr>
        <th><label for="heading_label">英字ラベル</label></th>
        <td><input type="text" id="heading_label" name="heading_label" class="regular-text"
            value="<?php echo esc_attr($d['heading_label']); ?>" placeholder="Company"></td>
      </tr>
      <tr>
        <th><label for="heading_title">ページタイトル</label></th>
        <td><input type="text" id="heading_title" name="heading_title" class="regular-text"
            value="<?php echo esc_attr($d['heading_title']); ?>" placeholder="会社概要"></td>
      </tr>
      <tr>
        <th><label for="heading_description">ページ説明文</label></th>
        <td><textarea id="heading_description" name="heading_description" rows="2"
            class="large-text"><?php echo esc_textarea($d['heading_description']); ?></textarea></td>
      </tr>
      <tr>
        <th><label for="section_title_philosophy">見出し：企業理念</label></th>
        <td><input type="text" id="section_title_philosophy" name="section_title_philosophy" class="regular-text"
            value="<?php echo esc_attr($d['section_title_philosophy']); ?>"></td>
      </tr>
      <tr>
        <th><label for="section_title_promises">見出し：私たちの約束</label></th>
        <td><input type="text" id="section_title_promises" name="section_title_promises" class="regular-text"
            value="<?php echo esc_attr($d['section_title_promises']); ?>"></td>
      </tr>
      <tr>
        <th><label for="section_title_company">見出し：会社情報</label></th>
        <td><input type="text" id="section_title_company" name="section_title_company" class="regular-text"
            value="<?php echo esc_attr($d['section_title_company']); ?>"></td>
      </tr>
      <tr>
        <th><label for="section_title_branches">見出し：店舗案内・アクセス</label></th>
        <td><input type="text" id="section_title_branches" name="section_title_branches" class="regular-text"
            value="<?php echo esc_attr($d['section_title_branches']); ?>"></td>
      </tr>
    </table>

    <h2 class="title">会社情報（項目の内容）</h2>
    <table class="form-table">
      <tr>
        <th><label for="company_name">会社名</label></th>
        <td><input type="text" id="company_name" name="company_name" value="<?php echo esc_attr($d['company_name']); ?>"
            class="regular-text"></td>
      </tr>
      <tr>
        <th><label for="company_representative">代表取締役</label></th>
        <td><input type="text" id="company_representative" name="company_representative"
            value="<?php echo esc_attr($d['company_representative']); ?>" class="regular-text"></td>
      </tr>
      <tr>
        <th><label for="company_established">設立</label></th>
        <td><input type="text" id="company_established" name="company_established"
            value="<?php echo esc_attr($d['company_established']); ?>" class="regular-text"></td>
      </tr>
      <tr>
        <th><label for="company_capital">資本金</label></th>
        <td><input type="text" id="company_capital" name="company_capital"
            value="<?php echo esc_attr($d['company_capital']); ?>" class="regular-text"></td>
      </tr>
      <tr>
        <th><label for="company_employees">従業員数</label></th>
        <td><input type="text" id="company_employees" name="company_employees"
            value="<?php echo esc_attr($d['company_employees']); ?>" class="regular-text"></td>
      </tr>
      <tr>
        <th><label for="company_business">事業内容</label></th>
        <td><textarea id="company_business" name="company_business" rows="2"
            class="large-text"><?php echo esc_textarea($d['company_business']); ?></textarea></td>
      </tr>
      <tr>
        <th><label for="company_license">免許番号</label></th>
        <td><input type="text" id="company_license" name="company_license"
            value="<?php echo esc_attr($d['company_license']); ?>" class="large-text"></td>
      </tr>
      <tr>
        <th><label for="company_affiliations">所属団体</label></th>
        <td><textarea id="company_affiliations" name="company_affiliations" rows="2"
            class="large-text"><?php echo esc_textarea($d['company_affiliations']); ?></textarea></td>
      </tr>
      <tr>
        <th>お問い合わせ通知メール</th>
        <td>
          <p class="description" style="margin-top:0;">
            フォーム送信時に、登録した宛先へそれぞれ同じ内容の通知メールを送ります。<strong>メールアドレスを追加</strong>で行を増やせます（保存上限
            <?php echo (int) FRIEND2026_CONTACT_EMAIL_MAX; ?> 件）。空欄は無視されます。すべて空のときは管理者メール（設定 → 一般）へ送ります。</p>
          <?php
						$ce_list = ! empty($d['contact_emails']) && is_array($d['contact_emails']) ? $d['contact_emails'] : array();
						friend2026_render_admin_contact_email_fields($ce_list);
						?>
        </td>
      </tr>
    </table>

    <h2 class="title">企業理念</h2>
    <table class="form-table">
      <tr>
        <th><label for="philosophy_catchphrase">キャッチフレーズ</label></th>
        <td><input type="text" id="philosophy_catchphrase" name="philosophy_catchphrase"
            value="<?php echo esc_attr($d['philosophy_catchphrase']); ?>" class="large-text"></td>
      </tr>
      <tr>
        <th><label for="philosophy_description">説明文</label></th>
        <td><textarea id="philosophy_description" name="philosophy_description" rows="4"
            class="large-text"><?php echo esc_textarea($d['philosophy_description']); ?></textarea></td>
      </tr>
    </table>

    <h2 class="title">私たちの約束（3つ）</h2>
    <table class="form-table">
      <?php for ($i = 0; $i < 3; $i++) : $p = isset($d['promises'][$i]) ? $d['promises'][$i] : array('title' => '', 'text' => ''); ?>
      <tr>
        <th><?php echo (int) ($i + 1); ?>.</th>
        <td>
          <input type="text" name="promise_title[<?php echo $i; ?>]" value="<?php echo esc_attr($p['title']); ?>"
            class="regular-text" placeholder="タイトル">
          <textarea name="promise_text[<?php echo $i; ?>]" rows="2" class="large-text" style="margin-top:6px"
            placeholder="説明"><?php echo esc_textarea($p['text']); ?></textarea>
        </td>
      </tr>
      <?php endfor; ?>
    </table>

    <h2 class="title">店舗案内・アクセス</h2>
    <p class="description">
      店舗を追加・編集できます。不要な店舗は各ブロックの「この店舗を削除」で消してから<strong>保存</strong>してください。地図は「地図（iframe）」欄に、<strong>Google
        マップの「共有」→「地図を埋め込む」で表示される iframe
        タグをそのまま貼り付け</strong>ても、埋め込みURLだけを貼り付けても利用できます。ページに地図が直接表示されます。</p>
    <div id="company-branches">
      <?php
				$branches = ! empty($d['branches']) ? $d['branches'] : array(array('name' => '', 'address' => '', 'phone' => '', 'access' => '', 'hours' => '', 'map_url' => ''));
				foreach ($branches as $idx => $b) :
					$b = wp_parse_args($b, array('name' => '', 'address' => '', 'phone' => '', 'access' => '', 'hours' => '', 'map_url' => ''));
				?>
      <div class="company-branch-box"
        style="border:1px solid #ccc; padding:12px; margin-bottom:12px; background:#f9f9f9;">
        <p><strong>店舗 <?php echo (int) ($idx + 1); ?></strong></p>
        <table class="form-table">
          <tr>
            <th>店舗名</th>
            <td><input type="text" name="branch_name[<?php echo $idx; ?>]" value="<?php echo esc_attr($b['name']); ?>"
                class="regular-text" placeholder="例: 本店"></td>
          </tr>
          <tr>
            <th>住所</th>
            <td><textarea name="branch_address[<?php echo $idx; ?>]" rows="2"
                class="large-text"><?php echo esc_textarea($b['address']); ?></textarea></td>
          </tr>
          <tr>
            <th>電話</th>
            <td><input type="text" name="branch_phone[<?php echo $idx; ?>]" value="<?php echo esc_attr($b['phone']); ?>"
                class="regular-text"></td>
          </tr>
          <tr>
            <th>アクセス</th>
            <td><input type="text" name="branch_access[<?php echo $idx; ?>]"
                value="<?php echo esc_attr($b['access']); ?>" class="large-text" placeholder="例: 京王新線「初台」駅 徒歩5分"></td>
          </tr>
          <tr>
            <th>営業時間</th>
            <td><input type="text" name="branch_hours[<?php echo $idx; ?>]" value="<?php echo esc_attr($b['hours']); ?>"
                class="regular-text" placeholder="例: 9:00~19:00 (水曜定休)"></td>
          </tr>
          <tr>
            <th>地図（iframe）</th>
            <td><textarea name="branch_map_url[<?php echo $idx; ?>]" rows="3" class="large-text"
                placeholder="&lt;iframe src=&quot;https://www.google.com/maps/embed?pb=...&quot; ...&gt;&lt;/iframe&gt; または URL を貼り付け"><?php echo esc_textarea($b['map_url']); ?></textarea><br><span
                class="description">iframe タグ全体、または埋め込みURLのどちらでも可</span></td>
          </tr>
        </table>
        <p><button type="button" class="button company-remove-branch">この店舗を削除</button></p>
      </div>
      <?php endforeach; ?>
    </div>
    <p><button type="button" class="button" id="company-add-branch">店舗を追加</button></p>

    <p class="submit"><input type="submit" class="button button-primary" value="保存"></p>
  </form>
</div>
<script>
(function() {
  var container = document.getElementById('company-branches');
  var addBtn = document.getElementById('company-add-branch');
  if (!container || !addBtn) return;

  function nextBranchIndex() {
    var max = -1;
    container.querySelectorAll('input[name^="branch_name["]').forEach(function(inp) {
      var m = inp.name.match(/^branch_name\[(\d+)\]$/);
      if (m) {
        max = Math.max(max, parseInt(m[1], 10));
      }
    });
    return max + 1;
  }

  container.addEventListener('click', function(ev) {
    var btn = ev.target.closest('.company-remove-branch');
    if (!btn || !container.contains(btn)) {
      return;
    }
    var box = btn.closest('.company-branch-box');
    if (box) {
      box.remove();
    }
  });

  addBtn.addEventListener('click', function() {
    var idx = nextBranchIndex();
    var n = container.querySelectorAll('.company-branch-box').length + 1;
    var box = document.createElement('div');
    box.className = 'company-branch-box';
    box.style.cssText = 'border:1px solid #ccc; padding:12px; margin-bottom:12px; background:#f9f9f9;';
    box.innerHTML = '<p><strong>店舗 ' + n + '</strong></p>' +
      '<table class="form-table"><tr><th>店舗名</th><td><input type="text" name="branch_name[' + idx +
      ']" class="regular-text" placeholder="例: 本店"></td></tr>' +
      '<tr><th>住所</th><td><textarea name="branch_address[' + idx +
      ']" rows="2" class="large-text"></textarea></td></tr>' +
      '<tr><th>電話</th><td><input type="text" name="branch_phone[' + idx + ']" class="regular-text"></td></tr>' +
      '<tr><th>アクセス</th><td><input type="text" name="branch_access[' + idx +
      ']" class="large-text" placeholder="例: 京王新線「初台」駅 徒歩5分"></td></tr>' +
      '<tr><th>営業時間</th><td><input type="text" name="branch_hours[' + idx + ']" class="regular-text"></td></tr>' +
      '<tr><th>地図（iframe）</th><td><textarea name="branch_map_url[' + idx +
      ']" rows="3" class="large-text" placeholder="&lt;iframe src=...&gt; または URL"></textarea><br><span class="description">iframe タグ全体、または埋め込みURLのどちらでも可</span></td></tr></table>' +
      '<p><button type="button" class="button company-remove-branch">この店舗を削除</button></p>';
    container.appendChild(box);
  });
})();
</script>
<?php
}

/**
 * 設定 → お問い合わせメール（送信先のみ。会社情報・店舗と同じオプションを更新）
 */
function friend2026_contact_email_settings_menu()
{
	add_options_page(
		'お問い合わせメール',
		'お問い合わせメール',
		'manage_options',
		'friend2026-contact-email',
		'friend2026_contact_email_settings_page'
	);
}

function friend2026_contact_email_settings_page()
{
	if (! current_user_can('manage_options')) {
		return;
	}
	if (isset($_POST['friend2026_contact_email_save']) && check_admin_referer('friend2026_contact_email')) {
		$saved = get_option('friend2026_company_data', array());
		if (! is_array($saved)) {
			$saved = array();
		}
		$saved['contact_emails'] = friend2026_parse_contact_emails_post('contact_emails');
		update_option('friend2026_company_data', $saved);
		wp_cache_delete('friend2026_company_data', 'options');
		echo '<div class="notice notice-success"><p>保存しました。</p></div>';
	}
	$d = friend2026_get_company_data();
	$ce_list = ! empty($d['contact_emails']) && is_array($d['contact_emails']) ? $d['contact_emails'] : array();
?>
<div class="wrap">
  <h1>お問い合わせメールの送信先</h1>
  <p>
    お問い合わせフォームからの通知（<code>wp_mail</code>）を受け取るメールアドレスです。<strong>会社情報・店舗</strong>の「お問い合わせ通知メール」と<strong>同じ一覧</strong>を共有します。
  </p>
  <form method="post" action="">
    <?php wp_nonce_field('friend2026_contact_email'); ?>
    <input type="hidden" name="friend2026_contact_email_save" value="1">
    <table class="form-table" role="presentation">
      <tr>
        <th scope="row">転送先一覧</th>
        <td>
          <p class="description"><strong>メールアドレスを追加</strong>で行を増やせます（上限
            <?php echo (int) FRIEND2026_CONTACT_EMAIL_MAX; ?> 件）。それぞれに同じ内容のメールが送られます。すべて空のときは管理者メールへ送ります。</p>
          <?php friend2026_render_admin_contact_email_fields($ce_list); ?>
        </td>
      </tr>
    </table>
    <?php submit_button('保存'); ?>
  </form>
</div>
<?php
}

add_action('admin_menu', 'friend2026_contact_email_settings_menu');
add_action('admin_menu', 'friend2026_company_admin_menu');