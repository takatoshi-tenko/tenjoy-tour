/* ヘッダーナビゲーション制御 */
(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    // ハンバーガーメニュー
    var toggle = document.querySelector('.nav-toggle');
    var mobileMenu = document.getElementById('mobile-menu');

    if (toggle && mobileMenu) {
      toggle.addEventListener('click', function () {
        var isOpen = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', String(!isOpen));
        mobileMenu.hidden = isOpen;
        mobileMenu.setAttribute('aria-hidden', String(isOpen));
      });
    }

    // FAQアコーディオン
    document.querySelectorAll('[data-faq-toggle]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var isOpen = btn.getAttribute('aria-expanded') === 'true';
        var answerId = btn.getAttribute('aria-controls');
        var answer = document.getElementById(answerId);
        btn.setAttribute('aria-expanded', String(!isOpen));
        if (answer) {
          answer.hidden = isOpen;
        }
      });
    });

    // 言語切替ドロップダウン
    var langToggle = document.querySelector('.lang-switcher-toggle');
    var langMenu = document.getElementById('lang-menu');

    if (langToggle && langMenu) {
      langToggle.addEventListener('click', function (e) {
        e.stopPropagation();
        var isOpen = langToggle.getAttribute('aria-expanded') === 'true';
        langToggle.setAttribute('aria-expanded', String(!isOpen));
        langMenu.hidden = isOpen;
      });

      // メニュー外クリックで閉じる
      document.addEventListener('click', function () {
        langToggle.setAttribute('aria-expanded', 'false');
        langMenu.hidden = true;
      });
    }

    // スタッフ Swiper カルーセル
    if (typeof Swiper !== 'undefined' && document.querySelector('.staff-swiper')) {
      new Swiper('.staff-swiper', {
        slidesPerView: 1,
        spaceBetween: 24,
        navigation: {
          prevEl: '.staff-swiper .swiper-button-prev',
          nextEl: '.staff-swiper .swiper-button-next',
        },
        breakpoints: {
          640: { slidesPerView: 2 },
          1024: { slidesPerView: 3 },
        },
      });
    }

    // レビュー投稿フォーム（AJAX）
    var reviewForm = document.getElementById('review-form');
    var reviewMsg = document.getElementById('review-form-msg');

    if (reviewForm && typeof tenjoyAjax !== 'undefined') {
      reviewForm.addEventListener('submit', function (e) {
        e.preventDefault();

        var submitBtn = reviewForm.querySelector('[type="submit"]');
        submitBtn.disabled = true;

        var data = new FormData();
        data.append('action', 'tenjoy_submit_review');
        data.append('nonce', tenjoyAjax.nonce);
        data.append('author', reviewForm.querySelector('[name="author"]').value.trim());
        data.append('country', reviewForm.querySelector('[name="country"]').value.trim());
        data.append('content', reviewForm.querySelector('[name="content"]').value.trim());
        var ratingInput = reviewForm.querySelector('[name="rating"]:checked');
        data.append('rating', ratingInput ? ratingInput.value : '5');

        fetch(tenjoyAjax.url, { method: 'POST', body: data })
          .then(function (res) { return res.json(); })
          .then(function (json) {
            reviewMsg.hidden = false;
            if (json.success) {
              reviewMsg.className = 'review-form-msg review-form-msg--success';
              reviewMsg.textContent = json.data;
              reviewForm.reset();
            } else {
              reviewMsg.className = 'review-form-msg review-form-msg--error';
              reviewMsg.textContent = json.data || 'エラーが発生しました。';
            }
          })
          .catch(function () {
            reviewMsg.hidden = false;
            reviewMsg.className = 'review-form-msg review-form-msg--error';
            reviewMsg.textContent = '通信エラーが発生しました。';
          })
          .finally(function () {
            submitBtn.disabled = false;
          });
      });
    }
  });
})();
