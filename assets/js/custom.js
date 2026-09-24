/**
 * Lifeleck front-end behaviour, without jQuery: the header that fixes itself
 * on scroll, and styled selects (Nice Select markup, from ColorlibUI).
 */
(function () {
  'use strict';

  var UI = window.ColorlibUI;
  if (!UI) return;

  // menu fixed js code
  window.addEventListener('scroll', function () {
    var fixed = window.pageYOffset + 1 > 50;
    UI.toElements('.main_menu').forEach(function (menu) {
      menu.classList.toggle('menu_fixed', fixed);
      menu.classList.toggle('animated', fixed);
      menu.classList.toggle('fadeInDown', fixed);
    });
  }, { passive: true });

  UI.ready(function () {
    if (document.getElementById('default-select')) {
      UI.enhanceSelects('select');
    }
  });
}());
