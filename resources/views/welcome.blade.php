@extends('layouts.main')
@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hello, Arua</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* CAROUSEL STYLES */
        /* NAVBAR ACTIVE + HOVER */

        .nav-link {
    padding: 8px 18px;
    border-radius: 10px;
    background: #1e3a8a; /* biru */
    color: #dbeafe;
    transition: all 0.25s ease;
    border: 2px solid transparent;
    font-weight: 600;
}

/* Hover effect */
.nav-link:hover {
    background: #3b82f6;
    color: white;
    transform: scale(1.07);
}

/* Active page style */
.nav-link.active {
    background: #3b82f6 !important;
    color: white;
    border-color: white;
    transform: scale(1.15); /* Zoom saat aktif */
    font-weight: 700;
}

.nav-link {
    padding: 8px 18px;
    border-radius: 10px;
    background: #1e3a8a;
    color: #dbeafe;
    transition: all 0.25s ease;
    border: 2px solid transparent;
    font-weight: 600;
}

.nav-link:hover {
    background: #3b82f6;
    color: white;
    transform: scale(1.07);
}

.nav-link.active {
    background: #3b82f6 !important;
    color: white;
    border-color: white;
    transform: scale(1.15);
    font-weight: 700;
}

        .carousel-wrapper {
            position: relative;
            max-width: 350px;
            margin-left: 120px;
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
            min-width: 220px;
            flex-shrink: 0;
        }

        .carousel-card {
            position: relative;
            width: 220px;
            height: 280px;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            transition: all 0.4s ease;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .carousel-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
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
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, transparent 50%);
            transition: background 0.4s ease;
        }

        .carousel-card:hover::after {
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, transparent 40%);
        }

        .carousel-card h3 {
            position: absolute;
            bottom: 20px;
            left: 20px;
            font-size: 20px;
            font-weight: bold;
            z-index: 2;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        }

        .carousel-card h3 {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            height: 55px;
            background: rgba(0, 0, 0, 0.70);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            font-weight: 600;
            color: white;
            border-bottom-left-radius: 16px;
            border-bottom-right-radius: 16px;
            z-index: 3;
        }

        /* Navigation buttons */
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
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
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
            background: rgba(255, 255, 255, 0.25);
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
            background: rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .carousel-dot.active {
            background: white;
            transform: scale(1.3);
        }

        .carousel-dot:hover {
            background: rgba(255, 255, 255, 0.6);
        }
    </style>
</head>

<body class="bg-[#0B1F33] text-white">
    <!-- HERO SECTION -->
    <section class="relative h-screen w-full overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('/images/danau.jpg');"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[#0B1F33]/95"></div>

        <!-- NAVBAR -->

        <!-- CONTENT WRAPPER -->
        <div class="relative z-20 px-16 pt-40 flex items-start gap-10">
            <!-- WRAPPER DESKRIPSI + SEARCH -->
       
        <!-- Deskripsi -->
        <div class="max-w-2xl">
        <h1 class="text-7xl font-extrabold drop-shadow-xl leading-[1.1]">SUMATERA UTARA</h1>
        <p class="text-gray-200 text-base leading-relaxed text-justify">
            Sumatera Utara adalah provinsi yang penuh pesona, memadukan keindahan alam, kekayaan budaya, dan tradisi yang begitu khas. 
            Setiap sudutnya menyuguhkan pengalaman yang memukau, mulai dari panorama yang menenangkan hingga keramahtamahan masyarakatnya. 
            Keunikan inilah yang menjadikan Sumatera Utara sebagai salah satu wajah Indonesia yang paling memikat untuk dijelajahi.
        </p>

        <!-- SEARCH BAR -->
        
      <form id="searchForm" class="mt-6 w-full max-w-2xl mx-auto flex">
  <div class="relative flex-grow">
    <!-- Ikon kaca pembesar -->
    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">🔍</span>
    <input 
      type="text" 
      id="searchInput" 
      placeholder="Find Destinations..." 
      class="w-full pl-10 pr-4 py-3 rounded-l-3xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900 bg-white"
      required
    />
  </div>
  <button 
    type="submit" 
    class="bg-blue-700 hover:bg-blue-800 text-white px-6 rounded-r-3xl font-semibold transition-all">
    GO!
  </button>
</form>


        <script>
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const query = document.getElementById('searchInput').value.toLowerCase();

            const wisataSection = document.getElementById('wisata-section');
            if (wisataSection) {
            wisataSection.scrollIntoView({ behavior: 'smooth' });
            }

            console.log("Mencari: ", query);
        });
        </script>
</div>

            
            <!-- CAROUSEL SECTION -->
            <div class="carousel-wrapper">
                <div class="carousel-container">
                    <div class="carousel" id="categoryCarousel">
                        <div class="carousel-item">
                            <div class="carousel-card">
                                <img src="/images/kategori-alam.jpeg" alt="Alam" />
                                <h3 class="carousel-label">Alam</h3>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <div class="carousel-card">
                                <img src="/images/kategori-budaya.jpeg" alt="Budaya" />
                                <h3 class="carousel-label">Budaya</h3>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <div class="carousel-card">
                                <img src="/images/kategori-religi.jpeg" alt="Religi" />
                                <h3 class="carousel-label">Religi</h3>
                            </div>
                        </div>
                    </div>
                </div>

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

<section id="wisata-section" class="relative py-24 px-16" 
    style="background-image: url('{{ asset('images/wpp2.jpeg') }}'); 
           background-size: cover; 
           background-position: center; 
           background-repeat: no-repeat;">

  <!-- Bingkai tengah -->
  <div class="mx-auto rounded-3xl border-4 border-white/30 shadow-xl max-w-[1200px]" 
       style="background: linear-gradient(135deg, #0B3D91, #0F7C59, #145C4A);">
    
    <h1 class="text-4xl font-bold mb-12 text-center text-white pt-8">TOP 10 DESTINATIONS</h1>

    <div class="flex gap-6 overflow-x-auto pb-8 px-6 scrollbar-hide">
        @php
            $wisataList = [
                ['img' => 'wisata1.jpg', 'nama' => 'Danau Toba'],
                ['img' => 'wisata2.jpg', 'nama' => 'Pulau Samosir'],
                ['img' => 'wisata3.jpg', 'nama' => 'Air Terjun Sipiso-piso'],
                ['img' => 'wisata4.jpg', 'nama' => 'Bukit Lawang'],
                ['img' => 'wisata5.jpg', 'nama' => 'Gunung Sibayak'],
                ['img' => 'wisata1.jpg', 'nama' => 'Taman Nasional Gunung Leuser'],
                ['img' => 'wisata2.jpg', 'nama' => 'Menara Pandang Tele'],
                ['img' => 'wisata3.jpg', 'nama' => 'Bukit Holbung'],
                ['img' => 'wisata4.jpg', 'nama' => 'Kawah Sipoholon'],
                ['img' => 'wisata5.jpg', 'nama' => 'Museum Batak'],

            ];
        @endphp

        @foreach ($wisataList as $w)
            <a href="/wisata?page={{ $loop->iteration }}"
               class="relative min-w-[250px] h-[330px] rounded-3xl shadow-xl flex flex-col justify-end overflow-hidden group transition transform hover:scale-105"
               style="background: linear-gradient(135deg, #FDE68A, #FBBF24);">
               
                <img src="/images/{{ $w['img'] }}"
                     class="w-full h-full object-cover transition duration-500 group-hover:scale-110 rounded-3xl" />

                <!-- TEXT -->
                <div class="absolute bottom-0 left-0 w-full bg-black/30 backdrop-blur-sm py-3 text-center">
                    <p class="text-white font-semibold text-lg">{{ $w['nama'] }}</p>
                </div>
            </a>
        @endforeach
    </div>
  </div>
</section>

<style>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>


<section class="relative py- px-6">
    
  <!-- Bingkai tengah -->
  <div class="mx-auto rounded-3xl border-4 border-white/30 shadow-xl max-w-[1000px] mt-12" 
       style="background: linear-gradient(135deg, #85c3e7ff, #7ceb9fff, #FFFFFF);">
    
    <div class="max-w-6xl mx-auto text-center py-8">
      <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">What They Say?</h2>
      
      <h2 class="text-gray-700 max-w-2xl mx-auto mb-12"> <b> Kata mereka para wisatawan yang telah menjelajahi keindahan Sumatera Utara</b>
       
</h2>

      <!-- Carousel Testimoni -->
      <div class="overflow-x-auto scroll-smooth scrollbar-hide py-4">
        <div class="flex gap-6 w-max px-6">

      <!-- Card 1 -->
      <div class="min-w-[280px] max-w-[300px] p-4 rounded-3xl shadow-xl flex flex-col justify-between transition transform hover:scale-105"
           style="background: linear-gradient(135deg, #FDE68A, #FBBF24); border: 2px solid #F59E0B;">
        <p class="text-gray-800 mb-4 text-sm">
          “Pengalaman yang sangat menyenangkan! Alamnya indah dan penduduknya ramah.”
        </p>
        <div class="flex items-center gap-3 mt-2 p-2 rounded-xl border-2 border-white/50 bg-white/20">
          <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=cartoon1" 
               class="w-10 h-10 rounded-full border-2 border-white p-[1px]" />
          <div class="text-left">
            <h4 class="font-semibold text-gray-800 text-sm">Rani Putri</h4>
            <p class="text-gray-700 text-xs">Traveler</p>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="min-w-[280px] max-w-[300px] p-4 rounded-3xl shadow-xl flex flex-col justify-between transition transform hover:scale-105"
           style="background: linear-gradient(135deg, #A5F3FC, #0EA5E9); border: 2px solid #0284C7;">
        <p class="text-gray-800 mb-4 text-sm">
          “Website ini membantu banget buat nyari wisata yang cocok tanpa ribet.”
        </p>
        <div class="flex items-center gap-3 mt-2 p-2 rounded-xl border-2 border-white/50 bg-white/20">
          <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=cartoon2" 
               class="w-10 h-10 rounded-full border-2 border-white p-[1px]" />
          <div class="text-left">
            <h4 class="font-semibold text-gray-800 text-sm">Budi Santoso</h4>
            <p class="text-gray-700 text-xs">Pengunjung</p>
          </div>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="min-w-[280px] max-w-[300px] p-4 rounded-3xl shadow-xl flex flex-col justify-between transition transform hover:scale-105"
           style="background: linear-gradient(135deg, #FBCFE8, #EC4899); border: 2px solid #DB2777;">
        <p class="text-gray-800 mb-4 text-sm">
          “Pilihan destinasinya lengkap dan informatif. Sangat direkomendasikan!”
        </p>
        <div class="flex items-center gap-3 mt-2 p-2 rounded-xl border-2 border-white/50 bg-white/20">
          <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=cartoon3" 
               class="w-10 h-10 rounded-full border-2 border-white p-[1px]" />
          <div class="text-left">
            <h4 class="font-semibold text-gray-800 text-sm">Siska Marbun</h4>
            <p class="text-gray-700 text-xs">Mahasiswa</p>
          </div>
        </div>
      </div>

      <!-- Card 4 -->
      <div class="min-w-[280px] max-w-[300px] p-4 rounded-3xl shadow-xl flex flex-col justify-between transition transform hover:scale-105"
           style="background: linear-gradient(135deg, #D9F99D, #84CC16); border: 2px solid #4D7C0F;">
        <p class="text-gray-800 mb-4 text-sm">
          “Destinasi menarik dan staf sangat membantu, pasti balik lagi!”
        </p>
        <div class="flex items-center gap-3 mt-2 p-2 rounded-xl border-2 border-white/50 bg-white/20">
          <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=cartoon4" 
               class="w-10 h-10 rounded-full border-2 border-white p-[1px]" />
          <div class="text-left">
            <h4 class="font-semibold text-gray-800 text-sm">Andi Wijaya</h4>
            <p class="text-gray-700 text-xs">Traveler</p>
          </div>
        </div>
      </div>

      <!-- Card 5 -->
      <div class="min-w-[280px] max-w-[300px] p-4 rounded-3xl shadow-xl flex flex-col justify-between transition transform hover:scale-105"
           style="background: linear-gradient(135deg, #FECACA, #EF4444); border: 2px solid #B91C1C;">
        <p class="text-gray-800 mb-4 text-sm">
          “Informasi lengkap dan website mudah digunakan, love it!”
        </p>
        <div class="flex items-center gap-3 mt-2 p-2 rounded-xl border-2 border-white/50 bg-white/20">
          <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=cartoon5" 
               class="w-10 h-10 rounded-full border-2 border-white p-[1px]" />
          <div class="text-left">
            <h4 class="font-semibold text-gray-800 text-sm">Citra Dewi</h4>
            <p class="text-gray-700 text-xs">Pengunjung</p>
          </div>
        </div>
      </div>

      <!-- Card 6 -->
      <div class="min-w-[280px] max-w-[300px] p-4 rounded-3xl shadow-xl flex flex-col justify-between transition transform hover:scale-105"
           style="background: linear-gradient(135deg, #E0E7FF, #6366F1); border: 2px solid #4338CA;">
        <p class="text-gray-800 mb-4 text-sm">
          “Sangat puas dengan pilihan wisata yang tersedia di sini.”
        </p>
        <div class="flex items-center gap-3 mt-2 p-2 rounded-xl border-2 border-white/50 bg-white/20">
          <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=cartoon6" 
               class="w-10 h-10 rounded-full border-2 border-white p-[1px]" />
          <div class="text-left">
            <h4 class="font-semibold text-gray-800 text-sm">Dewi Anggraini</h4>
            <p class="text-gray-700 text-xs">Mahasiswa</p>
          </div>
        </div>
      </div>

      <!-- Card 7 -->
      <div class="min-w-[280px] max-w-[300px] p-4 rounded-3xl shadow-xl flex flex-col justify-between transition transform hover:scale-105"
           style="background: linear-gradient(135deg, #FEF9C3, #FACC15); border: 2px solid #A16207;">
        <p class="text-gray-800 mb-4 text-sm">
          “Website ini bikin rencana liburan jadi gampang dan cepat.”
        </p>
        <div class="flex items-center gap-3 mt-2 p-2 rounded-xl border-2 border-white/50 bg-white/20">
          <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=cartoon7" 
               class="w-10 h-10 rounded-full border-2 border-white p-[1px]" />
          <div class="text-left">
            <h4 class="font-semibold text-gray-800 text-sm">Fajar Pratama</h4>
            <p class="text-gray-700 text-xs">Traveler</p>
          </div>
        </div>
      </div>

      <!-- Card 8 -->
      <div class="min-w-[280px] max-w-[300px] p-4 rounded-3xl shadow-xl flex flex-col justify-between transition transform hover:scale-105"
           style="background: linear-gradient(135deg, #FBCFE8, #DB2777); border: 2px solid #BE185D;">
        <p class="text-gray-800 mb-4 text-sm">
          “Pelayanan ramah, destinasi keren, pasti rekomendasi ke teman-teman.”
        </p>
        <div class="flex items-center gap-3 mt-2 p-2 rounded-xl border-2 border-white/50 bg-white/20">
          <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=cartoon8" 
               class="w-10 h-10 rounded-full border-2 border-white p-[1px]" />
          <div class="text-left">
            <h4 class="font-semibold text-gray-800 text-sm">Gita Lestari</h4>
            <p class="text-gray-700 text-xs">Pengunjung</p>
          </div>
        </div>
      </div>

      <!-- Card 9 -->
      <div class="min-w-[280px] max-w-[300px] p-4 rounded-3xl shadow-xl flex flex-col justify-between transition transform hover:scale-105"
           style="background: linear-gradient(135deg, #C7D2FE, #4338CA); border: 2px solid #3730A3;">
        <p class="text-gray-800 mb-4 text-sm">
          “Website ini bikin perjalanan kami jadi lebih seru dan mudah.”
        </p>
        <div class="flex items-center gap-3 mt-2 p-2 rounded-xl border-2 border-white/50 bg-white/20">
          <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=cartoon9" 
               class="w-10 h-10 rounded-full border-2 border-white p-[1px]" />
          <div class="text-left">
            <h4 class="font-semibold text-gray-800 text-sm">Hadi Susanto</h4>
            <p class="text-gray-700 text-xs">Traveler</p>
          </div>
        </div>
      </div>

      <!-- Card 10 -->
      <div class="min-w-[280px] max-w-[300px] p-4 rounded-3xl shadow-xl flex flex-col justify-between transition transform hover:scale-105"
           style="background: linear-gradient(135deg, #FDE68A, #F59E0B); border: 2px solid #B45309;">
        <p class="text-gray-800 mb-4 text-sm">
          “Destinasi recommended banget! Website jelas dan mudah dipakai.”
        </p>
        <div class="flex items-center gap-3 mt-2 p-2 rounded-xl border-2 border-white/50 bg-white/20">
          <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=cartoon10" 
               class="w-10 h-10 rounded-full border-2 border-white p-[1px]" />
          <div class="text-left">
            <h4 class="font-semibold text-gray-800 text-sm">Intan Permata</h4>
            <p class="text-gray-700 text-xs">Mahasiswa</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Bottom CTA Banner -->
<section class="relative h-80 bg-cover bg-center overflow-hidden mt-12" 
         style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)), url('{{ asset('images/danau.jpg') }}');">
    <!-- Overlay Pattern -->
    <div class="absolute inset-0 opacity-10" 
         style="background-image: repeating-linear-gradient(45deg, rgba(102, 126, 234, 0.1) 0px, rgba(102, 126, 234, 0.1) 10px, transparent 10px, transparent 20px);">
    </div>
    
    <!-- Content -->
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
        <h2 class="text-4xl md:text-5xl font-black text-white mb-8 drop-shadow-lg">
            Mulai menjelajahi Sumatera Utara?
        </h2>
        <a href="/" 
           class="inline-block px-8 py-4 bg-lime-400 hover:bg-lime-500 text-gray-900 font-black text-lg md:text-xl uppercase tracking-wide rounded-full transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl shadow-lg">
            Start Exploring →
        </a>
    </div>
</section>


<style>
  /* Hide scrollbar */
  .scrollbar-hide::-webkit-scrollbar {
    display: none;
  }
  .scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
  }
</style>


<style>
  /* Hide scrollbar */
  .scrollbar-hide::-webkit-scrollbar {
    display: none;
  }
  .scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
  }
</style>

<style>
  /* Hide scrollbar */
  .scrollbar-hide::-webkit-scrollbar {
    display: none;
  }
  .scrollbar-hide {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
  }
</style>

<style>
  /* Hide scrollbar */
  .scrollbar-hide::-webkit-scrollbar {
    display: none;
  }
  .scrollbar-hide {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
  }
</style>


<!-- Tambahkan CSS jika perlu -->
<style>
  /* Hide scrollbar */
  .scrollbar-hide::-webkit-scrollbar {
    display: none;
  }
  .scrollbar-hide {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
  }
</style>

<style>
    /* Hilangin scrollbar biar bersih */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

    <script>
        let currentSlide = 0;
        const totalSlides = 3;
        const carousel = document.getElementById("categoryCarousel");
        const dots = document.querySelectorAll(".carousel-dot");

        function updateCarousel() {
            const slideWidth = document.querySelector(".carousel-item").offsetWidth + 20;
            carousel.style.transform = translateX(-${currentSlide * slideWidth}px);

            dots.forEach((dot, i) => dot.classList.toggle("active", i === currentSlide));
        }

        function moveCarousel(dir) {
            currentSlide += dir;

            if (currentSlide < 0) currentSlide = totalSlides - 1;
            else if (currentSlide >= totalSlides) currentSlide = 0;

            updateCarousel();
        }

        function goToSlide(i) {
            currentSlide = i;
            updateCarousel();
        }

        // Touch swipe
        let startX = 0;

        carousel.addEventListener("touchstart", (e) => {
            startX = e.touches[0].clientX;
        });

        carousel.addEventListener("touchend", (e) => {
            const diff = startX - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 30) moveCarousel(diff > 0 ? 1 : -1);
        });

        updateCarousel();
    </script>
</body>
</html>