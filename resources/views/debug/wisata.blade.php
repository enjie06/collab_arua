@extends('layouts.main')
@section('content')

<div class="min-h-screen pt-24 p-8">
    <h1 class="text-3xl font-bold mb-6">Debug Wisata Data</h1>
    
    <div class="grid grid-cols-3 gap-6 mb-8">
        <div class="bg-blue-500/20 p-4 rounded-lg">
            <h2 class="text-xl font-bold">Total Wisata</h2>
            <p class="text-3xl">{{ count($allWisata) }}</p>
        </div>
        <div class="bg-green-500/20 p-4 rounded-lg">
            <h2 class="text-xl font-bold">Alam</h2>
            <p class="text-3xl">{{ count($wisataAlam) }}</p>
        </div>
        <div class="bg-yellow-500/20 p-4 rounded-lg">
            <h2 class="text-xl font-bold">Budaya</h2>
            <p class="text-3xl">{{ count($wisataBudaya) }}</p>
        </div>
    </div>
    
    <h2 class="text-2xl font-bold mb-4">Sample Data Alam</h2>
    @if(count($wisataAlam) > 0)
        <div class="bg-white/10 p-4 rounded-lg mb-6">
            <pre class="text-sm">{{ json_encode($wisataAlam[0], JSON_PRETTY_PRINT) }}</pre>
        </div>
        
        <h2 class="text-2xl font-bold mb-4">Card Preview</h2>
        <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden max-w-sm">
            @if($wisataAlam[0]['gambar'])
            <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $wisataAlam[0]['gambar'] }}')"></div>
            @else
            <div class="h-48 bg-gradient-to-br from-emerald-400 via-teal-500 to-blue-600 flex items-center justify-center">
                <span class="text-white text-xl font-bold">{{ strtoupper($wisataAlam[0]['kategori']) }}</span>
            </div>
            @endif
            <div class="p-6">
                <h3 class="text-xl font-bold mb-3 text-white">{{ $wisataAlam[0]['nama'] }}</h3>
                <div class="space-y-2 text-sm text-gray-300">
                    <div class="flex justify-between">
                        <span>📍 {{ $wisataAlam[0]['kota'] ?: 'Sumatera Utara' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="bg-emerald-500/20 text-emerald-300 px-2 py-1 rounded text-xs">
                            {{ ucwords(str_replace('_', ' ', $wisataAlam[0]['kategori'])) }}
                        </span>
                        <span class="text-orange-300">{{ $wisataAlam[0]['harga_tiket'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p class="text-red-300">No alam data!</p>
    @endif
    
    <div class="mt-8">
        <a href="/wisata" class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-lg text-white font-semibold">
            Back to Wisata Page
        </a>
    </div>
</div>

@endsection