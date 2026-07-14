<?php
/**
 * フッター
 *
 * @package tenjoy-tour
 */
?>
  </div><!-- #page -->

  <footer class="site-footer" role="contentinfo">
    <div class="footer-inner">
      <div class="footer-grid">

        <!-- ロゴ・説明 -->
        <div class="footer-brand">
          <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo">
            <img
              src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>"
              alt="<?php bloginfo('name'); ?>"
              width="40"
              height="40"
              loading="lazy">
            <span class="footer-logo-name">TENJOY-TOUR</span>
          </a>
          <p class="footer-desc">
            <?php esc_html_e('方日ゴルファーのためのゴルフ場予約・ホテル・送迎を完全サポート', 'tenjoy-tour'); ?>
          </p>
        </div>

        <!-- サイトマップ -->
        <div class="footer-links-block">
          <h3 class="footer-links-title"><?php esc_html_e('サイトマップ', 'tenjoy-tour'); ?></h3>
          <ul class="footer-links">
            <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('ホーム', 'tenjoy-tour'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/#services')); ?>"><?php esc_html_e('サービス', 'tenjoy-tour'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/activities/')); ?>"><?php esc_html_e('アクティビティ', 'tenjoy-tour'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/courses/')); ?>"><?php esc_html_e('ゴルフ場一覧', 'tenjoy-tour'); ?></a></li>
          </ul>
        </div>

        <!-- サービス -->
        <div class="footer-links-block">
          <h3 class="footer-links-title"><?php esc_html_e('サービス', 'tenjoy-tour'); ?></h3>
          <ul class="footer-links">
            <li><a href="<?php echo esc_url(home_url('/#reviews')); ?>"><?php esc_html_e('お客様の声', 'tenjoy-tour'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/staff/')); ?>"><?php esc_html_e('スタッフ紹介', 'tenjoy-tour'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/blog/')); ?>"><?php esc_html_e('ブログ', 'tenjoy-tour'); ?></a></li>
          </ul>
        </div>

        <!-- お問い合わせ -->
        <div class="footer-links-block">
          <h3 class="footer-links-title"><?php esc_html_e('お問い合わせ', 'tenjoy-tour'); ?></h3>
          <div class="footer-contact-info">
            <p>Email: <a href="mailto:info@tenjoy-tour.com">info@tenjoy-tour.com</a></p>
            <p>FAX: +81-3-1234-5678</p>
          </div>
          <p class="footer-messenger-label"><?php esc_html_e('メッセージアプリ', 'tenjoy-tour'); ?></p>
          <?php
          $footer_messengers = [
            'line'     => ['name' => 'LINE', 'fallback' => 'qr-line.jpg'],
            'kakao'    => ['name' => 'KakaoTalk', 'fallback' => 'qr-kakao.jpg'],
            'wechat'   => ['name' => 'WeChat', 'fallback' => 'qr-wechat.jpg'],
            'whatsapp' => ['name' => 'WhatsApp', 'fallback' => 'qr-whatsapp.jpg'],
          ];
          ?>
          <div class="footer-messenger-links">
            <?php foreach ($footer_messengers as $key => $m) : ?>
              <?php
              $icon_url = tenjoy_customizer_image_url(
                "tenjoy_icon_{$key}",
                'thumbnail',
                get_template_directory_uri() . '/assets/images/' . $m['fallback']
              );
              ?>
              <a href="<?php echo esc_url(home_url('/#contact')); ?>" class="footer-messenger-item">
                <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($m['name']); ?>" width="32" height="32" loading="lazy">
                <?php echo esc_html($m['name']); ?>
              </a>
            <?php endforeach; ?>
          </div>
        </div>

      </div><!-- /.footer-grid -->

      <div class="footer-bottom">
        <p>&copy; <?php echo esc_html(gmdate('Y')); ?> TENJOY-TOUR. <?php esc_html_e('All rights reserved.', 'tenjoy-tour'); ?></p>
      </div>

    </div><!-- /.footer-inner -->
  </footer><!-- /.site-footer -->

<?php wp_footer(); ?>
</body>
</html>
