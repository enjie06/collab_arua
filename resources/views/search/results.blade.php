{{-- resources/views/search/results.blade.php --}}
@extends('layouts.app')

@section('title', 'Hasil Pencarian: ' . $keyword)

@section('content')
<section class="w-full py-20 px-16">
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2 text-white">Hasil Pencarian: "{{ $keyword }}"</h1>
        <p class="text-gray-300">Ditemukan {{ count($results) }} hasil untuk pencarian Anda</p>
    </div>

    @if(count($results) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($results as $result)
                <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 transition duration-300">
                    <div class="h-48 bg-gradient-to-br from-green-500/80 to-blue-600/80 flex items-center justify-center">
                        <i class="fas fa-mountain text-white text-5xl"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-white">{{ $result->label->getValue() }}</h3>
                        
                        <div class="space-y-2 text-sm text-gray-300">
                            <div class="flex justify-between">
                                <span class="font-medium">Jenis:</span>
                                <span>{{ $result->jenis->getValue() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Kategori:</span>
                                <span class="bg-orange-500/20 text-orange-300 px-2 py-1 rounded text-xs">
                                    {{ $result->kategori->getValue() }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Kota:</span>
                                <span>{{ $result->kota->getValue() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Alamat:</span>
                                <span class="text-right">{{ Str::limit($result->alamat->getValue(), 30) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10 p-12 max-w-md mx-auto">
                <i class="fas fa-search text-5xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-semibold text-white mb-2">Tidak ada hasil ditemukan</h3>
                <p class="text-gray-300 mb-6">Tidak ada wisata yang sesuai dengan pencarian "{{ $keyword }}"</p>
                <a href="/wisata/all" class="bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-lg font-semibold text-white inline-flex items-center gap-2 transition duration-200">
                    <i class="fas fa-list"></i> Lihat Semua Wisata
                </a>
            </div>
        </div>
    @endif
</section>
@endsection