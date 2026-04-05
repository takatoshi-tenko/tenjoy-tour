/**
 * モバイルメニュー開閉
 * @package Friend2026
 */
(function () {
	var toggle = document.querySelector('.nav-toggle');
	var menu = document.getElementById('mobile-menu');
	if (!toggle || !menu) return;

	toggle.addEventListener('click', function () {
		var open = menu.getAttribute('aria-hidden') !== 'true';
		menu.setAttribute('aria-hidden', open ? 'true' : 'false');
		menu.hidden = open;
		toggle.setAttribute('aria-expanded', open ? 'false' : 'true');
		toggle.setAttribute('aria-label', open ? 'メニューを開く' : 'メニューを閉じる');
		menu.classList.toggle('mobile-open', !open);
	});
})();
