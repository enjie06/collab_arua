@extends('layouts.app')

@section('title', 'Server Error')

@section('content')
<section class="w-full py-20 px-16">
    <div class="text-center py-12">
        <div class="bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10 p-12 max-w-md mx-auto">
            <i class="fas fa-exclamation-triangle text-5xl text-yellow-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-white mb-2">Server Sedang Bermasalah</h3>
            <p class="text-gray-300 mb-6">{{ $message ?? 'Terjadi kesalahan pada server RDF.' }}</p>
            
            <div class="space-y-3">
                <a href="/" class="bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-lg font-semibold text-white inline-flex items-center gap-2 transition duration-200 w-full justify-center">
                    <i class="fas fa-home"></i> Kembali ke Home
                </a>
                <a href="/wisata" class="bg-gray-600 hover:bg-gray-700 px-6 py-2 rounded-lg font-semibold text-white inline-flex items-center gap-2 transition duration-200 w-full justify-center">
                    <i class="fas fa-arrow-left"></i> Kembali ke Wisata
                </a>
            </div>
            
            <p class="text-xs text-gray-400 mt-6">
                Jika masalah berlanjut, hubungi administrator.
            </p>
        </div>
    </div>
</section>
@endsection