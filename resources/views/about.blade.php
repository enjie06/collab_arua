@extends('layouts.main')
@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - ARUA (Around Sumatera Utara)</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<!-- Hero Section -->
<section class="bg-gradient-to-br from-purple-600 to-purple-800 py-32 px-4 text-center mt-16">
    <h1 class="text-5xl md:text-6xl font-black text-white mb-4">Tentang ARUA</h1>
    <p class="text-lg md:text-xl text-white/90 max-w-3xl mx-auto">
        <span class="font-bold text-lime-300">ARUA (Around Sumatera Utara)</span> - Platform pintar berbasis Web Semantik 
        yang menghadirkan pengalaman eksplorasi wisata Sumatera Utara yang lebih cerdas, personal, dan tak terlupakan
    </p>
</section>

<!-- About Content -->
<section class="bg-gray-950 py-24 px-4 md:px-8">
    <div class="max-w-6xl mx-auto">

        <!-- Deskripsi ARUA -->
        <div class="mb-16 text-center">
            <div class="bg-white/5 border border-white/10 rounded-2xl p-8 mb-12">
                <h2 class="text-3xl font-black text-white mb-6">Apa itu ARUA?</h2>
                <p class="text-lg text-gray-300 leading-relaxed mb-6">
                    <span class="text-lime-400 font-bold">ARUA (Around Sumatera Utara)</span> adalah revolusi dalam pencarian wisata. 
                    Dengan teknologi Web Semantik, kami tidak hanya menampilkan destinasi, tetapi 
                    <span class="text-purple-300">memahami preferensi dan konteks perjalanan</span> Anda untuk memberikan rekomendasi yang paling sesuai.
                </p>
                <div class="grid md:grid-cols-2 gap-6 text-left">
                    <div class="bg-purple-500/10 border border-purple-500/20 rounded-xl p-6">
                        <h3 class="text-xl font-bold text-white mb-3"> Lebih dari Sekadar Pencarian</h3>
                        <p class="text-gray-300">ARUA memahami makna di balik kata kunci. Cari "wisata keluarga dekat danau" 
                        dan dapatkan rekomendasi yang benar-benar sesuai kebutuhan.</p>
                    </div>
                    <div class="bg-lime-500/10 border border-lime-500/20 rounded-xl p-6">
                        <h3 class="text-xl font-bold text-white mb-3"> Koneksi Data yang Cerdas</h3>
                        <p class="text-gray-300">Teknologi semantik menghubungkan data wisata, fasilitas, lokasi, dan ulasan 
                        untuk memberikan informasi yang komprehensif.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-24">
    <h2 class="text-4xl md:text-5xl font-black text-center bg-gradient-to-r from-purple-500 to-purple-700 bg-clip-text text-transparent mb-16">
        Tim ARUA
    </h2>

    <!-- Wrapper -->
    <div class="flex flex-col items-center space-y-14">

        <!-- ROW 1 : 3 Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">

            <!-- CARD 1 -->
            <div class="group relative w-80 mx-auto">
                <div class="bg-gradient-to-br from-purple-600/20 to-pink-600/20 border border-white/10 
                    rounded-3xl p-8 text-center transition-all duration-500 
                    hover:bg-purple-600/30 hover:border-purple-400/50 hover:scale-105 
                    hover:shadow-2xl hover:shadow-purple-500/20">
                    
                    <div class="relative mb-6">
                        <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-purple-500 to-pink-500 p-1 
                            group-hover:from-purple-400 group-hover:to-pink-400 transition-all duration-500">
                            <img src="{{ asset('images/member1.jpg') }}" 
                                 class="w-full h-full rounded-full object-cover border-4 border-gray-900">
                        </div>
                    </div>

                    <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-purple-200 transition-colors">
                        Anggie Rahmadina Nasution
                    </h3>
                    <p class="text-purple-300 font-medium mb-4">Full Stack Developer</p>
                </div>
            </div>

            <!-- CARD 2 -->
            <div class="group relative w-80 mx-auto">
                <div class="bg-gradient-to-br from-blue-600/20 to-cyan-600/20 border border-white/10 
                    rounded-3xl p-8 text-center transition-all duration-500 hover:bg-blue-600/30 
                    hover:border-blue-400/50 hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/20">

                    <div class="relative mb-6">
                        <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 p-1 
                            group-hover:from-blue-400 group-hover:to-cyan-400 transition-all duration-500">
                            <img src="{{ asset('images/member2.jpg') }}" 
                                 class="w-full h-full rounded-full object-cover border-4 border-gray-900">
                        </div>
                    </div>

                    <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-blue-200 transition-colors">
                        Miranda Nainggolan
                    </h3>
                    <p class="text-blue-300 font-medium mb-4">UI/UX Designer</p>
                </div>
            </div>

            <!-- CARD 3 -->
            <div class="group relative w-80 mx-auto">
                <div class="bg-gradient-to-br from-green-600/20 to-emerald-600/20 border border-white/10 
                    rounded-3xl p-8 text-center transition-all duration-500 hover:bg-green-600/30 
                    hover:border-green-400/50 hover:scale-105 hover:shadow-2xl hover:shadow-green-500/20">

                    <div class="relative mb-6">
                        <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-green-500 to-emerald-500 p-1 
                            group-hover:from-green-400 group-hover:to-emerald-400 transition-all duration-500">
                            <img src="{{ asset('images/member3.jpg') }}" 
                                 class="w-full h-full rounded-full object-cover border-4 border-gray-900">
                        </div>
                    </div>

                    <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-green-200 transition-colors">
                        Vina Permata Sari
                    </h3>
                    <p class="text-green-300 font-medium mb-4">Content Specialist</p>
                </div>
            </div>
        </div>

        <!-- ROW 2 : 2 Cards (Centered) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 md:w-[70%]">

            <!-- CARD 4 -->
            <div class="group relative w-80 mx-auto">
                <div class="bg-gradient-to-br from-orange-600/20 to-red-600/20 border border-white/10 
                    rounded-3xl p-8 text-center transition-all duration-500 hover:bg-orange-600/30 
                    hover:border-orange-400/50 hover:scale-105 hover:shadow-2xl hover:shadow-orange-500/20">

                    <div class="relative mb-6">
                        <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-orange-500 to-red-500 p-1 
                            group-hover:from-orange-400 group-hover:to-red-400 transition-all duration-500">
                            <img src="{{ asset('images/member4.jpg') }}" 
                                 class="w-full h-full rounded-full object-cover border-4 border-gray-900">
                        </div>
                    </div>

                    <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-orange-200 transition-colors">
                        Nayla Vania
                    </h3>
                    <p class="text-orange-300 font-medium mb-4">Data Analyst</p>
                </div>
            </div>

            <!-- CARD 5 -->
            <div class="group relative w-80 mx-auto">
                <div class="bg-gradient-to-br from-indigo-600/20 to-purple-600/20 border border-white/10 
                    rounded-3xl p-8 text-center transition-all duration-500 hover:bg-indigo-600/30 
                    hover:border-indigo-400/50 hover:scale-105 hover:shadow-2xl hover:shadow-indigo-500/20">

                    <div class="relative mb-6">
                        <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 p-1 
                            group-hover:from-indigo-400 group-hover:to-purple-400 transition-all duration-500">
                            <img src="{{ asset('images/memberr5.jpg') }}" 
                                 class="w-full h-full rounded-full object-cover border-4 border-gray-900">
                        </div>
                    </div>

                    <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-indigo-200 transition-colors">
                        Natali Desi Sembiring
                    </h3>
                    <p class="text-indigo-300 font-medium mb-4">Project Manager</p>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="flex justify-center">
    <!-- Contact Info -->
    <div class="space-y-8">

        <div class="bg-white/5 border border-white/10 rounded-2xl p-8 backdrop-blur-sm 
                    w-[1500px]">
    <div class="space-y-8">
        <div class="bg-white/5 border border-white/10 rounded-2xl p-8 backdrop-blur-sm">
            <h3 class="text-2xl font-bold text-white mb-6 text-center">Informasi Kontak</h3>

            <div class="space-y-6">

                <!-- Email -->
                <div class="flex items-start gap-4 group cursor-pointer justify-center">
                    <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center group-hover:bg-purple-600 transition-all duration-300">
                        <i class="fas fa-envelope text-white text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-white font-bold mb-1">Email</h4>
                        <p class="text-gray-300 group-hover:text-purple-300 transition-colors">
                            info@aruasumut.com
                        </p>
                    </div>
                </div>

                <!-- Phone -->
                <div class="flex items-start gap-4 group cursor-pointer justify-center">
                    <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center group-hover:bg-green-600 transition-all duration-300">
                        <i class="fas fa-phone-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-white font-bold mb-1">Telepon/WhatsApp</h4>
                        <p class="text-gray-300 group-hover:text-green-300 transition-colors">
                            +62 812-3456-7890
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


                        
                  
<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
@endsection