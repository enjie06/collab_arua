{{-- resources/views/search/all.blade.php --}}
@extends('layouts.app')

@section('title', 'Semua Wisata Sumut')

@section('content')
<section class="w-full py-20 px-16">
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2 text-white">Semua Wisata Sumut</h1>
        <p class="text-gray-300">Jelajahi {{ count($results) }} destinasi wisata menakjubkan di Sumatera Utara</p>
    </div>

    @if(count($results) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($results as $result)
                <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 transition duration-300 group">
                    <div class="h-48 
                        @if(strtolower($result->kategori->getValue()) == 'alam') bg-gradient-to-br from-green-500/80 to-blue-600/80
                        @elseif(strtolower($result->kategori->getValue()) == 'budaya') bg-gradient-to-br from-yellow-500/80 to-red-600/80
                        @elseif(strtolower($result->kategori->getValue()) == 'religi') bg-gradient-to-br from-purple-500/80 to-pink-600/80
                        @else bg-gradient-to-br from-gray-500/80 to-blue-600/80 @endif
                        flex items-center justify-center group-hover:scale-105 transition duration-300">
                        <i class="fas 
                            @if(strtolower($result->kategori->getValue()) == 'alam') fa-mountain
                            @elseif(strtolower($result->kategori->getValue()) == 'budaya') fa-landmark
                            @elseif(strtolower($result->kategori->getValue()) == 'religi') fa-place-of-worship
                            @else fa-map-marker-alt @endif
                            text-white text-5xl">
                        </i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-white group-hover:text-blue-300 transition duration-200">
                            {{ $result->label->getValue() }}
                        </h3>
                        
                        <div class="space-y-2 text-sm text-gray-300">
                            <div class="flex justify-between items-center">
                                <span class="font-medium">Kategori:</span>
                                <span class="bg-orange-500/20 text-orange-300 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $result->kategori->getValue() }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Jenis:</span>
                                <span>{{ $result->jenis->getValue() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Kota:</span>
                                <span>{{ $result->kota->getValue() }}</span>
                            </div>
                            <div class="pt-2 border-t border-white/10">
                                <p class="text-xs text-gray-400 truncate" title="{{ $result->alamat->getValue() }}">
                                    {{ $result->alamat->getValue() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10 p-12 max-w-md mx-auto">
                <i class="fas fa-map-marked-alt text-5xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-semibold text-white mb-2">Belum ada data wisata</h3>
                <p class="text-gray-300">Data wisata sedang dalam pengembangan</p>
            </div>
        </div>
    @endif
</section>
@endsection