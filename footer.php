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
          <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>"
            alt="<?php bloginfo('name'); ?>" width="40" height="40" loading="lazy">
          <span class="footer-logo-name">TENJOY-TOUR</span>
        </a>
        <p class="footer-desc">
          <?php tenjoy_e('footer_01'); ?>
        </p>
      </div>

      <!-- サイトマップ -->
      <div class="footer-links-block">
        <h3 class="footer-links-title"><?php tenjoy_e('footer_02'); ?></h3>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php tenjoy_e('footer_03'); ?></a></li>
          <li><a href="<?php echo esc_url(home_url('/#services')); ?>"><?php tenjoy_e('nav_01'); ?></a></li>
          <li><a href="<?php echo esc_url(home_url('/activities/')); ?>"><?php tenjoy_e('nav_03'); ?></a></li>
          <li><a href="<?php echo esc_url(home_url('/courses/')); ?>"><?php tenjoy_e('footer_04'); ?></a></li>
          <li><a href="<?php echo esc_url(home_url('/sitemap/')); ?>"><?php tenjoy_e('footer_02'); ?></a></li>
        </ul>
      </div>

      <!-- サービス -->
      <div class="footer-links-block">
        <h3 class="footer-links-title"><?php tenjoy_e('nav_01'); ?></h3>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url(home_url('/#reviews')); ?>"><?php tenjoy_e('nav_04'); ?></a></li>
          <li><a href="<?php echo esc_url(home_url('/staff/')); ?>"><?php tenjoy_e('footer_05'); ?></a></li>
          <li><a href="<?php echo esc_url(home_url('/blog/')); ?>"><?php tenjoy_e('footer_06'); ?></a></li>
        </ul>
      </div>

      <!-- お問い合わせ -->
      <div class="footer-links-block">
        <h3 class="footer-links-title"><?php tenjoy_e('nav_06'); ?></h3>
        <?php
        $footer_email = tenjoy_get_company_meta('company_email', 'info@tenjoy-tour.com');
        $footer_fax   = tenjoy_get_company_meta('company_fax', '');
        ?>
        <div class="footer-contact-info">
          <p>Email: <a href="mailto:<?php echo esc_attr($footer_email); ?>"><?php echo esc_html($footer_email); ?></a>
          </p>
          <?php if ($footer_fax) : ?>
          <p>FAX: <?php echo esc_html($footer_fax); ?></p>
          <?php endif; ?>
        </div>
        <p class="footer-messenger-label"><?php tenjoy_e('footer_07'); ?></p>
        <?php
        $footer_messengers = [
          'kakao'     => ['name' => 'KakaoTalk', 'color' => '#FEE500', 'text' => '#3C1E1E', 'icon' => 'kakao'],
          'wechat'    => ['name' => 'WeChat', 'color' => '#07C160', 'text' => '#fff', 'icon' => 'message-circle'],
          'instagram' => ['name' => 'Instagram', 'color' => '#e6683c', 'text' => '#fff', 'icon' => 'instagram'],
          'line'      => ['name' => 'LINE', 'color' => '#00B900', 'text' => '#fff', 'icon' => 'line'],
          'whatsapp'  => ['name' => 'WhatsApp', 'color' => '#25D366', 'text' => '#fff', 'icon' => 'phone'],
        ];
        ?>
        <div class="footer-messenger-links">
          <?php foreach ($footer_messengers as $key => $m) : ?>
          <?php $icon_url = tenjoy_customizer_image_url("tenjoy_icon_{$key}", 'thumbnail'); ?>
          <a href="<?php echo esc_url(home_url('/#contact')); ?>" class="footer-messenger-item">
            <span class="footer-messenger-icon-wrap"
              style="background-color: <?php echo esc_attr($m['color']); ?>; color: <?php echo esc_attr($m['text']); ?>">
              <?php if ($icon_url) : ?>
              <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($m['name']); ?>" width="20"
                height="20" loading="lazy">
              <?php else : ?>
              <?php echo tenjoy_icon($m['icon']); // phpcs:ignore WordPress.Security.EscapeOutput ?>
              <?php endif; ?>
            </span>
            <?php echo esc_html($m['name']); ?>
          </a>
          <?php endforeach; ?>
        </div>
      </div>

    </div><!-- /.footer-grid -->

    <div class="footer-bottom">
      <p>&copy; <?php echo esc_html(gmdate('Y')); ?> TENJOY-TOUR. <?php tenjoy_e('footer_08'); ?></p>
    </div>

  </div><!-- /.footer-inner -->
</footer><!-- /.site-footer -->

<?php wp_footer(); ?>
</body>

</html>