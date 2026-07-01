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

  // ---- Fitur Navbar Berubah Warna Otomatis Sesuai Section ----
  var sections = document.querySelectorAll('section');
  var modifierClasses = ['st-nav--khaki', 'st-nav--dark'];

  if ('IntersectionObserver' in window && sections.length && nav) {
    var navObserver = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          // Hanya ubah warna jika section mendominasi layar & menu mobile TIDAK sedang terbuka
          if (entry.isIntersecting && !nav.classList.contains('is-open')) {
            var targetClass = entry.target.getAttribute('data-nav-class');

            // Reset warna navbar terlebih dahulu
            nav.classList.remove(...modifierClasses);

            // Pasang warna baru jika tipe section memilikinya
            if (targetClass) {
              nav.classList.add(targetClass);
            }
          }
        });
      },
      {
        root: null,
        // Area sensor deteksi: fokus mendeteksi saat kepala section berada di 15% dari atas layar
        rootMargin: '-15% 0px -75% 0px',
        threshold: 0
      }
    );

    sections.forEach(function (section) {
      navObserver.observe(section);
    });

    // Mengamankan warna navbar saat tombol menu mobile di-klik (Responsive fix)
    if (toggle) {
      toggle.addEventListener('click', function () {
        if (nav.classList.contains('is-open')) {
          nav.classList.remove(...modifierClasses);
        }
      });
    }
  }

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
});