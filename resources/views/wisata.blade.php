@extends('layouts.main')
@section('content')

<div class="min-h-screen pt-24">
    <!-- Hero Section -->
    <section class="relative h-[400px] flex items-center justify-center overflow-hidden mb-8">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/80 via-purple-900/80 to-indigo-900/80"></div>
        <div class="absolute inset-0 opacity-20">
            <div class="absolute w-96 h-96 bg-purple-500 rounded-full blur-3xl animate-pulse -top-20 -left-20"></div>
            <div class="absolute w-96 h-96 bg-blue-500 rounded-full blur-3xl animate-pulse -bottom-20 -right-20"></div>
        </div>

        <div class="relative z-10 text-center px-4 max-w-4xl">
            <h1 class="text-5xl md:text-6xl font-black text-white mb-4 animate-fade-in">
                Explore Sumatera Utara
            </h1>
            <p class="text-lg md:text-xl text-white/90">
                Temukan destinasi wisata impian Anda 
            </p>
        </div>
    </section>

    <!-- Header Semua Destinasi -->
    <section class="max-w-7xl mx-auto px-4 mb-8">
        <div class="text-center">
            <h2 class="text-4xl font-black text-white mb-2">SEMUA DESTINASI</h2>
            <p class="text-gray-400">Menampilkan semua wisata Sumatera Utara</p>
        </div>
    </section>

    <!-- Grid Semua Destinasi -->
    <section class="max-w-7xl mx-auto px-4 mb-12">
        <!-- Grid untuk semua destinasi -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                // Gabungkan semua destinasi dengan ID yang tepat untuk modal
                $allWisata = [];
                
                // Tambahkan wisata alam dengan informasi modal
                foreach($wisataAlam as $index => $wisata) {
                    $allWisata[] = [
                        'data' => $wisata,
                        'modal_id' => 'modal-alam-' . $index,
                        'kategori' => 'alam'
                    ];
                }
                
                // Tambahkan wisata budaya dengan informasi modal
                foreach($wisataBudaya as $index => $wisata) {
                    $allWisata[] = [
                        'data' => $wisata,
                        'modal_id' => 'modal-budaya-' . $index,
                        'kategori' => 'budaya'
                    ];
                }
                
                // Tambahkan wisata religi dengan informasi modal
                foreach($wisataReligi as $index => $wisata) {
                    $allWisata[] = [
                        'data' => $wisata,
                        'modal_id' => 'modal-religi-' . $index,
                        'kategori' => 'religi'
                    ];
                }
                
                // Pagination logic - DIUBAH JADI 12 PER HALAMAN
                $perPage = 12;
                $currentPage = request()->get('page', 1);
                $offset = ($currentPage - 1) * $perPage;
                $paginatedWisata = array_slice($allWisata, $offset, $perPage);
                $totalPages = ceil(count($allWisata) / $perPage);
            @endphp

            @foreach($paginatedWisata as $item)
            @php
                $wisata = $item['data'];
                $modalId = $item['modal_id'];
                $kategori = $item['kategori'];
            @endphp
            
            <div onclick="openModal('{{ $modalId }}')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                @if($wisata['gambar'])
                <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $wisata['gambar'] }}')">
                    <div class="h-full w-full bg-black/20 flex items-center justify-center"></div>
                </div>
                @else
                <div class="h-48 flex items-center justify-center
                    @if($kategori == 'alam') bg-gradient-to-br from-emerald-400 via-teal-500 to-blue-600
                    @elseif($kategori == 'budaya') bg-gradient-to-br from-amber-400 via-orange-500 to-red-600
                    @else bg-gradient-to-br from-violet-400 via-purple-500 to-fuchsia-600
                    @endif">
                    <span class="text-white text-xl font-bold">{{ strtoupper($kategori) }}</span>
                </div>
                @endif
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-white">{{ $wisata['nama'] }}</h3>
                    <div class="space-y-2 text-sm text-gray-300">
                        <div class="flex justify-between">
                            <span>📍 {{ $wisata['kota'] ?: 'Sumatera Utara' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="px-2 py-1 rounded text-xs
                                @if($kategori == 'alam') bg-emerald-500/20 text-emerald-300
                                @elseif($kategori == 'budaya') bg-amber-500/20 text-amber-300
                                @else bg-violet-500/20 text-violet-300
                                @endif">
                                {{ ucwords(str_replace('_', ' ', $wisata['kategori'])) }}
                            </span>
                            <span class="text-orange-300">{{ $wisata['harga_tiket'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination dengan style baru -->
        @if($totalPages > 1)
        <div class="mt-12">
            <!-- Style 3: Previous 1 2 3 ... 10 Next Page 1 of 14 -->
            <div class="flex flex-col items-center space-y-6">
                <!-- Navigation -->
                <div class="flex items-center justify-center space-x-2">
                    <!-- Previous Button -->
                    @if($currentPage > 1)
                    <a href="?page={{ $currentPage - 1 }}" class="pagination-btn group">
                        <span>Previous</span>
                    </a>
                    @else
                    <span class="pagination-btn-disabled">
                        <span>Previous</span>
                    </span>
                    @endif
                    
                    <!-- Page Numbers -->
                    <div class="flex items-center space-x-1">
                        @php
                            // Tampilkan maksimal 7 nomor halaman
                            $start = max(1, $currentPage - 3);
                            $end = min($totalPages, $start + 6);
                            $start = max(1, min($start, $totalPages - 6));
                        @endphp
                        
                        @if($start > 1)
                        <a href="?page=1" class="pagination-number">1</a>
                        @if($start > 2) <span class="pagination-ellipsis">...</span> @endif
                        @endif
                        
                        @for($i = $start; $i <= $end; $i++)
                            @if($i == $currentPage)
                            <span class="pagination-number-active">{{ $i }}</span>
                            @else
                            <a href="?page={{ $i }}" class="pagination-number">{{ $i }}</a>
                            @endif
                        @endfor
                        
                        @if($end < $totalPages)
                        @if($end < $totalPages - 1) <span class="pagination-ellipsis">...</span> @endif
                        <a href="?page={{ $totalPages }}" class="pagination-number">{{ $totalPages }}</a>
                        @endif
                    </div>
                    
                    <!-- Next Button -->
                    @if($currentPage < $totalPages)
                    <a href="?page={{ $currentPage + 1 }}" class="pagination-btn group">
                        <span>Next</span>
                    </a>
                    @else
                    <span class="pagination-btn-disabled">
                        <span>Next</span>
                    </span>
                    @endif
                </div>
                
                <!-- Page Info -->
                <div class="text-center">
                    <div class="inline-flex items-center space-x-2 bg-white/5 backdrop-blur-sm rounded-lg px-6 py-3 border border-white/10">
                        <span class="text-gray-300">Page</span>
                        <span class="text-white font-bold">{{ $currentPage }}</span>
                        <span class="text-gray-300">of</span>
                        <span class="text-white font-bold">{{ $totalPages }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Style 4 & 5: Dengan Go to page -->
            <div class="mt-8 pt-8 border-t border-white/10">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                    <!-- Total Items Info -->
                    <div class="text-gray-400 text-sm">
                        Showing {{ ($currentPage - 1) * $perPage + 1 }} to {{ min($currentPage * $perPage, count($allWisata)) }} of {{ count($allWisata) }} results
                    </div>
                    
                    <!-- Go to Page -->
                    <div class="flex items-center space-x-3">
                        <span class="text-gray-300 text-sm">Go to page:</span>
                        <div class="relative">
                            <input 
                                type="number" 
                                id="goToPage" 
                                min="1" 
                                max="{{ $totalPages }}" 
                                value="{{ $currentPage }}"
                                class="w-20 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg px-3 py-2 text-white text-center focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            <button 
                                onclick="goToPage()"
                                class="ml-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:opacity-90 transition-opacity"
                            >
                                Go
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Info jika hanya 1 halaman -->
        <div class="mt-8 text-center text-gray-400">
            <p>Showing all {{ count($allWisata) }} results</p>
        </div>
        @endif
    </section>
</div>

<!-- MODAL DINAMIS UNTUK ALAM -->
@foreach($wisataAlam as $index => $wisata)
<div id="modal-alam-{{ $index }}" class="fixed inset-0 bg-black/90 backdrop-blur-md z-50 hidden items-center justify-center p-4">
    <div class="glass-card rounded-3xl max-w-5xl w-full max-h-[90vh] overflow-y-auto border border-white/20">
        <div class="sticky top-0 glass-card border-b border-white/10 p-6 flex justify-between items-center">
            <h2 class="text-4xl font-black text-white">{{ $wisata['nama'] }}</h2>
            <button onclick="closeModal('modal-alam-{{ $index }}')" class="w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition">
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

<!-- MODAL DINAMIS UNTUK BUDAYA -->
@foreach($wisataBudaya as $index => $wisata)
<div id="modal-budaya-{{ $index }}" class="fixed inset-0 bg-black/90 backdrop-blur-md z-50 hidden items-center justify-center p-4">
    <div class="glass-card rounded-3xl max-w-5xl w-full max-h-[90vh] overflow-y-auto border border-white/20">
        <div class="sticky top-0 glass-card border-b border-white/10 p-6 flex justify-between items-center">
            <h2 class="text-4xl font-black text-white">{{ $wisata['nama'] }}</h2>
            <button onclick="closeModal('modal-budaya-{{ $index }}')" class="w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition">
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

<!-- MODAL DINAMIS UNTUK RELIGI -->
@foreach($wisataReligi as $index => $wisata)
<div id="modal-religi-{{ $index }}" class="fixed inset-0 bg-black/90 backdrop-blur-md z-50 hidden items-center justify-center p-4">
    <div class="glass-card rounded-3xl max-w-5xl w-full max-h-[90vh] overflow-y-auto border border-white/20">
        <div class="sticky top-0 glass-card border-b border-white/10 p-6 flex justify-between items-center">
            <h2 class="text-4xl font-black text-white">{{ $wisata['nama'] }}</h2>
            <button onclick="closeModal('modal-religi-{{ $index }}')" class="w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition">
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
    
    /* Pagination Styles */
    .pagination-btn {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .pagination-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .pagination-btn-disabled {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.3);
        padding: 0.5rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        cursor: not-allowed;
    }
    
    .pagination-number {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .pagination-number:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-1px);
    }
    
    .pagination-number-active {
        background: linear-gradient(135deg, #3b82f6, #6366f1);
        color: white;
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.375rem;
        font-weight: bold;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    .pagination-ellipsis {
        color: rgba(255, 255, 255, 0.5);
        padding: 0 0.5rem;
    }
    
    #goToPage::-webkit-inner-spin-button,
    #goToPage::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    #goToPage {
        -moz-appearance: textfield;
    }
</style>

<script>
    // Modal functions
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
            document.querySelectorAll('[id^="modal-"]').forEach(modal => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
            document.body.style.overflow = 'auto';
        }
    });

    // Close modal when clicking outside
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('fixed') && e.target.id.startsWith('modal-')) {
            closeModal(e.target.id);
        }
    });

    // Go to page function
    function goToPage() {
        const pageInput = document.getElementById('goToPage');
        const page = parseInt(pageInput.value);
        const totalPages = {{ $totalPages }};
        
        if (page >= 1 && page <= totalPages) {
            window.location.href = `?page=${page}`;
        } else {
            alert(`Please enter a page number between 1 and ${totalPages}`);
            pageInput.value = {{ $currentPage }};
            pageInput.focus();
        }
    }

    // Enter key support for go to page
    document.getElementById('goToPage')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            goToPage();
        }
    });
</script>

@endsection