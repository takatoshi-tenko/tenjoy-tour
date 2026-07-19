<?php

/**
 * TENJOY-TOUR テーマの関数定義
 *
 * @package tenjoy-tour
 */

if (! defined('ABSPATH')) {
    exit;
}

define('TENJOY_VERSION', '1.0.0');
define('TENJOY_DIR', get_template_directory());
define('TENJOY_URI', get_template_directory_uri());

require_once TENJOY_DIR . '/inc/meta-boxes.php';
require_once TENJOY_DIR . '/inc/customizer.php';
require_once TENJOY_DIR . '/inc/notification-settings.php';
require_once TENJOY_DIR . '/inc/contact-settings.php';
require_once TENJOY_DIR . '/inc/polylang-strings.php';

// ==========================================================================
// ナビゲーションフォールバック
// ==========================================================================

/**
 * 固定ページのスラッグから、現在のPolylang言語に対応するURLを返す。
 * 言語ごとにスラッグが異なる場合（例: 中国語版が /contact ではなく
 * /contact-2 になっている場合）でも、正しい翻訳先ページのURLを返す。
 * ページが見つからない場合やPolylang未使用時は $fallback_path を返す。
 *
 * @param string $slug          既定言語（Polylangのデフォルト言語）でのページスラッグ
 * @param string $fallback_path 見つからない場合のパス（例: '/contact/'）
 * @return string
 */
function tenjoy_page_url(string $slug, string $fallback_path): string
{
    $args = [
        'post_type'      => 'page',
        'name'           => $slug,
        'posts_per_page' => 1,
        'post_status'    => 'publish',
    ];

    if (function_exists('pll_default_language')) {
        $args['lang'] = pll_default_language();
    }

    $pages = get_posts($args);
    if (! $pages) {
        return home_url($fallback_path);
    }

    $post_id = $pages[0]->ID;

    if (function_exists('pll_get_post')) {
        $translated_id = pll_get_post($post_id);
        if ($translated_id) {
            $post_id = $translated_id;
        }
    }

    $permalink = get_permalink($post_id);

    return $permalink ?: home_url($fallback_path);
}

/**
 * 現在のPolylang言語に対応するフロントページ（トップページ）のURLを返す。
 * フロントページは言語ごとに別の固定ページ（スラッグも異なる）として
 * 設定されている場合があるため、単純な home_url('/') では対応できない。
 *
 * @param string $anchor 末尾に追加するアンカー（例: '#services'）。不要なら空文字。
 * @return string
 */
function tenjoy_front_page_url(string $anchor = ''): string
{
    $front_id = (int) get_option('page_on_front');

    if ($front_id && function_exists('pll_get_post')) {
        $translated_id = pll_get_post($front_id);
        if ($translated_id) {
            $front_id = $translated_id;
        }
    }

    $url = $front_id ? get_permalink($front_id) : '';
    if (! $url) {
        $url = home_url('/');
    }

    return $anchor ? $url . $anchor : $url;
}

/**
 * 現在のPolylang言語に対応する投稿ページ（ブログ一覧）のURLを返す。
 * page_on_front と同様、投稿ページも言語ごとに別の固定ページになりうる。
 *
 * @return string
 */
function tenjoy_posts_page_url(): string
{
    $page_id = (int) get_option('page_for_posts');

    if ($page_id && function_exists('pll_get_post')) {
        $translated_id = pll_get_post($page_id);
        if ($translated_id) {
            $page_id = $translated_id;
        }
    }

    $url = $page_id ? get_permalink($page_id) : '';

    return $url ?: home_url('/blog/');
}

/**
 * プライマリメニュー未設定時のフォールバック出力
 */
function tenjoy_fallback_nav()
{
    $links = [
        tenjoy_front_page_url('#services')                              => ['label' => tenjoy__('nav_01'), 'cta' => false],
        get_post_type_archive_link('courses')               => ['label' => tenjoy__('nav_02'), 'cta' => false],
        get_post_type_archive_link('activities')            => ['label' => tenjoy__('nav_03'), 'cta' => false],
        tenjoy_posts_page_url()                             => ['label' => tenjoy__('footer_06'), 'cta' => false],
        tenjoy_page_url('reviews', '/reviews/')   => ['label' => tenjoy__('nav_04'), 'cta' => false],
        tenjoy_page_url('company', '/company/')             => ['label' => tenjoy__('nav_05'), 'cta' => false],
        tenjoy_page_url('contact', '/contact/')             => ['label' => tenjoy__('nav_06'), 'cta' => true],
    ];
    echo '<ul class="nav-menu">';
    foreach ($links as $url => $item) {
        $class = $item['cta'] ? ' class="nav-cta"' : '';
        echo '<li' . $class . '><a href="' . esc_url($url) . '">' . esc_html($item['label']) . '</a></li>';
    }
    echo '</ul>';
}

function tenjoy_fallback_mobile_nav()
{
    $links = [
        tenjoy_front_page_url('#services')                              => ['label' => tenjoy__('nav_01'), 'cta' => false],
        get_post_type_archive_link('courses')               => ['label' => tenjoy__('nav_02'), 'cta' => false],
        get_post_type_archive_link('activities')            => ['label' => tenjoy__('nav_03'), 'cta' => false],
        tenjoy_posts_page_url()                             => ['label' => tenjoy__('footer_06'), 'cta' => false],
        tenjoy_page_url('reviews', '/reviews/')   => ['label' => tenjoy__('nav_04'), 'cta' => false],
        tenjoy_page_url('company', '/company/')             => ['label' => tenjoy__('nav_05'), 'cta' => false],
        tenjoy_page_url('contact', '/contact/')             => ['label' => tenjoy__('nav_06'), 'cta' => true],
    ];
    echo '<ul class="mobile-nav-menu">';
    foreach ($links as $url => $item) {
        $class = $item['cta'] ? ' class="nav-cta"' : '';
        echo '<li' . $class . '><a href="' . esc_url($url) . '">' . esc_html($item['label']) . '</a></li>';
    }
    echo '</ul>';
}

// ==========================================================================
// テーマセットアップ
// ==========================================================================

function tenjoy_setup()
{
    load_theme_textdomain('tenjoy-tour', TENJOY_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    // ナビゲーションメニュー
    register_nav_menus([
        'primary' => __('メインメニュー', 'tenjoy-tour'),
        'footer'  => __('フッターメニュー', 'tenjoy-tour'),
    ]);
}
add_action('after_setup_theme', 'tenjoy_setup');

// ==========================================================================
// スクリプト・スタイルの読み込み
// ==========================================================================

function tenjoy_scripts()
{
    // Google Fonts: Noto Sans JP + Noto Serif
    $font_url = 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;600;700&family=Noto+Serif:wght@400;600&display=swap';
    wp_enqueue_style('tenjoy-fonts', $font_url, [], null);

    // Swiper CSS
    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], '11');

    // メインスタイルシート（SCSS コンパイル済み: assets/css/main.css）
    $style_file = TENJOY_DIR . '/assets/css/main.css';
    $style_ver  = file_exists($style_file) ? (string) filemtime($style_file) : TENJOY_VERSION;
    wp_enqueue_style('tenjoy-style', TENJOY_URI . '/assets/css/main.css', ['tenjoy-fonts', 'swiper'], $style_ver);

    // Swiper JS
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], '11', true);

    // ナビゲーション JS
    $nav_file = TENJOY_DIR . '/assets/js/nav.js';
    $nav_ver  = file_exists($nav_file) ? (string) filemtime($nav_file) : TENJOY_VERSION;
    wp_enqueue_script('tenjoy-nav', TENJOY_URI . '/assets/js/nav.js', ['swiper'], $nav_ver, true);

    // レビュー送信 AJAX
    wp_localize_script('tenjoy-nav', 'tenjoyAjax', [
        'url'   => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('tenjoy_review_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'tenjoy_scripts');

// ==========================================================================
// カスタム投稿タイプ: アクティビティ (activities)
// ==========================================================================

function tenjoy_register_cpt_activities()
{
    $labels = [
        'name'               => __('アクティビティ', 'tenjoy-tour'),
        'singular_name'      => __('アクティビティ', 'tenjoy-tour'),
        'menu_name'          => __('アクティビティ', 'tenjoy-tour'),
        'add_new'            => __('新規追加', 'tenjoy-tour'),
        'add_new_item'       => __('新規アクティビティを追加', 'tenjoy-tour'),
        'edit_item'          => __('アクティビティを編集', 'tenjoy-tour'),
        'view_item'          => __('アクティビティを表示', 'tenjoy-tour'),
        'search_items'       => __('アクティビティを検索', 'tenjoy-tour'),
        'not_found'          => __('アクティビティが見つかりません', 'tenjoy-tour'),
        'not_found_in_trash' => __('ゴミ箱にアクティビティはありません', 'tenjoy-tour'),
    ];

    register_post_type('activities', [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'activities'],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-star-filled',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'],
        'show_in_rest'       => true,
    ]);
}
add_action('init', 'tenjoy_register_cpt_activities');

// ==========================================================================
// カスタム投稿タイプ: 車両紹介 (vehicles)
// ==========================================================================

function tenjoy_register_cpt_vehicles()
{
    $labels = [
        'name'               => __('車両紹介', 'tenjoy-tour'),
        'singular_name'      => __('車両', 'tenjoy-tour'),
        'menu_name'          => __('車両紹介', 'tenjoy-tour'),
        'add_new'            => __('新規追加', 'tenjoy-tour'),
        'add_new_item'       => __('新規車両を追加', 'tenjoy-tour'),
        'edit_item'          => __('車両を編集', 'tenjoy-tour'),
        'view_item'          => __('車両を表示', 'tenjoy-tour'),
        'search_items'       => __('車両を検索', 'tenjoy-tour'),
        'not_found'          => __('車両が見つかりません', 'tenjoy-tour'),
        'not_found_in_trash' => __('ゴミ箱に車両はありません', 'tenjoy-tour'),
    ];

    register_post_type('vehicles', [
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-car',
        'supports'           => ['title', 'thumbnail', 'page-attributes'],
        'show_in_rest'       => true,
    ]);
}
add_action('init', 'tenjoy_register_cpt_vehicles');

// ==========================================================================
// カスタム投稿タイプ: ゴルフ場 (courses)
// ==========================================================================

function tenjoy_register_cpt_courses()
{
    $labels = [
        'name'               => __('ゴルフ場', 'tenjoy-tour'),
        'singular_name'      => __('ゴルフ場', 'tenjoy-tour'),
        'menu_name'          => __('ゴルフ場一覧', 'tenjoy-tour'),
        'add_new'            => __('新規追加', 'tenjoy-tour'),
        'add_new_item'       => __('新規ゴルフ場を追加', 'tenjoy-tour'),
        'edit_item'          => __('ゴルフ場を編集', 'tenjoy-tour'),
        'view_item'          => __('ゴルフ場を表示', 'tenjoy-tour'),
        'search_items'       => __('ゴルフ場を検索', 'tenjoy-tour'),
        'not_found'          => __('ゴルフ場が見つかりません', 'tenjoy-tour'),
        'not_found_in_trash' => __('ゴミ箱にゴルフ場はありません', 'tenjoy-tour'),
    ];

    register_post_type('courses', [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'courses'],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 7,
        'menu_icon'          => 'dashicons-location-alt',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'],
        'show_in_rest'       => true,
    ]);
}
add_action('init', 'tenjoy_register_cpt_courses');

// ==========================================================================
// カスタム投稿タイプ: よくある質問 (faq)
// ==========================================================================

function tenjoy_register_cpt_faq()
{
    $labels = [
        'name'               => __('よくある質問', 'tenjoy-tour'),
        'singular_name'      => __('FAQ', 'tenjoy-tour'),
        'menu_name'          => __('よくある質問', 'tenjoy-tour'),
        'add_new'            => __('新規追加', 'tenjoy-tour'),
        'add_new_item'       => __('新規FAQを追加', 'tenjoy-tour'),
        'edit_item'          => __('FAQを編集', 'tenjoy-tour'),
        'view_item'          => __('FAQを表示', 'tenjoy-tour'),
        'search_items'       => __('FAQを検索', 'tenjoy-tour'),
        'not_found'          => __('FAQが見つかりません', 'tenjoy-tour'),
        'not_found_in_trash' => __('ゴミ箱にFAQはありません', 'tenjoy-tour'),
    ];

    register_post_type('faq', [
        'labels'          => $labels,
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'query_var'       => false,
        'rewrite'         => false,
        'capability_type' => 'post',
        'has_archive'     => false,
        'hierarchical'    => false,
        'menu_position'   => 9,
        'menu_icon'       => 'dashicons-editor-help',
        'supports'        => ['title', 'editor', 'page-attributes'],
        'show_in_rest'    => true,
    ]);
}
add_action('init', 'tenjoy_register_cpt_faq');

// ==========================================================================
// カスタム投稿タイプ: スタッフ (staff)
// ==========================================================================

function tenjoy_register_cpt_staff()
{
    $labels = [
        'name'               => __('スタッフ', 'tenjoy-tour'),
        'singular_name'      => __('スタッフ', 'tenjoy-tour'),
        'menu_name'          => __('スタッフ', 'tenjoy-tour'),
        'add_new'            => __('新規追加', 'tenjoy-tour'),
        'add_new_item'       => __('新規スタッフを追加', 'tenjoy-tour'),
        'edit_item'          => __('スタッフを編集', 'tenjoy-tour'),
        'view_item'          => __('スタッフを表示', 'tenjoy-tour'),
        'search_items'       => __('スタッフを検索', 'tenjoy-tour'),
        'not_found'          => __('スタッフが見つかりません', 'tenjoy-tour'),
        'not_found_in_trash' => __('ゴミ箱にスタッフはありません', 'tenjoy-tour'),
    ];

    register_post_type('staff', [
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 8,
        'menu_icon'          => 'dashicons-groups',
        'supports'           => ['title', 'thumbnail', 'page-attributes'],
        'show_in_rest'       => true,
    ]);
}
add_action('init', 'tenjoy_register_cpt_staff');

// ==========================================================================
// カスタムメタ登録
// ==========================================================================

function tenjoy_register_post_meta()
{
    // アクティビティ
    $activities_meta = [
        'activity_price'     => 'string', // 料金
        'activity_duration'  => 'string', // 所要時間
        'activity_location'  => 'string', // 場所
        'activity_category'  => 'string', // カテゴリ（食事/温泉/観光など）
    ];
    foreach ($activities_meta as $key => $type) {
        register_post_meta('activities', $key, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => $type,
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        ]);
    }

    // スタッフ
    $staff_meta = [
        'staff_role'      => 'string', // 役職
        'staff_bio'       => 'string', // 自己紹介
        'staff_languages' => 'string', // 対応言語（カンマ区切り）
        'staff_email'     => 'string', // メールアドレス
        'staff_phone'     => 'string', // 電話番号
    ];
    foreach ($staff_meta as $key => $type) {
        register_post_meta('staff', $key, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => $type,
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        ]);
    }

    // ゴルフ場
    $courses_meta = [
        'course_prefecture'    => 'string',  // 都道府県
        'course_address'       => 'string',  // 住所
        'course_holes'         => 'integer', // ホール数
        'course_green_fee'     => 'string',  // グリーンフィー
        'course_caddie'        => 'boolean', // キャディ有無
        'course_cart'          => 'string',  // カート種類
        'course_has_detail'    => 'boolean', // 詳細ページあり/なし
        'course_website'       => 'string',  // 公式サイト
        'course_map_embed'     => 'string',  // Googleマップ埋め込みURL
    ];
    foreach ($courses_meta as $key => $type) {
        register_post_meta('courses', $key, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => $type,
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        ]);
    }

    // 車両紹介
    register_post_meta('vehicles', 'vehicle_desc', [
        'show_in_rest'  => true,
        'single'        => true,
        'type'          => 'string',
        'auth_callback' => function () {
            return current_user_can('edit_posts');
        },
    ]);
    register_post_meta('vehicles', 'vehicle_gallery', [
        'show_in_rest'  => true,
        'single'        => true,
        'type'          => 'string',
        'auth_callback' => function () {
            return current_user_can('edit_posts');
        },
    ]);
}
add_action('init', 'tenjoy_register_post_meta');

// ==========================================================================
// 管理画面: 各CPT一覧に便利列を追加
// ==========================================================================

/**
 * ゴルフ場一覧: 都道府県・詳細ページ有無 列を追加
 *
 * @param array<string, string> $columns
 * @return array<string, string>
 */
function tenjoy_courses_columns($columns)
{
    $new = [];
    foreach ($columns as $key => $label) {
        $new[$key] = $label;
        if ($key === 'title') {
            $new['course_prefecture'] = __('都道府県', 'tenjoy-tour');
            $new['course_has_detail'] = __('詳細ページ', 'tenjoy-tour');
        }
    }
    return $new;
}
add_filter('manage_courses_posts_columns', 'tenjoy_courses_columns');

/**
 * @param string $column
 * @param int    $post_id
 */
function tenjoy_courses_column_cell($column, $post_id)
{
    if ($column === 'course_prefecture') {
        echo esc_html((string) get_post_meta($post_id, 'course_prefecture', true));
    }
    if ($column === 'course_has_detail') {
        $has_detail = (bool) get_post_meta($post_id, 'course_has_detail', true);
        echo $has_detail ? '&#10003;' : '&#8212;';
    }
}
add_action('manage_courses_posts_custom_column', 'tenjoy_courses_column_cell', 10, 2);

// ==========================================================================
// Polylang: CPTと固定ページを翻訳対象に登録
// ==========================================================================

function tenjoy_polylang_register_types($post_types, $is_settings)
{
    $tenjoy_types = ['activities', 'courses', 'staff', 'vehicles'];
    return array_merge($post_types, $tenjoy_types);
}
add_filter('pll_get_post_types', 'tenjoy_polylang_register_types', 10, 2);

// ==========================================================================
// 管理画面: サイドバーメニューの並び順調整
// 「言語」（Polylang）メニューを「ゴルフ場一覧」の直下に移動する
// ==========================================================================

add_filter('custom_menu_order', '__return_true');
add_filter('menu_order', 'tenjoy_reorder_admin_menu');

/**
 * @param array<int, string> $menu_order
 * @return array<int, string>
 */
function tenjoy_reorder_admin_menu($menu_order)
{
    $courses_slug = 'edit.php?post_type=courses';
    $lang_slug    = 'mlang';

    $lang_pos = array_search($lang_slug, $menu_order, true);
    if ($lang_pos === false) {
        return $menu_order;
    }

    unset($menu_order[$lang_pos]);
    $menu_order = array_values($menu_order);

    $courses_pos = array_search($courses_slug, $menu_order, true);
    if ($courses_pos === false) {
        // ゴルフ場一覧が見つからない場合は末尾に戻す
        $menu_order[] = $lang_slug;
        return $menu_order;
    }

    array_splice($menu_order, $courses_pos + 1, 0, [$lang_slug]);

    return $menu_order;
}

// ==========================================================================
// 管理画面: Polylang「翻訳」一覧に表示件数クイック切替を追加
// （ページネーションの代わりに 10 / 30 / 50 / 100 / 全部 から選べるようにする）
// ==========================================================================

add_action('admin_footer-languages_page_mlang_strings', 'tenjoy_pll_strings_per_page_shortcuts');

function tenjoy_pll_strings_per_page_shortcuts(): void
{
    $show_all_value = 99999;
?>
    <script>
        (function($) {
            var $input = $('#pll_strings_per_page');
            if (!$input.length) {
                return;
            }

            var $wrap = $('<div class="tenjoy-per-page-shortcuts" style="margin-top:8px;"></div>');
            var presets = [10, 30, 50, 100];

            function applyValue(value) {
                $input.val(value);
                $('input[name="screen-options-apply"]').trigger('click');
            }

            presets.forEach(function(n) {
                var $btn = $('<button type="button" class="button button-small" style="margin-right:4px;"></button>').text(n);
                $btn.on('click', function() {
                    applyValue(n);
                });
                $wrap.append($btn);
            });

            var $all = $('<button type="button" class="button button-small"></button>').text(
                '<?php echo esc_js(__('全部', 'tenjoy-tour')); ?>');
            $all.on('click', function() {
                applyValue(<?php echo (int) $show_all_value; ?>);
            });
            $wrap.append($all);

            $input.closest('.screen-options').append($wrap);
        })(jQuery);
    </script>
<?php
}

// ==========================================================================
// 管理バー: フロントエンドでは非表示（任意）
// ==========================================================================

// add_action('after_setup_theme', function () {
//     show_admin_bar(false);
// });

// ==========================================================================
// SVGアイコンヘルパー
// ==========================================================================

/**
 * シンプルなSVGアイコンを返す
 *
 * @param string $name アイコン名 (calendar|car|map-pin|star|message-circle|phone|instagram)
 * @return string SVGタグ
 */
function tenjoy_icon($name)
{
    $icons = [
        'calendar'       => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
        'car'            => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v9a2 2 0 0 1-2 2h-2"/><circle cx="7" cy="17" r="2"/><circle cx="15" cy="17" r="2"/><path d="M9 3v5h8"/></svg>',
        'map-pin'        => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
        'star'           => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="none" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
        'message-circle' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',
        'kakao'          => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="none" aria-hidden="true"><path d="M12 3C6.5 3 2 6.58 2 11c0 2.85 1.86 5.36 4.66 6.78L5.6 21.6a.5.5 0 0 0 .74.56l4.3-2.84c.45.05.9.08 1.36.08 5.5 0 10-3.58 10-8s-4.5-8-10-8z"/></svg>',
        'line'           => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="none" aria-hidden="true"><path d="M12 2C6.48 2 2 5.7 2 10.25c0 4.08 3.55 7.49 8.35 8.14.32.07.77.22.88.5.1.26.07.66.03.92l-.14.86c-.04.26-.2 1 .87.55 1.08-.46 5.8-3.42 7.92-5.85C21.28 13.85 22 12.13 22 10.25 22 5.7 17.52 2 12 2z"/></svg>',
        'message-square' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',
        'flag'           => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/></svg>',
        'globe'          => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/><path d="M2 12h20"/></svg>',
        'users'          => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        'phone'          => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
        'instagram'      => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
        'mail'           => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>',
        'clock'          => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
        'arrow-left'     => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>',
        'user'           => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
        'golf'           => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="18" x2="12" y2="2"/><path d="M7 7l5-5 5 5"/><circle cx="12" cy="21" r="1"/><path d="M5 18h14"/></svg>',
    ];

    return isset($icons[$name]) ? $icons[$name] : '';
}

// ==========================================================================
// 会社情報（「会社概要」テンプレートのページ）を他のテンプレートから参照する
// ==========================================================================

/**
 * 「会社概要」テンプレート（page-company.php）が割り当てられている
 * 固定ページのIDを返す。見つからない場合は0。
 *
 * @return int
 */
function tenjoy_get_company_page_id(): int
{
    static $page_id = null;

    if ($page_id !== null) {
        return $page_id;
    }

    $pages = get_posts([
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'meta_key'       => '_wp_page_template',
        'meta_value'     => 'page-company.php',
        'fields'         => 'ids',
    ]);

    $page_id = $pages ? (int) $pages[0] : 0;

    return $page_id;
}

/**
 * 「会社概要」ページに設定された会社情報メタを取得する。
 * ページ自体が見つからない、または値が未設定の場合は $default を返す。
 *
 * @param string $key
 * @param string $default
 * @return string
 */
function tenjoy_get_company_meta(string $key, string $default = ''): string
{
    $page_id = tenjoy_get_company_page_id();
    if (! $page_id) {
        return $default;
    }

    $value = (string) get_post_meta($page_id, $key, true);

    return $value !== '' ? $value : $default;
}

// ==========================================================================
// Googleマップ埋め込みURLの検証
// ==========================================================================

/**
 * 与えられたURLがGoogleマップの埋め込み用URLとして安全かを判定する。
 * iframe の src に使うため、Google のドメイン以外は許可しない。
 *
 * @param string $url
 * @return bool
 */
function tenjoy_is_valid_map_embed_url(string $url): bool
{
    if ($url === '') {
        return false;
    }

    $host = wp_parse_url($url, PHP_URL_HOST);
    if (! $host) {
        return false;
    }

    $allowed_hosts = ['www.google.com', 'google.com', 'maps.google.com'];
    $scheme        = (string) wp_parse_url($url, PHP_URL_SCHEME);

    return in_array($host, $allowed_hosts, true) && strpos($scheme, 'http') === 0;
}

/**
 * 管理画面に入力された値からGoogleマップの埋め込みURLを取り出す。
 * <iframe> タグがまるごと貼り付けられた場合は src 属性のみを抽出し、
 * すでにURLだけが入力されている場合はそのまま返す。
 *
 * @param string $input
 * @return string
 */
function tenjoy_extract_map_embed_url(string $input): string
{
    $input = trim($input);
    if ($input === '') {
        return '';
    }

    if (stripos($input, '<iframe') !== false && preg_match('/\ssrc=["\']([^"\']+)["\']/i', $input, $matches)) {
        $input = $matches[1];
    }

    $input = html_entity_decode($input, ENT_QUOTES);

    return esc_url_raw($input);
}

// ==========================================================================
// ページネーション
// ==========================================================================

/**
 * ページネーション出力
 *
 * @param WP_Query|null $query
 */
function tenjoy_pagination($query = null)
{
    if (is_null($query)) {
        global $wp_query;
        $query = $wp_query;
    }

    $big = 999999999;
    echo wp_kses_post(paginate_links([
        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'    => '?paged=%#%',
        'current'   => max(1, get_query_var('paged')),
        'total'     => $query->max_num_pages,
        'prev_text' => '&lsaquo;',
        'next_text' => '&rsaquo;',
        'type'      => 'list',
    ]));
}

// ==========================================================================
// サムネイルのデフォルトサイズ
// ==========================================================================

add_image_size('tenjoy-card', 600, 400, true);          // 一覧カード用
add_image_size('tenjoy-hero', 1440, 640, true);         // ヒーロー用
add_image_size('tenjoy-thumb', 300, 200, true);         // サムネイル小
add_image_size('tenjoy-vehicle-card', 640, 360, true);  // 車両紹介カード用（16:9）

// ==========================================================================
// excerpt の文字数（日本語対応）
// ==========================================================================

function tenjoy_excerpt_length($length)
{
    return 80;
}
add_filter('excerpt_length', 'tenjoy_excerpt_length');

function tenjoy_excerpt_more($more)
{
    return '…';
}
add_filter('excerpt_more', 'tenjoy_excerpt_more');

// ==========================================================================
// カスタム投稿タイプ: お客様の声 (tenjoy_review)
// ==========================================================================

function tenjoy_register_cpt_review()
{
    register_post_type('tenjoy_review', [
        'labels'          => [
            'name'               => __('お客様の声', 'tenjoy-tour'),
            'singular_name'      => __('レビュー', 'tenjoy-tour'),
            'menu_name'          => __('お客様の声', 'tenjoy-tour'),
            'add_new'            => __('新規追加', 'tenjoy-tour'),
            'add_new_item'       => __('新規レビューを追加', 'tenjoy-tour'),
            'edit_item'          => __('レビューを編集', 'tenjoy-tour'),
            'not_found'          => __('レビューが見つかりません', 'tenjoy-tour'),
            'not_found_in_trash' => __('ゴミ箱にレビューはありません', 'tenjoy-tour'),
        ],
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'query_var'       => false,
        'rewrite'         => false,
        'capability_type' => 'post',
        'has_archive'     => false,
        'hierarchical'    => false,
        'menu_position'   => 10,
        'menu_icon'       => 'dashicons-star-filled',
        'supports'        => ['title', 'editor'],
        'show_in_rest'    => true,
    ]);
}
add_action('init', 'tenjoy_register_cpt_review');

// ==========================================================================
// レビュー メタ登録
// ==========================================================================

function tenjoy_register_review_meta()
{
    foreach (['review_rating', 'review_country'] as $key) {
        register_post_meta('tenjoy_review', $key, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => $key === 'review_rating' ? 'integer' : 'string',
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        ]);
    }
}
add_action('init', 'tenjoy_register_review_meta');

// ==========================================================================
// レビュー AJAX 送信ハンドラ（未ログインユーザー対応）
// ==========================================================================

add_action('wp_ajax_nopriv_tenjoy_submit_review', 'tenjoy_submit_review');
add_action('wp_ajax_tenjoy_submit_review', 'tenjoy_submit_review');

function tenjoy_submit_review()
{
    if (! check_ajax_referer('tenjoy_review_nonce', 'nonce', false)) {
        wp_send_json_error(['message' => tenjoy__('review_ajax_01')]);
    }

    $author  = sanitize_text_field(wp_unslash($_POST['author'] ?? ''));
    $country = sanitize_text_field(wp_unslash($_POST['country'] ?? ''));
    $content = sanitize_textarea_field(wp_unslash($_POST['content'] ?? ''));
    $rating  = max(1, min(5, (int) ($_POST['rating'] ?? 5)));

    if (empty($author) || empty($content)) {
        wp_send_json_error(['message' => tenjoy__('review_ajax_02')]);
    }

    $post_id = wp_insert_post([
        'post_type'    => 'tenjoy_review',
        'post_title'   => $author,
        'post_content' => $content,
        'post_status'  => 'pending',
    ]);

    if (is_wp_error($post_id)) {
        wp_send_json_error(['message' => tenjoy__('review_ajax_03')]);
    }

    update_post_meta($post_id, 'review_rating', $rating);
    update_post_meta($post_id, 'review_country', $country);

    // 管理者へメール通知
    $to         = tenjoy_get_notification_emails() ?: [get_option('admin_email')];
    $site_name  = get_bloginfo('name');
    $manage_url = admin_url('post.php?post=' . $post_id . '&action=edit');
    $stars      = str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
    $from_label = $country ? "{$author}（{$country}）" : $author;

    $subject = "[{$site_name}] 新しいレビューが届きました";
    $body    = "新しいレビューが届きました。内容を確認して承認してください。\n\n"
        . "━━━━━━━━━━━━━━━━━━━━\n"
        . "投稿者：{$from_label}\n"
        . "評価　：{$stars}（{$rating}/5）\n"
        . "コメント：\n{$content}\n"
        . "━━━━━━━━━━━━━━━━━━━━\n\n"
        . "▼ 管理画面で確認・承認する\n"
        . $manage_url . "\n";

    wp_mail(
        $to,
        $subject,
        $body,
        ['Content-Type: text/plain; charset=UTF-8']
    );

    wp_send_json_success(['message' => tenjoy__('review_ajax_04')]);
}

// ==========================================================================
// アクティビティ 追加メタ登録
// ==========================================================================

function tenjoy_register_activity_extra_meta()
{
    $extra = [
        'activity_customer'    => 'string',  // お客様情報
        'activity_has_golf'    => 'boolean', // ゴルフ活動か
        'activity_course_name' => 'string',  // 利用ゴルフ場名
        'activity_gallery'     => 'string',  // ギャラリー画像ID（カンマ区切り）
    ];
    foreach ($extra as $key => $type) {
        register_post_meta('activities', $key, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => $type,
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        ]);
    }
}
add_action('init', 'tenjoy_register_activity_extra_meta');

// ==========================================================================
// ゴルフ場 追加メタ登録
// ==========================================================================

function tenjoy_register_course_extra_meta()
{
    $extra = [
        'course_rating'      => 'string',  // 星評価（例: 4.8）
        'course_region'      => 'string',  // エリア（例: 関東）
        'course_tags'        => 'string',  // 特徴タグ（カンマ区切り）
        'course_visit_count' => 'integer', // 訪問数
    ];
    foreach ($extra as $key => $type) {
        register_post_meta('courses', $key, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => $type,
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        ]);
    }
}
add_action('init', 'tenjoy_register_course_extra_meta');
