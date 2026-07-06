// index.blade.php
document.addEventListener('DOMContentLoaded', function () {
  // ---- toggle menu mobile ----
  var nav = document.querySelector('.st-nav');
  var toggle = document.getElementById('stNavToggle');

  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var isOpen = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    document.querySelectorAll('.st-nav__links a, .st-nav__actions a').forEach(function (link) {
      link.addEventListener('click', function () {
        nav.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
      });
    });
  }

  var revealItems = document.querySelectorAll('[data-reveal]');

  if ('IntersectionObserver' in window && revealItems.length) {
    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.15 }
    );

    revealItems.forEach(function (item) {
      observer.observe(item);
    });
  } else {
    revealItems.forEach(function (item) {
      item.classList.add('is-visible');
    });
  }

  // ---- Fitur Navbar Berubah Warna Otomatis Sesuai Section (SMOOTH JS TWEEN) ----
  // Alih-alih hanya toggle kelas (yang bergantung pada transition CSS),
  // kita interpolasi warna navbar via requestAnimationFrame + easing agar
  // perpindahan antar section tidak "patah" saat scroll cepat.
  (function initSmoothNavColor() {
    if (!nav) return;

    var sections = document.querySelectorAll('section[data-nav-class], section:not([data-nav-class])');
    if (!sections.length) return;

    // Palet warna per tipe section — dicocokkan dengan warna kelas CSS.
    var palettes = {
      'default': {
        cls: '',
        bg:      [13,  83,  14,  0.96],
        border:  [251, 245, 221, 0.12],
        fg:      [251, 245, 221, 1],
        fgMuted: [231, 225, 177, 1],
        accent:  [231, 225, 177, 1]
      },
      'st-nav--khaki': {
        cls: 'st-nav--khaki',
        bg:      [231, 225, 177, 0.96],
        border:  [28,  41,  21,  0.12],
        fg:      [28,  41,  21,  1],
        fgMuted: [63,  74,  53,  1],
        accent:  [13,  83,  14,  1]
      },
      'st-nav--dark': {
        cls: 'st-nav--dark',
        bg:      [28,  41,  21,  0.96],
        border:  [251, 245, 221, 0.12],
        fg:      [251, 245, 221, 1],
        fgMuted: [231, 225, 177, 1],
        accent:  [231, 225, 177, 1]
      }
    };

    var modifierClasses = ['st-nav--khaki', 'st-nav--dark'];
    var currentKey = 'default';
    var currentColors = clonePalette(palettes.default);
    var tweenRaf = null;

    // Terapkan warna awal ke CSS variable
    applyColors(currentColors);

    function clonePalette(p) {
      return {
        bg:      p.bg.slice(),
        border:  p.border.slice(),
        fg:      p.fg.slice(),
        fgMuted: p.fgMuted.slice(),
        accent:  p.accent.slice()
      };
    }

    function rgbaStr(c) {
      return 'rgba(' + Math.round(c[0]) + ',' + Math.round(c[1]) + ',' + Math.round(c[2]) + ',' + c[3].toFixed(3) + ')';
    }

    function applyColors(c) {
      nav.style.setProperty('--nav-bg',       rgbaStr(c.bg));
      nav.style.setProperty('--nav-border',   rgbaStr(c.border));
      nav.style.setProperty('--nav-fg',       rgbaStr(c.fg));
      nav.style.setProperty('--nav-fg-muted', rgbaStr(c.fgMuted));
      nav.style.setProperty('--nav-accent',   rgbaStr(c.accent));
    }

    // easing: easeInOutCubic — halus di awal & akhir
    function ease(t) {
      return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
    }

    function lerpArr(from, to, t) {
      var out = new Array(from.length);
      for (var i = 0; i < from.length; i++) out[i] = from[i] + (to[i] - from[i]) * t;
      return out;
    }

    function tweenTo(targetKey, duration) {
      if (targetKey === currentKey) return;

      var startColors = clonePalette(currentColors);
      var target = palettes[targetKey];
      var startTime = performance.now();

      // Toggle kelas segera hanya untuk selektor yang tidak var-aware
      // (mobile hamburger span), tapi biarkan bg/border/fg dianimasikan JS.
      nav.classList.remove.apply(nav.classList, modifierClasses);
      if (target.cls) nav.classList.add(target.cls);

      currentKey = targetKey;

      if (tweenRaf) cancelAnimationFrame(tweenRaf);

      function step(now) {
        var t = Math.min(1, (now - startTime) / duration);
        var e = ease(t);

        currentColors.bg      = lerpArr(startColors.bg,      target.bg,      e);
        currentColors.border  = lerpArr(startColors.border,  target.border,  e);
        currentColors.fg      = lerpArr(startColors.fg,      target.fg,      e);
        currentColors.fgMuted = lerpArr(startColors.fgMuted, target.fgMuted, e);
        currentColors.accent  = lerpArr(startColors.accent,  target.accent,  e);

        applyColors(currentColors);

        if (t < 1) {
          tweenRaf = requestAnimationFrame(step);
        } else {
          tweenRaf = null;
        }
      }

      tweenRaf = requestAnimationFrame(step);
    }

    // Deteksi section dominan berdasarkan rasio irisan tertinggi (hysteresis)
    if ('IntersectionObserver' in window) {
      var visible = new Map();

      var navObserver = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              visible.set(entry.target, entry.intersectionRatio);
            } else {
              visible.delete(entry.target);
            }
          });

          // Jangan ubah warna saat menu mobile terbuka
          if (nav.classList.contains('is-open')) return;

          // Cari section dengan rasio tertinggi
          var top = null;
          var topRatio = 0;
          visible.forEach(function (ratio, el) {
            if (ratio > topRatio) { topRatio = ratio; top = el; }
          });

          var targetKey = 'default';
          if (top) {
            var cls = top.getAttribute('data-nav-class');
            if (cls && palettes[cls]) targetKey = cls;
          }

          tweenTo(targetKey, 600);
        },
        {
          root: null,
          // Zona sensor lebih lebar → transisi lebih adem, tidak flicker
          rootMargin: '-20% 0px -60% 0px',
          threshold: [0, 0.25, 0.5, 0.75, 1]
        }
      );

      sections.forEach(function (section) { navObserver.observe(section); });
    }

    // Amankan warna navbar saat tombol menu mobile di-klik (Responsive fix)
    if (toggle) {
      toggle.addEventListener('click', function () {
        if (nav.classList.contains('is-open')) {
          nav.classList.remove.apply(nav.classList, modifierClasses);
          tweenTo('default', 400);
        }
      });
    }
  })();

 // ---- FITUR INTEGRASI DASHBOARD PETANI (MATERIAL VERSION) ----
 var dashToggle = document.getElementById('stDashToggle');
 var sidebar = document.getElementById('stSidebar');
 var triggerFormPanen = document.getElementById('triggerFormPanen');

 // 1. Kontrol Buka/Tutup Sidebar di Versi Mobile
 if (dashToggle && sidebar) {
   dashToggle.addEventListener('click', function (e) {
     e.stopPropagation();
     var isOpen = sidebar.classList.toggle('is-open');
     // Ubah icon tombol ketika menu terbuka/tertutup
     dashToggle.innerHTML = isOpen ? '<span class="material-icons">close</span>' : '<span class="material-icons">menu</span>';
   });

   // Menutup sidebar jika pengguna menyentuh area di luar menu
   document.addEventListener('click', function (e) {
     if (!sidebar.contains(e.target) && e.target !== dashToggle) {
       sidebar.classList.remove('is-open');
       dashToggle.innerHTML = '<span class="material-icons">menu</span>';
     }
   });
 }

 // 2. Transisi Link Navigasi Sidebar Aktif & Auto Focus Input
 var sidebarLinks = document.querySelectorAll('.st-sidebar__link');
 sidebarLinks.forEach(function (link) {
   link.addEventListener('click', function () {
     sidebarLinks.forEach(function (l) { l.classList.remove('is-active'); });
     this.classList.add('is-active');
     
     // Auto-close sidebar mobile setelah diklik
     if (sidebar) {
       sidebar.classList.remove('is-open');
       if (dashToggle) dashToggle.innerHTML = '<span class="material-icons">menu</span>';
     }
   });
 });

 if (triggerFormPanen) {
   triggerFormPanen.addEventListener('click', function () {
     var targetInput = document.getElementById('berat');
     if (targetInput) {
       setTimeout(function() {
         targetInput.focus();
       }, 450); // Menunggu scroll halus selesai bergerak
     }
   });
 }

  // ---- DARK MODE TOGGLE ----
  (function () {
    var root = document.documentElement;
    var toggles = [document.getElementById('stThemeToggle'), document.getElementById('stThemeToggleMobile')];

    function setTheme(theme) {
      if (theme === 'dark') {
        root.setAttribute('data-theme', 'dark');
      } else {
        root.removeAttribute('data-theme');
      }
      localStorage.setItem('sitani-theme', theme);
    }

    toggles.forEach(function (btn) {
      if (!btn) return;
      btn.addEventListener('click', function () {
        var isDark = root.getAttribute('data-theme') === 'dark';
        setTheme(isDark ? 'light' : 'dark');
      });
    });
  })();

  // ---- SINKRONISASI NOTIFIKASI REAL-TIME (data asli + Pusher) ----
  if (window.SiTaniRealtime) {
    window.SiTaniRealtime.initNotifBell();
  }

  // ---- FAQ ACCORDION ----
  (function () {
    var items = document.querySelectorAll('.st-faq-item');
    items.forEach(function (item) {
      var btn = item.querySelector('.st-faq-item__q');
      if (!btn) return;
      btn.addEventListener('click', function () {
        var wasOpen = item.classList.contains('is-open');
        items.forEach(function (i) { i.classList.remove('is-open'); });
        if (!wasOpen) item.classList.add('is-open');
      });
    });
  })();

});
