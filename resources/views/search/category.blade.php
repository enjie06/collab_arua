{{-- resources/views/search/category.blade.php --}}
@extends('layouts.app')

@section('title', 'Wisata Kategori: ' . $category)

@section('content')
<div class="bg-[#0B1F33] min-h-screen">
    <section class="w-full py-20 px-16">
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2 text-white flex items-center">
                @if($category == 'alam')
                    <i class="fas fa-mountain mr-3 text-orange-400"></i>
                @elseif($category == 'budaya')
                    <i class="fas fa-landmark mr-3 text-orange-400"></i>
                @elseif($category == 'religi')
                    <i class="fas fa-place-of-worship mr-3 text-orange-400"></i>
                @else
                    <i class="fas fa-tag mr-3 text-orange-400"></i>
                @endif
                Kategori: {{ strtoupper($category) }}
            </h1>
            <p class="text-gray-300">Total {{ count($results) }} wisata dalam kategori ini</p>
        </div>

        @if(count($results) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($results as $result)
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden hover:bg-white/15 transition duration-300">
                        <div class="h-48 
                            @if($category == 'alam') bg-gradient-to-br from-green-500/80 to-blue-600/80
                            @elseif($category == 'budaya') bg-gradient-to-br from-yellow-500/80 to-red-600/80
                            @elseif($category == 'religi') bg-gradient-to-br from-purple-500/80 to-pink-600/80
                            @else bg-gradient-to-br from-gray-500/80 to-blue-600/80 @endif
                            flex items-center justify-center">
                            <i class="fas 
                                @if($category == 'alam') fa-mountain
                                @elseif($category == 'budaya') fa-landmark
                                @elseif($category == 'religi') fa-place-of-worship
                                @else fa-map-marker-alt @endif
                                text-white text-5xl">
                            </i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-3 text-white">{{ $result->label->getValue() }}</h3>
                            
                            <div class="space-y-2 text-sm text-gray-300">
                                <div class="flex justify-between">
                                    <span class="font-medium">Jenis:</span>
                                    <span>{{ $result->jenis->getValue() }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Kota:</span>
                                    <span>{{ $result->kota->getValue() }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Alamat:</span>
                                    <span class="text-right">{{ Str::limit($result->alamat->getValue(), 25) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10 p-12 max-w-md mx-auto">
                    <i class="fas fa-tag text-5xl text-gray-400 mb-4"></i>
                    <h3 class="text-xl font-semibold text-white mb-2">Belum ada wisata</h3>
                    <p class="text-gray-300">Tidak ada wisata dalam kategori "{{ $category }}" saat ini</p>
                </div>
            </div>
        @endif
    </section>
</div>
@endsection