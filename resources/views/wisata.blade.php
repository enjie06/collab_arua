@extends('layouts.main')
@section('content')

<section class="w-full py-20 px-8 md:px-16">

  <!-- Kategori ALAM -->
  <div class="mb-16">
    <h2 class="text-2xl font-bold mb-8 text-white">
        ALAM
        
        <!-- Swipeable Container -->
        <div class="overflow-x-auto scrollbar-hide">
            <div class="flex gap-6 pb-4 min-w-max">
                <!-- Card Alam 1 -->
                <div class="carousel-item">
                    <div onclick="openModal('modal-alam-1')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 w-80 flex-shrink-0 cursor-pointer">
                    <div class="h-48 bg-gradient-to-br from-green-500/80 to-blue-600/80 flex items-center justify-center">
                        <i class="fas fa-image text-white text-5xl"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-white">Danau Toba</h3>
                        <div class="flex justify-between text-sm text-gray-300">
                            <span>📍 Sumatera Utara</span>
                        </div>
                    </div>
                    </div>
                </div>

                <!-- Card Alam 2 -->
                <div class="carousel-item">
                    <div onclick="openModal('modal-alam-2')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 w-80 flex-shrink-0 cursor-pointer">
                    <div class="h-48 bg-gradient-to-br from-green-500/80 to-blue-600/80 flex items-center justify-center">
                        <i class="fas fa-image text-white text-5xl"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-white">Air Terjun Sipiso-piso</h3>
                        <div class="flex justify-between text-sm text-gray-300">
                            <span>📍 Tongging</span>
                        </div>
                    </div>
                    </div>
                </div>

                <!-- Card Alam 3 -->
                <div class="carousel-item">
                    <div onclick="openModal('modal-alam-3')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 w-80 flex-shrink-0 cursor-pointer">
                    <div class="h-48 bg-gradient-to-br from-green-500/80 to-blue-600/80 flex items-center justify-center">
                        <i class="fas fa-image text-white text-5xl"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-white">Bukit Lawang</h3>
                        <div class="flex justify-between text-sm text-gray-300">
                            <span>📍 Langkat</span>
                        </div>
                    </div>
                    </div>
                </div>

                <!-- Card Alam 4 -->
                <div class="carousel-item">
                    <div onclick="openModal('modal-alam-4')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 w-80 flex-shrink-0 cursor-pointer">
                    <div class="h-48 bg-gradient-to-br from-green-500/80 to-blue-600/80 flex items-center justify-center">
                        <i class="fas fa-image text-white text-5xl"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-white">Pantai Parbaba</h3>
                        <div class="flex justify-between text-sm text-gray-300">
                            <span>📍 Samosir</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!-- Kategori BUDAYA -->
    <div class="mb-16">
    <h2 class="text-2xl font-bold mb-8 text-white">
        BUDAYA
    </h2>
        
        <!-- Swipeable Container -->
        <div class="overflow-x-auto scrollbar-hide">
            <div class="flex gap-6 pb-4 min-w-max">
                <!-- Card Budaya 1 -->
                <div class="carousel-item">
                    <div onclick="openModal('modal-budaya-1')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 w-80 flex-shrink-0 cursor-pointer">
                        <div class="h-48 bg-gradient-to-br from-yellow-500/80 to-red-600/80 flex items-center justify-center">
                            <i class="fas fa-image text-white text-5xl"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-3 text-white">Istana Maimun</h3>
                            <div class="flex justify-between text-sm text-gray-300">
                                <span>📍 Medan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Budaya 2 -->
                <div class="carousel-item">
                    <div onclick="openModal('modal-budaya-2')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 w-80 flex-shrink-0 cursor-pointer">
                        <div class="h-48 bg-gradient-to-br from-yellow-500/80 to-red-600/80 flex items-center justify-center">
                            <i class="fas fa-image text-white text-5xl"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-3 text-white">Rumah Bolon</h3>
                            <div class="flex justify-between text-sm text-gray-300">
                                <span>📍 Balige</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Budaya 3 -->
                <div class="carousel-item">
                    <div onclick="openModal('modal-budaya-3')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 w-80 flex-shrink-0 cursor-pointer">
                        <div class="h-48 bg-gradient-to-br from-yellow-500/80 to-red-600/80 flex items-center justify-center">
                            <i class="fas fa-image text-white text-5xl"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-3 text-white">Museum Negeri Sumut</h3>
                            <div class="flex justify-between text-sm text-gray-300">
                                <span>📍 Medan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Budaya 4 -->
                <div class="carousel-item">
                    <div onclick="openModal('modal-budaya-4')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 w-80 flex-shrink-0 cursor-pointer">
                        <div class="h-48 bg-gradient-to-br from-yellow-500/80 to-red-600/80 flex items-center justify-center">
                            <i class="fas fa-image text-white text-5xl"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-3 text-white">Kampung Naga</h3>
                            <div class="flex justify-between text-sm text-gray-300">
                                <span>📍 Tasikmalaya</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!-- Kategori RELIGI -->
  <div class="mb-16">
    <h2 class="text-2xl font-bold mb-8 text-white">
        RELIGI
    </h2>
        
        <!-- Swipeable Container -->
        <div class="overflow-x-auto scrollbar-hide">
            <div class="flex gap-6 pb-4 min-w-max">
                <!-- Card Religi 1 -->
                <div class="carousel-item">
                    <div onclick="openModal('modal-religi-1')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 w-80 flex-shrink-0 cursor-pointer">
                        <div class="h-48 bg-gradient-to-br from-purple-500/80 to-pink-600/80 flex items-center justify-center">
                            <i class="fas fa-image text-white text-5xl"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-3 text-white">Masjid Raya Medan</h3>
                            <div class="flex justify-between text-sm text-gray-300">
                                <span>📍 Medan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Religi 2 -->
                <div class="carousel-item">
                    <div onclick="openModal('modal-religi-2')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 w-80 flex-shrink-0 cursor-pointer">
                        <div class="h-48 bg-gradient-to-br from-purple-500/80 to-pink-600/80 flex items-center justify-center">
                            <i class="fas fa-image text-white text-5xl"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-3 text-white">Vihara Gunung Timur</h3>
                            <div class="flex justify-between text-sm text-gray-300">
                                <span>📍 Medan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Religi 3 -->
                <div class="carousel-item">
                    <div onclick="openModal('modal-religi-3')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 w-80 flex-shrink-0 cursor-pointer">
                        <div class="h-48 bg-gradient-to-br from-purple-500/80 to-pink-600/80 flex items-center justify-center">
                            <i class="fas fa-image text-white text-5xl"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-3 text-white">Gereja Graha Maria Annai Velangkanni</h3>
                            <div class="flex justify-between text-sm text-gray-300">
                                <span>📍 Medan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Religi 4 -->
                <div class="carousel-item">
                    <div onclick="openModal('modal-religi-4')" class="carousel-card bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 hover:scale-105 transition-all duration-300 w-80 flex-shrink-0 cursor-pointer">
                        <div class="h-48 bg-gradient-to-br from-purple-500/80 to-pink-600/80 flex items-center justify-center">
                            <i class="fas fa-image text-white text-5xl"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-3 text-white">Kuil Shri Mariamman</h3>
                            <div class="flex justify-between text-sm text-gray-300">
                                <span>📍 Medan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<!-- MODAL TEMPLATE - Contoh untuk Danau Toba -->
<div id="modal-alam-1" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-gray-900 rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto border border-white/20">
        <!-- Header -->
        <div class="sticky top-0 bg-gray-900/95 backdrop-blur-sm border-b border-white/10 p-6 flex justify-between items-center">
            <h2 class="text-3xl font-bold text-white">Danau Toba</h2>
            <button onclick="closeModal('modal-alam-1')" class="text-gray-400 hover:text-white transition">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <!-- Content -->
        <div class="p-6 space-y-6">
            <!-- Image Placeholder -->
            <div class="w-full h-64 bg-gradient-to-br from-green-500/80 to-blue-600/80 rounded-xl flex items-center justify-center">
                <i class="fas fa-image text-white text-6xl"></i>
            </div>

            <!-- Info Detail -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 text-gray-300">
                    <i class="fas fa-map-marker-alt text-orange-400"></i>
                    <span>Sumatera Utara, Indonesia</span>
                </div>
                
                <div class="flex items-center gap-3 text-gray-300">
                    <i class="fas fa-tag text-orange-400"></i>
                    <span>Kategori: Alam</span>
                </div>

                <!-- Description -->
                <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                    <h3 class="text-xl font-bold text-white mb-2">Deskripsi</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Danau Toba adalah danau vulkanik terbesar di Indonesia dan Asia Tenggara. 
                        Tempat ini menawarkan pemandangan yang spektakuler dengan Pulau Samosir di tengahnya.
                        <!-- Backend bisa isi deskripsi lengkap di sini -->
                    </p>
                </div>

                <!-- Google Maps Placeholder -->
                <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                    <h3 class="text-xl font-bold text-white mb-4">Lokasi di Peta</h3>
                    <div class="w-full h-64 bg-gray-800 rounded-lg flex items-center justify-center border border-white/20">
                        <div class="text-center">
                            <i class="fas fa-map text-orange-400 text-5xl mb-3"></i>
                            <p class="text-gray-400">Google Maps akan ditampilkan di sini</p>
                            <p class="text-sm text-gray-500 mt-2">Backend: Integrasikan Google Maps API</p>
                        </div>
                    </div>
                </div>

                <!-- Facilities -->
                <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                    <h3 class="text-xl font-bold text-white mb-3">Fasilitas</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <div class="flex items-center gap-2 text-gray-300">
                            <i class="fas fa-parking text-orange-400"></i>
                            <span>Parkir</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-300">
                            <i class="fas fa-utensils text-orange-400"></i>
                            <span>Restoran</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-300">
                            <i class="fas fa-hotel text-orange-400"></i>
                            <span>Hotel</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-300">
                            <i class="fas fa-camera text-orange-400"></i>
                            <span>Spot Foto</span>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                        <h4 class="font-bold text-white mb-2">Jam Operasional</h4>
                        <p class="text-gray-300">Buka 24 Jam</p>
                    </div>
                    <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                        <h4 class="font-bold text-white mb-2">Harga Tiket</h4>
                        <p class="text-gray-300">Gratis - Rp 50.000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan modal untuk card lainnya dengan ID berbeda: modal-alam-2, modal-budaya-1, dst -->
<!-- Copy struktur modal di atas dan ganti ID + kontennya -->

<!-- Custom CSS & JavaScript -->
<style>
    /* Hide scrollbar tapi tetap bisa scroll */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
        scroll-behavior: smooth;
    }
</style>

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden'; // Prevent background scroll
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto'; // Restore scroll
        }
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('bg-black/80')) {
            const modals = document.querySelectorAll('[id^="modal-"]');
            modals.forEach(modal => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
            document.body.style.overflow = 'auto';
        }
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modals = document.querySelectorAll('[id^="modal-"]');
            modals.forEach(modal => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
            document.body.style.overflow = 'auto';
        }
    });
</script>

@endsection