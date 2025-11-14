<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello, Arua</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
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
        <nav class="absolute top-0 w-full z-20 flex justify-between items-center px-16 py-8 text-gray-200">

            <!-- Logo -->
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-orange-400 rounded-full"></div>
                <span class="text-xl font-semibold">Hello, Arua</span>
            </div>

            <!-- Menu -->
            <ul class="flex gap-12 text-sm">
                <li><a href="#" class="hover:text-white">Home</a></li>
                <li><a href="#" class="hover:text-white">Destinations</a></li>
                <li><a href="#" class="hover:text-white">Blog</a></li>
                <li><a href="#" class="hover:text-white">Contact</a></li>
            </ul>

            <!-- User -->
            <div class="text-sm">Welcome!</div>
        </nav>

        <!-- LEFT VERTICAL ICON + LINE -->
        <div class="absolute left-10 top-1/2 -translate-y-1/2 z-20 flex flex-col items-center space-y-4">
            <div class="w-2 h-2 rounded-full bg-white"></div>
            <div class="w-[2px] h-40 bg-white/40"></div>
            <div class="w-2 h-2 rounded-full bg-white/60"></div>
        </div>

        <!-- TEXT CONTENT -->
        <div class="relative z-20 px-16 pt-40 max-w-2xl">

            <h1 class="text-7xl font-extrabold drop-shadow-xl leading-[1.1]">
                SUMATERA UTARA
            </h1>

            <p class="mt-6 text-gray-200 text-base leading-relaxed">
                Sumatera Utara adalah salah satu provinsi yang penuh pesona, mulai dari keindahan Danau Toba, 
                kekayaan budaya Batak, hingga beragam destinasi alam dan tradisi yang unik. 
                Setiap sudutnya menghadirkan pengalaman memukau yang menampilkan keindahan Indonesia yang sesungguhnya.
            </p>

            <!-- BUTTON EXPLORE scroll to bawah -->
            <button 
                onclick="document.getElementById('wisata-section').scrollIntoView({ behavior: 'smooth' })"
                class="mt-8 bg-blue-600 hover:bg-blue-700 px-8 py-3 rounded-xl font-semibold flex items-center gap-3">
                Explore 
                <span>→</span>
            </button>

        </div>

    </section>

<!-- ======================================= -->
<!--   BAGIAN BAWAH — KATEGORI + SLIDER     -->
<!-- ======================================= -->

<section id="wisata-section" class="w-full py-24 px-16 bg-[#0B1F33]">

    <h2 class="text-4xl font-bold mb-16 text-center">Kategori Wisata di Sumatera Utara</h2>


    <!-- ========================= -->
    <!-- 1. WISATA ALAM -->
    <!-- ========================= -->
    <div class="mb-20">

        <div class="flex justify-between items-center mb-6">
            <h3 class="text-3xl font-semibold">🌿 Wisata Alam</h3>
            <a href="/kategori/alam" class="text-blue-400 hover:underline">See All</a>
        </div>

        <div class="flex space-x-6 overflow-x-auto pb-4 scrollbar-hide">
            @for($i = 1; $i <= 6; $i++)
                <div class="min-w-[300px] h-56 bg-white/5 rounded-xl overflow-hidden border border-white/10 flex-shrink-0 shadow-lg">
                    <img src="/images/alam{{ $i }}.jpg" 
                         class="w-full h-full object-cover"
                         alt="Foto Alam {{ $i }}">
                </div>
            @endfor
        </div>
    </div>




    <!-- ========================= -->
    <!-- 2. WISATA BUDAYA -->
    <!-- ========================= -->
    <div class="mb-20">

        <div class="flex justify-between items-center mb-6">
            <h3 class="text-3xl font-semibold">🏺 Wisata Budaya</h3>
            <a href="/kategori/budaya" class="text-blue-400 hover:underline">See All</a>
        </div>

        <div class="flex space-x-6 overflow-x-auto pb-4 scrollbar-hide">
            @for($i = 1; $i <= 6; $i++)
                <div class="min-w-[300px] h-56 bg-white/5 rounded-xl overflow-hidden border border-white/10 flex-shrink-0 shadow-lg">
                    <img src="/images/budaya{{ $i }}.jpg" 
                         class="w-full h-full object-cover"
                         alt="Foto Budaya {{ $i }}">
                </div>
            @endfor
        </div>
    </div>




    <!-- ========================= -->
    <!-- 3. WISATA RELIGI -->
    <!-- ========================= -->
    <div class="mb-20">

        <div class="flex justify-between items-center mb-6">
            <h3 class="text-3xl font-semibold">⛪ Wisata Religi</h3>
            <a href="/kategori/religi" class="text-blue-400 hover:underline">See All</a>
        </div>

        <div class="flex space-x-6 overflow-x-auto pb-4 scrollbar-hide">
            @for($i = 1; $i <= 6; $i++)
                <div class="min-w-[300px] h-56 bg-white/5 rounded-xl overflow-hidden border border-white/10 flex-shrink-0 shadow-lg">
                    <img src="/images/religi{{ $i }}.jpg" 
                         class="w-full h-full object-cover"
                         alt="Foto Religi {{ $i }}">
                </div>
            @endfor
        </div>
    </div>

</section>
