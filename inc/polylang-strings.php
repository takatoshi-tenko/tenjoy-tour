<?php

/**
 * Polylang 文字列翻訳
 *
 * テーマ内の固定文言（見出し・ボタン・ラベルなど）をPolylangの
 * 「言語 → 翻訳」画面から翻訳できるようにする。
 *
 * 文言の実体はこのファイルの $tenjoy_strings 配列のみに存在する。
 * テンプレート側はキー名で呼び出すだけなので、文言を変更したい
 * ときはこの配列だけを編集すればよい（二重管理にならない）。
 *
 * 使い方（テンプレート側）:
 *   tenjoy_e('hero_title');        // esc_html_e() の代わり
 *   tenjoy_attr_e('contact_name'); // esc_attr_e() の代わり
 *   tenjoy__('hero_title');        // __() の代わり（戻り値を使う場合）
 *
 * Polylangが無効な場合は元の日本語文字列がそのまま出力される。
 *
 * @package tenjoy-tour
 */

if (! defined('ABSPATH')) {
    exit;
}

// ======================================================================
// 文言データ（キー => [text, group]）
// ======================================================================

function tenjoy_strings(): array
{
    static $strings = null;

    if ($strings !== null) {
        return $strings;
    }

    $strings = [

        // ナビゲーション
        'nav_01' => ['text' => 'サービス', 'group' => 'ナビゲーション'],
        'nav_02' => ['text' => 'ゴルフ場', 'group' => 'ナビゲーション'],
        'nav_03' => ['text' => 'アクティビティ', 'group' => 'ナビゲーション'],
        'nav_04' => ['text' => 'お客様の声', 'group' => 'ナビゲーション'],
        'nav_05' => ['text' => '会社概要', 'group' => 'ナビゲーション'],
        'nav_06' => ['text' => 'お問い合わせ', 'group' => 'ナビゲーション'],

        // お問い合わせページ
        'contact_01' => ['text' => 'ご質問やご相談がございましたら、お気軽にお問い合わせください', 'group' => 'お問い合わせページ'],
        'contact_02' => ['text' => '電話でのお問い合わせ', 'group' => 'お問い合わせページ'],
        'contact_03' => ['text' => '平日 9:00 - 18:00', 'group' => 'お問い合わせページ'],
        'contact_04' => ['text' => 'メールでのお問い合わせ', 'group' => 'お問い合わせページ'],
        'contact_05' => ['text' => '24時間受付', 'group' => 'お問い合わせページ'],
        'contact_06' => ['text' => '本社所在地', 'group' => 'お問い合わせページ'],
        'contact_07' => ['text' => '東京都港区赤坂1-2-3 TENJOYビル 5F', 'group' => 'お問い合わせページ'],
        'contact_08' => ['text' => '地下鉄赤坂駅より徒歩3分', 'group' => 'お問い合わせページ'],
        'contact_09' => ['text' => '営業時間', 'group' => 'お問い合わせページ'],
        'contact_10' => ['text' => '土日祝日休業', 'group' => 'お問い合わせページ'],
        'contact_11' => ['text' => 'お問い合わせフォーム', 'group' => 'お問い合わせページ'],
        'contact_12' => ['text' => '以下のフォームからお問い合わせください。24時間以内にご返信いたします。', 'group' => 'お問い合わせページ'],
        'contact_13' => ['text' => 'お名前', 'group' => 'お問い合わせページ'],
        'contact_14' => ['text' => '山田 太郎', 'group' => 'お問い合わせページ'],
        'contact_15' => ['text' => 'メールアドレス', 'group' => 'お問い合わせページ'],
        'contact_16' => ['text' => '電話番号', 'group' => 'お問い合わせページ'],
        'contact_17' => ['text' => 'どの県に行く予定ですか', 'group' => 'お問い合わせページ'],
        'contact_18' => ['text' => '選択してください', 'group' => 'お問い合わせページ'],
        'contact_19' => ['text' => 'いつ日本に来る予定ですか', 'group' => 'お問い合わせページ'],
        'contact_20' => ['text' => 'まだ確定していない人は大体の日付で問題ございません', 'group' => 'お問い合わせページ'],
        'contact_21' => ['text' => 'お問い合わせ内容', 'group' => 'お問い合わせページ'],
        'contact_22' => ['text' => 'お問い合わせ内容を詳しくご記入ください', 'group' => 'お問い合わせページ'],
        'contact_23' => ['text' => '送信する', 'group' => 'お問い合わせページ'],
        'contact_24' => ['text' => '営業日24時間以内にご返信いたします', 'group' => 'お問い合わせページ'],
        'contact_25' => ['text' => 'よくあるご質問', 'group' => 'お問い合わせページ'],
        'contact_26' => ['text' => 'キャンセル料はかかりますか？', 'group' => 'お問い合わせページ'],
        'contact_27' => ['text' => 'ツアー開始日の30日前まで無料でキャンセルいただけます。30日以内の場合はツアー代金の50%、7日以内の場合は100%のキャンセル料が発生いたします。', 'group' => 'お問い合わせページ'],
        'contact_28' => ['text' => 'ツアー代金に何が含まれていますか？', 'group' => 'お問い合わせページ'],
        'contact_29' => ['text' => 'ゴルフプレイ費、宿泊費、朝食・昼食、空港送迎、専門ガイド、旅行保険が含まれています。航空券は含まれておりませんので、別途ご手配ください。', 'group' => 'お問い合わせページ'],
        'contact_30' => ['text' => '初心者でも参加できますか？', 'group' => 'お問い合わせページ'],
        'contact_31' => ['text' => 'はい、もちろん歓迎いたします。経験豊富なスタッフがサポートし、初心者の方でも楽しめるコースを選定しています。', 'group' => 'お問い合わせページ'],

        // ゴルフ場詳細
        'course_single_01' => ['text' => 'このコースについてお問い合わせする', 'group' => 'ゴルフ場詳細'],
        'course_single_02' => ['text' => 'コース一覧に戻る', 'group' => 'ゴルフ場詳細'],
        'course_single_03' => ['text' => 'コース情報', 'group' => 'ゴルフ場詳細'],
        'course_single_04' => ['text' => '都道府県', 'group' => 'ゴルフ場詳細'],
        'course_single_05' => ['text' => '住所', 'group' => 'ゴルフ場詳細'],
        'course_single_06' => ['text' => 'ホール数', 'group' => 'ゴルフ場詳細'],
        'course_single_07' => ['text' => 'グリーンフィー', 'group' => 'ゴルフ場詳細'],
        'course_single_08' => ['text' => 'キャディ', 'group' => 'ゴルフ場詳細'],
        'course_single_09' => ['text' => 'あり', 'group' => 'ゴルフ場詳細'],
        'course_single_10' => ['text' => 'なし', 'group' => 'ゴルフ場詳細'],
        'course_single_11' => ['text' => 'カート', 'group' => 'ゴルフ場詳細'],
        'course_single_12' => ['text' => '公式サイト', 'group' => 'ゴルフ場詳細'],
        'course_single_13' => ['text' => '外部サイトを開く', 'group' => 'ゴルフ場詳細'],
        'course_single_14' => ['text' => 'アクセスマップ', 'group' => 'ゴルフ場詳細'],
        'course_single_15' => ['text' => 'このコースが気になりましたか？', 'group' => 'ゴルフ場詳細'],
        'course_single_16' => ['text' => '空き状況やご予約について、専門スタッフが丁寧にご案内いたします。', 'group' => 'ゴルフ場詳細'],

        // アクティビティ詳細
        'activity_single_01' => ['text' => '一覧に戻る', 'group' => 'アクティビティ詳細'],
        'activity_single_02' => ['text' => 'ゴルフ', 'group' => 'アクティビティ詳細'],
        'activity_single_03' => ['text' => '場所', 'group' => 'アクティビティ詳細'],
        'activity_single_04' => ['text' => '所要時間', 'group' => 'アクティビティ詳細'],
        'activity_single_05' => ['text' => '料金', 'group' => 'アクティビティ詳細'],
        'activity_single_06' => ['text' => 'フォトギャラリー', 'group' => 'アクティビティ詳細'],
        'activity_single_07' => ['text' => 'このアクティビティに興味がありますか？', 'group' => 'アクティビティ詳細'],
        'activity_single_08' => ['text' => 'お問い合わせ・予約', 'group' => 'アクティビティ詳細'],
        'activity_single_10' => ['text' => 'ご不明な点やご予約について、お気軽にお問い合わせください。', 'group' => 'アクティビティ詳細'],

        // よくある質問ページ
        'faq_01' => ['text' => 'よくある質問', 'group' => 'よくある質問ページ'],
        'faq_02' => ['text' => 'お客様からよくいただくご質問をまとめました', 'group' => 'よくある質問ページ'],
        'faq_03' => ['text' => 'FAQはまだ登録されていません。管理画面の「よくある質問」から追加してください。', 'group' => 'よくある質問ページ'],
        'faq_04' => ['text' => '解決しない場合は', 'group' => 'よくある質問ページ'],
        'faq_05' => ['text' => '上記以外のご質問がございましたら、お気軽にお問い合わせください。', 'group' => 'よくある質問ページ'],
        'faq_06' => ['text' => 'お問い合わせはこちら', 'group' => 'よくある質問ページ'],

        // ヘッダー
        'header_01' => ['text' => 'メインメニュー', 'group' => 'ヘッダー'],
        'header_02' => ['text' => '言語切替', 'group' => 'ヘッダー'],
        'header_03' => ['text' => 'メニューを開く', 'group' => 'ヘッダー'],
        'header_04' => ['text' => 'モバイルメニュー', 'group' => 'ヘッダー'],

        // お客様の声ページ
        'testimonials_page_01' => ['text' => '実際にご利用いただいたお客様からのレビューです', 'group' => 'お客様の声ページ'],
        'testimonials_page_02' => ['text' => 'お客様の声はまだ登録されていません。', 'group' => 'お客様の声ページ'],
        'testimonials_page_03' => ['text' => 'レビューを投稿する', 'group' => 'お客様の声ページ'],
        'testimonials_page_04' => ['text' => '出身国・地域', 'group' => 'お客様の声ページ'],
        'testimonials_page_05' => ['text' => '評価', 'group' => 'お客様の声ページ'],
        'testimonials_page_06' => ['text' => '星評価', 'group' => 'お客様の声ページ'],
        'testimonials_page_07' => ['text' => 'コメント', 'group' => 'お客様の声ページ'],
        'testimonials_page_08' => ['text' => 'ご感想をお書きください', 'group' => 'お客様の声ページ'],

        // レビュー投稿（送信結果メッセージ）
        'review_ajax_01' => ['text' => 'セキュリティエラーが発生しました。', 'group' => 'レビュー投稿'],
        'review_ajax_02' => ['text' => 'お名前とコメントは必須です。', 'group' => 'レビュー投稿'],
        'review_ajax_03' => ['text' => '送信に失敗しました。', 'group' => 'レビュー投稿'],
        'review_ajax_04' => ['text' => '送信しました、レビューいただきまして誠にありがとうございます！', 'group' => 'レビュー投稿'],

        // 共通
        'common_01' => ['text' => 'コンテンツが見つかりません。', 'group' => '共通'],

        // フッター
        'footer_01' => ['text' => '方日ゴルファーのためのゴルフ場予約・ホテル・送迎を完全サポート', 'group' => 'フッター'],
        'footer_02' => ['text' => 'サイトマップ', 'group' => 'フッター'],
        'footer_03' => ['text' => 'ホーム', 'group' => 'フッター'],
        'footer_04' => ['text' => 'ゴルフ場一覧', 'group' => 'フッター'],
        'footer_05' => ['text' => 'スタッフ紹介', 'group' => 'フッター'],
        'footer_06' => ['text' => 'ブログ', 'group' => 'フッター'],
        'footer_07' => ['text' => 'メッセージアプリ', 'group' => 'フッター'],
        'footer_08' => ['text' => 'All rights reserved.', 'group' => 'フッター'],

        // ゴルフ場一覧
        'courses_archive_01' => ['text' => '日本全国の厳選されたゴルフコースをご紹介します', 'group' => 'ゴルフ場一覧'],
        'courses_archive_02' => ['text' => '回訪問', 'group' => 'ゴルフ場一覧'],
        'courses_archive_03' => ['text' => '詳細を見る', 'group' => 'ゴルフ場一覧'],
        'courses_archive_04' => ['text' => 'ゴルフ場情報は準備中です。', 'group' => 'ゴルフ場一覧'],
        'courses_archive_05' => ['text' => 'ご希望のゴルフ場が見つかりましたか？', 'group' => 'ゴルフ場一覧'],
        'courses_archive_06' => ['text' => 'ゴルフ場の予約から交通手配まで、お気軽にご相談ください。', 'group' => 'ゴルフ場一覧'],
        'courses_archive_07' => ['text' => '無料でお問い合わせ', 'group' => 'ゴルフ場一覧'],

        // アクティビティ一覧
        'activities_archive_01' => ['text' => '日本各地でゴルフと合わせて楽しめるアクティビティをご紹介します', 'group' => 'アクティビティ一覧'],
        'activities_archive_02' => ['text' => 'アクティビティ情報は準備中です。', 'group' => 'アクティビティ一覧'],

        // 会社概要ページ
        'company_01' => ['text' => 'TENJOY-TOUR について', 'group' => '会社概要ページ'],
        'company_02' => ['text' => 'Have a good tour. Have a good trip !', 'group' => '会社概要ページ'],
        'company_03' => ['text' => '訪日ゴルファーの皆様へ', 'group' => '会社概要ページ'],
        'company_04' => ['text' => 'TENJOY-TOURは、日本でのゴルフ旅行を心から楽しんでいただくために設立されました。ゴルフ場の予約・送迎・ガイドなど、旅行に関わるすべての手配を私たちにお任せください。', 'group' => '会社概要ページ'],
        'company_05' => ['text' => '日本語・中国語・韓国語・英語に対応したスタッフが、お客様一人ひとりに寄り添いながら、最高のゴルフ旅行をサポートいたします。', 'group' => '会社概要ページ'],
        'company_06' => ['text' => '代表取締役　', 'group' => '会社概要ページ'],
        'company_07' => ['text' => '基本情報', 'group' => '会社概要ページ'],
        'company_08' => ['text' => '会社名', 'group' => '会社概要ページ'],
        'company_09' => ['text' => '代表者', 'group' => '会社概要ページ'],
        'company_10' => ['text' => '設立', 'group' => '会社概要ページ'],
        'company_11' => ['text' => '資本金', 'group' => '会社概要ページ'],
        'company_12' => ['text' => '従業員数', 'group' => '会社概要ページ'],
        'company_13' => ['text' => '所在地', 'group' => '会社概要ページ'],
        'company_14' => ['text' => '対応言語', 'group' => '会社概要ページ'],
        'company_15' => ['text' => '事業内容', 'group' => '会社概要ページ'],
        'company_16' => ['text' => '旅行業', 'group' => '会社概要ページ'],
        'company_17' => ['text' => '訪日外国人向けのゴルフ旅行・観光ツアーの企画・手配を行います。', 'group' => '会社概要ページ'],
        'company_18' => ['text' => '翻訳・通訳', 'group' => '会社概要ページ'],
        'company_19' => ['text' => '中国語・韓国語・英語に対応した翻訳・通訳サービスを提供します。', 'group' => '会社概要ページ'],
        'company_20' => ['text' => '観光ガイド', 'group' => '会社概要ページ'],
        'company_21' => ['text' => '経験豊富なガイドが日本各地の観光スポットをご案内します。', 'group' => '会社概要ページ'],
        'company_22' => ['text' => '送迎・チャーター', 'group' => '会社概要ページ'],
        'company_23' => ['text' => '空港・ゴルフ場間の送迎から長距離チャーターまで対応します。', 'group' => '会社概要ページ'],
        'company_24' => ['text' => 'サービスエリア', 'group' => '会社概要ページ'],
        'service_area_01' => ['text' => '九州地域（福岡、佐賀、大分、長崎、熊本、鹿児島、宮崎）、山口、札幌、沖縄、千葉、大阪。', 'group' => '会社概要ページ'],
        'service_area_02' => ['text' => '参考', 'group' => '会社概要ページ'],
        'service_area_03' => ['text' => '日本のゴルフ場：', 'group' => '会社概要ページ'],
        'service_area_04' => ['text' => '日本のゴルフ', 'group' => '会社概要ページ'],
        'service_area_05' => ['text' => '日本ホテル：', 'group' => '会社概要ページ'],
        'service_area_06' => ['text' => '日本ホテル', 'group' => '会社概要ページ'],
        'service_area_07' => ['text' => '※北海道、大阪、東京、その他地域は別途ご相談が必要です。', 'group' => '会社概要ページ'],
        'company_31' => ['text' => 'ご不明な点はお気軽にお問い合わせください', 'group' => '会社概要ページ'],
        'company_32' => ['text' => 'WeChat・Kakao Talk・LINE・WhatsApp でもご連絡いただけます。', 'group' => '会社概要ページ'],
        'company_33' => ['text' => 'ゴルフ場を見る', 'group' => '会社概要ページ'],

        // トップページ
        'home_01' => ['text' => 'ゴルフ旅行に役立つ最新情報をお届けします', 'group' => 'トップページ'],
        'home_02' => ['text' => '記事はまだありません。', 'group' => 'トップページ'],
        'home_03' => ['text' => 'ブログ記事は現在韓国語でのみ更新しております。恐れ入りますが、下記より韓国語版のブログをご覧ください。', 'group' => 'トップページ'],
        'home_04' => ['text' => '韓国語版ブログを見る', 'group' => 'トップページ'],

        // サイトマップページ
        'sitemap_01' => ['text' => 'サイト内のページ一覧です', 'group' => 'サイトマップページ'],
        'sitemap_02' => ['text' => 'メイン', 'group' => 'サイトマップページ'],
        'sitemap_03' => ['text' => 'トップページ', 'group' => 'サイトマップページ'],
        'sitemap_04' => ['text' => 'ゴルフ・アクティビティ', 'group' => 'サイトマップページ'],
        'sitemap_05' => ['text' => 'アクティビティ一覧', 'group' => 'サイトマップページ'],
        'sitemap_06' => ['text' => 'サポート', 'group' => 'サイトマップページ'],
        'sitemap_07' => ['text' => 'ブログ一覧', 'group' => 'サイトマップページ'],
        'sitemap_08' => ['text' => 'その他', 'group' => 'サイトマップページ'],
        'sitemap_09' => ['text' => 'プライバシーポリシー', 'group' => 'サイトマップページ'],

        // 共通
        'common_02' => ['text' => 'パンくず', 'group' => '共通'],
        'common_03' => ['text' => 'ブログ一覧に戻る', 'group' => '共通'],

        // 画像ライトボックス
        'lightbox_01' => ['text' => '閉じる', 'group' => '共通'],
        'lightbox_02' => ['text' => '前の画像', 'group' => '共通'],
        'lightbox_03' => ['text' => '次の画像', 'group' => '共通'],

        // トップ：会社概要
        'company_home_01' => ['text' => '会社情報', 'group' => 'トップ：会社概要'],
        'company_home_02' => ['text' => '日本、東京、渋谷区', 'group' => 'トップ：会社概要'],
        'company_home_03' => ['text' => '会社概要を見る →', 'group' => 'トップ：会社概要'],
        'price_list_01' => ['text' => '料金表', 'group' => 'トップ：会社概要'],
        'price_list_02' => ['text' => '移動に関する料金表はこちらをご覧ください。', 'group' => 'トップ：会社概要'],
        'price_list_03' => ['text' => '料金表', 'group' => 'トップ：会社概要'],

        // トップ：お問い合わせ導線
        'contact_qr_01' => ['text' => '韓国で人気', 'group' => 'トップ：お問い合わせ導線'],
        'contact_qr_02' => ['text' => 'カカオトークで連絡', 'group' => 'トップ：お問い合わせ導線'],
        'contact_qr_03' => ['text' => '中国で人気', 'group' => 'トップ：お問い合わせ導線'],
        'contact_qr_04' => ['text' => 'WeChatで連絡', 'group' => 'トップ：お問い合わせ導線'],
        'contact_qr_05' => ['text' => '写真・動画を公開中', 'group' => 'トップ：お問い合わせ導線'],
        'contact_qr_06' => ['text' => 'Instagramでフォロー', 'group' => 'トップ：お問い合わせ導線'],
        'contact_qr_07' => ['text' => '日本で人気', 'group' => 'トップ：お問い合わせ導線'],
        'contact_qr_08' => ['text' => 'LINEで連絡', 'group' => 'トップ：お問い合わせ導線'],
        'contact_qr_09' => ['text' => '世界中で人気', 'group' => 'トップ：お問い合わせ導線'],
        'contact_qr_10' => ['text' => 'WhatsAppで連絡', 'group' => 'トップ：お問い合わせ導線'],
        'contact_qr_11' => ['text' => '今すぐお問い合わせ', 'group' => 'トップ：お問い合わせ導線'],
        'contact_qr_12' => ['text' => 'お好みのメッセージアプリでQRコードをスキャンして、簡単にお問い合わせいただけます', 'group' => 'トップ：お問い合わせ導線'],
        'contact_qr_13' => ['text' => '迅速な対応をお約束します', 'group' => 'トップ：お問い合わせ導線'],
        'contact_qr_14' => ['text' => 'メッセージを受信次第、できるだけ早くご返信いたします。お気軽にお問い合わせください。', 'group' => 'トップ：お問い合わせ導線'],

        // スタッフ一覧ページ
        'staff_page_01' => ['text' => '経験豊富なスタッフがお客様のゴルフ旅行をサポートします', 'group' => 'スタッフ一覧ページ'],
        'staff_page_02' => ['text' => 'スタッフ情報は準備中です。', 'group' => 'スタッフ一覧ページ'],

        // トップ：ヒーロー
        'hero_01' => ['text' => 'ゴルフコース', 'group' => 'トップ：ヒーロー'],
        'hero_02' => ['text' => '日本のゴルフ手配専門', 'group' => 'トップ：ヒーロー'],
        'hero_03' => ['text' => '訪日ゴルファーの皆様へ、ゴルフ場予約・送迎を完全サポート', 'group' => 'トップ：ヒーロー'],

        // トップ：スタッフ
        'staff_home_01' => ['text' => 'スタッフ一覧を見る', 'group' => 'トップ：スタッフ'],

        // トップ：車両紹介
        'vehicles_09' => ['text' => '車両紹介', 'group' => 'トップ：車両紹介'],
        'vehicles_10' => ['text' => '快適で安全な移動のため、様々なタイプの車両をご用意しています', 'group' => 'トップ：車両紹介'],

        // トップ：お客様の声
        'reviews_01' => ['text' => '素晴らしいサービスでした。ゴルフ場の予約から送迎まで全てスムーズに手配していただき、日本でのゴルフ旅行が最高の思い出になりました。', 'group' => 'トップ：お客様の声'],
        'reviews_02' => ['text' => '初めての日本ゴルフ旅行でしたが、言葉の心配もなくスタッフの方が親切に対応してくれました。コースも素晴らしかったです。', 'group' => 'トップ：お客様の声'],
        'reviews_03' => ['text' => '友人4人での旅行でしたが、全員が大満足でした。次回は家族も連れて来たいと思います。', 'group' => 'トップ：お客様の声'],
        'reviews_04' => ['text' => 'もっと見る →', 'group' => 'トップ：お客様の声'],

        // トップ：サービス
        'services_01' => ['text' => 'ゴルフ場予約', 'group' => 'トップ：サービス'],
        'services_02' => ['text' => '日本全国の名門ゴルフコースの予約を代行。お客様のご希望に合わせた最適なコースをご提案します。', 'group' => 'トップ：サービス'],
        'services_03' => ['text' => '空港送迎', 'group' => 'トップ：サービス'],
        'services_04' => ['text' => '空港からゴルフ場への送迎サービス。安全で快適な移動をサポートします。', 'group' => 'トップ：サービス'],
        'services_05' => ['text' => '現地サポート', 'group' => 'トップ：サービス'],
        'services_06' => ['text' => '滞在中の困りごとや追加手配など、現地での24時間サポート体制を整えています。', 'group' => 'トップ：サービス'],
        'services_07' => ['text' => '提供サービス', 'group' => 'トップ：サービス'],
        'services_08' => ['text' => '日本でのゴルフを快適に楽しんでいただくため、あらゆる手配をサポートいたします', 'group' => 'トップ：サービス'],
    ];

    return $strings;
}

// ======================================================================
// Polylangへの登録（毎リクエストで実行。管理画面の翻訳一覧にも必要）
// ======================================================================

add_action('init', 'tenjoy_register_pll_strings', 20);

function tenjoy_register_pll_strings(): void
{
    if (! function_exists('pll_register_string')) {
        return;
    }

    foreach (tenjoy_strings() as $key => $item) {
        pll_register_string($key, $item['text'], $item['group']);
    }
}

// ======================================================================
// ヘルパー関数
// ======================================================================

/**
 * 登録済みキーの翻訳を返す（Polylang未使用時は元の文字列を返す）。
 *
 * @param string $key tenjoy_strings() のキー
 * @return string
 */
function tenjoy__(string $key): string
{
    $strings = tenjoy_strings();
    $text    = $strings[$key]['text'] ?? $key;

    return function_exists('pll__') ? pll__($text) : $text;
}

/**
 * エスケープ済みの翻訳文字列を出力する（esc_html_e() の代替）。
 *
 * @param string $key tenjoy_strings() のキー
 */
function tenjoy_e(string $key): void
{
    echo esc_html(tenjoy__($key));
}

/**
 * 属性値として使う翻訳文字列を出力する（esc_attr_e() の代替）。
 *
 * @param string $key tenjoy_strings() のキー
 */
function tenjoy_attr_e(string $key): void
{
    echo esc_attr(tenjoy__($key));
}
