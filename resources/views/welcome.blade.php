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
<!--            12 FOTO + PAGINATION         -->
<!-- ======================================= -->

<section id="wisata-section" class="w-full py-24 px-16 bg-[#0B1F33]">

    <h2 class="text-4xl font-bold mb-12 text-center">Wisata Sumatera Utara</h2>

    <!-- GRID 12 FOTO -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

        @for($i = 1; $i <= 12; $i++)
            <div class="w-full h-56 bg-white/5 rounded-xl overflow-hidden border border-white/10 shadow-lg">
                <img src="/images/wisata{{ $i }}.jpg"
                     class="w-full h-full object-cover"
                     alt="Foto Wisata {{ $i }}">
            </div>
        @endfor

    </div>

    <!-- PAGINATION -->
    <div class="flex justify-center mt-12 gap-4 text-lg">

        <a href="/" class="px-4 py-2 bg-blue-600 rounded-lg">1</a>

        <a href="/wisata/page2" 
           class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg">
           2
        </a>

        <a href="/wisata/page3" 
           class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg">
           3
        </a>

        <a href="/wisata/page4" 
           class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg">
           4
        </a>

    </div>

</section>
