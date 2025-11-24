@extends('layouts.main')
@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Wisata Sumatera Utara</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<!-- Hero Section -->
<section class="bg-gradient-to-br from-purple-600 to-purple-800 py-32 px-4 text-center mt-16">
    <h1 class="text-5xl md:text-6xl font-black text-white mb-4">Tentang Kami</h1>
    <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto">Platform pencarian wisata berbasis Web Semantik untuk menghubungkan Anda dengan keindahan Sumatera Utara</p>
</section>

<!-- About Content -->
<section class="bg-gray-950 py-24 px-4 md:px-8">
    <div class="max-w-5xl mx-auto">

        <!-- Team Section -->
        <div class="mb-24">
            <h2 class="text-4xl md:text-5xl font-black text-center bg-gradient-to-r from-purple-500 to-purple-700 bg-clip-text text-transparent mb-16">Tim Kami</h2>
            
            <div class="flex flex-col items-center gap-8">
                <!-- Baris Atas: 3 Orang -->
                <div class="flex flex-wrap justify-center gap-8">
                    <!-- Member 1 -->
                    <div class="bg-white/5 border border-white/10 rounded-3xl p-10 w-72 text-center transition-all duration-300 hover:bg-white/8 hover:border-purple-500/50 hover:-translate-y-2">
                        <img src="{{ asset('images/member1.jpg') }}" alt="Anggie Rahmadina Nasution" class="w-40 h-40 rounded-full object-cover mx-auto mb-6">
                        <h3 class="text-2xl font-bold text-white">Anggie Rahmadina Nasution</h3>
                    </div>

                    <!-- Member 2 -->
                    <div class="bg-white/5 border border-white/10 rounded-3xl p-10 w-72 text-center transition-all duration-300 hover:bg-white/8 hover:border-purple-500/50 hover:-translate-y-2">
                        <img src="{{ asset('images/member2.jpg') }}" alt="Miranda Nainggolan" class="w-40 h-40 rounded-full object-cover mx-auto mb-6">
                        <h3 class="text-2xl font-bold text-white">Miranda Nainggolan</h3>
                    </div>

                    <!-- Member 3 -->
                    <div class="bg-white/5 border border-white/10 rounded-3xl p-10 w-72 text-center transition-all duration-300 hover:bg-white/8 hover:border-purple-500/50 hover:-translate-y-2">
                        <img src="{{ asset('images/member3.jpg') }}" alt="Vina Permata Sari" class="w-40 h-40 rounded-full object-cover mx-auto mb-6">
                        <h3 class="text-2xl font-bold text-white">Vina Permata Sari</h3>
                    </div>
                </div>

                <!-- Baris Bawah: 2 Orang -->
                <div class="flex flex-wrap justify-center gap-8">
                    <!-- Member 4 -->
                    <div class="bg-white/5 border border-white/10 rounded-3xl p-10 w-72 text-center transition-all duration-300 hover:bg-white/8 hover:border-purple-500/50 hover:-translate-y-2">
                        <img src="{{ asset('images/member4.jpg') }}" alt="Nayla Vania" class="w-40 h-40 rounded-full object-cover mx-auto mb-6">
                        <h3 class="text-2xl font-bold text-white">Nayla Vania</h3>
                    </div>

                    <!-- Member 5 -->
                    <div class="bg-white/5 border border-white/10 rounded-3xl p-10 w-72 text-center transition-all duration-300 hover:bg-white/8 hover:border-purple-500/50 hover:-translate-y-2">
                        <img src="{{ asset('images/member5.jpg') }}" alt="Natali Desi Sembiring" class="w-40 h-40 rounded-full object-cover mx-auto mb-6">
                        <h3 class="text-2xl font-bold text-white">Natali Desi Sembiring</h3>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Bottom CTA Banner -->
<section class="relative h-80 bg-cover bg-center overflow-hidden" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)), url('{{ asset('images/danau.jpg') }}');">
    <!-- Overlay Pattern -->
    <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(45deg, rgba(102, 126, 234, 0.1) 0px, rgba(102, 126, 234, 0.1) 10px, transparent 10px, transparent 20px);"></div>
    
    <!-- Content -->
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
        <h2 class="text-4xl md:text-5xl font-black text-white mb-8 drop-shadow-lg">Mulai menjelajahi Sumatera Utara?</h2>
        <a href="/" class="inline-block px-8 py-4 bg-lime-400 hover:bg-lime-500 text-gray-900 font-black text-lg md:text-xl uppercase tracking-wide rounded-full transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl shadow-lg">
            Start Exploring →
        </a>
    </div>
</section>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
@endsection