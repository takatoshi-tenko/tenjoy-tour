<?php

/**
 * カスタムメタボックス定義
 * 各 CPT の管理画面フォームを提供する
 *
 * @package tenjoy-tour
 */

if (! defined('ABSPATH')) {
  exit;
}

// ==========================================================================
// メタボックス登録
// ==========================================================================

add_action('add_meta_boxes', function () {
  // 車両紹介
  add_meta_box(
    'tenjoy_vehicle_meta',
    __('車両情報', 'tenjoy-tour'),
    'tenjoy_render_vehicle_meta_box',
    'vehicles',
    'normal',
    'high'
  );

  // ゴルフ場
  add_meta_box(
    'tenjoy_course_meta',
    __('ゴルフ場情報', 'tenjoy-tour'),
    'tenjoy_render_course_meta_box',
    'courses',
    'normal',
    'high'
  );

  // アクティビティ
  add_meta_box(
    'tenjoy_activity_meta',
    __('アクティビティ情報', 'tenjoy-tour'),
    'tenjoy_render_activity_meta_box',
    'activities',
    'normal',
    'high'
  );

  // お客様の声
  add_meta_box(
    'tenjoy_review_meta',
    __('レビュー詳細', 'tenjoy-tour'),
    'tenjoy_render_review_meta_box',
    'tenjoy_review',
    'normal',
    'high'
  );

  // お問い合わせ
  add_meta_box(
    'tenjoy_contact_meta',
    __('お問い合わせ詳細', 'tenjoy-tour'),
    'tenjoy_render_contact_meta_box',
    'tenjoy_contact',
    'normal',
    'high'
  );

  // スタッフ
  add_meta_box(
    'tenjoy_staff_meta',
    __('スタッフ情報', 'tenjoy-tour'),
    'tenjoy_render_staff_meta_box',
    'staff',
    'normal',
    'high'
  );

  // 会社概要ページ（テンプレート判定）
  add_meta_box(
    'tenjoy_company_meta',
    __('会社基本情報', 'tenjoy-tour'),
    'tenjoy_render_company_meta_box',
    'page',
    'normal',
    'high'
  );
});

// ==========================================================================
// 共通ヘルパー
// ==========================================================================

/**
 * テキスト入力フィールドを出力する
 *
 * @param int    $post_id
 * @param string $key      メタキー
 * @param string $label    ラベル
 * @param string $type     input type (text / url / number)
 * @param string $desc     補足説明（任意）
 */
function tenjoy_meta_text_field($post_id, $key, $label, $type = 'text', $desc = '')
{
  $value = get_post_meta($post_id, $key, true);
  $id    = esc_attr($key);
?>
  <div class="tenjoy-meta-field">
    <label for="<?php echo $id; ?>"><strong><?php echo esc_html($label); ?></strong></label>
    <input type="<?php echo esc_attr($type); ?>" id="<?php echo $id; ?>" name="<?php echo $id; ?>"
      value="<?php echo esc_attr((string) $value); ?>" class="widefat">
    <?php if ($desc) : ?>
      <p class="description"><?php echo esc_html($desc); ?></p>
    <?php endif; ?>
  </div>
<?php
}

/**
 * チェックボックスフィールドを出力する
 *
 * @param int    $post_id
 * @param string $key
 * @param string $label
 * @param string $desc
 */
function tenjoy_meta_checkbox_field($post_id, $key, $label, $desc = '')
{
  $value = (bool) get_post_meta($post_id, $key, true);
  $id    = esc_attr($key);
?>
  <div class="tenjoy-meta-field">
    <label>
      <input type="checkbox" id="<?php echo $id; ?>" name="<?php echo $id; ?>" value="1" <?php checked($value, true); ?>>
      <strong><?php echo esc_html($label); ?></strong>
    </label>
    <?php if ($desc) : ?>
      <p class="description"><?php echo esc_html($desc); ?></p>
    <?php endif; ?>
  </div>
<?php
}

// ==========================================================================
// 車両紹介メタボックス
// ==========================================================================

/**
 * @param WP_Post $post
 */
function tenjoy_render_vehicle_meta_box($post)
{
  wp_nonce_field('tenjoy_vehicle_meta_save', 'tenjoy_vehicle_meta_nonce');
  $pid     = $post->ID;
  $desc    = get_post_meta($pid, 'vehicle_desc', true);
  $gallery = get_post_meta($pid, 'vehicle_gallery', true);
  echo '<div class="tenjoy-meta-box">';
?>
  <div class="tenjoy-meta-field">
    <label for="vehicle_desc"><strong><?php esc_html_e('説明文', 'tenjoy-tour'); ?></strong></label>
    <textarea id="vehicle_desc" name="vehicle_desc" class="widefat"
      rows="3"><?php echo esc_textarea((string) $desc); ?></textarea>
    <p class="description"><?php esc_html_e('例: 大人数でのご移動に最適です（最大45名）', 'tenjoy-tour'); ?></p>
  </div>

  <div class="tenjoy-meta-field">
    <label><strong><?php esc_html_e('車両画像（複数登録可）', 'tenjoy-tour'); ?></strong></label>
    <p class="description"><?php esc_html_e('メディアライブラリから複数の画像を選択できます。1枚目が代表画像として使われます。', 'tenjoy-tour'); ?></p>
    <div id="vehicle-gallery-preview" style="display:flex;flex-wrap:wrap;gap:8px;margin:8px 0;">
      <?php
      if ($gallery) {
        foreach (array_filter(explode(',', $gallery)) as $img_id) {
          $url = wp_get_attachment_image_url((int) $img_id, 'thumbnail');
          if ($url) {
            echo '<img src="' . esc_url($url) . '" style="width:80px;height:80px;object-fit:cover;border-radius:4px;">';
          }
        }
      }
      ?>
    </div>
    <input type="hidden" id="vehicle_gallery" name="vehicle_gallery" value="<?php echo esc_attr((string) $gallery); ?>">
    <button type="button" class="button"
      id="vehicle-gallery-btn"><?php esc_html_e('画像を選択 / 追加', 'tenjoy-tour'); ?></button>
    <button type="button" class="button" id="vehicle-gallery-clear"
      style="margin-left:4px;"><?php esc_html_e('クリア', 'tenjoy-tour'); ?></button>
  </div>
  <script>
    (function($) {
      var frame;
      $('#vehicle-gallery-btn').on('click', function(e) {
        e.preventDefault();
        if (frame) {
          frame.open();
          return;
        }
        frame = wp.media({
          title: '<?php echo esc_js(__('車両画像を選択', 'tenjoy-tour')); ?>',
          multiple: true,
          library: {
            type: 'image'
          }
        });
        frame.on('select', function() {
          var ids = [],
            previews = '';
          frame.state().get('selection').each(function(a) {
            ids.push(a.id);
            previews += '<img src="' + a.attributes.sizes.thumbnail.url +
              '" style="width:80px;height:80px;object-fit:cover;border-radius:4px;">';
          });
          $('#vehicle_gallery').val(ids.join(','));
          $('#vehicle-gallery-preview').html(previews);
        });
        frame.open();
      });
      $('#vehicle-gallery-clear').on('click', function() {
        $('#vehicle_gallery').val('');
        $('#vehicle-gallery-preview').html('');
      });
    })(jQuery);
  </script>

  <p class="description">
    <?php esc_html_e('タイトルには車両名（例: 大型バス）を設定してください。並び順は「並べ替え」欄で調整できます。', 'tenjoy-tour'); ?>
  </p>
<?php
  echo '</div>';
}

// ==========================================================================
// ゴルフ場メタボックス
// ==========================================================================

/**
 * @param WP_Post $post
 */
function tenjoy_render_course_meta_box($post)
{
  wp_nonce_field('tenjoy_course_meta_save', 'tenjoy_course_meta_nonce');
  $pid       = $post->ID;
  $map_embed = get_post_meta($pid, 'course_map_embed', true);
  echo '<div class="tenjoy-meta-box">';
?>
  <div class="tenjoy-meta-field">
    <label for="course_map_embed"><strong><?php esc_html_e('Googleマップ 埋め込み', 'tenjoy-tour'); ?></strong></label>
    <textarea id="course_map_embed" name="course_map_embed" class="widefat" rows="3"
      placeholder="<?php esc_attr_e('GoogleマップのURL、または「地図を埋め込む」でコピーしたiframeタグをそのまま貼り付けてください', 'tenjoy-tour'); ?>"><?php echo esc_textarea((string) $map_embed); ?></textarea>
    <p class="description">
      <?php esc_html_e('Googleマップで場所を検索 →「共有」→「地図を埋め込む」→ 表示されたHTMLをそのまま貼り付けてください（URLだけでも構いません）。', 'tenjoy-tour'); ?>
    </p>
    <p>
      <button type="button" class="button" id="course-map-fetch-btn">
        <?php esc_html_e('この地図からタイトル・住所を取得', 'tenjoy-tour'); ?>
      </button>
      <span id="course-map-fetch-status" style="margin-left:8px;font-size:12px;color:#646970;"></span>
    </p>
  </div>
  <?php
  tenjoy_meta_text_field($pid, 'course_rating', __('星評価', 'tenjoy-tour'), 'text', __('例: 4.8（5.0 満点）', 'tenjoy-tour'));
  tenjoy_meta_text_field($pid, 'course_region', __('エリア', 'tenjoy-tour'), 'text', __('例: 関東 / 関西 / 北海道', 'tenjoy-tour'));
  tenjoy_meta_text_field($pid, 'course_tags', __('特徴タグ', 'tenjoy-tour'), 'text', __('例: 富士山ビュー,温泉施設（カンマ区切り）', 'tenjoy-tour'));
  tenjoy_meta_text_field($pid, 'course_visit_count', __('訪問数', 'tenjoy-tour'), 'number', __('例: 15', 'tenjoy-tour'));
  tenjoy_meta_text_field($pid, 'course_prefecture', __('都道府県', 'tenjoy-tour'), 'text', __('例: 神奈川県', 'tenjoy-tour'));
  tenjoy_meta_text_field($pid, 'course_address', __('住所', 'tenjoy-tour'), 'text', __('例: 神奈川県足柄上郡...', 'tenjoy-tour'));
  tenjoy_meta_text_field($pid, 'course_holes', __('ホール数', 'tenjoy-tour'), 'number', __('例: 18', 'tenjoy-tour'));
  tenjoy_meta_text_field($pid, 'course_green_fee', __('グリーンフィー', 'tenjoy-tour'), 'text', __('例: ¥10,000〜¥20,000', 'tenjoy-tour'));
  tenjoy_meta_checkbox_field($pid, 'course_caddie', __('キャディあり', 'tenjoy-tour'));
  tenjoy_meta_text_field($pid, 'course_cart', __('カート', 'tenjoy-tour'), 'text', __('例: 乗用カート（GPS付）', 'tenjoy-tour'));
  tenjoy_meta_text_field($pid, 'course_website', __('公式サイト URL', 'tenjoy-tour'), 'url', __('例: https://example-golf.com', 'tenjoy-tour'));
  tenjoy_meta_checkbox_field($pid, 'course_has_detail', __('詳細ページを作成する', 'tenjoy-tour'), __('チェックを入れると個別の詳細ページが表示されます', 'tenjoy-tour'));
  echo '</div>';
  ?>
  <script>
    (function($) {
      function extractSrc(raw) {
        raw = (raw || '').trim();
        if (!raw) {
          return '';
        }
        var m = raw.match(/<iframe[^>]*\ssrc=["']([^"']+)["']/i);
        if (m) {
          raw = m[1];
        }
        var ta = document.createElement('textarea');
        ta.innerHTML = raw;
        return ta.value.trim();
      }

      function parseFromUrl(url) {
        var result = {
          lat: null,
          lng: null,
          name: null
        };
        try {
          var u = new URL(url);
          var pb = u.searchParams.get('pb');
          if (pb) {
            var mLatLng = pb.match(/!2d(-?[\d.]+)!3d(-?[\d.]+)/);
            if (mLatLng) {
              result.lng = parseFloat(mLatLng[1]);
              result.lat = parseFloat(mLatLng[2]);
            }
            var mName = pb.match(/!1s0x[0-9a-fA-F]+(?:%3A|:)0x[0-9a-fA-F]+!2s([^!]+)!5e0/);
            if (mName) {
              result.name = decodeURIComponent(mName[1].replace(/\+/g, ' '));
            }
          }
        } catch (e) {
          // URLとして解釈できない場合は何もしない
        }
        return result;
      }

      $('#course-map-fetch-btn').on('click', function() {
        var $status = $('#course-map-fetch-status');
        var url = extractSrc($('#course_map_embed').val());

        if (!url) {
          $status.text('<?php echo esc_js(__('URLを認識できませんでした', 'tenjoy-tour')); ?>');
          return;
        }
        $('#course_map_embed').val(url);

        var parsed = parseFromUrl(url);
        var filled = [];

        if (parsed.name) {
          var $title = $('#title');
          if ($title.length) {
            $title.val(parsed.name);
            filled.push('<?php echo esc_js(__('タイトル', 'tenjoy-tour')); ?>');
          }
        }

        if (parsed.lat && parsed.lng) {
          $status.text('<?php echo esc_js(__('住所を取得中...', 'tenjoy-tour')); ?>');
          $.getJSON('https://nominatim.openstreetmap.org/reverse', {
            format: 'jsonv2',
            lat: parsed.lat,
            lon: parsed.lng,
            'accept-language': 'ja',
            zoom: 17
          }).done(function(data) {
            if (data && data.display_name) {
              $('#course_address').val(data.display_name);
              filled.push('<?php echo esc_js(__('住所', 'tenjoy-tour')); ?>');
            }
            if (data && data.address && data.address.state) {
              $('#course_prefecture').val(data.address.state);
              filled.push('<?php echo esc_js(__('都道府県', 'tenjoy-tour')); ?>');
            }
            $status.text(filled.length ? ('<?php echo esc_js(__('取得しました:', 'tenjoy-tour')); ?> ' + filled.join(
              '・')) : '<?php echo esc_js(__('住所情報が見つかりませんでした', 'tenjoy-tour')); ?>');
          }).fail(function() {
            $status.text('<?php echo esc_js(__('住所の取得に失敗しました（時間をおいて再度お試しください）', 'tenjoy-tour')); ?>');
          });
        } else {
          $status.text(filled.length ? ('<?php echo esc_js(__('取得しました:', 'tenjoy-tour')); ?> ' + filled.join('・')) :
            '<?php echo esc_js(__('位置情報が見つかりませんでした', 'tenjoy-tour')); ?>');
        }
      });
    })(jQuery);
  </script>
<?php
}

// ==========================================================================
// アクティビティメタボックス
// ==========================================================================

/**
 * @param WP_Post $post
 */
function tenjoy_render_activity_meta_box($post)
{
  wp_nonce_field('tenjoy_activity_meta_save', 'tenjoy_activity_meta_nonce');
  $pid = $post->ID;
  echo '<div class="tenjoy-meta-box">';
  tenjoy_meta_text_field($pid, 'activity_category', __('カテゴリ', 'tenjoy-tour'), 'text', __('例: ゴルフ / 食事 / 温泉 / 観光', 'tenjoy-tour'));
  tenjoy_meta_text_field($pid, 'activity_customer', __('お客様情報', 'tenjoy-tour'), 'text', __('例: 韓国からのお客様（4名様）', 'tenjoy-tour'));
  tenjoy_meta_text_field($pid, 'activity_location', __('場所', 'tenjoy-tour'), 'text', __('例: 山梨県', 'tenjoy-tour'));
  tenjoy_meta_text_field($pid, 'activity_duration', __('所要時間', 'tenjoy-tour'), 'text', __('例: 約2時間', 'tenjoy-tour'));
  tenjoy_meta_text_field($pid, 'activity_price', __('料金', 'tenjoy-tour'), 'text', __('例: ¥3,000〜', 'tenjoy-tour'));
  tenjoy_meta_text_field($pid, 'activity_course_name', __('利用ゴルフ場', 'tenjoy-tour'), 'text', __('例: 富士桜カントリークラブ', 'tenjoy-tour'));
  tenjoy_meta_checkbox_field($pid, 'activity_has_golf', __('ゴルフアクティビティ（ゴルフバッジを表示）', 'tenjoy-tour'));

  // ギャラリー画像
  $gallery = get_post_meta($pid, 'activity_gallery', true);
?>
  <div class="tenjoy-meta-field">
    <label><strong><?php esc_html_e('ギャラリー画像', 'tenjoy-tour'); ?></strong></label>
    <p class="description"><?php esc_html_e('メディアライブラリから画像を選択してください。', 'tenjoy-tour'); ?></p>
    <div id="activity-gallery-preview" style="display:flex;flex-wrap:wrap;gap:8px;margin:8px 0;">
      <?php
      if ($gallery) {
        foreach (array_filter(explode(',', $gallery)) as $img_id) {
          $url = wp_get_attachment_image_url((int) $img_id, 'thumbnail');
          if ($url) {
            echo '<img src="' . esc_url($url) . '" style="width:80px;height:80px;object-fit:cover;border-radius:4px;">';
          }
        }
      }
      ?>
    </div>
    <input type="hidden" id="activity_gallery" name="activity_gallery" value="<?php echo esc_attr((string) $gallery); ?>">
    <button type="button" class="button"
      id="activity-gallery-btn"><?php esc_html_e('画像を選択 / 追加', 'tenjoy-tour'); ?></button>
    <button type="button" class="button" id="activity-gallery-clear"
      style="margin-left:4px;"><?php esc_html_e('クリア', 'tenjoy-tour'); ?></button>
  </div>
  <script>
    (function($) {
      var frame;
      $('#activity-gallery-btn').on('click', function(e) {
        e.preventDefault();
        if (frame) {
          frame.open();
          return;
        }
        frame = wp.media({
          title: 'ギャラリー画像を選択',
          multiple: true,
          library: {
            type: 'image'
          }
        });
        frame.on('select', function() {
          var ids = [],
            previews = '';
          frame.state().get('selection').each(function(a) {
            ids.push(a.id);
            previews += '<img src="' + a.attributes.sizes.thumbnail.url +
              '" style="width:80px;height:80px;object-fit:cover;border-radius:4px;">';
          });
          $('#activity_gallery').val(ids.join(','));
          $('#activity-gallery-preview').html(previews);
        });
        frame.open();
      });
      $('#activity-gallery-clear').on('click', function() {
        $('#activity_gallery').val('');
        $('#activity-gallery-preview').html('');
      });
    })(jQuery);
  </script>
<?php
  echo '</div>';
}

// ==========================================================================
// スタッフメタボックス
// ==========================================================================

/**
 * @param WP_Post $post
 */
function tenjoy_render_staff_meta_box($post)
{
  wp_nonce_field('tenjoy_staff_meta_save', 'tenjoy_staff_meta_nonce');
  $pid = $post->ID;
  echo '<div class="tenjoy-meta-box">';
  tenjoy_meta_text_field($pid, 'staff_role', __('役職', 'tenjoy-tour'), 'text', __('例: ゴルフコーディネーター', 'tenjoy-tour'));

  $bio = get_post_meta($pid, 'staff_bio', true);
  $image_position = tenjoy_sanitize_image_position((string) get_post_meta($pid, 'staff_image_position', true));
?>
  <div class="tenjoy-meta-field">
    <label for="staff_bio"><strong><?php esc_html_e('自己紹介', 'tenjoy-tour'); ?></strong></label>
    <textarea id="staff_bio" name="staff_bio" class="widefat"
      rows="4"><?php echo esc_textarea((string) $bio); ?></textarea>
  </div>
  <div class="tenjoy-meta-field">
    <label for="staff_image_position"><strong><?php esc_html_e('写真の表示位置', 'tenjoy-tour'); ?></strong></label>
    <select id="staff_image_position" name="staff_image_position" class="widefat" style="max-width:240px;">
      <?php foreach (tenjoy_image_position_choices() as $value => $label) : ?>
        <option value="<?php echo esc_attr($value); ?>" <?php selected($image_position, $value); ?>>
          <?php echo esc_html($label); ?></option>
      <?php endforeach; ?>
    </select>
    <p class="description"><?php esc_html_e('顔が見切れる場合は「中央上」などに変更してください。', 'tenjoy-tour'); ?></p>
  </div>
<?php
  tenjoy_meta_text_field($pid, 'staff_languages', __('対応言語', 'tenjoy-tour'), 'text', __('例: 日本語, 英語, 中国語（カンマ区切り）', 'tenjoy-tour'));
  tenjoy_meta_text_field($pid, 'staff_email', __('メールアドレス', 'tenjoy-tour'), 'text', __('例: staff@tenjoy-tour.com', 'tenjoy-tour'));
  tenjoy_meta_text_field($pid, 'staff_phone', __('電話番号', 'tenjoy-tour'), 'text', __('例: +81-3-1234-5678', 'tenjoy-tour'));
  echo '</div>';
}

// ==========================================================================
// お客様の声メタボックス
// ==========================================================================

/**
 * @param WP_Post $post
 */
function tenjoy_render_review_meta_box($post)
{
  wp_nonce_field('tenjoy_review_meta_save', 'tenjoy_review_meta_nonce');
  $pid = $post->ID;
  echo '<div class="tenjoy-meta-box">';
  tenjoy_meta_text_field($pid, 'review_country', __('出身国・地域', 'tenjoy-tour'), 'text', __('例: 台湾 / 韓国 / 中国', 'tenjoy-tour'));

  $rating = (int) get_post_meta($pid, 'review_rating', true);
  if ($rating < 1 || $rating > 5) {
    $rating = 5;
  }
?>
  <div class="tenjoy-meta-field">
    <label for="review_rating"><strong><?php esc_html_e('星評価', 'tenjoy-tour'); ?></strong></label>
    <select id="review_rating" name="review_rating" class="widefat" style="max-width:120px;">
      <?php for ($i = 5; $i >= 1; $i--) : ?>
        <option value="<?php echo $i; ?>" <?php selected($rating, $i); ?>><?php echo $i; ?> ★</option>
      <?php endfor; ?>
    </select>
  </div>
<?php
  echo '</div>';
}

// ==========================================================================
// お問い合わせメタボックス
// ==========================================================================

/**
 * @param WP_Post $post
 */
function tenjoy_render_contact_meta_box($post)
{
  wp_nonce_field('tenjoy_contact_meta_save', 'tenjoy_contact_meta_nonce');
  $pid = $post->ID;
  echo '<div class="tenjoy-meta-box">';
  echo '<p class="description">' . esc_html__('タイトルはお名前、本文はお問い合わせ内容です。', 'tenjoy-tour') . '</p>';
  tenjoy_meta_text_field($pid, 'contact_email', __('メールアドレス', 'tenjoy-tour'), 'email');
  tenjoy_meta_text_field($pid, 'contact_phone', __('電話番号', 'tenjoy-tour'), 'text');
  tenjoy_meta_text_field($pid, 'contact_prefecture', __('どの県に行く予定ですか', 'tenjoy-tour'), 'text');
  tenjoy_meta_text_field($pid, 'contact_visit_date', __('いつ日本に来る予定ですか', 'tenjoy-tour'), 'text');
  echo '</div>';
}

// ==========================================================================
// 保存処理
// ==========================================================================

add_action('save_post', function ($post_id) {
  // 自動保存・権限チェック
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }
  if (! current_user_can('edit_post', $post_id)) {
    return;
  }

  $post_type = get_post_type($post_id);

  // ---- 車両紹介 ----
  if ($post_type === 'vehicles' && isset($_POST['tenjoy_vehicle_meta_nonce'])) {
    if (! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['tenjoy_vehicle_meta_nonce'])), 'tenjoy_vehicle_meta_save')) {
      return;
    }
    if (isset($_POST['vehicle_desc'])) {
      update_post_meta($post_id, 'vehicle_desc', sanitize_textarea_field(wp_unslash($_POST['vehicle_desc'])));
    }
    if (isset($_POST['vehicle_gallery'])) {
      $gallery_ids = array_filter(array_map('intval', explode(',', wp_unslash($_POST['vehicle_gallery']))));
      update_post_meta($post_id, 'vehicle_gallery', implode(',', $gallery_ids));
    }
  }

  // ---- ゴルフ場 ----
  if ($post_type === 'courses' && isset($_POST['tenjoy_course_meta_nonce'])) {
    if (! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['tenjoy_course_meta_nonce'])), 'tenjoy_course_meta_save')) {
      return;
    }
    $string_fields = ['course_rating', 'course_region', 'course_tags', 'course_prefecture', 'course_address', 'course_green_fee', 'course_cart'];
    foreach ($string_fields as $field) {
      if (isset($_POST[$field])) {
        update_post_meta($post_id, $field, sanitize_text_field(wp_unslash($_POST[$field])));
      }
    }
    $holes = isset($_POST['course_holes']) ? (int) $_POST['course_holes'] : 0;
    update_post_meta($post_id, 'course_holes', $holes);
    $visit_count = isset($_POST['course_visit_count']) ? (int) $_POST['course_visit_count'] : 0;
    update_post_meta($post_id, 'course_visit_count', $visit_count);

    $website = isset($_POST['course_website']) ? esc_url_raw(wp_unslash($_POST['course_website'])) : '';
    update_post_meta($post_id, 'course_website', $website);

    $map_embed = isset($_POST['course_map_embed']) ? tenjoy_extract_map_embed_url(wp_unslash($_POST['course_map_embed'])) : '';
    if ($map_embed !== '' && ! tenjoy_is_valid_map_embed_url($map_embed)) {
      $map_embed = '';
    }
    update_post_meta($post_id, 'course_map_embed', $map_embed);

    update_post_meta($post_id, 'course_caddie', isset($_POST['course_caddie']) ? true : false);
    update_post_meta($post_id, 'course_has_detail', isset($_POST['course_has_detail']) ? true : false);
  }

  // ---- アクティビティ ----
  if ($post_type === 'activities' && isset($_POST['tenjoy_activity_meta_nonce'])) {
    if (! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['tenjoy_activity_meta_nonce'])), 'tenjoy_activity_meta_save')) {
      return;
    }
    $string_fields = ['activity_category', 'activity_customer', 'activity_location', 'activity_duration', 'activity_price', 'activity_course_name', 'activity_gallery'];
    foreach ($string_fields as $field) {
      if (isset($_POST[$field])) {
        update_post_meta($post_id, $field, sanitize_text_field(wp_unslash($_POST[$field])));
      }
    }
    update_post_meta($post_id, 'activity_has_golf', isset($_POST['activity_has_golf']) ? true : false);
  }

  // ---- スタッフ ----
  if ($post_type === 'staff' && isset($_POST['tenjoy_staff_meta_nonce'])) {
    if (! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['tenjoy_staff_meta_nonce'])), 'tenjoy_staff_meta_save')) {
      return;
    }
    if (isset($_POST['staff_role'])) {
      update_post_meta($post_id, 'staff_role', sanitize_text_field(wp_unslash($_POST['staff_role'])));
    }
    if (isset($_POST['staff_bio'])) {
      update_post_meta($post_id, 'staff_bio', sanitize_textarea_field(wp_unslash($_POST['staff_bio'])));
    }
    if (isset($_POST['staff_image_position'])) {
      update_post_meta(
        $post_id,
        'staff_image_position',
        tenjoy_sanitize_image_position(sanitize_text_field(wp_unslash($_POST['staff_image_position'])))
      );
    }
    foreach (['staff_languages', 'staff_email', 'staff_phone'] as $field) {
      if (isset($_POST[$field])) {
        update_post_meta($post_id, $field, sanitize_text_field(wp_unslash($_POST[$field])));
      }
    }
  }

  // ---- 会社概要 ----
  if ($post_type === 'page' && isset($_POST['tenjoy_company_meta_nonce'])) {
    if (! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['tenjoy_company_meta_nonce'])), 'tenjoy_company_meta_save')) {
      return;
    }
    $company_fields = [
      'company_name',
      'company_representative',
      'company_founded',
      'company_capital',
      'company_employees',
      'company_address',
      'company_phone',
      'company_fax',
      'company_email',
      'company_languages',
      'company_hours',
    ];
    foreach ($company_fields as $field) {
      if (isset($_POST[$field])) {
        update_post_meta($post_id, $field, sanitize_text_field(wp_unslash($_POST[$field])));
      }
    }
  }

  // ---- お客様の声 ----
  if ($post_type === 'tenjoy_review' && isset($_POST['tenjoy_review_meta_nonce'])) {
    if (! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['tenjoy_review_meta_nonce'])), 'tenjoy_review_meta_save')) {
      return;
    }
    if (isset($_POST['review_country'])) {
      update_post_meta($post_id, 'review_country', sanitize_text_field(wp_unslash($_POST['review_country'])));
    }
    $rating = isset($_POST['review_rating']) ? max(1, min(5, (int) $_POST['review_rating'])) : 5;
    update_post_meta($post_id, 'review_rating', $rating);
  }

  // ---- お問い合わせ ----
  if ($post_type === 'tenjoy_contact' && isset($_POST['tenjoy_contact_meta_nonce'])) {
    if (! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['tenjoy_contact_meta_nonce'])), 'tenjoy_contact_meta_save')) {
      return;
    }
    foreach (['contact_email', 'contact_phone', 'contact_prefecture', 'contact_visit_date'] as $field) {
      if (! isset($_POST[$field])) {
        continue;
      }
      $value = sanitize_text_field(wp_unslash($_POST[$field]));
      if ($field === 'contact_email') {
        $value = sanitize_email(wp_unslash($_POST[$field]));
      }
      update_post_meta($post_id, $field, $value);
    }
  }
});

// ==========================================================================
// 会社概要メタボックス描画
// ==========================================================================

function tenjoy_render_company_meta_box(WP_Post $post): void
{
  // 会社概要テンプレート以外では非表示
  if (get_page_template_slug($post->ID) !== 'page-company.php') {
    echo '<p style="color:#646970;font-size:13px;">' . esc_html__('このメタボックスは「会社概要」テンプレートを選択したページのみ有効です。', 'tenjoy-tour') . '</p>';
    return;
  }

  wp_nonce_field('tenjoy_company_meta_save', 'tenjoy_company_meta_nonce');

  $fields = [
    'company_name'           => ['label' => __('会社名', 'tenjoy-tour'),   'default' => 'TENJOY-TOUR 株式会社'],
    'company_representative' => ['label' => __('代表者', 'tenjoy-tour'),   'default' => '天孝 高俊'],
    'company_founded'        => ['label' => __('設立', 'tenjoy-tour'),     'default' => '2023年5月26日'],
    'company_capital'        => ['label' => __('資本金', 'tenjoy-tour'),   'default' => '800万円'],
    'company_employees'      => ['label' => __('従業員数', 'tenjoy-tour'), 'default' => '5名'],
    'company_address'        => ['label' => __('所在地', 'tenjoy-tour'),   'default' => '福岡市東区'],
    'company_phone'          => ['label' => __('電話番号', 'tenjoy-tour'), 'default' => '090-9561-3388'],
    'company_fax'            => ['label' => __('FAX番号', 'tenjoy-tour'), 'default' => ''],
    'company_email'          => ['label' => __('メールアドレス', 'tenjoy-tour'), 'default' => 'info@tenjoy-tour.com'],
    'company_languages'      => ['label' => __('対応言語', 'tenjoy-tour'), 'default' => '日本語・中国語・韓国語・英語'],
    'company_hours'          => ['label' => __('営業時間', 'tenjoy-tour'), 'default' => '09:00 〜 18:00（年中無休）'],
  ];

  echo '<div class="tenjoy-meta-box">';
  foreach ($fields as $key => $field) {
    $value = (string) get_post_meta($post->ID, $key, true);
    if ($value === '') {
      $value = $field['default'];
    }
    echo '<div class="tenjoy-meta-field">';
    echo '<label for="' . esc_attr($key) . '">' . esc_html($field['label']) . '</label>';
    echo '<input type="text" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" class="widefat">';
    echo '</div>';
  }
  echo '</div>';
}

// ==========================================================================
// 管理画面スタイル
// ==========================================================================

add_action('admin_head', function () {
  $screen = get_current_screen();
  if (! $screen) {
    return;
  }
  $cpt_list = ['courses', 'activities', 'staff', 'faq', 'vehicles'];
  if (! in_array($screen->post_type, $cpt_list, true)) {
    return;
  }
?>
  <style>
    .tenjoy-meta-box {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .tenjoy-meta-field {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .tenjoy-meta-field label {
      font-size: 13px;
    }

    .tenjoy-meta-field input[type="text"],
    .tenjoy-meta-field input[type="url"],
    .tenjoy-meta-field input[type="number"],
    .tenjoy-meta-field textarea {
      margin-top: 2px;
    }

    .tenjoy-meta-field .description {
      color: #646970;
      font-size: 12px;
      margin: 2px 0 0;
    }
  </style>
<?php
});
