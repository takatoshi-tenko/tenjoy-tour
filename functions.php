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

// ==========================================================================
// Polylang: デフォルト言語を韓国語に設定
// 言語が検出できない場合（初回訪問など）に韓国語を優先する
// ==========================================================================

add_filter('pll_preferred_language', function ($lang) {
    return $lang ?: 'ko';
});

// ==========================================================================
// ナビゲーションフォールバック
// ==========================================================================

/**
 * プライマリメニュー未設定時のフォールバック出力
 */
function tenjoy_fallback_nav()
{
    $links = [
        home_url('/#services')     => ['label' => __('サービス', 'tenjoy-tour'),   'cta' => false],
        home_url('/courses/')      => ['label' => __('ゴルフ場', 'tenjoy-tour'),   'cta' => false],
        home_url('/activities/')   => ['label' => __('アクティビティ', 'tenjoy-tour'), 'cta' => false],
        home_url('/testimonials/') => ['label' => __('お客様の声', 'tenjoy-tour'), 'cta' => false],
        home_url('/company/')      => ['label' => __('会社概要', 'tenjoy-tour'),   'cta' => false],
        home_url('/contact/')      => ['label' => __('お問い合わせ', 'tenjoy-tour'), 'cta' => true],
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
        home_url('/#services')     => ['label' => __('サービス', 'tenjoy-tour'),     'cta' => false],
        home_url('/courses/')      => ['label' => __('ゴルフ場', 'tenjoy-tour'),     'cta' => false],
        home_url('/activities/')   => ['label' => __('アクティビティ', 'tenjoy-tour'), 'cta' => false],
        home_url('/testimonials/') => ['label' => __('お客様の声', 'tenjoy-tour'),   'cta' => false],
        home_url('/company/')      => ['label' => __('会社概要', 'tenjoy-tour'),     'cta' => false],
        home_url('/contact/')      => ['label' => __('お問い合わせ', 'tenjoy-tour'), 'cta' => true],
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
    $tenjoy_types = ['activities', 'courses', 'staff'];
    return array_merge($post_types, $tenjoy_types);
}
add_filter('pll_get_post_types', 'tenjoy_polylang_register_types', 10, 2);

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

add_image_size('tenjoy-card', 600, 400, true);    // 一覧カード用
add_image_size('tenjoy-hero', 1440, 640, true);   // ヒーロー用
add_image_size('tenjoy-thumb', 300, 200, true);   // サムネイル小

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
        wp_send_json_error(['message' => 'セキュリティエラーが発生しました。']);
    }

    $author  = sanitize_text_field(wp_unslash($_POST['author'] ?? ''));
    $country = sanitize_text_field(wp_unslash($_POST['country'] ?? ''));
    $content = sanitize_textarea_field(wp_unslash($_POST['content'] ?? ''));
    $rating  = max(1, min(5, (int) ($_POST['rating'] ?? 5)));

    if (empty($author) || empty($content)) {
        wp_send_json_error(['message' => 'お名前とコメントは必須です。']);
    }

    $post_id = wp_insert_post([
        'post_type'    => 'tenjoy_review',
        'post_title'   => $author,
        'post_content' => $content,
        'post_status'  => 'pending',
    ]);

    if (is_wp_error($post_id)) {
        wp_send_json_error(['message' => '送信に失敗しました。']);
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

    wp_send_json_success(['message' => 'レビューを送信しました。承認後に表示されます。']);
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
