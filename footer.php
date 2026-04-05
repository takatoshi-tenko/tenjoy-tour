<?php

/**
 * フッター
 *
 * @package Friend2026
 */
?>
</div><!-- #page -->

<footer class="site-footer" role="contentinfo">
  <div class="footer-inner">
    <div class="footer-grid">
      <!-- 会社情報 -->
      <div class="footer-company">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo">
          <img src="<?php echo esc_url(FRIEND2026_URI . '/assets/images/logo.png'); ?>" alt="<?php bloginfo('name'); ?>"
            width="60" height="60" loading="lazy">
          <div class="footer-logo-text">
            <span class="footer-logo-label">有限会社</span>
            <span class="footer-logo-name">ふれんど 東京支社</span>
          </div>
        </a>
        <p class="footer-desc">有限会社ふれんどは、東京23区・多摩エリアを中心に、お客様の理想の住まい探しをサポートいたします。経験豊富なスタッフが、物件探しから購入まで丁寧にご案内します。</p>
        <dl class="footer-contact">
          <div>
            <dt>電話</dt>
            <dd><a href="tel:0120-123-456">0120-123-456</a></dd>
          </div>
          <div>
            <dt>メール</dt>
            <dd><a href="mailto:info@friend-fudosan.jp">info@friend-fudosan.jp</a></dd>
          </div>
          <div>
            <dt>住所</dt>
            <dd>〒183-0005<br>東京都府中市若松町1-2-7 3F</dd>
          </div>
          <div>
            <dt>営業時間</dt>
            <dd>9:00〜19:00（水曜定休）</dd>
          </div>
        </dl>
      </div>

      <!-- リンクブロック -->
      <div class="footer-links-block">
        <h3 class="footer-links-title">物件一覧</h3>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url(home_url('/properties/')); ?>">すべての物件</a></li>
          <li><a href="<?php echo esc_url(home_url('/properties/?type=new-house')); ?>">新築一戸建て</a></li>
          <li><a href="<?php echo esc_url(home_url('/properties/?type=used-house')); ?>">中古一戸建て</a></li>
          <li><a href="<?php echo esc_url(home_url('/properties/?type=apartment')); ?>">マンション</a></li>
          <li><a href="<?php echo esc_url(home_url('/properties/?type=land')); ?>">土地</a></li>
        </ul>
      </div>
      <div class="footer-links-block">
        <h3 class="footer-links-title">会社情報</h3>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url(home_url('/company/')); ?>">会社概要</a></li>
          <li><a href="<?php echo esc_url(home_url('/staff/')); ?>">スタッフ紹介</a></li>
          <li><a href="<?php echo esc_url(home_url('/company/#access')); ?>">アクセス</a></li>
        </ul>
      </div>
      <div class="footer-links-block">
        <h3 class="footer-links-title">サポート</h3>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">お問い合わせ</a></li>
          <li><a href="<?php echo esc_url(home_url('/faq/')); ?>">よくあるご質問</a></li>
          <li><a href="<?php echo esc_url(home_url('/sitemap/')); ?>">サイトマップ</a></li>
        </ul>
      </div>
      <div class="footer-links-block">
        <h3 class="footer-links-title">法的情報</h3>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url(home_url('/privacy/')); ?>">プライバシーポリシー</a></li>
          <li><a href="<?php echo esc_url(home_url('/personal-info/')); ?>">個人情報取扱に関する説明</a></li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <p class="footer-copy">&copy; <?php echo esc_html(date('Y')); ?> 有限会社ふれんど All Rights Reserved.</p>
      <p class="footer-license">宅地建物取引業者免許 東京都知事（1）第000000号</p>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>