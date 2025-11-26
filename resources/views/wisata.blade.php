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
                Jelajahi Sumatera Utara
            </h1>
            <p class="text-lg md:text-xl text-white/90">
                Temukan destinasi wisata impian Anda dengan teknologi Web Semantik
            </p>
        </div>
    </section>

    <!-- Filter Tabs -->
    <section class="max-w-7xl mx-auto px-4 mb-12">
        <div class="flex gap-4 overflow-x-auto scrollbar-hide pb-2">
            <button onclick="showCategory('semua')" id="tab-semua" class="tab-btn group px-8 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-full whitespace-nowrap hover:scale-105 transition-all duration-300 shadow-lg">
                Semua
            </button>
            <button onclick="showCategory('alam')" id="tab-alam" class="tab-btn group px-8 py-4 glass-card text-white font-bold rounded-full whitespace-nowrap hover:scale-105 hover:bg-white/20 transition-all duration-300">
                Alam
            </button>
            <button onclick="showCategory('budaya')" id="tab-budaya" class="tab-btn group px-8 py-4 glass-card text-white font-bold rounded-full whitespace-nowrap hover:scale-105 hover:bg-white/20 transition-all duration-300">
                Budaya
            </button>
            <button onclick="showCategory('religi')" id="tab-religi" class="tab-btn group px-8 py-4 glass-card text-white font-bold rounded-full whitespace-nowrap hover:scale-105 hover:bg-white/20 transition-all duration-300">
                Religi
            </button>
        </div>
    </section>

    <!-- Kategori SEMUA (default tampil) -->
    <section id="category-semua" class="category-content max-w-7xl mx-auto px-4 mb-20">
        <h2 class="text-4xl font-black text-white mb-4">SEMUA DESTINASI</h2>
        <p class="text-gray-400 mb-8">Jelajahi semua kategori wisata</p>
        
        <!-- Grid untuk semua destinasi -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Destinasi Alam -->
            <div onclick="openModal('modal-alam-1')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-emerald-400 via-teal-500 to-blue-600 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">DANAU TOBA</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-white">Danau Toba</h3>
                    <div class="flex justify-between text-sm text-gray-300">
                        <span>📍 Kabupaten Simalungun</span>
                    </div>
                </div>
            </div>

            <div onclick="openModal('modal-alam-2')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-emerald-400 via-teal-500 to-blue-600 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">AIR TERJUN</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-white">Air Terjun Sipiso-piso</h3>
                    <div class="flex justify-between text-sm text-gray-300">
                        <span>📍 Tongging</span>
                    </div>
                </div>
            </div>

            <!-- Destinasi Budaya -->
            <div onclick="openModal('modal-budaya-1')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-amber-400 via-orange-500 to-red-600 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">ISTANA</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-white">Istana Maimun</h3>
                    <div class="flex justify-between text-sm text-gray-300">
                        <span>📍 Medan</span>
                    </div>
                </div>
            </div>

            <div onclick="openModal('modal-budaya-2')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-amber-400 via-orange-500 to-red-600 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">RUMAH BOLON</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-white">Rumah Bolon</h3>
                    <div class="flex justify-between text-sm text-gray-300">
                        <span>📍 Balige</span>
                    </div>
                </div>
            </div>

            <!-- Destinasi Religi -->
            <div onclick="openModal('modal-religi-1')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-violet-400 via-purple-500 to-fuchsia-600 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">MASJID</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-white">Masjid Raya Medan</h3>
                    <div class="flex justify-between text-sm text-gray-300">
                        <span>📍 Medan</span>
                    </div>
                </div>
            </div>

            <div onclick="openModal('modal-religi-2')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-violet-400 via-purple-500 to-fuchsia-600 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">VIHARA</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-white">Vihara Gunung Timur</h3>
                    <div class="flex justify-between text-sm text-gray-300">
                        <span>📍 Medan</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kategori ALAM -->
    <section id="category-alam" class="category-content hidden max-w-7xl mx-auto px-4 mb-20">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-4xl font-black text-white">ALAM</h2>
                <p class="text-gray-400 mt-2">Keindahan alam yang memukau</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card Alam 1 - Danau Toba -->
            <div onclick="openModal('modal-alam-1')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-emerald-400 via-teal-500 to-blue-600 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">DANAU TOBA</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-white">Danau Toba</h3>
                    <div class="flex justify-between text-sm text-gray-300">
                        <span>📍 Kabupaten Simalungun</span>
                    </div>
                </div>
            </div>

            <!-- Card Alam 2 -->
            <div onclick="openModal('modal-alam-2')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-emerald-400 via-teal-500 to-blue-600 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">AIR TERJUN</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-white">Air Terjun Sipiso-piso</h3>
                    <div class="flex justify-between text-sm text-gray-300">
                        <span>📍 Tongging</span>
                    </div>
                </div>
            </div>

            <!-- Card Alam 3 -->
            <div onclick="openModal('modal-alam-3')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-emerald-400 via-teal-500 to-blue-600 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">BUKIT LAWANG</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-white">Bukit Lawang</h3>
                    <div class="flex justify-between text-sm text-gray-300">
                        <span>📍 Langkat</span>
                    </div>
                </div>
            </div>

            <!-- Card Alam 4 -->
            <div onclick="openModal('modal-alam-4')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-emerald-400 via-teal-500 to-blue-600 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">PANTAI</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-white">Pantai Parbaba</h3>
                    <div class="flex justify-between text-sm text-gray-300">
                        <span>📍 Samosir</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kategori BUDAYA -->
    <section id="category-budaya" class="category-content hidden max-w-7xl mx-auto px-4 mb-20">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-4xl font-black text-white">BUDAYA</h2>
                <p class="text-gray-400 mt-2">Warisan budaya yang kaya</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card Budaya 1 -->
            <div onclick="openModal('modal-budaya-1')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-amber-400 via-orange-500 to-red-600 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">ISTANA</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-white">Istana Maimun</h3>
                    <div class="flex justify-between text-sm text-gray-300">
                        <span>📍 Medan</span>
                    </div>
                </div>
            </div>

            <!-- Card Budaya 2 -->
            <div onclick="openModal('modal-budaya-2')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-amber-400 via-orange-500 to-red-600 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">RUMAH BOLON</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-white">Rumah Bolon</h3>
                    <div class="flex justify-between text-sm text-gray-300">
                        <span>📍 Balige</span>
                    </div>
                </div>
            </div>

            <!-- Card Budaya 3 -->
            <div onclick="openModal('modal-budaya-3')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-amber-400 via-orange-500 to-red-600 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">MUSEUM</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-white">Museum Negeri Sumut</h3>
                    <div class="flex justify-between text-sm text-gray-300">
                        <span>📍 Medan</span>
                    </div>
                </div>
            </div>

            <!-- Card Budaya 4 -->
            <div onclick="openModal('modal-budaya-4')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-amber-400 via-orange-500 to-red-600 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">KAMPUNG</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-white">Kampung Naga</h3>
                    <div class="flex justify-between text-sm text-gray-300">
                        <span>📍 Tasikmalaya</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kategori RELIGI -->
    <section id="category-religi" class="category-content hidden max-w-7xl mx-auto px-4 mb-20">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-4xl font-black text-white">RELIGI</h2>
                <p class="text-gray-400 mt-2">Tempat ibadah yang sakral</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card Religi 1 -->
            <div onclick="openModal('modal-religi-1')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-violet-400 via-purple-500 to-fuchsia-600 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">MASJID</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-white">Masjid Raya Medan</h3>
                    <div class="flex justify-between text-sm text-gray-300">
                        <span>📍 Medan</span>
                    </div>
                </div>
            </div>

            <!-- Card Religi 2 -->
            <div onclick="openModal('modal-religi-2')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-violet-400 via-purple-500 to-fuchsia-600 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">VIHARA</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-white">Vihara Gunung Timur</h3>
                    <div class="flex justify-between text-sm text-gray-300">
                        <span>📍 Medan</span>
                    </div>
                </div>
            </div>

            <!-- Card Religi 3 -->
            <div onclick="openModal('modal-religi-3')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-violet-400 via-purple-500 to-fuchsia-600 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">GEREJA</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-white">Gereja Graha Maria</h3>
                    <div class="flex justify-between text-sm text-gray-300">
                        <span>📍 Medan</span>
                    </div>
                </div>
            </div>

            <!-- Card Religi 4 -->
            <div onclick="openModal('modal-religi-4')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="h-48 bg-gradient-to-br from-violet-400 via-purple-500 to-fuchsia-600 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">KUIL</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-white">Kuil Shri Mariamman</h3>
                    <div class="flex justify-between text-sm text-gray-300">
                        <span>📍 Medan</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Danau Toba -->
<div id="modal-alam-1" class="fixed inset-0 bg-black/90 backdrop-blur-md z-50 hidden items-center justify-center p-4">
    <div class="glass-card rounded-3xl max-w-5xl w-full max-h-[90vh] overflow-y-auto border border-white/20">
        <div class="sticky top-0 glass-card border-b border-white/10 p-6 flex justify-between items-center">
            <h2 class="text-4xl font-black text-white">Danau Toba</h2>
            <button onclick="closeModal('modal-alam-1')" class="w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition">
                <span class="text-xl">×</span>
            </button>
        </div>
        <div class="p-8">
            <div class="w-full h-96 bg-gradient-to-br from-emerald-400 via-teal-500 to-blue-600 rounded-2xl flex items-center justify-center mb-8">
                <span class="text-white text-4xl font-bold">DANAU TOBA</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white/10 rounded-xl p-4">
                    <h3 class="text-white font-bold mb-2">Jenis Wisata</h3>
                    <p class="text-gray-300">Alam</p>
                </div>
                <div class="bg-white/10 rounded-xl p-4">
                    <h3 class="text-white font-bold mb-2">Kategori</h3>
                    <p class="text-gray-300">Danau</p>
                </div>
                <div class="bg-white/10 rounded-xl p-4">
                    <h3 class="text-white font-bold mb-2">Harga Tiket</h3>
                    <p class="text-gray-300">Gratis</p>
                </div>
                <div class="bg-white/10 rounded-xl p-4">
                    <h3 class="text-white font-bold mb-2">Jam Operasional</h3>
                    <p class="text-gray-300">24 Jam</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="bg-white/10 rounded-xl p-6">
                    <h3 class="text-white font-bold mb-4 text-xl">Informasi Lokasi</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-300">Alamat:</span>
                            <span class="text-white font-medium">Parapat, Kabupaten Simalungun</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Kabupaten:</span>
                            <span class="text-white font-medium">Kabupaten Simalungun</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Provinsi:</span>
                            <span class="text-white font-medium">Sumatera Utara</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Koordinat:</span>
                            <span class="text-white font-medium">2.6096° N, 98.9289° E</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 rounded-xl p-6">
                    <h3 class="text-white font-bold mb-4 text-xl">Fasilitas & Aktivitas</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-gray-300">Fasilitas:</span>
                            <p class="text-white font-medium">Parkir, Penginapan, Restoran, Toilet</p>
                        </div>
                        <div>
                            <span class="text-gray-300">Aktivitas:</span>
                            <p class="text-white font-medium">Berenang, Berlayar, Foto, Wisata Alam</p>
                        </div>
                        <div>
                            <span class="text-gray-300">Dekat Dengan:</span>
                            <p class="text-white font-medium">Pulau Samosir</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white/10 rounded-xl p-6">
                <h3 class="text-white font-bold mb-4 text-xl">Deskripsi</h3>
                <p class="text-gray-300 text-lg leading-relaxed">
                    Danau Toba adalah danau vulkanik terbesar di Indonesia dan Asia Tenggara, serta danau terbesar kedua di dunia setelah Danau Victoria di Afrika. 
                    Danau ini terbentuk dari letusan gunung berapi super sekitar 74.000 tahun yang lalu. Dengan luas lebih dari 1.145 kilometer persegi dan kedalaman mencapai 450 meter, 
                    Danau Toba menawarkan pemandangan alam yang menakjubkan dengan Pulau Samosir di tengahnya. Destinasi ini menjadi salah satu ikon wisata Sumatera Utara 
                    yang menawarkan berbagai aktivitas wisata alam dan budaya.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Modal lainnya bisa ditambahkan dengan struktur yang sama -->

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
    
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
</style>

<script>
    // Tab Switching Function
    function showCategory(category) {
        // Hide all categories
        document.querySelectorAll('.category-content').forEach(section => {
            section.classList.add('hidden');
        });
        
        // Show selected category
        document.getElementById('category-' + category).classList.remove('hidden');
        
        // Update tab styles
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-gradient-to-r', 'from-emerald-500', 'to-teal-600', 'from-amber-500', 'to-orange-600', 'from-violet-500', 'to-purple-600', 'from-blue-500', 'to-indigo-600');
            btn.classList.add('glass-card');
        });
        
        // Highlight active tab
        const activeTab = document.getElementById('tab-' + category);
        activeTab.classList.remove('glass-card');
        
        if (category === 'alam') {
            activeTab.classList.add('bg-gradient-to-r', 'from-emerald-500', 'to-teal-600');
        } else if (category === 'budaya') {
            activeTab.classList.add('bg-gradient-to-r', 'from-amber-500', 'to-orange-600');
        } else if (category === 'religi') {
            activeTab.classList.add('bg-gradient-to-r', 'from-violet-500', 'to-purple-600');
        } else if (category === 'semua') {
            activeTab.classList.add('bg-gradient-to-r', 'from-blue-500', 'to-indigo-600');
        }
    }

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
</script>

@endsection