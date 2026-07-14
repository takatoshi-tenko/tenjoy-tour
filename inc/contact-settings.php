<?php

/**
 * お問い合わせフォーム設定
 *
 * 管理画面「設定 → お問い合わせ選択肢」から
 * 「どの県に行く予定ですか」の選択肢を登録・管理できる。
 *
 * @package tenjoy-tour
 */

if (! defined('ABSPATH')) {
    exit;
}

// ======================================================================
// 設定ページ登録
// ======================================================================

add_action('admin_menu', function () {
    add_options_page(
        __('お問い合わせ選択肢設定', 'tenjoy-tour'),
        __('お問い合わせ選択肢', 'tenjoy-tour'),
        'manage_options',
        'tenjoy-contact-prefectures',
        'tenjoy_contact_prefectures_settings_page'
    );
});

// ======================================================================
// Settings API 登録
// ======================================================================

add_action('admin_init', function () {
    register_setting(
        'tenjoy_contact_prefectures_group',
        'tenjoy_contact_prefectures',
        [
            'sanitize_callback' => 'tenjoy_sanitize_contact_prefectures',
            'default'           => "北海道\n東京都\n神奈川県\n千葉県\n大阪府\n沖縄県\nその他",
        ]
    );

    add_settings_section(
        'tenjoy_contact_prefectures_section',
        '',
        '__return_false',
        'tenjoy-contact-prefectures'
    );

    add_settings_field(
        'tenjoy_contact_prefectures_field',
        __('選択肢一覧', 'tenjoy-tour'),
        'tenjoy_contact_prefectures_field_render',
        'tenjoy-contact-prefectures',
        'tenjoy_contact_prefectures_section'
    );
});

// ======================================================================
// バリデーション：空行を除いた文字列のみ保存
// ======================================================================

function tenjoy_sanitize_contact_prefectures(string $raw): string
{
    $lines = preg_split('/[\r\n]+/', $raw);
    $valid = [];

    foreach ($lines as $line) {
        $text = sanitize_text_field(trim($line));
        if ($text !== '') {
            $valid[] = $text;
        }
    }

    return implode("\n", $valid);
}

// ======================================================================
// フィールド描画
// ======================================================================

function tenjoy_contact_prefectures_field_render(): void
{
    $value = (string) get_option('tenjoy_contact_prefectures', '');
    ?>
    <textarea
        name="tenjoy_contact_prefectures"
        id="tenjoy_contact_prefectures"
        rows="8"
        cols="40"
        class="large-text"
        placeholder="北海道&#10;東京都"
    ><?php echo esc_textarea($value); ?></textarea>
    <p class="description">
        <?php esc_html_e('1行につき1つの選択肢を入力してください。お問い合わせフォームの「どの県に行く予定ですか」のプルダウンに表示されます。', 'tenjoy-tour'); ?>
    </p>
    <?php
}

// ======================================================================
// 設定ページ描画
// ======================================================================

function tenjoy_contact_prefectures_settings_page(): void
{
    if (! current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('お問い合わせ選択肢設定', 'tenjoy-tour'); ?></h1>
        <p><?php esc_html_e('お問い合わせフォームの「どの県に行く予定ですか」に表示する選択肢を設定します。', 'tenjoy-tour'); ?></p>

        <?php settings_errors('tenjoy_contact_prefectures'); ?>

        <form method="post" action="options.php">
            <?php
            settings_fields('tenjoy_contact_prefectures_group');
            do_settings_sections('tenjoy-contact-prefectures');
            submit_button(__('保存する', 'tenjoy-tour'));
            ?>
        </form>
    </div>
    <?php
}

// ======================================================================
// ヘルパー：選択肢一覧を配列で返す
// ======================================================================

function tenjoy_get_contact_prefectures(): array
{
    $raw   = (string) get_option('tenjoy_contact_prefectures', '');
    $lines = preg_split('/[\r\n]+/', $raw);
    $items = [];

    foreach ($lines as $line) {
        $text = trim($line);
        if ($text !== '') {
            $items[] = $text;
        }
    }

    return $items;
}
