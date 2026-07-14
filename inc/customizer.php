<?php

/**
 * WordPress カスタマイザー設定
 *
 * 管理画面「外観 > カスタマイズ」から設定できる画像を定義する。
 * 画像はすべてメディアライブラリからアップロード・選択する方式。
 *
 * 設定項目:
 *   - ヒーロー画像
 *   - SNS連絡先 QRコード（Kakao / WeChat / Instagram / LINE / WhatsApp）
 *   - SNSアイコン画像（Kakao / WeChat / Instagram / LINE / WhatsApp）
 *
 * 車両紹介は「車両紹介」投稿タイプ（管理画面サイドバー）で管理する。
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

    $wp_customize->add_setting('tenjoy_hero_image_position', [
        'default'           => 'center center',
        'sanitize_callback' => 'tenjoy_sanitize_hero_image_position',
    ]);

    $wp_customize->add_control('tenjoy_hero_image_position', [
        'label'   => __('画像の表示位置', 'tenjoy-tour'),
        'section' => 'tenjoy_hero',
        'type'    => 'select',
        'choices' => [
            'left top'      => __('左上', 'tenjoy-tour'),
            'center top'    => __('中央上', 'tenjoy-tour'),
            'right top'     => __('右上', 'tenjoy-tour'),
            'left center'   => __('左中央', 'tenjoy-tour'),
            'center center' => __('中央（初期値）', 'tenjoy-tour'),
            'right center'  => __('右中央', 'tenjoy-tour'),
            'left bottom'   => __('左下', 'tenjoy-tour'),
            'center bottom' => __('中央下', 'tenjoy-tour'),
            'right bottom'  => __('右下', 'tenjoy-tour'),
        ],
    ]);

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

    // ======================================================================
    // セクション5: SNSアイコン画像
    // ======================================================================

    $wp_customize->add_section('tenjoy_sns_icons', [
        'title' => __('SNSアイコン画像', 'tenjoy-tour'),
        'panel' => 'tenjoy_panel',
    ]);

    foreach ($messengers as $key => $label) {
        $wp_customize->add_setting("tenjoy_icon_{$key}", [
            'default'           => '',
            'sanitize_callback' => 'absint',
        ]);

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "tenjoy_icon_{$key}", [
            'label'       => sprintf(__('%s アイコン画像', 'tenjoy-tour'), $label),
            'description' => __('フッターおよび「今すぐお問い合わせ」欄のアイコンに使用されます。', 'tenjoy-tour'),
            'section'     => 'tenjoy_sns_icons',
            'mime_type'   => 'image',
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

/**
 * ヒーロー画像の表示位置（object-position）を許可リストで検証する。
 *
 * @param string $value
 * @return string
 */
function tenjoy_sanitize_hero_image_position(string $value): string
{
    $allowed = [
        'left top',
        'center top',
        'right top',
        'left center',
        'center center',
        'right center',
        'left bottom',
        'center bottom',
        'right bottom',
    ];

    return in_array($value, $allowed, true) ? $value : 'center center';
}
