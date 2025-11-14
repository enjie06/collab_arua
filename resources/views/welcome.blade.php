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
        <nav class="backdrop-blur-md bg-white/10 border-b border-white/20 fixed top-0 left-0 w-full z-50">
    <div class="max-w-6xl mx-auto px-6 py-3 flex justify-between items-center">

        <!-- Logo -->
        <h1 class="text-white text-xl font-bold tracking-wide">
            Hello, Arua
        </h1>

        <!-- Menu -->
        <ul class="flex gap-10 text-white font-medium absolute left-1/2 -translate-x-1/2">
            <li><a href="/" class="hover:text-gray-300 transition">Home</a></li>
            <li><a href="#kategori" class="hover:text-gray-300 transition">Kategori</a></li>
            <li><a href="/wisata/page2" class="hover:text-gray-300 transition">Wisata</a></li>
            <li><a href="/about" class="hover:text-gray-300 transition">About</a></li>
        </ul>

        <div class="w-32"></div>
    </div>
</nav>

       <!-- TEXT + CARD WRAPPER -->
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

    <button onclick="document.getElementById('wisata-section').scrollIntoView({ behavior: 'smooth' })"
        class="mt-8 bg-blue-600 hover:bg-blue-700 px-8 py-3 rounded-xl font-semibold flex items-center gap-3">
        Explore →
    </button>
</div>

<div class="flex flex-col gap-4">

    <div class="flex gap-4">

        <!-- Card 1 -->
        <div class="group relative w-40 h-30 rounded-xl overflow-hidden shadow-lg border border-white/20 bg-white/10">
            <img src="/images/kategori-alam.jpeg" 
                 class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
            <div class="absolute inset-0 bg-black/40 transition group-hover:bg-black/50"></div>
            <h3 class="absolute bottom-3 left-3 text-lg font-bold">Alam</h3>
        </div>

        <!-- Card 2 -->
        <div class="group relative w-40 h-30 rounded-xl overflow-hidden shadow-lg border border-white/20 bg-white/10">
            <img src="/images/kategori-budaya.jpeg" 
                 class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
            <div class="absolute inset-0 bg-black/40 transition group-hover:bg-black/50"></div>
            <h3 class="absolute bottom-3 left-3 text-lg font-bold">Budaya</h3>
        </div>

    </div>

    <!-- Card 3 bawah -->
    <div class="ml-20 group relative w-40 h-30 rounded-xl overflow-hidden shadow-lg border border-white/20 bg-white/10">
    <img src="/images/kategori-religi.jpeg" 
         class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
    <div class="absolute inset-0 bg-black/40 transition group-hover:bg-black/50"></div>
    <h3 class="absolute bottom-3 left-3 text-lg font-bold">Religi</h3>
</div>

</div>

</div>


    </section>


    <!-- =================================================== -->
    <!--            12 FOTO + PAGINATION                     -->
    <!-- =================================================== -->

    <section id="wisata-section" class="w-full py-24 px-16 bg-[#0B1F33]">

        <h2 class="text-4xl font-bold mb-12 text-center">Wisata Sumatera Utara</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @for($i = 1; $i <= 12; $i++)
                <div class="w-full h-56 bg-white/5 rounded-xl overflow-hidden border border-white/10 shadow-lg">
                    <img src="/images/wisata{{ $i }}.jpg"
                         class="w-full h-full object-cover"
                         alt="Foto Wisata {{ $i }}">
                </div>
            @endfor
        </div>

        <div class="flex justify-center mt-12 gap-4 text-lg">
            <a href="/" class="px-4 py-2 bg-blue-600 rounded-lg">1</a>
            <a href="/wisata/page2" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg">2</a>
            <a href="/wisata/page3" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg">3</a>
            <a href="/wisata/page4" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg">4</a>
        </div>

    </section>

</body>
</html>
