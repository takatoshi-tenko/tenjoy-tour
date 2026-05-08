<?php
/**
 * WordPress カスタマイザー設定
 *
 * 管理画面「外観 > カスタマイズ」から設定できる画像を定義する。
 * 画像はすべてメディアライブラリからアップロード・選択する方式。
 *
 * 設定項目:
 *   - ヒーロー画像
 *   - ゴルフ体験ギャラリー画像（4枚）
 *   - 車両紹介画像（バス・ワゴン・セダン）
 *   - SNS連絡先 QRコード（Kakao / WeChat / Instagram / LINE / WhatsApp）
 *
 * 使い方（テンプレート側）:
 *   $url = get_theme_mod('tenjoy_hero_image', '');
 *
 * @package tenjoy-tour
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('customize_register', 'tenjoy_customizer_register');

function tenjoy_customizer_register(WP_Customize_Manager $wp_customize)
{
    // ======================================================================
    // パネル: TENJOY-TOUR サイト設定
    // ======================================================================

    $wp_customize->add_panel('tenjoy_panel', [
        'title'    => __('TENJOY-TOUR サイト設定', 'tenjoy-tour'),
        'priority' => 30,
    ]);

    // ======================================================================
    // セクション1: ヒーロー画像
    // ======================================================================

    $wp_customize->add_section('tenjoy_hero', [
        'title' => __('ヒーロー画像', 'tenjoy-tour'),
        'panel' => 'tenjoy_panel',
    ]);

    $wp_customize->add_setting('tenjoy_hero_image', [
        'default'           => '',
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'tenjoy_hero_image', [
        'label'     => __('ヒーロー背景画像', 'tenjoy-tour'),
        'section'   => 'tenjoy_hero',
        'mime_type' => 'image',
    ]));

    // ======================================================================
    // セクション2: ゴルフ体験ギャラリー
    // ======================================================================

    $wp_customize->add_section('tenjoy_experience', [
        'title' => __('ゴルフ体験ギャラリー', 'tenjoy-tour'),
        'panel' => 'tenjoy_panel',
    ]);

    for ($i = 1; $i <= 4; $i++) {
        $wp_customize->add_setting("tenjoy_experience_image_{$i}", [
            'default'           => '',
            'sanitize_callback' => 'absint',
        ]);

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "tenjoy_experience_image_{$i}", [
            'label'     => sprintf(__('体験ギャラリー画像 %d', 'tenjoy-tour'), $i),
            'section'   => 'tenjoy_experience',
            'mime_type' => 'image',
        ]));
    }

    // ======================================================================
    // セクション3: 車両紹介
    // ======================================================================

    $wp_customize->add_section('tenjoy_vehicles', [
        'title' => __('車両紹介', 'tenjoy-tour'),
        'panel' => 'tenjoy_panel',
    ]);

    $vehicles = [
        'bus'     => [
            'label'        => __('大型バス', 'tenjoy-tour'),
            'default_name' => __('大型バス', 'tenjoy-tour'),
            'default_desc' => __('大人数でのご移動に最適です（最大45名）', 'tenjoy-tour'),
        ],
        'van'     => [
            'label'        => __('ワゴン車', 'tenjoy-tour'),
            'default_name' => __('ワゴン車', 'tenjoy-tour'),
            'default_desc' => __('中人数のグループに最適です（最大10名）', 'tenjoy-tour'),
        ],
        'sedan'   => [
            'label'        => __('高級セダン', 'tenjoy-tour'),
            'default_name' => __('高級セダン', 'tenjoy-tour'),
            'default_desc' => __('少人数でのプライベート移動に（最大4名）', 'tenjoy-tour'),
        ],
        'minivan' => [
            'label'        => __('ミニバン', 'tenjoy-tour'),
            'default_name' => __('ミニバン', 'tenjoy-tour'),
            'default_desc' => __('小グループに最適な快適移動（最大8名）', 'tenjoy-tour'),
        ],
    ];

    foreach ($vehicles as $key => $vehicle) {
        // 画像
        $wp_customize->add_setting("tenjoy_vehicle_{$key}", [
            'default'           => '',
            'sanitize_callback' => 'absint',
        ]);
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "tenjoy_vehicle_{$key}", [
            'label'     => sprintf('%s — %s', $vehicle['label'], __('画像', 'tenjoy-tour')),
            'section'   => 'tenjoy_vehicles',
            'mime_type' => 'image',
        ]));

        // タイトル
        $wp_customize->add_setting("tenjoy_vehicle_{$key}_name", [
            'default'           => $vehicle['default_name'],
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control("tenjoy_vehicle_{$key}_name", [
            'label'   => sprintf('%s — %s', $vehicle['label'], __('タイトル', 'tenjoy-tour')),
            'section' => 'tenjoy_vehicles',
            'type'    => 'text',
        ]);

        // 説明
        $wp_customize->add_setting("tenjoy_vehicle_{$key}_desc", [
            'default'           => $vehicle['default_desc'],
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control("tenjoy_vehicle_{$key}_desc", [
            'label'   => sprintf('%s — %s', $vehicle['label'], __('説明文', 'tenjoy-tour')),
            'section' => 'tenjoy_vehicles',
            'type'    => 'text',
        ]);
    }

    // ======================================================================
    // セクション4: SNS連絡先 QRコード
    // ======================================================================

    $wp_customize->add_section('tenjoy_qr', [
        'title' => __('SNS QRコード', 'tenjoy-tour'),
        'panel' => 'tenjoy_panel',
    ]);

    $messengers = [
        'kakao'     => 'Kakao Talk',
        'wechat'    => 'WeChat',
        'instagram' => 'Instagram',
        'line'      => 'LINE',
        'whatsapp'  => 'WhatsApp',
    ];

    foreach ($messengers as $key => $label) {
        $wp_customize->add_setting("tenjoy_qr_{$key}", [
            'default'           => '',
            'sanitize_callback' => 'absint',
        ]);

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "tenjoy_qr_{$key}", [
            'label'     => sprintf(__('%s QRコード', 'tenjoy-tour'), $label),
            'section'   => 'tenjoy_qr',
            'mime_type' => 'image',
        ]));
    }
}

// ======================================================================
// ヘルパー関数: カスタマイザー画像のURLを取得する
//
// WP_Customize_Media_Control は attachment ID を保存するため、
// URLへの変換が必要。フォールバックとして $fallback_url を使う。
// ======================================================================

/**
 * カスタマイザーで設定された画像のURLを返す。
 *
 * @param string $setting_key  get_theme_mod のキー名（例: 'tenjoy_hero_image'）
 * @param string $size         画像サイズ（例: 'full', 'tenjoy-hero'）
 * @param string $fallback_url 画像未設定時のフォールバックURL
 * @return string
 */
function tenjoy_customizer_image_url(string $setting_key, string $size = 'full', string $fallback_url = ''): string
{
    $attachment_id = (int) get_theme_mod($setting_key, 0);

    if ($attachment_id > 0) {
        $src = wp_get_attachment_image_url($attachment_id, $size);
        if ($src) {
            return $src;
        }
    }

    return $fallback_url;
}
