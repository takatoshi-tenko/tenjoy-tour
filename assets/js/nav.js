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

    // 車両画像 Swiper カルーセル（1車両ずつ独立したインスタンス）
    if (typeof Swiper !== 'undefined') {
      document.querySelectorAll('.vehicle-swiper').forEach(function (el) {
        new Swiper(el, {
          slidesPerView: 1,
          loop: true,
          navigation: {
            prevEl: el.querySelector('.swiper-button-prev'),
            nextEl: el.querySelector('.swiper-button-next'),
          },
          pagination: {
            el: el.querySelector('.swiper-pagination'),
            clickable: true,
          },
        });
      });
    }

    // 画像ライトボックス
    var lightbox = document.getElementById('tenjoy-lightbox');
    if (lightbox) {
      var lightboxImg = lightbox.querySelector('.tenjoy-lightbox-img');
      var lightboxCounter = lightbox.querySelector('.tenjoy-lightbox-counter');
      var lightboxPrev = lightbox.querySelector('.tenjoy-lightbox-prev');
      var lightboxNext = lightbox.querySelector('.tenjoy-lightbox-next');
      var lightboxClose = lightbox.querySelector('.tenjoy-lightbox-close');
      var lightboxImages = [];
      var lightboxIndex = 0;

      function renderLightbox() {
        lightboxImg.src = lightboxImages[lightboxIndex];
        lightboxCounter.textContent = (lightboxIndex + 1) + ' / ' + lightboxImages.length;
        var hasMultiple = lightboxImages.length > 1;
        lightboxPrev.hidden = !hasMultiple;
        lightboxNext.hidden = !hasMultiple;
        lightboxCounter.hidden = !hasMultiple;
      }

      function openLightbox(images, index) {
        lightboxImages = images;
        lightboxIndex = index;
        if (!lightboxImages.length) {
          return;
        }
        renderLightbox();
        lightbox.hidden = false;
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
      }

      function closeLightbox() {
        lightbox.hidden = true;
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
      }

      document.addEventListener('click', function (e) {
        var trigger = e.target.closest('[data-lightbox-images]');
        if (!trigger) {
          return;
        }
        var images;
        try {
          images = JSON.parse(trigger.getAttribute('data-lightbox-images') || '[]');
        } catch (err) {
          images = [];
        }
        var index = parseInt(trigger.getAttribute('data-lightbox-index'), 10) || 0;
        openLightbox(images, index);
      });

      lightboxPrev.addEventListener('click', function () {
        lightboxIndex = (lightboxIndex - 1 + lightboxImages.length) % lightboxImages.length;
        renderLightbox();
      });

      lightboxNext.addEventListener('click', function () {
        lightboxIndex = (lightboxIndex + 1) % lightboxImages.length;
        renderLightbox();
      });

      lightboxClose.addEventListener('click', closeLightbox);

      lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox) {
          closeLightbox();
        }
      });

      document.addEventListener('keydown', function (e) {
        if (lightbox.hidden) {
          return;
        }
        if (e.key === 'Escape') {
          closeLightbox();
        } else if (e.key === 'ArrowLeft') {
          lightboxPrev.click();
        } else if (e.key === 'ArrowRight') {
          lightboxNext.click();
        }
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
              reviewMsg.textContent = (json.data && json.data.message) || '送信しました。';
              reviewForm.reset();
            } else {
              reviewMsg.className = 'review-form-msg review-form-msg--error';
              reviewMsg.textContent = (json.data && json.data.message) || 'エラーが発生しました。';
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
