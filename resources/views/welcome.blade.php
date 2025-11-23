<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello, Arua</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        /* CAROUSEL STYLES */
        .carousel-wrapper {
            position: relative;
            max-width: 350px;
            margin-left: 120px; /* LEBIH KE KANAN LAGI */
        }

        .carousel-container {
            overflow: hidden;
            width: 100%;
            border-radius: 16px;
        }

        .carousel {
            display: flex;
            transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            gap: 20px;
        }

        .carousel-item {
            min-width: 220px; /* LEBIH BESAR */
            flex-shrink: 0;
        }

        .carousel-card {
            position: relative;
            width: 220px; /* LEBIH BESAR */
            height: 280px; /* LEBIH PANJANG */
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(15px);
            transition: all 0.4s ease;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }

        .carousel-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.4);
        }

        .carousel-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .carousel-card:hover img {
            transform: scale(1.08);
        }

        .carousel-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 50%);
            transition: background 0.4s ease;
        }

        .carousel-card:hover::after {
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 40%);
        }

        .carousel-card h3 {
            position: absolute;
            bottom: 20px;
            left: 20px;
            font-size: 20px;
            font-weight: bold;
            z-index: 2;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
        }

        /* Navigation buttons - kecil di bawah */
        .carousel-nav {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-top: 25px;
        }

        .carousel-btn {
            width: 36px;
            height: 36px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
            color: white;
        }

        .carousel-btn:hover {
            background: rgba(255,255,255,0.25);
            transform: scale(1.1);
        }

        .carousel-dots {
            display: flex;
            gap: 10px;
        }

        .carousel-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .carousel-dot.active {
            background: white;
            transform: scale(1.3);
        }

        .carousel-dot:hover {
            background: rgba(255,255,255,0.6);
        }
    </style>
</head>

<body class="bg-[#0B1F33] text-white">

    <!-- ========================= -->
    <!--        HERO WRAPPER       -->
    <!-- ========================= -->
    <section class="relative h-screen w-full overflow-hidden">

        <!-- Background -->
        <div class="absolute inset-0 bg-cover bg-center"
             style="background-image: url('/images/danau.jpg');"></div>

        <!-- Gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[#0B1F33]/95"></div>

        <!-- NAVBAR -->
        <nav class="backdrop-blur-md bg-white/10 border-b border-white/20 fixed top-0 left-0 w-full z-50">
            <div class="max-w-6xl mx-auto px-6 py-3 flex justify-between items-center">

                <!-- Logo -->
                <h1 class="text-white text-xl font-bold tracking-wide">
                    Hello, Arua
                </h1>

                <!-- Menu -->
                <ul class="flex gap-10 text-white font-medium absolute left-1/2 -translate-x-1/2">
                    <li><a href="/" class="hover:text-gray-300 transition">Home</a></li>
                    <li><a href="/wisata" class="hover:text-gray-300 transition">Wisata</a></li>
                    <li><a href="/about" class="hover:text-gray-300 transition">About</a></li>
                </ul>

                <div class="w-64">
            {{-- Di welcome.blade.php - cari form yang ada --}}
            <form action="/wisata/search" method="GET" class="relative">  {{-- GANTI ACTION KE SINI --}}
                <input type="text" name="q" placeholder="Cari wisata..." 
                    class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-2 text-white placeholder-gray-300 focus:outline-none focus:border-blue-400 text-sm pr-10">
                <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-300 hover:text-white transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>
            </div>
        </nav>

        <!-- TEXT + CAROUSEL WRAPPER -->
        <div class="relative z-20 px-16 pt-40 flex items-start gap-10">

            <!-- TEXT -->
            <div class="max-w-2xl">
                <h1 class="text-7xl font-extrabold drop-shadow-xl leading-[1.1]">
                    SUMATERA UTARA
                </h1>

                <p class="mt-6 text-gray-200 text-base leading-relaxed">
                    Sumatera Utara adalah salah satu provinsi yang penuh pesona, mulai dari keindahan Danau Toba, 
                    kekayaan budaya Batak, hingga beragam destinasi alam dan tradisi yang unik. 
                    Setiap sudutnya menghadirkan pengalaman memukau yang menampilkan keindahan Indonesia yang sesungguhnya.
                </p>

               <a href="/wisata"
                class="mt-8 bg-blue-600 hover:bg-blue-700 px-8 py-3 rounded-xl font-semibold flex items-center gap-3 inline-block">
             Explore →
                </a>

            </div>

            <!-- CAROUSEL SECTION -->
            <div class="carousel-wrapper">
                <div class="carousel-container">
                    <div class="carousel" id="categoryCarousel">
                        <!-- Card 1 - Alam -->
                        <div class="carousel-item">
                            <div class="carousel-card">
                                <img src="/images/kategori-alam.jpeg" alt="Alam">
                                <h3>Alam</h3>
                            </div>
                        </div>

                        <!-- Card 2 - Budaya -->
                        <div class="carousel-item">
                            <div class="carousel-card">
                                <img src="/images/kategori-budaya.jpeg" alt="Budaya">
                                <h3>Budaya</h3>
                            </div>
                        </div>

                        <!-- Card 3 - Religi -->
                        <div class="carousel-item">
                            <div class="carousel-card">
                                <img src="/images/kategori-religi.jpeg" alt="Religi">
                                <h3>Religi</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation kecil di bawah -->
                <div class="carousel-nav">
                    <button class="carousel-btn" onclick="moveCarousel(-1)">❮</button>
                    
                    <div class="carousel-dots">
                        <span class="carousel-dot active" onclick="goToSlide(0)"></span>
                        <span class="carousel-dot" onclick="goToSlide(1)"></span>
                        <span class="carousel-dot" onclick="goToSlide(2)"></span>
                    </div>
                    
                    <button class="carousel-btn" onclick="moveCarousel(1)">❯</button>
                </div>
            </div>

        </div>

    </section>
