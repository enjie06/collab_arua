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
        
        <form action="{{ route('search') }}" method="GET" class="mt-6 w-full max-w-2xl mx-auto flex">
            <div class="relative flex-grow">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></span>
                <input 
                    type="text" 
                    name="q"  
                    id="searchInput" 
                    placeholder="Find Destinations..." 
                    class="w-full pl-10 pr-4 py-3 rounded-l-3xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900 bg-white"
                    required
                    value="{{ request('q') }}"  
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

      <style>
          .stack-gallery {
              text-align: center;
              padding: 50px 0;
              position: relative;
          }

          .stack-container {
              position: relative;
              width: 400px;
              height: 260px;
              margin: auto;
          }

          .stack-img {
              width: 300px;
              height: 300px;
              object-fit: cover;
              border-radius: 15px;
              position: absolute;
              transition: 0.35s ease;
          }

          /* Wrapper untuk efek hover */
          .img-wrapper {
              position: absolute;
              width: 300px;
              height: 300px;
              border-radius: 15px;
              overflow: hidden;

              transition: 0.35s ease;
              z-index: 1;
          }

          /* Efek naik, zoom, dan jadi paling depan */
          .img-wrapper:hover {
              transform: scale(1.12) translateY(-25px) rotate(0deg);
              z-index: 15;
              box-shadow: 0 20px 40px rgba(0,0,0,0.45);
          }

        .label {
              position: absolute;
              bottom: 0;
              width: 100%;
              left: 0;

              padding: 5px;

              background: rgba(0, 0, 0, 0.45);
              border: 1px solid rgba(255,255,255,0.45);

              color: white;
              font-size: 17px;
              font-weight: 600;

              border-radius: 0;
              backdrop-filter: blur(3px);
              z-index: 20;
          }

          .img-1 {
              top: 0;
              right: 120px;
              transform: rotate(-12deg);
              z-index: 3;
          }

          .img-2 {
              top: -90px;
              left: 80px;
              transform: rotate(0deg) scale(1.05);
              z-index: 5;
          }

          .img-3 {
              top: 0;
              left: 190px;
              transform: rotate(10deg);
              z-index: 2;
          }

          .stack-text {
              margin-top: 230px;
              font-size: 26px;
              font-weight: 700;
              color: white;
          }

          .stack-btn {
              margin-top: 15px;
              background: #00AEEF;
              color: white;
              padding: 10px 25px;
              border-radius: 25px;
              font-weight: 600;
              border: none;
              cursor: pointer;
              transition: 0.25s;
          }

          .stack-btn:hover {
              background: #0284c7;
              transform: scale(1.05);
          }
      </style>

      <section class="stack-gallery">
          <div class="stack-container">

              <!-- Gambar 1 -->
              <div class="img-wrapper img-1">
                  <img src="/images/kategori-alam.jpeg" alt="Alam" class="stack-img">
                  <div class="label">Alam</div>
              </div>

              <!-- Gambar 2 -->
              <div class="img-wrapper img-2">
                  <img src="/images/kategori-religi.jpeg" alt="Religi" class="stack-img">
                  <div class="label">Religi</div>
              </div>

              <!-- Gambar 3 -->
              <div class="img-wrapper img-3">
                  <img src="/images/kategori-budaya.jpeg" alt="Budaya" class="stack-img">
                  <div class="label">Budaya</div>
              </div>

          </div>


      </section>


      </section>

      <section id="wisata-section" class="relative py-24 px-16"
          style="background-image: url('{{ asset('images/Tano_Ponggol.jpg') }}');
          
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;">
                    <div class="absolute inset-0 bg-black/50"></div>

          <h1 class="text-6xl font-bold mb-12 text-center text-white drop-shadow-lg">
              TOP 10 DESTINATIONS
         </h1>

<div class="flex gap-6 overflow-x-auto pb-8 px-6 scrollbar-hide">

    @php
    // Gabungkan semua wisata yang ada
        $allWisata = [];
        if (isset($wisataAlam) && is_array($wisataAlam)) {
            $allWisata = array_merge($allWisata, array_slice($wisataAlam, 0, 4));
        }
        if (isset($wisataBudaya) && is_array($wisataBudaya)) {
            $allWisata = array_merge($allWisata, array_slice($wisataBudaya, 0, 3));
        }
        if (isset($wisataReligi) && is_array($wisataReligi)) {
            $allWisata = array_merge($allWisata, array_slice($wisataReligi, 0, 3));
        }
    @endphp

    @if(count($allWisata) > 0)
        @foreach ($allWisata as $index => $wisata)
            <div class="relative min-w-[250px] h-[330px] rounded-3xl shadow-xl flex flex-col justify-end overflow-hidden group transition transform hover:scale-105"
                style="background: linear-gradient(135deg, #FDE68A, #FBBF24);">

                @if($wisata['gambar'])
                    <img src="{{ $wisata['gambar'] }}"
                        class="w-full h-full object-cover transition duration-500 group-hover:scale-110 rounded-3xl" 
                        alt="{{ $wisata['nama'] }}" />
                @else
                    <div class="w-full h-full bg-gradient-to-br from-emerald-400 via-teal-500 to-blue-600 flex items-center justify-center rounded-3xl">
                        <span class="text-white text-xl font-bold">{{ strtoupper($wisata['kategori'] ?? 'WISATA') }}</span>
                    </div>
                @endif

                <div class="absolute bottom-0 left-0 w-full bg-black/40 backdrop-blur-sm py-3 text-center">
                    <p class="text-white font-semibold text-lg">{{ $wisata['nama'] }}</p>
                    <p class="text-gray-200 text-sm">{{ $wisata['kota'] }}</p>
                </div>
            </div>
        @endforeach
    @else
    <div class="text-center py-12">
        <div class="bg-white/10 rounded-2xl p-8">
            <i class="fas fa-map-marked-alt text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-white mb-2">Data Wisata Sedang Dimuat</h3>
            <p class="text-gray-300">Top destinations akan segera tampil...</p>
        </div>
    </div>
    @endif

</div>
</section>


<!-- MODAL UNTUK SEMUA WISATA -->
@foreach($allWisata as $index => $wisata)
<div id="modal-wisata-{{ $index }}" class="fixed inset-0 bg-black/90 backdrop-blur-md z-50 hidden items-center justify-center p-4">
    <div class="glass-card rounded-3xl max-w-5xl w-full max-h-[90vh] overflow-y-auto border border-white/20">
        <div class="sticky top-0 glass-card border-b border-white/10 p-6 flex justify-between items-center">
            <h2 class="text-4xl font-black text-white">{{ $wisata['nama'] }}</h2>
            <button onclick="closeModal('modal-wisata-{{ $index }}')" class="w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition">
                <span class="text-xl">×</span>
            </button>
        </div>
        <div class="p-8">
            @if($wisata['gambar'])
            <div class="w-full h-96 bg-cover bg-center rounded-2xl mb-8" style="background-image: url('{{ $wisata['gambar'] }}')"></div>
            @else
            <div class="w-full h-96 bg-gradient-to-br from-emerald-400 via-teal-500 to-blue-600 rounded-2xl flex items-center justify-center mb-8">
                <span class="text-white text-4xl font-bold">{{ strtoupper($wisata['kategori'] ?? 'WISATA') }}</span>
            </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white/10 rounded-xl p-4">
                    <h3 class="text-white font-bold mb-2">Jenis Wisata</h3>
                    <p class="text-gray-300">{{ $wisata['jenisWisata'] ?? 'Wisata' }}</p>
                </div>
                <div class="bg-white/10 rounded-xl p-4">
                    <h3 class="text-white font-bold mb-2">Kategori</h3>
                    <p class="text-gray-300">{{ $wisata['kategori'] ?? '-' }}</p>
                </div>
                <div class="bg-white/10 rounded-xl p-4">
                    <h3 class="text-white font-bold mb-2">Harga Tiket</h3>
                    <p class="text-gray-300">{{ $wisata['harga_tiket'] ?? 'Gratis' }}</p>
                </div>
                <div class="bg-white/10 rounded-xl p-4">
                    <h3 class="text-white font-bold mb-2">Jam Operasional</h3>
                    <p class="text-gray-300">
                        {{ $wisata['jam_buka'] ?? 'Tidak tersedia' }}
                        @if(isset($wisata['jam_tutup']) && $wisata['jam_tutup'] && $wisata['jam_tutup'] != '-')
                        - {{ $wisata['jam_tutup'] }}
                        @endif
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="bg-white/10 rounded-xl p-6">
                    <h3 class="text-white font-bold mb-4 text-xl">Informasi Lokasi</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-300">Alamat:</span>
                            <span class="text-white font-medium">{{ $wisata['alamat'] ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Kabupaten:</span>
                            <span class="text-white font-medium">{{ $wisata['kota'] ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Provinsi:</span>
                            <span class="text-white font-medium">{{ $wisata['provinsi'] ?? '-' }}</span>
                        </div>
                        @if(isset($wisata['latitude']) && isset($wisata['longitude']) && $wisata['latitude'] && $wisata['longitude'])
                        <div class="flex justify-between">
                            <span class="text-gray-300">Koordinat:</span>
                            <span class="text-white font-medium">{{ $wisata['latitude'] }}° N, {{ $wisata['longitude'] }}° E</span>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white/10 rounded-xl p-6">
                    <h3 class="text-white font-bold mb-4 text-xl">Fasilitas & Aktivitas</h3>
                    <div class="space-y-3">
                        @if(isset($wisata['fasilitas']) && $wisata['fasilitas'])
                        <div>
                            <span class="text-gray-300">Fasilitas:</span>
                            <p class="text-white font-medium">{{ $wisata['fasilitas'] }}</p>
                        </div>
                        @endif
                        
                        @if(isset($wisata['aktivitas']) && $wisata['aktivitas'])
                        <div>
                            <span class="text-gray-300">Aktivitas:</span>
                            <p class="text-white font-medium">{{ $wisata['aktivitas'] }}</p>
                        </div>
                        @endif
                        
                        @if(isset($wisata['dekat_dengan']) && $wisata['dekat_dengan'])
                        <div>
                            <span class="text-gray-300">Dekat Dengan:</span>
                            <p class="text-white font-medium">{{ $wisata['dekat_dengan'] }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white/10 rounded-xl p-6">
                <h3 class="text-white font-bold mb-4 text-xl">Deskripsi</h3>
                <p class="text-gray-300 text-lg leading-relaxed">
                    {{ $wisata['nama'] }} adalah salah satu destinasi wisata {{ $wisata['jenisWisata'] ?? 'terbaik' }} di Sumatera Utara. 
                    Menawarkan pengalaman wisata yang tak terlupakan dengan pemandangan yang menakjubkan 
                    dan berbagai aktivitas menarik untuk dinikmati oleh pengunjung.
                </p>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- JavaScript untuk Modal -->
<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }

    // ESC key close
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="modal-wisata-"]').forEach(modal => {
                closeModal(modal.id);
            });
        }
    });

    // Close modal when clicking outside
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('fixed') && e.target.id.startsWith('modal-wisata-')) {
            closeModal(e.target.id);
        }
    });
</script>
      <style>
      .scrollbar-hide::-webkit-scrollbar {
          display: none;
      }
      .scrollbar-hide {
          -ms-overflow-style: none;
          scrollbar-width: none;
      }
      </style>


      <style>
      .scrollbar-hide::-webkit-scrollbar {
          display: none;
      }
      .scrollbar-hide {
          -ms-overflow-style: none;
          scrollbar-width: none;
      }
      </style>


     <style>
/* Warna card: biru gelap elegan */
.card-blue {
    background: rgba(10, 25, 47, 0.75);     /* navy + transparan */
    border: 1px solid rgba(255,255,255,0.15);
    backdrop-filter: blur(8px);
}

/* Hover biar lebih pop */
.card-blue:hover {
    transform: scale(1.06);
    border-color: rgba(255,255,255,0.3);
}
</style>

<section class="relative px-6 py-20 bg-cover bg-center"
         style="background-image: url('{{ asset('images/Sibayak.jpg') }}');">
             <div class="absolute inset-0 bg-black/50"></div>

    <div class="text-center mb-12">
        <h1 class="text-6xl md:text-10xl font-bold text-white drop-shadow-lg">
            What They Say?
        </h1>

        <h1 class="text-gray-200 mt-10 max-w-10xl mx-auto text-2xl font-bold text-white drop-shadow-lg">
    Kata mereka para wisatawan yang telah menjelajahi keindahan Sumatera Utara
</h1>

    </div>

    <!-- Carousel -->
    <div class="overflow-x-auto scroll-smooth scrollbar-hide py-4">
        <div class="flex gap-6 w-max px-6">
        <!-- Card 1 -->

<div class="min-w-[280px] max-w-[300px] p-4 rounded-3xl shadow-xl card-blue transition duration-300">
    <p class="text-gray-200 mb-4 text-sm">
        “Pengalaman yang sangat menyenangkan! Alamnya indah dan penduduknya ramah.”
    </p>
    <div class="flex items-center gap-3 mt-2 p-2 rounded-xl border border-white/20 bg-white/5">
        <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=cartoon1"
            class="w-10 h-10 rounded-full border border-white/20 p-[1px]" />
        <div class="text-left">
            <h4 class="font-semibold text-white text-sm">Rani Putri</h4>
            <p class="text-gray-400 text-xs">Traveler</p>
        </div>
    </div>
</div>

<!-- Card 2 -->
<div class="min-w-[280px] max-w-[300px] p-4 rounded-3xl shadow-xl card-blue transition duration-300">
    <p class="text-gray-200 mb-4 text-sm">
        “Website ini membantu banget buat nyari wisata yang cocok tanpa ribet.”
    </p>
    <div class="flex items-center gap-3 mt-2 p-2 rounded-xl border border-white/20 bg-white/5">
        <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=cartoon2"
            class="w-10 h-10 rounded-full border border-white/20 p-[1px]" />
        <div class="text-left">
            <h4 class="font-semibold text-white text-sm">Budi Santoso</h4>
            <p class="text-gray-400 text-xs">Pengunjung</p>
        </div>
    </div>
</div>

<!-- Card 3 -->
<div class="min-w-[280px] max-w-[300px] p-4 rounded-3xl shadow-xl card-blue transition duration-300">
    <p class="text-gray-200 mb-4 text-sm">
        “Pilihan destinasinya lengkap dan informatif. Sangat direkomendasikan!”
    </p>
    <div class="flex items-center gap-3 mt-2 p-2 rounded-xl border border-white/20 bg-white/5">
        <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=cartoon3"
            class="w-10 h-10 rounded-full border border-white/20 p-[1px]" />
        <div class="text-left">
            <h4 class="font-semibold text-white text-sm">Siska Marbun</h4>
            <p class="text-gray-400 text-xs">Mahasiswa</p>
        </div>
    </div>
</div>

<!-- Card 4 -->
<div class="min-w-[280px] max-w-[300px] p-4 rounded-3xl shadow-xl card-blue transition duration-300">
    <p class="text-gray-200 mb-4 text-sm">
        “Navigasinya mudah dipahami dan tampilannya keren banget!”
    </p>
    <div class="flex items-center gap-3 mt-2 p-2 rounded-xl border border-white/20 bg-white/5">
        <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=cartoon4"
            class="w-10 h-10 rounded-full border border-white/20 p-[1px]" />
        <div class="text-left">
            <h4 class="font-semibold text-white text-sm">Rio Pratama</h4>
            <p class="text-gray-400 text-xs">Pekerja Kantoran</p>
        </div>
    </div>
</div>

<!-- Card 5 -->
<div class="min-w-[280px] max-w-[300px] p-4 rounded-3xl shadow-xl card-blue transition duration-300">
    <p class="text-gray-200 mb-4 text-sm">
        “Informasinya lengkap banget, sampai kuliner pun dibahas!”
    </p>
    <div class="flex items-center gap-3 mt-2 p-2 rounded-xl border border-white/20 bg-white/5">
        <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=cartoon5"
            class="w-10 h-10 rounded-full border border-white/20 p-[1px]" />
        <div class="text-left">
            <h4 class="font-semibold text-white text-sm">Anita Sihombing</h4>
            <p class="text-gray-400 text-xs">Food Lover</p>
        </div>
    </div>
</div>

<!-- Card 6 -->
<div class="min-w-[280px] max-w-[300px] p-4 rounded-3xl shadow-xl card-blue transition duration-300">
    <p class="text-gray-200 mb-4 text-sm">
        “Sangat membantu buat planning liburan bareng keluarga.”
    </p>
    <div class="flex items-center gap-3 mt-2 p-2 rounded-xl border border-white/20 bg-white/5">
        <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=cartoon6"
            class="w-10 h-10 rounded-full border border-white/20 p-[1px]" />
        <div class="text-left">
            <h4 class="font-semibold text-white text-sm">Dedi Hartono</h4>
            <p class="text-gray-400 text-xs">Ayah 2 Anak</p>
        </div>
    </div>
</div>

<!-- Card 7 -->
<div class="min-w-[280px] max-w-[300px] p-4 rounded-3xl shadow-xl card-blue transition duration-300">
    <p class="text-gray-200 mb-4 text-sm">
        “Baru tau banyak hidden gem di Sumut setelah buka web ini!”
    </p>
    <div class="flex items-center gap-3 mt-2 p-2 rounded-xl border border-white/20 bg-white/5">
        <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=cartoon7"
            class="w-10 h-10 rounded-full border border-white/20 p-[1px]" />
        <div class="text-left">
            <h4 class="font-semibold text-white text-sm">Maya Putong</h4>
            <p class="text-gray-400 text-xs">Content Creator</p>
        </div>
    </div>
</div>

<!-- Card 8 -->
<div class="min-w-[280px] max-w-[300px] p-4 rounded-3xl shadow-xl card-blue transition duration-300">
    <p class="text-gray-200 mb-4 text-sm">
        “Loading cepat dan responsif banget. Enak dipake di HP.”
    </p>
    <div class="flex items-center gap-3 mt-2 p-2 rounded-xl border border-white/20 bg-white/5">
        <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=cartoon8"
            class="w-10 h-10 rounded-full border border-white/20 p-[1px]" />
        <div class="text-left">
            <h4 class="font-semibold text-white text-sm">Danu Saputra</h4>
            <p class="text-gray-400 text-xs">IT Support</p>
        </div>
    </div>
</div>

<!-- Card 9 -->
<div class="min-w-[280px] max-w-[300px] p-4 rounded-3xl shadow-xl card-blue transition duration-300">
    <p class="text-gray-200 mb-4 text-sm">
        “Akhirnya ada web wisata Sumut yang estetik & lengkap! Love it.”
    </p>
    <div class="flex items-center gap-3 mt-2 p-2 rounded-xl border border-white/20 bg-white/5">
        <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=cartoon9"
            class="w-10 h-10 rounded-full border border-white/20 p-[1px]" />
        <div class="text-left">
            <h4 class="font-semibold text-white text-sm">Cika Br Ginting</h4>
            <p class="text-gray-400 text-xs">Mahasiswi</p>
        </div>
    </div>
</div>

<!-- Card 10 -->
<div class="min-w-[280px] max-w-[300px] p-4 rounded-3xl shadow-xl card-blue transition duration-300">
    <p class="text-gray-200 mb-4 text-sm">
        “Suka banget animasi hover-nya, smooth dan modern!”
    </p>
    <div class="flex items-center gap-3 mt-2 p-2 rounded-xl border border-white/20 bg-white/5">
        <img src="https://api.dicebear.com/6.x/avataaars/svg?seed=cartoon10"
            class="w-10 h-10 rounded-full border border-white/20 p-[1px]" />
        <div class="text-left">
            <h4 class="font-semibold text-white text-sm">Felix Wijaya</h4>
            <p class="text-gray-400 text-xs">UI/UX Enthusiast</p>
            </section>
        </div>
    </div>
</div>




<!-- Bottom CTA Banner -->
<section class="relative w-full bg-cover bg-center overflow-hidden"
         style="
            height: 380px; 
            margin: 0 !important; 
            padding: 0 !important;
            background-image:
                linear-gradient(rgba(0,0,0,0.60), rgba(0,0,0,0.75)),
                url('{{ asset('images/Batu_Hoda.jpg') }}');
        ">

    <!-- Overlay Pattern -->
    <div class="absolute inset-0 opacity-10"
         style="background-image: repeating-linear-gradient(45deg,
            rgba(102, 126, 234, 0.1) 0px,
            rgba(102, 126, 234, 0.1) 10px,
            transparent 10px,
            transparent 20px);">
    </div>

    <!-- Content -->
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-0 py-0">
        <h2 class="text-4xl md:text-5xl font-black text-white drop-shadow-lg m-0 p-0">
            Ready to Explore North Sumatera?
        </h2>

        <a href="{{ route('wisata') }}"
           class="inline-block mt-8 px-8 py-4 bg-lime-400 hover:bg-lime-500 text-gray-900 font-black text-lg md:text-xl uppercase tracking-wide rounded-full transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl shadow-lg">
            Start Exploring →
        </a>
    </div>
<section class="relative w-full bg-cover bg-center overflow-hidden m-0 p-0">

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