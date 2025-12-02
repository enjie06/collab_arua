@extends('layouts.main') 

@section('content')
<div class="min-h-screen pt-24">
    <section class="relative h-[300px] flex items-center justify-center overflow-hidden mb-8">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/80 via-purple-900/80 to-indigo-900/80"></div>
        <div class="absolute inset-0 opacity-20">
            <div class="absolute w-96 h-96 bg-purple-500 rounded-full blur-3xl animate-pulse -top-20 -left-20"></div>
            <div class="absolute w-96 h-96 bg-blue-500 rounded-full blur-3xl animate-pulse -bottom-20 -right-20"></div>
        </div>

        <div class="relative z-10 text-center px-4 max-w-4xl">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-4 animate-fade-in">
                Hasil Pencarian: "{{ $keyword }}"
            </h1>
            <p class="text-lg md:text-xl text-white/90">
                Ditemukan {{ $total }} hasil untuk pencarian Anda
            </p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 mb-12">
        <div class="bg-white/5 backdrop-blur-sm rounded-xl border border-white/20 p-6">
            <form action="{{ route('search') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center">
                
                <div class="flex-1 w-full">
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ $keyword ?? '' }}"
                        placeholder="search..."
                        class="w-full px-6 py-4 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg font-medium transition duration-300"
                    />
                </div>
                
                <div class="w-full md:w-auto">
                    <button 
                        type="submit" 
                        class="w-full md:w-auto bg-blue-700 hover:bg-blue-800 text-white font-medium py-4 px-8 rounded-lg border border-blue-600 hover:border-blue-700 transition duration-300 flex items-center justify-center gap-2 group">
                        <span class="text-lg"></span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </div>
            </form>
            
            <div class="mt-6 flex flex-wrap gap-3 justify-center">
                <a href="{{ route('search', ['q' => 'Danau']) }}" 
                class="bg-white/10 hover:bg-white/20 text-gray-300 hover:text-white text-sm px-4 py-2 rounded-full border border-white/20 transition duration-300">
                    Danau
                </a>
                <a href="{{ route('search', ['q' => 'Pantai']) }}" 
                class="bg-white/10 hover:bg-white/20 text-gray-300 hover:text-white text-sm px-4 py-2 rounded-full border border-white/20 transition duration-300">
                    Pantai
                </a>
                <a href="{{ route('search', ['q' => 'Medan']) }}" 
                class="bg-white/10 hover:bg-white/20 text-gray-300 hover:text-white text-sm px-4 py-2 rounded-full border border-white/20 transition duration-300">
                    Medan
                </a>
                <a href="{{ route('search', ['q' => 'Alam']) }}" 
                class="bg-white/10 hover:bg-white/20 text-gray-300 hover:text-white text-sm px-4 py-2 rounded-full border border-white/20 transition duration-300">
                    Alam
                </a>
                <a href="{{ route('search', ['q' => 'Religi']) }}" 
                class="bg-white/10 hover:bg-white/20 text-gray-300 hover:text-white text-sm px-4 py-2 rounded-full border border-white/20 transition duration-300">
                    Religi
                </a>
            </div>
        </div>
    </section>

    @if($total > 0)
        <section class="max-w-7xl mx-auto px-4 mb-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                @foreach($wisataAlam as $index => $wisata)
                <div onclick="openModal('modal-alam-search-{{ $index }}')" 
                    class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                    
                    @if($wisata['gambar'])
                    <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $wisata['gambar'] }}')">
                        <div class="h-full w-full bg-black/20 flex items-center justify-center"></div>
                    </div>
                    @else
                    <div class="h-48 bg-gradient-to-br from-emerald-400 via-teal-500 to-blue-600 flex items-center justify-center">
                        <span class="text-white text-xl font-bold">{{ strtoupper($wisata['kategori']) }}</span>
                    </div>
                    @endif
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-white">{{ $wisata['nama'] }}</h3>
                        <div class="space-y-2 text-sm text-gray-300">
                            <div class="flex justify-between">
                                <span>📍 {{ $wisata['kota'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="bg-emerald-500/20 text-emerald-300 px-2 py-1 rounded text-xs">
                                    {{ $wisata['kategori'] }}
                                </span>
                                <span class="text-orange-300">{{ $wisata['harga_tiket'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @foreach($wisataBudaya as $index => $wisata)
                <div onclick="openModal('modal-budaya-search-{{ $index }}')" 
                    class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                    
                    @if($wisata['gambar'])
                    <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $wisata['gambar'] }}')">
                        <div class="h-full w-full bg-black/20 flex items-center justify-center"></div>
                    </div>
                    @else
                    <div class="h-48 bg-gradient-to-br from-amber-400 via-orange-500 to-red-600 flex items-center justify-center">
                        <span class="text-white text-xl font-bold">{{ strtoupper($wisata['kategori']) }}</span>
                    </div>
                    @endif
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-white">{{ $wisata['nama'] }}</h3>
                        <div class="space-y-2 text-sm text-gray-300">
                            <div class="flex justify-between">
                                <span>📍 {{ $wisata['kota'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="bg-amber-500/20 text-amber-300 px-2 py-1 rounded text-xs">
                                    {{ $wisata['kategori'] }}
                                </span>
                                <span class="text-orange-300">{{ $wisata['harga_tiket'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @foreach($wisataReligi as $index => $wisata)
                <div onclick="openModal('modal-religi-search-{{ $index }}')" 
                    class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                    
                    @if($wisata['gambar'])
                    <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $wisata['gambar'] }}')">
                        <div class="h-full w-full bg-black/20 flex items-center justify-center"></div>
                    </div>
                    @else
                    <div class="h-48 bg-gradient-to-br from-violet-400 via-purple-500 to-fuchsia-600 flex items-center justify-center">
                        <span class="text-white text-xl font-bold">{{ strtoupper($wisata['kategori']) }}</span>
                    </div>
                    @endif
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-white">{{ $wisata['nama'] }}</h3>
                        <div class="space-y-2 text-sm text-gray-300">
                            <div class="flex justify-between">
                                <span>📍 {{ $wisata['kota'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="bg-violet-500/20 text-violet-300 px-2 py-1 rounded text-xs">
                                    {{ $wisata['kategori'] }}
                                </span>
                                <span class="text-orange-300">{{ $wisata['harga_tiket'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @foreach($wisataAlam as $index => $wisata)
                <div id="modal-alam-search-{{ $index }}" class="fixed inset-0 bg-black/90 backdrop-blur-md z-50 hidden items-center justify-center p-4">
                    <div class="glass-card rounded-3xl max-w-5xl w-full max-h-[90vh] overflow-y-auto border border-white/20">
                        <div class="sticky top-0 glass-card border-b border-white/10 p-6 flex justify-between items-center">
                            <h2 class="text-4xl font-black text-white">{{ $wisata['nama'] }}</h2>
                            <button onclick="closeModal('modal-alam-search-{{ $index }}')" class="w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition">
                                <span class="text-xl">×</span>
                            </button>
                        </div>
                        <div class="p-8">
                            @if($wisata['gambar'])
                            <div class="w-full h-96 bg-cover bg-center rounded-2xl mb-8" style="background-image: url('{{ $wisata['gambar'] }}')"></div>
                            @else
                            <div class="w-full h-96 bg-gradient-to-br from-emerald-400 via-teal-500 to-blue-600 rounded-2xl flex items-center justify-center mb-8">
                                <span class="text-white text-4xl font-bold">{{ strtoupper($wisata['kategori']) }}</span>
                            </div>
                            @endif
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h3 class="text-white font-bold mb-2">Jenis Wisata</h3>
                                    <p class="text-gray-300">Alam</p>
                                </div>
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h3 class="text-white font-bold mb-2">Kategori</h3>
                                    <p class="text-gray-300">{{ $wisata['kategori'] }}</p>
                                </div>
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h3 class="text-white font-bold mb-2">Harga Tiket</h3>
                                    <p class="text-gray-300">{{ $wisata['harga_tiket'] }}</p>
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
                                <!-- Kolom kiri: Informasi Lokasi -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h3 class="text-white font-bold mb-4 text-xl">Informasi Lokasi</h3>
                                    <div class="space-y-4">
                                        <div class="space-y-2">
                                            <div class="flex items-center text-gray-300">
                                                <i class="fas fa-map-marker-alt mr-2"></i>
                                                <span class="font-medium">Alamat</span>
                                            </div>
                                            <p class="text-white font-medium pl-6">{{ $wisata['alamat'] }}</p>
                                        </div>
                                        
                                        <div class="space-y-2">
                                            <div class="flex items-center text-gray-300">
                                                <i class="fas fa-city mr-2"></i>
                                                <span class="font-medium">Kabupaten/Kota</span>
                                            </div>
                                            <p class="text-white font-medium pl-6">{{ $wisata['kota'] }}</p>
                                        </div>
                                        
                                        <!-- Provinsi -->
                                        <div class="space-y-2">
                                            <div class="flex items-center text-gray-300">
                                                <i class="fas fa-globe mr-2"></i>
                                                <span class="font-medium">Provinsi</span>
                                            </div>
                                            <p class="text-white font-medium pl-6">{{ $wisata['provinsi'] }}</p>
                                        </div>
                                        
                                        <!-- Koordinat (hanya teks) -->
                                        @if(isset($wisata['latitude']) && isset($wisata['longitude']) && $wisata['latitude'] && $wisata['longitude'])
                                        <div class="space-y-2">
                                            <div class="flex items-center text-gray-300">
                                                <i class="fas fa-crosshairs mr-2"></i>
                                                <span class="font-medium">Koordinat</span>
                                            </div>
                                            <p class="text-white font-medium pl-6">
                                                {{ number_format($wisata['latitude'], 6) }}° N, 
                                                {{ number_format($wisata['longitude'], 6) }}° E
                                            </p>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                @if(isset($wisata['latitude']) && isset($wisata['longitude']) && $wisata['latitude'] && $wisata['longitude'])
                                <div class="relative bg-white/10 rounded-xl p-6">
                                    <h3 class="text-white font-bold mb-4 text-xl">Peta Wisata</h3>
                                    
                                    <div class="mb-4">
                                        <div class="rounded-xl overflow-hidden border border-white/20 shadow-lg" style="height: 250px;">
                                            <iframe
                                                width="100%"
                                                height="100%"
                                                frameborder="0"
                                                style="border:0;"
                                                src="https://www.google.com/maps?q={{ $wisata['latitude'] }},{{ $wisata['longitude'] }}&z=15&output=embed"
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-row items-center gap-3">
                                        
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $wisata['latitude'] }},{{ $wisata['longitude'] }}" 
                                        target="_blank" 
                                        class="group relative flex items-center justify-center w-16 h-16 bg-white/10 backdrop-blur-sm rounded-full hover:bg-white/20 transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-xl border border-white/20">
                                            <div class="absolute -top-10 bg-black/90 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                                Buka di Google Maps
                                            </div>
                                            <i class="fas fa-map-marked-alt text-white text-2xl"></i>
                                        </a>
                                        
                                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $wisata['latitude'] }},{{ $wisata['longitude'] }}" 
                                        target="_blank" 
                                        class="group relative flex items-center justify-center w-16 h-16 bg-white/10 backdrop-blur-sm rounded-full hover:bg-white/20 transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-xl border border-white/20">
                                            <div class="absolute -top-10 bg-black/90 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                                Dapatkan Rute
                                            </div>
                                            <i class="fas fa-directions text-white text-2xl"></i>
                                        </a>
                                        
                                        <a href="https://www.google.com/maps/@?api=1&map_action=pano&viewpoint={{ $wisata['latitude'] }},{{ $wisata['longitude'] }}" 
                                        target="_blank" 
                                        class="group relative flex items-center justify-center w-16 h-16 bg-white/10 backdrop-blur-sm rounded-full hover:bg-white/20 transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-xl border border-white/20">
                                            <div class="absolute -top-10 bg-black/90 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                                Lihat Street View
                                            </div>
                                            <i class="fas fa-street-view text-white text-2xl"></i>
                                        </a>
                                    </div>
                                </div>
                                @else
                                <div class="bg-white/10 rounded-xl p-6 flex flex-col items-center justify-center">
                                    <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-map-marker-slash text-4xl text-gray-500"></i>
                                    </div>
                                    <h4 class="text-white font-bold mb-2">Peta Tidak Tersedia</h4>
                                    <p class="text-gray-400 text-sm text-center">
                                        Lokasi koordinat untuk wisata ini belum tersedia
                                    </p>
                                </div>
                                @endif
                            </div>

                            <div class="bg-white/10 rounded-xl p-6 mb-8">
                                <h3 class="text-white font-bold mb-4 text-xl">Fasilitas & Aktivitas</h3>
                                <div class="space-y-4">
                                    @if(isset($wisata['fasilitas']) && $wisata['fasilitas'])
                                    <div class="space-y-2">
                                        <div class="flex items-center text-gray-300">
                                            <i class="fas fa-concierge-bell mr-2"></i>
                                            <span class="font-medium">Fasilitas</span>
                                        </div>
                                        <p class="text-white font-medium pl-6">{{ $wisata['fasilitas'] }}</p>
                                    </div>
                                    @endif
                                    
                                    @if(isset($wisata['aktivitas']) && $wisata['aktivitas'])
                                    <div class="space-y-2">
                                        <div class="flex items-center text-gray-300">
                                            <i class="fas fa-hiking mr-2"></i>
                                            <span class="font-medium">Aktivitas</span>
                                        </div>
                                        <p class="text-white font-medium pl-6">{{ $wisata['aktivitas'] }}</p>
                                    </div>
                                    @endif
                                    
                                    @if(isset($wisata['dekat_dengan']) && $wisata['dekat_dengan'])
                                    <div class="space-y-2">
                                        <div class="flex items-center text-gray-300">
                                            <i class="fas fa-landmark mr-2"></i>
                                            <span class="font-medium">Dekat Dengan</span>
                                        </div>
                                        <p class="text-white font-medium pl-6">{{ $wisata['dekat_dengan'] }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div class="bg-white/10 rounded-xl p-6">
                                <h3 class="text-white font-bold mb-4 text-xl">Deskripsi</h3>
                                <p class="text-gray-300 text-lg leading-relaxed">
                                    {{ $wisata['nama'] }} adalah salah satu destinasi wisata alam terbaik di Sumatera Utara. 
                                    Menawarkan pengalaman wisata yang tak terlupakan dengan pemandangan alam yang menakjubkan 
                                    dan berbagai aktivitas menarik untuk dinikmati oleh pengunjung.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @foreach($wisataBudaya as $index => $wisata)
                <div id="modal-budaya-search-{{ $index }}" class="fixed inset-0 bg-black/90 backdrop-blur-md z-50 hidden items-center justify-center p-4">
                    <div class="glass-card rounded-3xl max-w-5xl w-full max-h-[90vh] overflow-y-auto border border-white/20">
                        <div class="sticky top-0 glass-card border-b border-white/10 p-6 flex justify-between items-center">
                            <h2 class="text-4xl font-black text-white">{{ $wisata['nama'] }}</h2>
                            <button onclick="closeModal('modal-budaya-search-{{ $index }}')" class="w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition">
                                <span class="text-xl">×</span>
                            </button>
                        </div>
                        <div class="p-8">
                            @if($wisata['gambar'])
                            <div class="w-full h-96 bg-cover bg-center rounded-2xl mb-8" style="background-image: url('{{ $wisata['gambar'] }}')"></div>
                            @else
                            <div class="w-full h-96 bg-gradient-to-br from-amber-400 via-orange-500 to-red-600 rounded-2xl flex items-center justify-center mb-8">
                                <span class="text-white text-4xl font-bold">{{ strtoupper($wisata['kategori']) }}</span>
                            </div>
                            @endif
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h3 class="text-white font-bold mb-2">Jenis Wisata</h3>
                                    <p class="text-gray-300">Budaya</p>
                                </div>
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h3 class="text-white font-bold mb-2">Kategori</h3>
                                    <p class="text-gray-300">{{ $wisata['kategori'] }}</p>
                                </div>
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h3 class="text-white font-bold mb-2">Harga Tiket</h3>
                                    <p class="text-gray-300">{{ $wisata['harga_tiket'] }}</p>
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
                                <!-- Kolom kiri: Informasi Lokasi -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h3 class="text-white font-bold mb-4 text-xl">Informasi Lokasi</h3>
                                    <div class="space-y-4">
                                        <!-- Alamat -->
                                        <div class="space-y-2">
                                            <div class="flex items-center text-gray-300">
                                                <i class="fas fa-map-marker-alt mr-2"></i>
                                                <span class="font-medium">Alamat</span>
                                            </div>
                                            <p class="text-white font-medium pl-6">{{ $wisata['alamat'] }}</p>
                                        </div>
                                        
                                        <div class="space-y-2">
                                            <div class="flex items-center text-gray-300">
                                                <i class="fas fa-city mr-2"></i>
                                                <span class="font-medium">Kabupaten/Kota</span>
                                            </div>
                                            <p class="text-white font-medium pl-6">{{ $wisata['kota'] }}</p>
                                        </div>
                                        
                                        <div class="space-y-2">
                                            <div class="flex items-center text-gray-300">
                                                <i class="fas fa-globe mr-2"></i>
                                                <span class="font-medium">Provinsi</span>
                                            </div>
                                            <p class="text-white font-medium pl-6">{{ $wisata['provinsi'] }}</p>
                                        </div>
                                        
                                        @if(isset($wisata['latitude']) && isset($wisata['longitude']) && $wisata['latitude'] && $wisata['longitude'])
                                        <div class="space-y-2">
                                            <div class="flex items-center text-gray-300">
                                                <i class="fas fa-crosshairs mr-2"></i>
                                                <span class="font-medium">Koordinat</span>
                                            </div>
                                            <p class="text-white font-medium pl-6">
                                                {{ number_format($wisata['latitude'], 6) }}° N, 
                                                {{ number_format($wisata['longitude'], 6) }}° E
                                            </p>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                @if(isset($wisata['latitude']) && isset($wisata['longitude']) && $wisata['latitude'] && $wisata['longitude'])
                                <div class="relative bg-white/10 rounded-xl p-6">
                                    <h3 class="text-white font-bold mb-4 text-xl">Peta Wisata</h3>
                                    
                                    <!-- Map Container (Lebar, tidak terlalu tinggi) -->
                                    <div class="mb-4">
                                        <div class="rounded-xl overflow-hidden border border-white/20 shadow-lg" style="height: 250px;">
                                            <iframe
                                                width="100%"
                                                height="100%"
                                                frameborder="0"
                                                style="border:0;"
                                                src="https://www.google.com/maps?q={{ $wisata['latitude'] }},{{ $wisata['longitude'] }}&z=15&output=embed"
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-row items-center gap-3">
                                        <!-- Tombol Buka di Maps -->
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $wisata['latitude'] }},{{ $wisata['longitude'] }}" 
                                        target="_blank" 
                                        class="group relative flex items-center justify-center w-16 h-16 bg-white/10 backdrop-blur-sm rounded-full hover:bg-white/20 transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-xl border border-white/20">
                                            <div class="absolute -top-10 bg-black/90 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                                Buka di Google Maps
                                            </div>
                                            <i class="fas fa-map-marked-alt text-white text-2xl"></i>
                                        </a>
                                        
                                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $wisata['latitude'] }},{{ $wisata['longitude'] }}" 
                                        target="_blank" 
                                        class="group relative flex items-center justify-center w-16 h-16 bg-white/10 backdrop-blur-sm rounded-full hover:bg-white/20 transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-xl border border-white/20">
                                            <div class="absolute -top-10 bg-black/90 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                                Dapatkan Rute
                                            </div>
                                            <i class="fas fa-directions text-white text-2xl"></i>
                                        </a>
                                        
                                        <a href="https://www.google.com/maps/@?api=1&map_action=pano&viewpoint={{ $wisata['latitude'] }},{{ $wisata['longitude'] }}" 
                                        target="_blank" 
                                        class="group relative flex items-center justify-center w-16 h-16 bg-white/10 backdrop-blur-sm rounded-full hover:bg-white/20 transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-xl border border-white/20">
                                            <div class="absolute -top-10 bg-black/90 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                                Lihat Street View
                                            </div>
                                            <i class="fas fa-street-view text-white text-2xl"></i>
                                        </a>
                                    </div>
                                </div>
                                @else
                                
                                <div class="bg-white/10 rounded-xl p-6 flex flex-col items-center justify-center">
                                    <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-map-marker-slash text-4xl text-gray-500"></i>
                                    </div>
                                    <h4 class="text-white font-bold mb-2">Peta Tidak Tersedia</h4>
                                    <p class="text-gray-400 text-sm text-center">
                                        Lokasi koordinat untuk wisata ini belum tersedia
                                    </p>
                                </div>
                                @endif
                            </div>

                            <div class="bg-white/10 rounded-xl p-6 mb-8">
                                <h3 class="text-white font-bold mb-4 text-xl">Fasilitas & Aktivitas</h3>
                                <div class="space-y-4">
                                    @if(isset($wisata['fasilitas']) && $wisata['fasilitas'])
                                    <div class="space-y-2">
                                        <div class="flex items-center text-gray-300">
                                            <i class="fas fa-concierge-bell mr-2"></i>
                                            <span class="font-medium">Fasilitas</span>
                                        </div>
                                        <p class="text-white font-medium pl-6">{{ $wisata['fasilitas'] }}</p>
                                    </div>
                                    @endif
                                    
                                    @if(isset($wisata['aktivitas']) && $wisata['aktivitas'])
                                    <div class="space-y-2">
                                        <div class="flex items-center text-gray-300">
                                            <i class="fas fa-landmark mr-2"></i>
                                            <span class="font-medium">Aktivitas Budaya</span>
                                        </div>
                                        <p class="text-white font-medium pl-6">{{ $wisata['aktivitas'] }}</p>
                                    </div>
                                    @endif
                                    
                                    @if(isset($wisata['dekat_dengan']) && $wisata['dekat_dengan'])
                                    <div class="space-y-2">
                                        <div class="flex items-center text-gray-300">
                                            <i class="fas fa-compass mr-2"></i>
                                            <span class="font-medium">Dekat Dengan</span>
                                        </div>
                                        <p class="text-white font-medium pl-6">{{ $wisata['dekat_dengan'] }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-white/10 rounded-xl p-6">
                                <h3 class="text-white font-bold mb-4 text-xl">Deskripsi</h3>
                                <p class="text-gray-300 text-lg leading-relaxed">
                                    {{ $wisata['nama'] }} adalah salah satu destinasi wisata budaya terbaik di Sumatera Utara. 
                                    Menawarkan pengalaman wisata yang tak terlupakan dengan kekayaan budaya yang menakjubkan 
                                    dan berbagai aktivitas menarik untuk dinikmati oleh pengunjung.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @foreach($wisataReligi as $index => $wisata)
                <div id="modal-religi-search-{{ $index }}" class="fixed inset-0 bg-black/90 backdrop-blur-md z-50 hidden items-center justify-center p-4">
                    <div class="glass-card rounded-3xl max-w-5xl w-full max-h-[90vh] overflow-y-auto border border-white/20">
                        <div class="sticky top-0 glass-card border-b border-white/10 p-6 flex justify-between items-center">
                            <h2 class="text-4xl font-black text-white">{{ $wisata['nama'] }}</h2>
                            <button onclick="closeModal('modal-religi-search-{{ $index }}')" class="w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition">
                                <span class="text-xl">×</span>
                            </button>
                        </div>
                        <div class="p-8">
                            @if($wisata['gambar'])
                            <div class="w-full h-96 bg-cover bg-center rounded-2xl mb-8" style="background-image: url('{{ $wisata['gambar'] }}')"></div>
                            @else
                            <div class="w-full h-96 bg-gradient-to-br from-violet-400 via-purple-500 to-fuchsia-600 rounded-2xl flex items-center justify-center mb-8">
                                <span class="text-white text-4xl font-bold">{{ strtoupper($wisata['kategori']) }}</span>
                            </div>
                            @endif
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h3 class="text-white font-bold mb-2">Jenis Wisata</h3>
                                    <p class="text-gray-300">Religi</p>
                                </div>
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h3 class="text-white font-bold mb-2">Kategori</h3>
                                    <p class="text-gray-300">{{ $wisata['kategori'] }}</p>
                                </div>
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h3 class="text-white font-bold mb-2">Harga Tiket</h3>
                                    <p class="text-gray-300">{{ $wisata['harga_tiket'] }}</p>
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
                                <!-- Kolom kiri: Informasi Lokasi -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h3 class="text-white font-bold mb-4 text-xl">Informasi Lokasi</h3>
                                    <div class="space-y-4">
                                        <!-- Alamat -->
                                        <div class="space-y-2">
                                            <div class="flex items-center text-gray-300">
                                                <i class="fas fa-map-marker-alt mr-2"></i>
                                                <span class="font-medium">Alamat</span>
                                            </div>
                                            <p class="text-white font-medium pl-6">{{ $wisata['alamat'] }}</p>
                                        </div>
                                        
                                        <!-- Kabupaten/Kota -->
                                        <div class="space-y-2">
                                            <div class="flex items-center text-gray-300">
                                                <i class="fas fa-city mr-2"></i>
                                                <span class="font-medium">Kabupaten/Kota</span>
                                            </div>
                                            <p class="text-white font-medium pl-6">{{ $wisata['kota'] }}</p>
                                        </div>
                                        
                                        <!-- Provinsi -->
                                        <div class="space-y-2">
                                            <div class="flex items-center text-gray-300">
                                                <i class="fas fa-globe mr-2"></i>
                                                <span class="font-medium">Provinsi</span>
                                            </div>
                                            <p class="text-white font-medium pl-6">{{ $wisata['provinsi'] }}</p>
                                        </div>
                                        
                                        <!-- Agama Terkait -->
                                        @if(isset($wisata['agama_terkait']) && $wisata['agama_terkait'])
                                        <div class="space-y-2">
                                            <div class="flex items-center text-gray-300">
                                                <i class="fas fa-pray mr-2"></i>
                                                <span class="font-medium">Agama</span>
                                            </div>
                                            <p class="text-white font-medium pl-6">{{ $wisata['agama_terkait'] }}</p>
                                        </div>
                                        @endif
                                        
                                        <!-- Koordinat (hanya teks) -->
                                        @if(isset($wisata['latitude']) && isset($wisata['longitude']) && $wisata['latitude'] && $wisata['longitude'])
                                        <div class="space-y-2">
                                            <div class="flex items-center text-gray-300">
                                                <i class="fas fa-crosshairs mr-2"></i>
                                                <span class="font-medium">Koordinat</span>
                                            </div>
                                            <p class="text-white font-medium pl-6">
                                                {{ number_format($wisata['latitude'], 6) }}° N, 
                                                {{ number_format($wisata['longitude'], 6) }}° E
                                            </p>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                @if(isset($wisata['latitude']) && isset($wisata['longitude']) && $wisata['latitude'] && $wisata['longitude'])
                                <div class="relative bg-white/10 rounded-xl p-6">
                                    <h3 class="text-white font-bold mb-4 text-xl">Peta Wisata</h3>
                                    
                                    <div class="mb-4">
                                        <div class="rounded-xl overflow-hidden border border-white/20 shadow-lg" style="height: 250px;">
                                            <iframe
                                                width="100%"
                                                height="100%"
                                                frameborder="0"
                                                style="border:0;"
                                                src="https://www.google.com/maps?q={{ $wisata['latitude'] }},{{ $wisata['longitude'] }}&z=15&output=embed"
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-row items-center gap-3">
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $wisata['latitude'] }},{{ $wisata['longitude'] }}" 
                                        target="_blank" 
                                        class="group relative flex items-center justify-center w-16 h-16 bg-white/10 backdrop-blur-sm rounded-full hover:bg-white/20 transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-xl border border-white/20">
                                            <div class="absolute -top-10 bg-black/90 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                                Buka di Google Maps
                                            </div>
                                            <i class="fas fa-map-marked-alt text-white text-2xl"></i>
                                        </a>
                                        
                                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $wisata['latitude'] }},{{ $wisata['longitude'] }}" 
                                        target="_blank" 
                                        class="group relative flex items-center justify-center w-16 h-16 bg-white/10 backdrop-blur-sm rounded-full hover:bg-white/20 transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-xl border border-white/20">
                                            <div class="absolute -top-10 bg-black/90 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                                Dapatkan Rute
                                            </div>
                                            <i class="fas fa-directions text-white text-2xl"></i>
                                        </a>
                                        
                                        <a href="https://www.google.com/maps/@?api=1&map_action=pano&viewpoint={{ $wisata['latitude'] }},{{ $wisata['longitude'] }}" 
                                        target="_blank" 
                                        class="group relative flex items-center justify-center w-16 h-16 bg-white/10 backdrop-blur-sm rounded-full hover:bg-white/20 transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-xl border border-white/20">
                                            <div class="absolute -top-10 bg-black/90 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                                Lihat Street View
                                            </div>
                                            <i class="fas fa-street-view text-white text-2xl"></i>
                                        </a>
                                    </div>
                                </div>
                                @else
                                
                                <div class="bg-white/10 rounded-xl p-6 flex flex-col items-center justify-center">
                                    <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-map-marker-slash text-4xl text-gray-500"></i>
                                    </div>
                                    <h4 class="text-white font-bold mb-2">Peta Tidak Tersedia</h4>
                                    <p class="text-gray-400 text-sm text-center">
                                        Lokasi koordinat untuk wisata ini belum tersedia
                                    </p>
                                </div>
                                @endif
                            </div>

                            <div class="bg-white/10 rounded-xl p-6 mb-8">
                                <h3 class="text-white font-bold mb-4 text-xl">Fasilitas & Aktivitas</h3>
                                <div class="space-y-4">
                                    @if(isset($wisata['fasilitas']) && $wisata['fasilitas'])
                                    <div class="space-y-2">
                                        <div class="flex items-center text-gray-300">
                                            <i class="fas fa-concierge-bell mr-2"></i>
                                            <span class="font-medium">Fasilitas</span>
                                        </div>
                                        <p class="text-white font-medium pl-6">{{ $wisata['fasilitas'] }}</p>
                                    </div>
                                    @endif
                                    
                                    @if(isset($wisata['aktivitas']) && $wisata['aktivitas'])
                                    <div class="space-y-2">
                                        <div class="flex items-center text-gray-300">
                                            <i class="fas fa-praying-hands mr-2"></i>
                                            <span class="font-medium">Aktivitas Religi</span>
                                        </div>
                                        <p class="text-white font-medium pl-6">{{ $wisata['aktivitas'] }}</p>
                                    </div>
                                    @endif
                                    
                                    @if(isset($wisata['tokoh_terkait']) && $wisata['tokoh_terkait'] && $wisata['tokoh_terkait'] != '-')
                                    <div class="space-y-2">
                                        <div class="flex items-center text-gray-300">
                                            <i class="fas fa-user-tie mr-2"></i>
                                            <span class="font-medium">Tokoh Terkait</span>
                                        </div>
                                        <p class="text-white font-medium pl-6">{{ $wisata['tokoh_terkait'] }}</p>
                                    </div>
                                    @endif
                                    
                                    @if(isset($wisata['dekat_dengan']) && $wisata['dekat_dengan'])
                                    <div class="space-y-2">
                                        <div class="flex items-center text-gray-300">
                                            <i class="fas fa-compass mr-2"></i>
                                            <span class="font-medium">Dekat Dengan</span>
                                        </div>
                                        <p class="text-white font-medium pl-6">{{ $wisata['dekat_dengan'] }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-white/10 rounded-xl p-6">
                                <h3 class="text-white font-bold mb-4 text-xl">Deskripsi</h3>
                                <p class="text-gray-300 text-lg leading-relaxed">
                                    {{ $wisata['nama'] }} adalah salah satu destinasi wisata religi terbaik di Sumatera Utara. 
                                    Menawarkan pengalaman wisata yang tak terlupakan dengan suasana spiritual yang menakjubkan 
                                    dan berbagai aktivitas menarik untuk dinikmati oleh pengunjung.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-8 text-center">
                <p class="text-gray-400 text-sm">
                    Menampilkan {{ $total }} hasil pencarian untuk "{{ $keyword }}"
                </p>
            </div>
        </section>
        
    @else
        <div class="max-w-7xl mx-auto px-4 text-center py-12">
            <div class="bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10 p-12 max-w-md mx-auto">
                <h3 class="text-xl font-semibold text-white mb-2">Tidak ada hasil ditemukan</h3>
                <p class="text-gray-300 mb-6">Tidak ada wisata yang sesuai dengan pencarian "{{ $keyword }}"</p>
                <div class="space-y-3">
                    <a href="/wisata" class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-lg font-semibold text-white inline-flex items-center gap-2 transition duration-200 w-full justify-center">
                        Lihat Semua Wisata
                    </a>
                    <a href="/" class="bg-gray-600 hover:bg-gray-700 px-6 py-3 rounded-lg font-semibold text-white inline-flex items-center gap-2 transition duration-200 w-full justify-center">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fade-in 1s ease-out; }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
</style>

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

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="modal-"]').forEach(modal => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
            document.body.style.overflow = 'auto';
        }
    });

    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('fixed') && e.target.id.startsWith('modal-')) {
            closeModal(e.target.id);
        }
    });
</script>
@endsection