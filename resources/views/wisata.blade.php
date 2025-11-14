@extends('layouts.main')
@section('content')

<h2 class="text-4xl font-bold text-center mb-12">Destinasi Wisata</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 px-10">

    @for($i = 1; $i <= 12; $i++)
        <div class="h-56 rounded-xl overflow-hidden border border-white/10 shadow-lg">
            <img src="/images/wisata{{ $i }}.jpg" class="w-full h-full object-cover">
        </div>
    @endfor

</div>

@endsection
