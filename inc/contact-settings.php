<?php

/**
 * お問い合わせフォーム設定
 *
 * 管理画面「設定 → お問い合わせ選択肢」から
 * 「どの県に行く予定ですか」の選択肢を登録・管理できる。
 * 登録した文言は Polylang の文字列翻訳で言語ごとに翻訳できる。
 *
 * @package tenjoy-tour
 */

if (! defined('ABSPATH')) {
    exit;
}

/** @var string 未設定時の初期選択肢 */
const TENJOY_CONTACT_PREFECTURES_DEFAULT = "北海道\n東京都\n神奈川県\n千葉県\n大阪府\n沖縄県\nその他";

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
            'default'           => TENJOY_CONTACT_PREFECTURES_DEFAULT,
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
// Polylang 文字列登録
// ======================================================================

add_action('init', 'tenjoy_register_contact_prefecture_strings', 20);

/**
 * 県の選択肢を Polylang の文字列翻訳に登録する。
 */
function tenjoy_register_contact_prefecture_strings(): void
{
    if (! function_exists('pll_register_string')) {
        return;
    }

    foreach (tenjoy_get_contact_prefectures() as $index => $prefecture) {
        pll_register_string(
            'contact_prefecture_' . ($index + 1),
            $prefecture,
            'お問い合わせ：県の選択肢'
        );
    }
}

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
    $value = (string) get_option('tenjoy_contact_prefectures', TENJOY_CONTACT_PREFECTURES_DEFAULT);
?>
<textarea name="tenjoy_contact_prefectures" id="tenjoy_contact_prefectures" rows="8" cols="40" class="large-text"
  placeholder="北海道&#10;東京都"><?php echo esc_textarea($value); ?></textarea>
<p class="description">
  <?php esc_html_e('1行につき1つの選択肢を日本語で入力してください。お問い合わせフォームの「どの県に行く予定ですか」のプルダウンに表示されます。', 'tenjoy-tour'); ?>
</p>
<p class="description">
  <?php esc_html_e('英語・韓国語・中国語への翻訳は「言語 → 文字列の翻訳」のグループ「お問い合わせ：県の選択肢」から行えます。', 'tenjoy-tour'); ?>
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

/**
 * 県の選択肢一覧を返す（日本語の原文）。
 *
 * @return list<string>
 */
function tenjoy_get_contact_prefectures(): array
{
    $raw = (string) get_option('tenjoy_contact_prefectures', TENJOY_CONTACT_PREFECTURES_DEFAULT);
    if ($raw === '') {
        $raw = TENJOY_CONTACT_PREFECTURES_DEFAULT;
    }

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

/**
 * 県の選択肢を現在の言語に翻訳して返す。
 *
 * @param string $prefecture 日本語の原文
 * @return string
 */
function tenjoy_translate_contact_prefecture(string $prefecture): string
{
    return function_exists('pll__') ? pll__($prefecture) : $prefecture;
}

// ======================================================================
// お問い合わせフォーム送信処理
// ======================================================================

add_action('template_redirect', 'tenjoy_handle_contact_form');

/**
 * お問い合わせフォームの POST を処理し、通知メール送信後にリダイレクトする。
 */
function tenjoy_handle_contact_form(): void
{
    if (
        ($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST'
        || empty($_POST['tenjoy_contact_nonce'])
        || empty($_POST['tenjoy_contact_submit'])
    ) {
        return;
    }

    $redirect_url = tenjoy_page_url('contact', '/contact/');

    if (! wp_verify_nonce(
        sanitize_text_field(wp_unslash($_POST['tenjoy_contact_nonce'])),
        'tenjoy_contact'
    )) {
        wp_safe_redirect(add_query_arg('contact', 'error', $redirect_url));
        exit;
    }

    // ハニーポット（ボット対策）
    if (! empty($_POST['contact_website'])) {
        wp_safe_redirect(add_query_arg('contact', 'sent', $redirect_url));
        exit;
    }

    $name       = sanitize_text_field(wp_unslash($_POST['contact_name'] ?? ''));
    $email      = sanitize_email(wp_unslash($_POST['contact_email'] ?? ''));
    $phone      = sanitize_text_field(wp_unslash($_POST['contact_phone'] ?? ''));
    $prefecture = sanitize_text_field(wp_unslash($_POST['contact_prefecture'] ?? ''));
    $visit_date = sanitize_text_field(wp_unslash($_POST['contact_visit_date'] ?? ''));
    $message    = sanitize_textarea_field(wp_unslash($_POST['contact_message'] ?? ''));

    $allowed_prefectures = tenjoy_get_contact_prefectures();

    if (
        $name === ''
        || $email === ''
        || ! is_email($email)
        || $prefecture === ''
        || ! in_array($prefecture, $allowed_prefectures, true)
        || $visit_date === ''
    ) {
        wp_safe_redirect(add_query_arg('contact', 'invalid', $redirect_url));
        exit;
    }

    $data = [
        'name'       => $name,
        'email'      => $email,
        'phone'      => $phone,
        'prefecture' => $prefecture,
        'visit_date' => $visit_date,
        'message'    => $message,
    ];

    $post_id = tenjoy_save_contact_inquiry($data);
    if (! $post_id) {
        wp_safe_redirect(add_query_arg('contact', 'error', $redirect_url));
        exit;
    }

    tenjoy_send_contact_notification($data, $post_id);

    wp_safe_redirect(add_query_arg('contact', 'sent', $redirect_url));
    exit;
}

/**
 * お問い合わせ内容を管理画面用に保存する。
 *
 * @param array{name:string,email:string,phone:string,prefecture:string,visit_date:string,message:string} $data
 * @return int 投稿ID。失敗時は 0
 */
function tenjoy_save_contact_inquiry(array $data): int
{
    $post_id = wp_insert_post([
        'post_type'    => 'tenjoy_contact',
        'post_title'   => $data['name'],
        'post_content' => $data['message'],
        'post_status'  => 'private',
    ], true);

    if (is_wp_error($post_id) || ! $post_id) {
        return 0;
    }

    update_post_meta($post_id, 'contact_email', $data['email']);
    update_post_meta($post_id, 'contact_phone', $data['phone']);
    update_post_meta($post_id, 'contact_prefecture', $data['prefecture']);
    update_post_meta($post_id, 'contact_visit_date', $data['visit_date']);

    return (int) $post_id;
}

/**
 * お問い合わせ内容を通知先メールへ送信する。
 *
 * @param array{name:string,email:string,phone:string,prefecture:string,visit_date:string,message:string} $data
 * @param int                                                                                              $post_id
 * @return bool
 */
function tenjoy_send_contact_notification(array $data, int $post_id = 0): bool
{
    $to        = tenjoy_get_notification_emails() ?: [get_option('admin_email')];
    $site_name = get_bloginfo('name');
    $phone     = $data['phone'] !== '' ? $data['phone'] : '（未入力）';
    $message   = $data['message'] !== '' ? $data['message'] : '（未入力）';
    $manage_url = $post_id > 0
        ? admin_url('post.php?post=' . $post_id . '&action=edit')
        : admin_url('edit.php?post_type=tenjoy_contact');

    $subject = "[{$site_name}] お問い合わせが届きました";
    $body    = "ウェブサイトからお問い合わせが届きました。\n\n"
        . "━━━━━━━━━━━━━━━━━━━━\n"
        . "お名前　　：{$data['name']}\n"
        . "メール　　：{$data['email']}\n"
        . "電話番号　：{$phone}\n"
        . "予定の県　：{$data['prefecture']}\n"
        . "来日予定日：{$data['visit_date']}\n"
        . "お問い合わせ内容：\n{$message}\n"
        . "━━━━━━━━━━━━━━━━━━━━\n\n"
        . "▼ 管理画面で確認する\n"
        . $manage_url . "\n";

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $data['email'],
    ];

    return (bool) wp_mail($to, $subject, $body, $headers);
}