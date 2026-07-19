<?php

/**
 * 通知メール設定ページ
 *
 * 管理画面「設定 → 通知メール」から
 * レビュー・お問い合わせの通知先メールアドレスを複数登録・管理できる。
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
        __('通知メール設定', 'tenjoy-tour'),
        __('通知メール', 'tenjoy-tour'),
        'manage_options',
        'tenjoy-notification-emails',
        'tenjoy_notification_settings_page'
    );
});

// ======================================================================
// Settings API 登録
// ======================================================================

add_action('admin_init', function () {
    register_setting(
        'tenjoy_notification_group',
        'tenjoy_notification_emails',
        [
            'sanitize_callback' => 'tenjoy_sanitize_notification_emails',
            'default'           => '',
        ]
    );

    add_settings_section(
        'tenjoy_notification_section',
        '',
        '__return_false',
        'tenjoy-notification-emails'
    );

    add_settings_field(
        'tenjoy_notification_emails_field',
        __('通知先メールアドレス', 'tenjoy-tour'),
        'tenjoy_notification_emails_field_render',
        'tenjoy-notification-emails',
        'tenjoy_notification_section'
    );
});

// ======================================================================
// バリデーション：有効なメールアドレスのみ保存
// ======================================================================

function tenjoy_sanitize_notification_emails(string $raw): string
{
    $lines  = preg_split('/[\r\n]+/', $raw);
    $valid  = [];

    foreach ($lines as $line) {
        $email = sanitize_email(trim($line));
        if ($email && is_email($email)) {
            $valid[] = $email;
        }
    }

    return implode("\n", array_unique($valid));
}

// ======================================================================
// フィールド描画
// ======================================================================

function tenjoy_notification_emails_field_render(): void
{
    $value = (string) get_option('tenjoy_notification_emails', '');
?>
    <textarea name="tenjoy_notification_emails" id="tenjoy_notification_emails" rows="8" cols="40" class="large-text"
        placeholder="example@gmail.com&#10;another@gmail.com"><?php echo esc_textarea($value); ?></textarea>
    <p class="description">
        <?php esc_html_e('1行につき1つのメールアドレスを入力してください。', 'tenjoy-tour'); ?><br>
        <?php esc_html_e('空欄の場合は管理者メールアドレス（設定 → 一般）に送信されます。', 'tenjoy-tour'); ?>
    </p>
<?php
}

// ======================================================================
// 設定ページ描画
// ======================================================================

function tenjoy_notification_settings_page(): void
{
    if (! current_user_can('manage_options')) {
        return;
    }
?>
    <div class="wrap">
        <h1><?php esc_html_e('通知メール設定', 'tenjoy-tour'); ?></h1>
        <p><?php esc_html_e('お問い合わせフォーム、およびお客様の声フォームから送信があったときに通知するメールアドレスを設定します。', 'tenjoy-tour'); ?></p>

        <?php settings_errors('tenjoy_notification_emails'); ?>

        <form method="post" action="options.php">
            <?php
            settings_fields('tenjoy_notification_group');
            do_settings_sections('tenjoy-notification-emails');
            submit_button(__('保存する', 'tenjoy-tour'));
            ?>
        </form>

        <hr>
        <h2><?php esc_html_e('現在の設定', 'tenjoy-tour'); ?></h2>
        <?php
        $emails = tenjoy_get_notification_emails();
        if ($emails) :
        ?>
            <ul>
                <?php foreach ($emails as $email) : ?>
                    <li><?php echo esc_html($email); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p><?php esc_html_e('未設定（管理者メールアドレスに送信）', 'tenjoy-tour'); ?></p>
        <?php endif; ?>
    </div>
<?php
}

// ======================================================================
// ヘルパー：通知先メールアドレス一覧を配列で返す
// ======================================================================

function tenjoy_get_notification_emails(): array
{
    $raw    = (string) get_option('tenjoy_notification_emails', '');
    $lines  = preg_split('/[\r\n]+/', $raw);
    $emails = [];

    foreach ($lines as $line) {
        $email = trim($line);
        if ($email && is_email($email)) {
            $emails[] = $email;
        }
    }

    return $emails;
}
