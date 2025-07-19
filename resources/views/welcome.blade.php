<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Klinik Bidan Yulis Setiawan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }

        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%" r="50%"><stop offset="0%" style="stop-color:rgba(255,255,255,0.1)"/><stop offset="100%" style="stop-color:rgba(255,255,255,0)"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"/><circle cx="800" cy="300" r="150" fill="url(%23a)"/><circle cx="400" cy="700" r="120" fill="url(%23a)"/></svg>');
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            z-index: 1000;
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #667eea;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link:hover {
            color: #667eea;
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: #667eea;
            border: 2px solid #667eea;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 8rem 2rem 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            min-height: 100vh;
        }

        .hero-text {
            animation: slideInLeft 1s ease-out;
        }

        .hero-text h1 {
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-text h1 .highlight {
            background: linear-gradient(45deg, #ffd700, #ffed4a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-text p {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .hero-image {
            position: relative;
            animation: slideInRight 1s ease-out;
        }

        .hero-image img {
            width: 100%;
            height: 500px;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .hero-image:hover img {
            transform: scale(1.05);
        }

        .floating-card {
            position: absolute;
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: floatCard 3s ease-in-out infinite;
        }

        .card-1 {
            top: 20%;
            right: -10%;
            animation-delay: 0s;
        }

        .card-2 {
            bottom: 20%;
            left: -10%;
            animation-delay: 1s;
        }

        @keyframes floatCard {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .services-section {
            padding: 6rem 2rem;
            background: #f8fafc;
        }

        .services-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 3rem;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .service-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(45deg, #667eea, #764ba2);
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .service-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }

        .service-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }

        .service-card p {
            color: #666;
            line-height: 1.6;
        }

        .info-section {
            padding: 6rem 2rem;
            background: white;
        }

        .info-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .info-content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 2rem;
        }

        .info-list {
            list-style: none;
            margin: 2rem 0;
        }

        .info-list li {
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .hours-card {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
        }

        .hours-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .hours-list {
            list-style: none;
        }

        .hours-list li {
            padding: 0.5rem 0;
            font-size: 1.1rem;
        }

        .footer {
            background: #333;
            color: white;
            padding: 3rem 2rem 1rem;
            text-align: center;
        }

        .mobile-menu {
            display: none;
            flex-direction: column;
            position: fixed;
            top: 80px;
            left: 0;
            right: 0;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            z-index: 999;
            padding: 2rem;
            gap: 1rem;
        }

        .mobile-menu.active {
            display: flex;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 4px;
        }

        .hamburger span {
            width: 25px;
            height: 3px;
            background: #333;
            transition: 0.3s;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .hamburger {
                display: flex;
            }

            .hero-content {
                grid-template-columns: 1fr;
                gap: 2rem;
                padding: 6rem 1rem 2rem;
            }

            .hero-text h1 {
                font-size: 2.5rem;
            }

            .info-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .floating-card {
                display: none;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="#" class="logo">Klinik Bidan Yulis</a>
            <div class="nav-links">
                <a href="#home" class="nav-link">Beranda</a>
                <a href="#services" class="nav-link">Layanan</a>
                <a href="#about" class="nav-link">Tentang</a>
                <a href="#contact" class="nav-link">Kontak</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-secondary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-secondary">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
            <div class="hamburger" onclick="toggleMobileMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="mobile-menu" id="mobileMenu">
            <a href="#home" class="nav-link">Beranda</a>
            <a href="#services" class="nav-link">Layanan</a>
            <a href="#about" class="nav-link">Tentang</a>
            <a href="#contact" class="nav-link">Kontak</a>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-secondary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-secondary">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-primary">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <section class="hero-section" id="home">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Selamat Datang di<br><span class="highlight">Klinik Bidan Yulis Setiawan</span></h1>
                <p>Memberikan pelayanan kesehatan terbaik untuk ibu dan anak dengan fasilitas modern dan tenaga medis
                    berpengalaman. Kesehatan keluarga adalah prioritas utama kami.</p>

            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1559757148-5c350d0d3c56?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                    alt="Happy Mother and Child">
                <div class="floating-card card-1">
                    <div class="service-icon">👶</div>
                    <h4>Perawatan Bayi</h4>
                    <p>Profesional & Terpercaya</p>
                </div>
                <div class="floating-card card-2">
                    <div class="service-icon">🤱</div>
                    <h4>Konsultasi Ibu</h4>
                    <p>24/7 Siap Membantu</p>
                </div>
            </div>
        </div>
    </section>

    <section class="services-section" id="services">
        <div class="services-container">
            <h2 class="section-title">Layanan Unggulan Kami</h2>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">🤰</div>
                    <h3>Konsultasi Kehamilan</h3>
                    <p>Pemeriksaan rutin dan konsultasi komprehensif untuk menjaga kesehatan ibu dan bayi selama masa
                        kehamilan.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">👶</div>
                    <h3>Perawatan Bayi</h3>
                    <p>Layanan kesehatan lengkap untuk bayi mulai dari pemeriksaan rutin hingga perawatan khusus.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">💊</div>
                    <h3>Keluarga Berencana</h3>
                    <p>Konsultasi dan layanan KB yang aman dan sesuai dengan kebutuhan setiap pasangan.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">💉</div>
                    <h3>Imunisasi</h3>
                    <p>Program imunisasi lengkap untuk bayi dan anak sesuai dengan jadwal yang direkomendasikan.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">🏥</div>
                    <h3>Persalinan</h3>
                    <p>Layanan persalinan yang aman dan nyaman dengan fasilitas modern dan tenaga medis berpengalaman.
                    </p>
                </div>
                <div class="service-card">
                    <div class="service-icon">📋</div>
                    <h3>Pemeriksaan Rutin</h3>
                    <p>Pemeriksaan kesehatan berkala untuk memantau kondisi kesehatan ibu dan anak.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="info-section" id="about">
        <div class="info-container">
            <div class="info-content">
                <h2>Mengapa Memilih Kami?</h2>
                <p>Dengan pengalaman bertahun-tahun, kami berkomitmen memberikan pelayanan kesehatan terbaik untuk
                    keluarga Indonesia.</p>
                <ul class="info-list">
                    <li>
                        <div class="info-icon">✓</div>
                        <span>Tenaga medis berpengalaman dan bersertifikat</span>
                    </li>
                    <li>
                        <div class="info-icon">✓</div>
                        <span>Fasilitas modern dan peralatan canggih</span>
                    </li>
                    <li>
                        <div class="info-icon">✓</div>
                        <span>Pelayanan 24/7 untuk kasus darurat</span>
                    </li>
                    <li>
                        <div class="info-icon">✓</div>
                        <span>Lingkungan yang nyaman dan higienis</span>
                    </li>
                    <li>
                        <div class="info-icon">✓</div>
                        <span>Harga terjangkau dengan kualitas terbaik</span>
                    </li>
                </ul>
            </div>
            <div class="hours-card">
                <h3>Jam Operasional</h3>
                <ul class="hours-list">
                    <li><strong>Senin - Jumat:</strong> 08:00 - 20:00</li>
                    <li><strong>Sabtu:</strong> 08:00 - 18:00</li>
                    <li><strong>Minggu:</strong> 08:00 - 16:00</li>
                </ul>
                <p style="margin-top: 1rem; font-size: 0.9rem; opacity: 0.9;">
                    * Layanan darurat 24/7<br>
                    * Appointment tersedia online
                </p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div style="max-width: 1200px; margin: 0 auto;">
            <h3>Klinik Bidan Yulis Setiawan</h3>
            <p>Alamat: Jl. Kesehatan No. 123, Jakarta Selatan</p>
            <p>Telepon: (021) 1234-5678 | Email: info@klinikbidanyulis.com</p>
            <p style="margin-top: 2rem; opacity: 0.7;">© 2024 Klinik Bidan Yulis Setiawan. Semua hak dilindungi.</p>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('active');
        }

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
                // Close mobile menu if open
                document.getElementById('mobileMenu').classList.remove('active');
            });
        });

        // Login modal simulation
        function showLogin() {
            alert(
                'Halaman login akan segera tersedia!\n\nUntuk saat ini, silakan hubungi kami di:\nTelepon: (021) 1234-5678\nEmail: info@klinikbidanyulis.com'
                );
        }

        // Register modal simulation
        function showRegister() {
            alert(
                'Halaman pendaftaran akan segera tersedia!\n\nUntuk mendaftar sebagai pasien baru, silakan hubungi:\nTelepon: (021) 1234-5678\nEmail: info@klinikbidanyulis.com\n\nAtau datang langsung ke klinik kami.'
                );
        }

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, observerOptions);

        // Observe service cards for staggered animation
        document.addEventListener('DOMContentLoaded', function() {
            const serviceCards = document.querySelectorAll('.service-card');
            serviceCards.forEach((card, index) => {
                card.style.animation = `slideInUp 0.6s ease-out ${index * 0.1}s both`;
                card.style.animationPlayState = 'paused';
                observer.observe(card);
            });
        });

        // Add slideInUp animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);

        // Add loading animation
        window.addEventListener('load', function() {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease-in-out';
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });
    </script>
</body>

</html>
