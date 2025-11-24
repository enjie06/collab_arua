@extends('layouts.main')
@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - AURA (Around Sumatera Utara)</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<!-- Hero Section -->
<section class="bg-gradient-to-br from-purple-600 to-purple-800 py-32 px-4 text-center mt-16">
    <h1 class="text-5xl md:text-6xl font-black text-white mb-4">Tentang AURA</h1>
    <p class="text-lg md:text-xl text-white/90 max-w-3xl mx-auto">
        <span class="font-bold text-lime-300">AURA (Around Sumatera Utara)</span> - Platform pintar berbasis Web Semantik 
        yang menghadirkan pengalaman eksplorasi wisata Sumatera Utara yang lebih cerdas, personal, dan tak terlupakan
    </p>
</section>

<!-- About Content -->
<section class="bg-gray-950 py-24 px-4 md:px-8">
    <div class="max-w-6xl mx-auto">

        <!-- Deskripsi AURA -->
        <div class="mb-16 text-center">
            <div class="bg-white/5 border border-white/10 rounded-2xl p-8 mb-12">
                <h2 class="text-3xl font-black text-white mb-6">Apa itu AURA?</h2>
                <p class="text-lg text-gray-300 leading-relaxed mb-6">
                    <span class="text-lime-400 font-bold">AURA (Around Sumatera Utara)</span> adalah revolusi dalam pencarian wisata. 
                    Dengan teknologi Web Semantik, kami tidak hanya menampilkan destinasi, tetapi 
                    <span class="text-purple-300">memahami preferensi dan konteks perjalanan</span> Anda untuk memberikan rekomendasi yang paling sesuai.
                </p>
                <div class="grid md:grid-cols-2 gap-6 text-left">
                    <div class="bg-purple-500/10 border border-purple-500/20 rounded-xl p-6">
                        <h3 class="text-xl font-bold text-white mb-3">🎯 Lebih dari Sekadar Pencarian</h3>
                        <p class="text-gray-300">AURA memahami makna di balik kata kunci. Cari "wisata keluarga dekat danau" 
                        dan dapatkan rekomendasi yang benar-benar sesuai kebutuhan.</p>
                    </div>
                    <div class="bg-lime-500/10 border border-lime-500/20 rounded-xl p-6">
                        <h3 class="text-xl font-bold text-white mb-3">🌐 Koneksi Data yang Cerdas</h3>
                        <p class="text-gray-300">Teknologi semantik menghubungkan data wisata, fasilitas, lokasi, dan ulasan 
                        untuk memberikan informasi yang komprehensif.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="mb-24">
            <h2 class="text-4xl md:text-5xl font-black text-center bg-gradient-to-r from-purple-500 to-purple-700 bg-clip-text text-transparent mb-16">Tim AURA</h2>
            
            <!-- Grid dengan 3 kolom di desktop, card ke-4 dan ke-5 di-center -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Member 1 -->
                <div class="group relative">
                    <div class="bg-gradient-to-br from-purple-600/20 to-pink-600/20 border border-white/10 rounded-3xl p-8 text-center transition-all duration-500 hover:bg-purple-600/30 hover:border-purple-400/50 hover:scale-105 hover:shadow-2xl hover:shadow-purple-500/20 h-full flex flex-col">
                        <div class="relative mb-6">
                            <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-purple-500 to-pink-500 p-1 group-hover:from-purple-400 group-hover:to-pink-400 transition-all duration-500">
                                <img src="{{ asset('images/member1.jpg') }}" alt="Anggie Rahmadina Nasution" 
                                     class="w-full h-full rounded-full object-cover border-4 border-gray-900">
                            </div>
                            <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-purple-500 text-white px-4 py-1 rounded-full text-sm font-bold">
                                Lead
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-purple-200 transition-colors">Anggie Rahmadina Nasution</h3>
                        <p class="text-purple-300 font-medium mb-4">Full Stack Developer</p>
                        <div class="flex justify-center space-x-3 mt-auto">
                            <div class="bg-purple-500/20 text-purple-300 px-3 py-1 rounded-full text-sm border border-purple-500/30">
                                Web Semantik
                            </div>
                            <div class="bg-pink-500/20 text-pink-300 px-3 py-1 rounded-full text-sm border border-pink-500/30">
                                AI
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Member 2 -->
                <div class="group relative">
                    <div class="bg-gradient-to-br from-blue-600/20 to-cyan-600/20 border border-white/10 rounded-3xl p-8 text-center transition-all duration-500 hover:bg-blue-600/30 hover:border-blue-400/50 hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/20 h-full flex flex-col">
                        <div class="relative mb-6">
                            <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 p-1 group-hover:from-blue-400 group-hover:to-cyan-400 transition-all duration-500">
                                <img src="{{ asset('images/member2.jpg') }}" alt="Miranda Nainggolan" 
                                     class="w-full h-full rounded-full object-cover border-4 border-gray-900">
                            </div>
                            <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-blue-500 text-white px-4 py-1 rounded-full text-sm font-bold">
                                Design
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-blue-200 transition-colors">Miranda Nainggolan</h3>
                        <p class="text-blue-300 font-medium mb-4">UI/UX Designer</p>
                        <div class="flex justify-center space-x-3 mt-auto">
                            <div class="bg-blue-500/20 text-blue-300 px-3 py-1 rounded-full text-sm border border-blue-500/30">
                                Figma
                            </div>
                            <div class="bg-cyan-500/20 text-cyan-300 px-3 py-1 rounded-full text-sm border border-cyan-500/30">
                                Prototype
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Member 3 -->
                <div class="group relative">
                    <div class="bg-gradient-to-br from-green-600/20 to-emerald-600/20 border border-white/10 rounded-3xl p-8 text-center transition-all duration-500 hover:bg-green-600/30 hover:border-green-400/50 hover:scale-105 hover:shadow-2xl hover:shadow-green-500/20 h-full flex flex-col">
                        <div class="relative mb-6">
                            <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-green-500 to-emerald-500 p-1 group-hover:from-green-400 group-hover:to-emerald-400 transition-all duration-500">
                                <img src="{{ asset('images/member3.jpg') }}" alt="Vina Permata Sari" 
                                     class="w-full h-full rounded-full object-cover border-4 border-gray-900">
                            </div>
                            <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-1 rounded-full text-sm font-bold">
                                Content
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-green-200 transition-colors">Vina Permata Sari</h3>
                        <p class="text-green-300 font-medium mb-4">Content Specialist</p>
                        <div class="flex justify-center space-x-3 mt-auto">
                            <div class="bg-green-500/20 text-green-300 px-3 py-1 rounded-full text-sm border border-green-500/30">
                                Writing
                            </div>
                            <div class="bg-emerald-500/20 text-emerald-300 px-3 py-1 rounded-full text-sm border border-emerald-500/30">
                                Research
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Member 4 - Pindah ke baris baru dengan centering -->
                <div class="group relative lg:col-start-2">
                    <div class="bg-gradient-to-br from-orange-600/20 to-red-600/20 border border-white/10 rounded-3xl p-8 text-center transition-all duration-500 hover:bg-orange-600/30 hover:border-orange-400/50 hover:scale-105 hover:shadow-2xl hover:shadow-orange-500/20 h-full flex flex-col">
                        <div class="relative mb-6">
                            <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-orange-500 to-red-500 p-1 group-hover:from-orange-400 group-hover:to-red-400 transition-all duration-500">
                                <img src="{{ asset('images/member4.jpg') }}" alt="Nayla Vania" 
                                     class="w-full h-full rounded-full object-cover border-4 border-gray-900">
                            </div>
                            <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-orange-500 text-white px-4 py-1 rounded-full text-sm font-bold">
                                Data
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-orange-200 transition-colors">Nayla Vania</h3>
                        <p class="text-orange-300 font-medium mb-4">Data Analyst</p>
                        <div class="flex justify-center space-x-3 mt-auto">
                            <div class="bg-orange-500/20 text-orange-300 px-3 py-1 rounded-full text-sm border border-orange-500/30">
                                Analytics
                            </div>
                            <div class="bg-red-500/20 text-red-300 px-3 py-1 rounded-full text-sm border border-red-500/30">
                                SQL
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Member 5 - Tetap di baris yang sama dengan member 4 -->
                <div class="group relative">
                    <div class="bg-gradient-to-br from-indigo-600/20 to-purple-600/20 border border-white/10 rounded-3xl p-8 text-center transition-all duration-500 hover:bg-indigo-600/30 hover:border-indigo-400/50 hover:scale-105 hover:shadow-2xl hover:shadow-indigo-500/20 h-full flex flex-col">
                        <div class="relative mb-6">
                            <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 p-1 group-hover:from-indigo-400 group-hover:to-purple-400 transition-all duration-500">
                                <img src="{{ asset('images/memberr5.jpg') }}" alt="Natali Desi Sembiring" 
                                     class="w-full h-full rounded-full object-cover border-4 border-gray-900">
                            </div>
                            <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-indigo-500 text-white px-4 py-1 rounded-full text-sm font-bold">
                                Manager
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-indigo-200 transition-colors">Natali Desi Sembiring</h3>
                        <p class="text-indigo-300 font-medium mb-4">Project Manager</p>
                        <div class="flex justify-center space-x-3 mt-auto">
                            <div class="bg-indigo-500/20 text-indigo-300 px-3 py-1 rounded-full text-sm border border-indigo-500/30">
                                Agile
                            </div>
                            <div class="bg-purple-500/20 text-purple-300 px-3 py-1 rounded-full text-sm border border-purple-500/30">
                                Scrum
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
@endsection