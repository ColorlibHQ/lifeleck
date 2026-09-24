/*! ColorlibUI 3.0.0 — core, ajaxchimp. Built for this theme from core + the modules it uses. */
/**
 * The interactive pieces these themes actually use, without jQuery.
 *
 * The core: the small helpers every module uses, plus the pieces nearly every
 * theme needs (styled selects, counters, reveal on scroll). Modules for the
 * other plugins the themes used (Owl Carousel, Slick, Magnific Popup, Isotope,
 * SlickNav, ScrollUp, AjaxChimp, ...) are appended after it by the build, only
 * when a theme uses them, and register themselves on window.ColorlibUI.
 * Those libraries are general-purpose; the themes use a narrow slice of them:
 * a looping carousel, a slider with a thumbnail strip, a lightbox for images
 * and video embeds, a styled select, numbers that count up and elements that
 * animate in as they scroll into view.
 *
 * Markup is read from the same class names and data attributes the old
 * plugins used, so templates do not change.
 *
 * Each piece is optional: if the markup is not on the page, nothing runs.
 */
(function () {
  'use strict';

  var PREFERS_REDUCED = window.matchMedia
    ? window.matchMedia('(prefers-reduced-motion: reduce)').matches
    : false;

  /** Elements from a selector, an Element, a NodeList/array, or a jQuery-like object. */
  function toElements(target, root) {
    if (!target) return [];
    if (typeof target === 'string') {
      return Array.prototype.slice.call((root || document).querySelectorAll(target));
    }
    if (target.nodeType === 1) return [target];
    if (typeof target.length === 'number') return Array.prototype.slice.call(target);
    return [];
  }

  /** Dispatch a bubbling CustomEvent carrying detail. */
  function emit(el, type, detail) {
    var event;
    try {
      event = new CustomEvent(type, { bubbles: true, cancelable: true, detail: detail || {} });
    } catch (e) {
      event = document.createEvent('CustomEvent');
      event.initCustomEvent(type, true, true, detail || {});
    }
    return el.dispatchEvent(event);
  }

  /** Shallow-merge plain objects left to right (Object.assign where available). */
  function extend(target) {
    for (var i = 1; i < arguments.length; i++) {
      var src = arguments[i];
      if (!src) continue;
      for (var k in src) {
        if (Object.prototype.hasOwnProperty.call(src, k)) target[k] = src[k];
      }
    }
    return target;
  }

  /** Parse an HTML string into its first element (for navText, prevArrow, ...). */
  function fromHTML(html) {
    var t = document.createElement('template');
    t.innerHTML = String(html).trim();
    return t.content.firstElementChild || document.createTextNode(String(html));
  }

  /** Animate window scroll to y over ms (instant with reduced motion). */
  function scrollToY(y, ms) {
    if (PREFERS_REDUCED || !ms) { window.scrollTo(0, y); return; }
    var from = window.pageYOffset, start = null;
    function step(now) {
      if (start === null) start = now;
      var p = Math.min((now - start) / ms, 1);
      var eased = p < 0.5 ? 2 * p * p : -1 + (4 - 2 * p) * p;
      window.scrollTo(0, from + (y - from) * eased);
      if (p < 1) window.requestAnimationFrame(step);
    }
    window.requestAnimationFrame(step);
  }

  /* ------------------------------------------------------------------ *
   * The jQuery effects the themes use, on the Web Animations API.
   * jQuery's semantics: slideDown/fadeIn show a hidden element (display
   * from the stylesheet, or block), slideUp/fadeOut end with display:none.
   * With reduced motion the end state is applied at once.
   * ------------------------------------------------------------------ */

  function isHidden(el) {
    return window.getComputedStyle(el).display === 'none';
  }

  function show(el) {
    el.style.display = '';
    if (isHidden(el)) el.style.display = 'block';
  }

  function animateTo(el, frames, ms, done) {
    if (PREFERS_REDUCED || !ms || !el.animate) { if (done) done(); return; }
    var anim = el.animate(frames, { duration: ms, easing: 'ease' });
    anim.onfinish = function () { if (done) done(); };
  }

  /** slide(el, 'up' | 'down' | 'toggle', ms = 400, done) */
  function slide(target, dir, ms, done) {
    if (ms === undefined) ms = 400;
    toElements(target).forEach(function (el) {
      var hidden = isHidden(el);
      var down = dir === 'down' || (dir === 'toggle' && hidden);
      if (down && !hidden) return;
      if (!down && hidden) return;
      if (down) show(el);
      var h = el.scrollHeight + 'px';
      el.style.overflow = 'hidden';
      animateTo(el, down ? [{ height: '0px' }, { height: h }] : [{ height: h }, { height: '0px' }], ms, function () {
        el.style.overflow = '';
        if (!down) el.style.display = 'none';
        if (done) done.call(el);
      });
    });
  }

  /** fade(el, 'in' | 'out' | 'toggle', ms = 400, done) */
  function fade(target, dir, ms, done) {
    if (ms === undefined) ms = 400;
    toElements(target).forEach(function (el) {
      var hidden = isHidden(el);
      var fadeIn = dir === 'in' || (dir === 'toggle' && hidden);
      if (fadeIn && !hidden) return;
      if (!fadeIn && hidden) return;
      if (fadeIn) show(el);
      animateTo(el, fadeIn ? [{ opacity: 0 }, { opacity: 1 }] : [{ opacity: 1 }, { opacity: 0 }], ms, function () {
        if (!fadeIn) el.style.display = 'none';
        if (done) done.call(el);
      });
    });
  }

  /** Document offset of an element, like jQuery's .offset(). */
  function offset(el) {
    var r = el.getBoundingClientRect();
    return { top: r.top + window.pageYOffset, left: r.left + window.pageXOffset };
  }

  /**
   * POST/GET to WordPress (admin-ajax.php and friends) the way $.ajax did:
   * data is form-encoded, the response parsed as JSON when it is JSON.
   * Returns a Promise.
   */
  function request(url, opts) {
    opts = opts || {};
    var method = (opts.method || opts.type || 'POST').toUpperCase();
    var body = null;
    if (opts.data) {
      var params = new URLSearchParams();
      Object.keys(opts.data).forEach(function (k) { params.append(k, opts.data[k]); });
      if (method === 'GET') url += (url.indexOf('?') < 0 ? '?' : '&') + params.toString();
      else body = params;
    }
    return fetch(url, { method: method, body: body, credentials: 'same-origin' }).then(function (res) {
      return res.text().then(function (text) {
        try { return JSON.parse(text); } catch (e) { return text; }
      });
    });
  }

  function debounce(fn, wait) {
    var t;
    return function () {
      clearTimeout(t);
      t = setTimeout(fn, wait);
    };
  }

  function videoSource(href) {
    var yt = href.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([\w-]+)/);
    if (yt) return 'https://www.youtube.com/embed/' + yt[1] + '?autoplay=1&rel=0';
    var vm = href.match(/vimeo\.com\/(?:video\/)?(\d+)/);
    if (vm) return 'https://player.vimeo.com/video/' + vm[1] + '?autoplay=1';
    return href;
  }


  /* ------------------------------------------------------------------ *
   * Select
   *
   * Builds the same markup jQuery Nice Select produced, because the themes
   * style that structure: .nice-select > .current, and a .list of .option.
   * The original select stays in the DOM and keeps carrying the value, so
   * forms submit exactly as before and assistive technology still sees it.
   * ------------------------------------------------------------------ */

  function enhanceSelect(select) {
    if (select.dataset.clEnhanced) return;
    select.dataset.clEnhanced = '1';

    var wrap = document.createElement('div');
    wrap.className = 'nice-select ' + (select.className || '');
    wrap.tabIndex = 0;
    wrap.setAttribute('role', 'button');
    wrap.setAttribute('aria-haspopup', 'listbox');
    wrap.setAttribute('aria-expanded', 'false');

    var current = document.createElement('span');
    current.className = 'current';

    var list = document.createElement('ul');
    list.className = 'list';
    list.setAttribute('role', 'listbox');

    Array.prototype.forEach.call(select.options, function (option) {
      var li = document.createElement('li');
      li.className = 'option' + (option.selected ? ' selected' : '') +
        (option.disabled ? ' disabled' : '');
      li.textContent = option.textContent;
      li.dataset.value = option.value;
      li.setAttribute('role', 'option');
      li.setAttribute('aria-selected', option.selected ? 'true' : 'false');

      li.addEventListener('click', function (e) {
        // The wrapper toggles on click; without this the choice would bubble
        // up and reopen the list it just closed.
        e.stopPropagation();
        if (option.disabled) return;
        select.value = option.value;
        select.dispatchEvent(new Event('change', { bubbles: true }));
        sync();
        wrap.classList.remove('open');
        wrap.setAttribute('aria-expanded', 'false');
      });
      list.appendChild(li);
    });

    function sync() {
      var chosen = select.options[select.selectedIndex];
      current.textContent = chosen ? chosen.textContent : '';
      Array.prototype.forEach.call(list.children, function (li) {
        var on = li.dataset.value === select.value;
        li.classList.toggle('selected', on);
        li.setAttribute('aria-selected', on ? 'true' : 'false');
      });
    }

    wrap.addEventListener('click', function () {
      var open = wrap.classList.toggle('open');
      wrap.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    wrap.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); wrap.click(); }
      if (e.key === 'Escape') { wrap.classList.remove('open'); }
    });
    document.addEventListener('click', function (e) {
      if (!wrap.contains(e.target)) {
        wrap.classList.remove('open');
        wrap.setAttribute('aria-expanded', 'false');
      }
    });
    select.addEventListener('change', sync);

    wrap.appendChild(current);
    wrap.appendChild(list);
    select.parentNode.insertBefore(wrap, select);

    // Kept for the form and for assistive technology, but out of the way.
    select.style.position = 'absolute';
    select.style.width = '1px';
    select.style.height = '1px';
    select.style.opacity = '0';
    select.style.pointerEvents = 'none';

    sync();
  }

  /* ------------------------------------------------------------------ *
   * Running when the page is ready
   *
   * Callers are theme scripts in the footer and inline scripts printed by
   * widgets in the middle of the page; both are safe.
   * ------------------------------------------------------------------ */

  function ready(fn) {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', fn);
    } else {
      fn();
    }
  }

  function each(target, fn) {
    ready(function () {
      toElements(target).forEach(fn);
    });
  }

  /** $('select').niceSelect(), without jQuery. */
  function enhanceSelects(selector) {
    each(selector || 'select', function (select) {
      // Nice Select never handled multiple selects, and neither does this.
      if (select.multiple) return;
      enhanceSelect(select);
    });
  }


  /* ------------------------------------------------------------------ *
   * Counter
   *
   * Replaces jQuery CounterUp and the Waypoints library it depended on.
   * Like CounterUp, the number is read from the element's own text and left
   * untouched until the element scrolls into view; it then counts up from
   * zero and always finishes on the original text. Text that is not a plain
   * number ("24/7") is left alone.
   * ------------------------------------------------------------------ */

  function counter(selector, options) {
    var time = (options && options.time) || 1000;

    each(selector, function (el) {
      if (el.dataset.clCounter) return;
      el.dataset.clCounter = '1';

      var text = el.textContent.trim();
      var plain = text.replace(/,/g, '');
      if (!/^\d+(\.\d+)?$/.test(plain)) return;
      if (PREFERS_REDUCED || !('IntersectionObserver' in window)) return;

      var target = parseFloat(plain);
      var decimals = (plain.split('.')[1] || '').length;
      var commas = /\d,\d/.test(text);

      function format(n) {
        var s = n.toFixed(decimals);
        return commas ? s.replace(/\B(?=(\d{3})+(?!\d))/g, ',') : s;
      }

      var observer = new IntersectionObserver(function (entries) {
        if (!entries[0].isIntersecting) return;
        observer.disconnect();

        var start = null;
        function step(now) {
          if (start === null) start = now;
          var progress = Math.min((now - start) / time, 1);
          el.textContent = progress < 1 ? format(target * progress) : text;
          if (progress < 1) window.requestAnimationFrame(step);
        }
        window.requestAnimationFrame(step);
      });
      observer.observe(el);
    });
  }


  /* ------------------------------------------------------------------ *
   * Reveal on scroll
   *
   * Replaces WOW.js, against the same markup: an element with class "wow"
   * and an animate.css animation class, plus optional data-wow-duration,
   * data-wow-delay and data-wow-iteration. It is hidden until it scrolls
   * into view, then gets the "animated" class.
   *
   * The animation name is held at "none" until then, as WOW did: otherwise
   * the animation has already run (at zero duration) by the time "animated"
   * gives it a real one, and nothing moves. With reduced motion requested,
   * or no IntersectionObserver, elements are simply left visible.
   * ------------------------------------------------------------------ */

  function reveal(selector, options) {
    var offset = (options && options.offset) || 0;
    if (PREFERS_REDUCED || !('IntersectionObserver' in window)) return;

    each(selector || '.wow', function (el) {
      if (el.dataset.clReveal) return;
      el.dataset.clReveal = '1';

      el.style.visibility = 'hidden';
      el.style.animationName = 'none';

      var observer = new IntersectionObserver(function (entries) {
        if (!entries[0].isIntersecting) return;
        observer.disconnect();

        var data = el.dataset;
        if (data.wowDuration) el.style.animationDuration = data.wowDuration;
        if (data.wowDelay) el.style.animationDelay = data.wowDelay;
        if (data.wowIteration) el.style.animationIterationCount = data.wowIteration;
        el.style.animationName = '';
        el.style.visibility = 'visible';
        el.classList.add('animated');
      }, { rootMargin: '0px 0px ' + (-offset) + 'px 0px' });
      observer.observe(el);
    });
  }

  var UI = window.ColorlibUI || {};
  extend(UI, {
    version: '3.0.0',
    reducedMotion: PREFERS_REDUCED,
    toElements: toElements,
    each: each,
    emit: emit,
    extend: extend,
    fromHTML: fromHTML,
    scrollToY: scrollToY,
    slide: slide,
    fade: fade,
    offset: offset,
    request: request,
    enhanceSelect: enhanceSelect,
    enhanceSelects: enhanceSelects,
    counter: counter,
    reveal: reveal,
    ready: ready,
    videoSource: videoSource,
    debounce: debounce
  });
  window.ColorlibUI = UI;
}());

/* ColorlibUI module: ajaxchimp — replaces jquery.ajaxchimp. A Mailchimp embed
 * form posts to .../subscribe/post?u=..&id=..; like the plugin, this turns it into
 * a JSONP request to .../subscribe/post-json?u=..&id=..&c=<callback> (Mailchimp
 * sends no CORS headers, so JSONP is still the only way to read the answer), stops
 * the normal submit and writes the result into the form's `.info` element with the
 * `valid` / `error` classes on it and on the email input. The JSONP call is a
 * script tag with a one-off global callback and a timeout. */
(function () {
  'use strict';
  var UI = window.ColorlibUI;
  if (!UI) return;

  var SUCCESS = 'We have sent you a confirmation email';
  var seq = 0;
  var cacheBust = Date.now();
  var SHOW_PROPS = ['height', 'marginTop', 'marginBottom', 'paddingTop', 'paddingBottom',
    'width', 'marginLeft', 'marginRight', 'paddingLeft', 'paddingRight'];

  /** jQuery's form.serializeArray(), folded into an object (last value wins). */
  function serialize(form) {
    var data = {};
    Array.prototype.forEach.call(form.elements, function (el) {
      if (!el.name || el.disabled || el.matches(':disabled')) return;
      if (!/^(?:input|select|textarea|keygen)/i.test(el.nodeName)) return;
      if (/^(?:submit|button|image|reset|file)$/i.test(el.type)) return;
      if (/^(?:checkbox|radio)$/i.test(el.type) && !el.checked) return;
      if (el.nodeName === 'SELECT' && el.multiple) {
        Array.prototype.forEach.call(el.options, function (o) { if (o.selected) data[el.name] = o.value; });
        return;
      }
      if (el.nodeName === 'SELECT' && el.selectedIndex < 0) return;
      data[el.name] = el.value.replace(/\r?\n/g, '\r\n');
    });
    return data;
  }

  function param(data) {
    return Object.keys(data).map(function (k) {
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k] == null ? '' : data[k]);
    }).join('&');
  }

  /** JSONP like jQuery's: url's `c=?` becomes the callback name; data and `_=` are appended. */
  function jsonp(url, data, success, error) {
    var name = 'ColorlibUIChimp_' + (++seq) + '_' + Date.now();
    var script = document.createElement('script');
    var called = false, timer;
    function cleanup(answered) {
      clearTimeout(timer);
      // After a timeout or error a late reply may still arrive: leave it a no-op to call.
      if (answered) { try { delete window[name]; } catch (e) { window[name] = undefined; } }
      else window[name] = function () {};
      if (script.parentNode) script.parentNode.removeChild(script);
    }
    window[name] = function (resp) { called = true; cleanup(true); success(resp); };
    url = url.replace(/(=)\?(?=&|$)|\?\?/, '$1' + name);
    var qs = param(data);
    if (qs) url += (/\?/.test(url) ? '&' : '?') + qs;
    url += (/\?/.test(url) ? '&' : '?') + '_=' + (cacheBust++);
    script.async = true;
    script.src = url;
    script.onload = function () { if (!called) { cleanup(); error('parsererror'); } };
    script.onerror = function () { cleanup(); error('error'); };
    timer = setTimeout(function () { cleanup(); error('timeout'); }, 15000);
    document.head.appendChild(script);
  }

  /** jQuery's show(2000): a hidden element grows and fades in; a visible one is left alone. */
  function show(el, ms) {
    if (getComputedStyle(el).display !== 'none') return;
    el.style.display = '';
    if (getComputedStyle(el).display === 'none') el.style.display = 'block';
    if (UI.reducedMotion) return;
    var cs = getComputedStyle(el), full = {}, start = null;
    SHOW_PROPS.forEach(function (p) { full[p] = parseFloat(cs[p]) || 0; });
    var opacity = parseFloat(cs.opacity);
    el.style.overflow = 'hidden';
    function apply(e) {
      SHOW_PROPS.forEach(function (p) { el.style[p] = full[p] * e + 'px'; });
      el.style.opacity = String(opacity * e);
    }
    apply(0);
    requestAnimationFrame(function frame(now) {
      if (start === null) start = now;
      var p = Math.min((now - start) / ms, 1);
      apply(0.5 - Math.cos(p * Math.PI) / 2);
      if (p < 1) { requestAnimationFrame(frame); return; }
      SHOW_PROPS.forEach(function (prop) { el.style[prop] = ''; });
      el.style.opacity = '';
      el.style.overflow = '';
    });
  }

  function each(list, fn) { Array.prototype.forEach.call(list, fn); }
  function swap(list, remove, add) {
    each(list, function (el) { el.classList.remove(remove); el.classList.add(add); });
  }

  function translate(language, key) {
    var t = UI.ajaxChimp.translations;
    return language !== 'en' && t && t[language] && t[language][key] ? t[language][key] : null;
  }

  function init(form, options) {
    var emails = form.querySelectorAll('input[type=email]');
    var labels = form.querySelectorAll('.info');
    var s = UI.extend({ url: form.getAttribute('action'), language: 'en' }, options);
    if (!s.url) return null;
    var url = s.url.replace('/post?', '/post-json?').concat('&c=?');

    form.setAttribute('novalidate', 'true');
    each(emails, function (e) { e.setAttribute('name', 'EMAIL'); });

    function setLabel(html) {
      each(labels, function (l) { l.innerHTML = html; show(l, 2000); });
    }

    function onResponse(resp) {
      var msg;
      if (resp.result === 'success') {
        msg = SUCCESS;
        swap(labels, 'error', 'valid');
        swap(emails, 'error', 'valid');
      } else {
        swap(emails, 'valid', 'error');
        swap(labels, 'valid', 'error');
        // Mailchimp prefixes field errors with the field index: "0 - Please enter a value".
        try {
          var parts = resp.msg.split(' - ', 2);
          msg = parts[1] !== undefined && parseInt(parts[0], 10).toString() === parts[0] ? parts[1] : resp.msg;
        } catch (e) {
          msg = resp.msg;
        }
      }
      var code = UI.ajaxChimp.responses[msg];
      if (code !== undefined) msg = translate(s.language, code) || msg;
      setLabel(msg);
      if (s.callback) s.callback(resp);
      UI.emit(form, 'ajaxchimp:response', resp);
    }

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      e.stopPropagation();
      jsonp(url, serialize(form), onResponse, function (text) {
        if (window.console) console.log('mailchimp ajax submit error: ' + text);
      });
      setLabel(translate(s.language, 'submit') || 'Submitting...');
    });
    return { form: form, settings: s };
  }

  /** $(form).ajaxChimp(options) → ColorlibUI.ajaxChimp(form, options). */
  UI.ajaxChimp = function (target, options) {
    var out = [];
    UI.toElements(target).forEach(function (form) {
      if (form._clAjaxChimp) { out.push(form._clAjaxChimp); return; }
      var inst = init(form, options);
      if (!inst) return;
      form._clAjaxChimp = inst;
      form.setAttribute('data-cl-ajaxchimp', '1');
      out.push(inst);
    });
    return out;
  };
  UI.ajaxChimp.responses = {
    'We have sent you a confirmation email': 0,
    'Please enter a valid email': 1,
    'An email address must contain a single @': 2,
    'The domain portion of the email address is invalid (the portion after the @: )': 3,
    'The username portion of the email address is invalid (the portion before the @: )': 4,
    'This email address looks fake or invalid. Please enter a real email address': 5
  };
  UI.ajaxChimp.translations = { en: null };
  UI.ajaxChimp.init = function (selector, options) { return UI.ajaxChimp(selector, options); };
}());
