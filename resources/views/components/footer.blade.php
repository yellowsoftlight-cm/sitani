<footer class="st-footer">
    <div class="st-container st-footer__inner">
      <div>
        <span class="st-nav__mark st-nav__mark--light">SiTani</span>
        <p>Sistem manajemen kelompok tani — pendaftaran, panen, distribusi, dan bagi hasil dalam satu tempat.</p>
      </div>
      <div class="st-footer__cols">
        <div>
          <h5>Navigasi</h5>
          <a href="#peran">Peran Pengguna</a>
          <a href="#alur">Alur Kerja</a>
          <a href="#fitur">Fitur</a>
        </div>
        <div>
          <h5>Akun</h5>
          <a href="{{ route('login') ?? '#' }}">Masuk</a>
          <a href="{{ route('register') ?? '#' }}">Daftar Kelompok</a>
        </div>
      </div>
    </div>
    <div class="st-container st-footer__bottom">
      <span>© {{ date('Y') }} SiTani. Seluruh hak cipta dilindungi.</span>
    </div>
  </footer>