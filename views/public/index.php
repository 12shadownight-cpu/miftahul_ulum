<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MI Miftahul Ulum Batam</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Navbar */
    .navbar {
      background-color: #b8b8f3;
    }

    .navbar-nav .nav-item {
      margin-left: 25px;   /* adjust these values as you like */
      margin-right: 25px;
    }

    .me-custom { margin-right: 40px; }

    /* Welcome Section */
    #welcome {
      background: url('../../assets/images/school.jpg') no-repeat center center;
      background-size: cover;
      color: white;
      text-align: center;
      padding: 120px 20px;
      font-weight: bold;
    }

    /* Tentang Section */
    #tentang {
      padding: 60px 20px;
      background-color: #F5EE90;
    }

    /* Galeri Section */
    #galeri {
      padding: 60px 0;
      background-color: #AEE64C;
    }

    /* Reduce Carousel Height */
    #galeri .carousel-item img {
      height: 400px;        /* adjust as needed, e.g. 300px–500px */
      object-fit: cover;    /* crop instead of stretching */
    }

    .carousel-caption {
      background-color: rgba(0, 0, 0, 0.5);
      border-radius: 5px;
      padding: 5px 10px;
    }

    /* Footer */
    footer {
      background-color: #b8b8f3;
      padding: 1rem;
      text-align: center;
      font-size: 0.9rem;
      border-top: 1px solid #dee2e6;
      position: relative;
      bottom: 0;
      width: 100%;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="../../assets/images/logo.svg" alt="Logo Madrasah" width="40" class="me-2">
        MI Miftahul Ulum Batam
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
          <li class="nav-item"><a class="nav-link" href="#galeri">Galeri</a></li>
          <li class="nav-item"><a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Pilih Login</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
          <a href="../user/login.php" class="btn btn-success mb-2 w-100">Login User</a>
          <a href="../pengurus/login.php" class="btn btn-primary w-100">Login Pengurus</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Welcome Section -->
  <section id="welcome">
    <h1>Selamat Datang Di Website</h1>
    <h2>MI Miftahul Ulum Batam</h2>
  </section>

  <!-- Tentang Section -->
  <section id="tentang">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d498.6263684020659!2d104.02998878999156!3d1.1526714566050928!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d9890034bd42c5%3A0x9353a9cbb01b4d4!2sSD%20Miftahul%20Ulum!5e0!3m2!1sid!2sid!4v1760337161501!5m2!1sid!2sid"
            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
          </iframe>
        </div>
        <div class="col-md-6">
          <h3>Tentang MI Miftahul Ulum Batam</h3>
          <p>
            MI Miftahul Ulum Batam adalah lembaga pendidikan dasar Islam yang berkomitmen mencetak generasi berakhlak mulia dan berprestasi. 
            Kami mengedepankan pendidikan berbasis karakter dan teknologi untuk masa depan yang lebih baik.
          </p>
          <p><strong>Kontak:</strong> +62 812 3456 7890</p>
          <p>
            <strong>Media Sosial:</strong><br>
            <a href="#">Facebook</a> | 
            <a href="#">Instagram</a> | 
            <a href="#">Twitter</a>
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Galeri Section -->
  <section id="galeri">
    <div class="container">
      <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="../../assets/images/kegiatan belajar.jpg" class="d-block w-100" alt="Kegiatan Sekolah">
            <div class="carousel-caption">Kegiatan Belajar Mengajar</div>
          </div>
          <div class="carousel-item">
            <img src="../../assets/images/upacara bender.jpg" class="d-block w-100" alt="Upacara Bendera">
            <div class="carousel-caption">Upacara Bendera</div>
          </div>
          <div class="carousel-item">
            <img src="../../assets/images/kegiatan pramuka.jpg" class="d-block w-100" alt="Kegiatan Pramuka">
            <div class="carousel-caption">Kegiatan Pramuka</div>
          </div>
          <div class="carousel-item">
            <img src="../../assets/images/lomba sains.jpg" class="d-block w-100" alt="Lomba Sains">
            <div class="carousel-caption">Lomba Sains Antar Sekolah</div>
          </div>
          <div class="carousel-item">
            <img src="../../assets/images/extrakurikuler seni.jpg" class="d-block w-100" alt="Ekstrakurikuler Seni">
            <div class="carousel-caption">Ekstrakurikuler Seni</div>
          </div>
          <div class="carousel-item">
            <img src="../../assets/images/kegiatan olahraga.jpg" class="d-block w-100" alt="Kegiatan Olahraga">
            <div class="carousel-caption">Kegiatan Olahraga</div>
          </div>
          <div class="carousel-item">
            <img src="../../assets/images/kegiatan sosial.jpg" class="d-block w-100" alt="Kegiatan Sosial">
            <div class="carousel-caption">Kegiatan Sosial</div>
          </div>
          <div class="carousel-item">
            <img src="../../assets/images/guru murid.jpg" class="d-block w-100" alt="Guru dan Murid">
            <div class="carousel-caption">Guru dan Murid Berprestasi</div>
          </div>
          <div class="carousel-item">
            <img src="../../assets/images/kegiatan bersama.jpg" class="d-block w-100" alt="Kegiatan Bersama">
            <div class="carousel-caption">Kegiatan Gotong Royong</div>
          </div>
          <div class="carousel-item">
            <img src="../../assets/images/acara sekolah.jpg" class="d-block w-100" alt="Acara Sekolah">
            <div class="carousel-caption">Acara Akhir Tahun</div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    &copy; 2025 Madrasah Ibtidaiyah Miftahul Ulum.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
