@extends('layouts.app')

@section('title', 'Hasil Pencarian: ' . $keyword)

@section('content')
<div class="bg-[#0B1F33] min-h-screen">
    <section class="w-full py-20 px-16">
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2 text-white">Hasil Pencarian: "{{ $keyword }}"</h1>
            <p class="text-gray-300">Ditemukan {{ count($results) }} hasil untuk pencarian Anda</p>
        </div>

        @if(count($results) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($results as $result)
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 transition duration-300 hover:shadow-2xl">
                        <!-- Gradient Header berdasarkan Kategori -->
                        <div class="h-48 
                            @if(strtolower($result->kategori->getValue()) == 'pantai') bg-gradient-to-br from-blue-500/80 to-teal-600/80
                            @elseif(strtolower($result->kategori->getValue()) == 'alam') bg-gradient-to-br from-green-500/80 to-emerald-600/80
                            @elseif(strtolower($result->kategori->getValue()) == 'budaya') bg-gradient-to-br from-yellow-500/80 to-orange-600/80
                            @elseif(strtolower($result->kategori->getValue()) == 'religi') bg-gradient-to-br from-purple-500/80 to-pink-600/80
                            @else bg-gradient-to-br from-gray-500/80 to-blue-600/80 @endif
                            flex items-center justify-center relative overflow-hidden">
                            
                            <!-- Icon berdasarkan kategori -->
                            <div class="text-white text-6xl opacity-80">
                                @if(strtolower($result->kategori->getValue()) == 'pantai') 🏖️
                                @elseif(strtolower($result->kategori->getValue()) == 'alam') 🏞️
                                @elseif(strtolower($result->kategori->getValue()) == 'budaya') 🏛️
                                @elseif(strtolower($result->kategori->getValue()) == 'religi') ⛪
                                @else 🗺️
                                @endif
                            </div>
                            
                            <!-- Badge Kategori -->
                            <div class="absolute top-4 right-4 bg-black/30 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-semibold border border-white/20">
                                {{ $result->kategori->getValue() }}
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-3 text-white hover:text-blue-300 transition duration-200">
                                {{ $result->label->getValue() }}
                            </h3>
                            
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-300 font-medium">Jenis Wisata:</span>
                                    <span class="text-white bg-blue-500/20 px-2 py-1 rounded text-xs">{{ $result->jenis->getValue() }}</span>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-300 font-medium">Lokasi:</span>
                                    <span class="text-white text-right">{{ $result->kota->getValue() }}</span>
                                </div>
                                
                                <div class="pt-2 border-t border-white/10">
                                    <p class="text-gray-400 text-xs" title="{{ $result->alamat->getValue() }}">
                                        📍 {{ Str::limit($result->alamat->getValue(), 40) }}
                                    </p>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex gap-2 pt-3">
                                    <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded-lg text-xs font-semibold transition duration-200 flex items-center justify-center gap-1">
                                        <span>🔍</span> Detail
                                    </button>
                                    <button class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded-lg text-xs font-semibold transition duration-200 flex items-center justify-center gap-1">
                                        <span>📌</span> Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination Info -->
            <div class="mt-8 text-center">
                <p class="text-gray-400 text-sm">
                    Menampilkan {{ count($results) }} hasil pencarian
                </p>
            </div>
        @else
            <div class="text-center py-12">
                <div class="bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10 p-12 max-w-md mx-auto">
                    <div class="text-6xl mb-4">🔍</div>
                    <h3 class="text-xl font-semibold text-white mb-2">Tidak ada hasil ditemukan</h3>
                    <p class="text-gray-300 mb-6">Tidak ada wisata yang sesuai dengan pencarian "{{ $keyword }}"</p>
                    <div class="space-y-3">
                        <a href="/wisata/all" class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-lg font-semibold text-white inline-flex items-center gap-2 transition duration-200 w-full justify-center">
                            <span>🗺️</span> Lihat Semua Wisata
                        </a>
                        <a href="/wisata" class="bg-gray-600 hover:bg-gray-700 px-6 py-3 rounded-lg font-semibold text-white inline-flex items-center gap-2 transition duration-200 w-full justify-center">
                            <span>↶</span> Kembali ke Wisata
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </section>
</div>

<!-- Tambahkan Font Awesome untuk icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }
    ::-webkit-scrollbar-track {
        background: rgba(255,255,255,0.1);
    }
    ::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.3);
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: rgba(255,255,255,0.5);
    }
</style>
@endsection