<script>
  window.SITANI_CSRF_TOKEN = "{{ csrf_token() }}";
  window.SITANI_PUSHER_KEY = "{{ config('broadcasting.connections.pusher.key') }}";
  window.SITANI_PUSHER_CLUSTER = "{{ config('broadcasting.connections.pusher.options.cluster') }}";
  @auth
  window.SITANI_USER = { id: {{ auth()->id() }}, name: @json(auth()->user()->name), role: @json(auth()->user()->role) };
  @endauth
</script>
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
<script src="{{ asset('js/realtime.js') }}"></script>
<!--
  Catatan: pemanggilan SiTaniRealtime.initNotifBell()/initChatWidget()/initCharts()
  sudah dilakukan otomatis di dalam public/js/main.js (dijalankan di setiap
  halaman), jadi cukup pastikan realtime.js ini dimuat SEBELUM main.js selesai
  dijalankan (letakkan komponen ini sebelum tag <script src=".../main.js">
  atau di manapun asalkan sebelum event DOMContentLoaded selesai diproses).
-->

