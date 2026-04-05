/**
 * FAQ アコーディオン（カテゴリごとに1つだけ開く）
 * 複数カテゴリのリストすべてでクリックが効くよう、イベント委譲を使用
 */
(function () {
  var wrapper = document.querySelector('.page-faq-body');
  if (!wrapper) return;

  wrapper.addEventListener('click', function (e) {
    var btn = e.target.closest('[data-faq-toggle]');
    if (!btn) return;

    var item = btn.closest('.page-faq-item');
    var answer = item ? item.querySelector('.page-faq-answer') : null;
    if (!answer) return;

    var list = btn.closest('.page-faq-list');
    if (!list) return;

    var isExpanded = btn.getAttribute('aria-expanded') === 'true';

    // 同じカテゴリ（同じリスト）内の他をすべて閉じる
    var allButtons = list.querySelectorAll('[data-faq-toggle]');
    var allAnswers = list.querySelectorAll('.page-faq-answer');
    allButtons.forEach(function (b) {
      b.setAttribute('aria-expanded', 'false');
    });
    allAnswers.forEach(function (a) {
      a.hidden = true;
    });

    if (!isExpanded) {
      btn.setAttribute('aria-expanded', 'true');
      answer.hidden = false;
    }
  });
})();
