/**
 * SiTani — Realtime layer
 * Menghubungkan UI (lonceng notifikasi, widget chat, grafik) ke backend
 * sungguhan: REST endpoint Laravel + broadcasting Pusher/Laravel Echo.
 *
 * File ini aman dimuat di halaman manapun (landing page maupun dashboard):
 * setiap modul memeriksa dulu apakah elemen terkait ada di DOM sebelum
 * melakukan apa pun, dan memeriksa apakah user sedang login sebelum
 * memanggil endpoint yang butuh autentikasi.
 */
window.SiTaniRealtime = (function () {
  'use strict';

  var csrfToken = window.SITANI_CSRF_TOKEN || '';
  var currentUser = window.SITANI_USER || null; // { id, name, role } atau null jika tamu

  /* ---------------------------------------------------------------- */
  /* Helper: fetch JSON dengan header standar Laravel                  */
  /* ---------------------------------------------------------------- */
  function fetchJSON(url, options) {
    options = options || {};
    var headers = Object.assign(
      {
        'X-Requested-With': 'XMLHttpRequest',
        Accept: 'application/json',
      },
      options.headers || {}
    );

    if (options.method && options.method.toUpperCase() !== 'GET') {
      headers['X-CSRF-TOKEN'] = csrfToken;
      if (!(options.body instanceof FormData)) {
        headers['Content-Type'] = 'application/json';
      }
    }

    return fetch(url, Object.assign({ credentials: 'same-origin' }, options, { headers: headers }))
      .then(function (res) {
        return res.json().then(function (data) {
          if (!res.ok) {
            var err = new Error((data && data.message) || 'Request gagal');
            err.data = data;
            throw err;
          }
          return data;
        });
      });
  }

  /* ---------------------------------------------------------------- */
  /* Echo / Pusher setup                                                */
  /* ---------------------------------------------------------------- */
  var echoInstance = null;

  function initEcho() {
    if (echoInstance) return echoInstance;
    if (typeof Pusher === 'undefined' || typeof Echo === 'undefined') return null;
    if (!window.SITANI_PUSHER_KEY) return null; // belum dikonfigurasi di .env, lewati saja

    window.Pusher = Pusher;

    echoInstance = new Echo({
      broadcaster: 'pusher',
      key: window.SITANI_PUSHER_KEY,
      cluster: window.SITANI_PUSHER_CLUSTER || 'ap1',
      forceTLS: true,
      authorizer: function (channel) {
        return {
          authorize: function (socketId, callback) {
            fetchJSON('/broadcasting/auth', {
              method: 'POST',
              body: JSON.stringify({ socket_id: socketId, channel_name: channel.name }),
            })
              .then(function (data) {
                callback(false, data);
              })
              .catch(function (err) {
                callback(true, err);
              });
          },
        };
      },
    });

    return echoInstance;
  }

  /* ---------------------------------------------------------------- */
  /* Modul: Lonceng Notifikasi (real-time)                              */
  /* ---------------------------------------------------------------- */
  function initNotifBell(ids) {
    ids = ids || {};
    var toggle = document.getElementById(ids.toggle || 'stNotifToggle');
    var panel = document.getElementById(ids.panel || 'stNotifPanel');
    var list = document.getElementById(ids.list || 'stNotifList');
    var dot = document.getElementById(ids.dot || 'stNotifDot');
    if (!toggle || !panel || !list) return;

    // Tamu (belum login) tidak punya notifikasi pribadi — biarkan
    // konten contoh statis yang sudah ada di markup, tanpa fetch.
    if (!currentUser) return;

    var unread = 0;

    function updateDot() {
      if (dot) dot.hidden = unread <= 0;
    }

    function renderItem(n, prepend) {
      var li = document.createElement('li');
      li.className = 'st-notif-item';
      li.dataset.id = n.id;
      li.innerHTML =
        '<span class="st-notif-item__ic">' + iconFor(n.tipe) + '</span>' +
        '<div><p>' + escapeHtml(n.judul ? n.judul + ' — ' + n.pesan : n.pesan) + '</p><time>' + escapeHtml(n.created_at) + '</time></div>';
      if (prepend) {
        list.insertBefore(li, list.firstChild);
      } else {
        list.appendChild(li);
      }
    }

    function iconFor(tipe) {
      var map = {
        panen_masuk: '🌾',
        panen_disetujui: '✓',
        panen_ditolak: '✕',
        anggota_baru: '👤',
        bagi_hasil: '💸',
        role_diubah: '🛠️',
        chat: '💬',
      };
      return map[tipe] || '🔔';
    }

    function escapeHtml(str) {
      var div = document.createElement('div');
      div.textContent = String(str == null ? '' : str);
      return div.innerHTML;
    }

    // 1. Muat notifikasi awal dari database (bukan data contoh).
    fetchJSON('/notifikasi')
      .then(function (data) {
        list.innerHTML = '';
        (data.notifikasis || []).forEach(function (n) {
          renderItem(n, false);
        });
        unread = data.jumlah_belum_dibaca || 0;
        updateDot();
      })
      .catch(function () {
        // Diamkan jika gagal (mis. belum migrate) — dropdown tetap bisa dibuka kosong.
      });

    // 2. Dengarkan notifikasi baru secara real-time lewat Pusher.
    var echo = initEcho();
    if (echo && currentUser) {
      echo.private('App.Models.User.' + currentUser.id).listen('.notifikasi.baru', function (n) {
        renderItem(n, true);
        while (list.children.length > 8) {
          list.removeChild(list.lastChild);
        }
        unread += 1;
        updateDot();
      });
    } else {
      // 3. Fallback polling jika Pusher belum dikonfigurasi / koneksi gagal,
      // supaya badge tetap "tersinkronisasi" walau tidak instan.
      setInterval(function () {
        fetchJSON('/notifikasi/jumlah-belum-dibaca')
          .then(function (data) {
            if ((data.jumlah_belum_dibaca || 0) > unread) {
              unread = data.jumlah_belum_dibaca;
              updateDot();
            }
          })
          .catch(function () {});
      }, 20000);
    }

    toggle.addEventListener('click', function (e) {
      e.stopPropagation();
      var isHidden = panel.hidden;
      panel.hidden = !isHidden;
      toggle.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
      if (isHidden && unread > 0) {
        unread = 0;
        updateDot();
        fetchJSON('/notifikasi/baca-semua', { method: 'POST' }).catch(function () {});
      }
    });

    document.addEventListener('click', function (e) {
      if (!panel.hidden && !panel.contains(e.target) && e.target !== toggle) {
        panel.hidden = true;
        toggle.setAttribute('aria-expanded', 'false');
      }
    });
  }

  /* ---------------------------------------------------------------- */

  return {
    fetchJSON: fetchJSON,
    initEcho: initEcho,
    initNotifBell: initNotifBell,
    currentUser: currentUser,
  };
})();
