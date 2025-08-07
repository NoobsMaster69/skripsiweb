<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Sistem Luaran</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('enno/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('enno/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('enno/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('enno/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('enno/assets/vendor/aos/aos.css" rel="stylesheet') }}">
    <link href="{{ asset('enno/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('enno/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('enno/assets/css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('enno/assets/css/style.css') }}">


    <!-- =======================================================
  * Template Name: eNno
  * Template URL: https://bootstrapmade.com/enno-free-simple-bootstrap-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="#" class="logo d-flex align-items-center me-auto">
                <img src="enno/assets/img/logo/logo-ucic.png" alt="Logo" style="height: 40px; margin-right: 10px;">
                <h1 class="sitename">U-CIC Luaran</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
                    <li><a href="#about" class="{{ request()->is('about') ? 'active' : '' }}">Tentang</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#contact">Kontak</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <!-- Tambah jarak dan desain tombol halus -->
            <a href="{{ route('login') }}" class="login-btn ms-5">Login</a>




        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section">

            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center"
                        data-aos="zoom-out">
                        <h1>Sistem Manajemen Luaran Akademik U-CIC</h1>
                        <p>Platform berbasis website untuk pencatatan, pemantauan, dan pengelolaan luaran akademik
                            secara efisien.</p>
                        <div class="d-flex">
                            <a href="{{ route('login') }}" class="btn-login-custom">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Login
                            </a>
                            {{-- <a href="#" class="btn-get-started">Registrasi</a> --}}
                            {{-- <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch Video</span></a> --}}
                        </div>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="200">
                        {{-- GAMBAR LOGO LANDING PAGE --}}
                        <img src="enno/assets/img/logo/Logo1.png" class="img-fluid animated" alt="">
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->

        <!-- Featured Services Section -->
        <section id="featured-services" class="featured-services section">

        </section><!-- /Featured Services Section -->
        <hr class="section-divider">


        <!-- About Section -->
        <section id="about" class="about section white-background">

            <div class="container section-title" data-aos="fade-up">
                <h2 class="text-center fw-bold text-uppercase" style="color:#2b3a67">Tentang Sejarah U-CIC</h2>
                <hr style="width: 80px; border: 2px solid #2b3a67; margin: 0 auto 20px auto;">
            </div>

            <div class="container">
                <div class="row gy-4">
                    <!-- Kiri: Sejarah -->
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                        <p style="text-align: justify;">
                            Catur Insan Cendekia (CIC) didirikan pada tahun 1984 sebagai lembaga pendidikan kursus dan
                            pelatihan.
                            Sepuluh tahun kemudian, pada tahun 1994, CIC mengembangkan diri dengan mendirikan Akademi
                            Perdagangan Widya Dharma.
                            Perkembangan berlanjut pada tahun 1999 dengan pendirian Sekolah Tinggi Manajemen Informatika
                            dan Komputer (STMIK) Catur Insan Cendekia.
                            Pada tahun 2006, Akademi Perdagangan Widya Dharma resmi berganti nama menjadi Akademi
                            Perdagangan CIC.
                            Selanjutnya, pada tahun 2019, Akademi Perdagangan CIC dan STMIK CIC digabungkan menjadi satu
                            institusi pendidikan tinggi bernama Universitas Catur Insan Cendekia (UCIC).
                            Penggabungan ini disahkan melalui Surat Keputusan Menteri Riset, Teknologi, dan Pendidikan
                            Tinggi Republik Indonesia Nomor 952/KPT/I/2019 tertanggal 10 Oktober 2019.
                        </p>
                    </div>

                    <!-- Kanan: Fakultas & Tombol -->
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <p>Saat ini UCIC memiliki dua fakultas, yaitu:</p>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check2-circle text-primary"></i> Fakultas Ekonomi dan Bisnis.</li>
                            <li><i class="bi bi-check2-circle text-primary"></i> Fakultas Teknologi Informasi.</li>
                        </ul>
                        <a href="#" class="btn btn-outline-primary rounded-pill mt-3 px-4">
                            Pelajari Lebih Lanjut <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

        </section>

        <!-- /About Section -->

        <!-- Stats Section -->
        <section id="stats" class="stats section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

            </div>

        </section><!-- /Stats Section -->

        <!-- Services Section -->
        <section id="services" class="services section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <span>Services</span>
                <h2>Services</h2>
                <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <div class="icon icon-blue">
                                <i class="bi bi-activity"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Nesciunt Mete</h3>
                            </a>
                            <p>Provident nihil minus qui consequatur non omnis maiores. Eos accusantium minus dolores
                                iure perferendis tempore et consequatur.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-broadcast"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Eosle Commodi</h3>
                            </a>
                            <p>Ut autem aut autem non a. Sint sint sit facilis nam iusto sint. Libero corrupti neque eum
                                hic non ut nesciunt dolorem.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-easel"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Ledo Markt</h3>
                            </a>
                            <p>Ut excepturi voluptatem nisi sed. Quidem fuga consequatur. Minus ea aut. Vel qui id
                                voluptas adipisci eos earum corrupti.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-bounding-box-circles"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Asperiores Commodit</h3>
                            </a>
                            <p>Non et temporibus minus omnis sed dolor esse consequatur. Cupiditate sed error ea fuga
                                sit provident adipisci neque.</p>
                            <a href="service-details.html" class="stretched-link"></a>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-calendar4-week"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Velit Doloremque</h3>
                            </a>
                            <p>Cumque et suscipit saepe. Est maiores autem enim facilis ut aut ipsam corporis aut. Sed
                                animi at autem alias eius labore.</p>
                            <a href="service-details.html" class="stretched-link"></a>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-chat-square-text"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Dolori Architecto</h3>
                            </a>
                            <p>Hic molestias ea quibusdam eos. Fugiat enim doloremque aut neque non et debitis iure.
                                Corrupti recusandae ducimus enim.</p>
                            <a href="service-details.html" class="stretched-link"></a>
                        </div>
                    </div><!-- End Service Item -->

                </div>

            </div>

        </section><!-- /Services Section -->

        <!-- Testimonials Section -->
        <section id="testimonials" class="testimonials section bg-white">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <span>Testimonials</span>
                <h2>Testimonials</h2>
                <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="swiper init-swiper" data-speed="600" data-delay="5000"
                    data-breakpoints="{ &quot;320&quot;: { &quot;slidesPerView&quot;: 1, &quot;spaceBetween&quot;: 40 }, &quot;1200&quot;: { &quot;slidesPerView&quot;: 3, &quot;spaceBetween&quot;: 40 } }">
                    <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 1,
                  "spaceBetween": 40
                },
                "1200": {
                  "slidesPerView": 3,
                  "spaceBetween": 20
                }
              }
            }
          </script>
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="testimonial-item" "="">
            <p>
              <i class=" bi bi-quote quote-icon-left"></i>
                <span>Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.</span>
                <i class="bi bi-quote quote-icon-right"></i>
                </p>
                <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                <h3>Saul Goodman</h3>
                <h4>Ceo &amp; Founder</h4>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
                <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                <h3>Sara Wilsson</h3>
                <h4>Designer</h4>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
                <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                <h3>Jena Karlis</h3>
                <h4>Store Owner</h4>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
                <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
                <h3>Matt Brandon</h3>
                <h4>Freelancer</h4>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
                <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
                <h3>John Larson</h3>
                <h4>Entrepreneur</h4>
              </div>
            </div><!-- End testimonial item -->

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- /Testimonials Section -->

    <!-- Call To Action Section -->
    <section id="call-to-action" class="call-to-action section accent-background">

      <div class="container">
        <div class="row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
          <div class="col-xl-10">
            <div class="text-center">
              <h3>Call To Action</h3>
              <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
              <a class="cta-btn" href="#">Call To Action</a>
            </div>
          </div>
        </div>
      </div>

    </section><!-- /Call To Action Section -->

    <!-- Team Section -->
    <section id="team" class="team section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <span>Section Title</span>
        <h2>Team</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-5">

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="member">
              <div class="pic"><img src="assets/img/team/team-1.jpg" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>Walter White</h4>
                <span>Chief Executive Officer</span>
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="member">
              <div class="pic"><img src="assets/img/team/team-2.jpg" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>Sarah Jhonson</h4>
                <span>Product Manager</span>
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="member">
              <div class="pic"><img src="assets/img/team/team-3.jpg" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>William Anderson</h4>
                <span>CTO</span>
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

        </div>

      </div>

    </section><!-- /Team Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <span>Kontak</span>
        <h2>Kontak</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

       <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4 justify-content-center">

      <!-- Informasi Kontak -->
      <div class="col-lg-10">
        <div class="info-wrap p-4 shadow-sm bg-white rounded d-flex justify-content-between flex-wrap text-center text-md-start border border-2 border-primary" style="gap: 20px;">

          <div class="d-flex align-items-center flex-grow-1 px-2">
            <i class="bi bi-geo-alt text-primary me-3" style="font-size: 24px;"></i>
            <div>
              <h5 class="fw-bold m-0">Alamat</h5>
              <p class="m-0">Jl. Kesambi No.202, Kesambi, Cirebon City</p>
            </div>
          </div>

          <div class="d-flex align-items-center flex-grow-1 px-2">
            <i class="bi bi-telephone text-primary me-3" style="font-size: 24px;"></i>
            <div>
              <h5 class="fw-bold m-0">Kontak</h5>
              <p class="m-0">+62231-200418</p>
            </div>
          </div>

          <div class="d-flex align-items-center flex-grow-1 px-2">
            <i class="bi bi-envelope text-primary me-3" style="font-size: 24px;"></i>
            <div>
              <h5 class="fw-bold m-0">Email</h5>
              <p class="m-0">info@cic.ac.id</p>
            </div>
          </div>

        </div>
      </div>

      <!-- Google Maps -->
      <div class="col-lg-10 mt-4">
        <div class="map-container">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.2964098276!2d108.55051271028947!3d-6.733646665810743!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f1d8ebc133e3f%3A0x91385801f5822049!2sUniversitas%20Catur%20Insan%20Cendekia%20(CIC)!5e0!3m2!1sid!2sid!4v1741886221361!5m2!1sid!2sid"
            width="100%" height="350"
            style="border-radius:10px; box-shadow: 0px 4px 10px rgba(0,0,0,0.1);"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>

    </div>
  </div>

    </section>
    <!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="d-flex align-items-center">
                        <span class="sitename">Luaran UCIC</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Kampus UCIC Jalan Kesambi No. 202  </p>
                        <p>Kota Cirebon, Jawa Barat</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>+62895 1231 4188</span></p>
                        <p><strong>Email:</strong> <span>info@cic.ac.id</span></p>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">About us</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Services</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Terms of service</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Our Services</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Web Design</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Web Development</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Product Management</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Marketing</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12">
                    <h4>Follow Us</h4>
                    <p>Tetap terhubung dengan kami melalui media sosial untuk mendapatkan informasi terbaru, berita menarik, dan pembaruan seputar layanan kami.</p>
                    <div class="social-links d-flex">
                        <a href=""><i class="bi bi-twitter-x"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href="https://www.instagram.com/universitas_cic/"><i class="bi bi-instagram"></i></a>
                        <a
                            href="https://www.linkedin.com/company/universitas-catur-insan-cendekia/?originalSubdomain=id"><i
                                class="bi bi-linkedin"></i></a>
                    </div>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>2025 Universitas Catur Insan Cendekia - </span> <strong class="px-1 sitename">Sistem Manajement Luaran </strong> <span>All Rights Reserved</span>
            </p>
            {{-- <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you've purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div> --}}
        </div>

    </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('enno/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('enno/assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('enno/assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('enno/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('enno/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('enno/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('enno/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('enno/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('enno/assets/js/main.js') }}"></script>
  <script>
      window.addEventListener('scroll', function() {
          const header = document.getElementById('header');
          if (window.scrollY > 50) {
              header.classList.add('scrolled');
          } else {
              header.classList.remove('scrolled');
          }
      });
  </script>

</body>

</html>
