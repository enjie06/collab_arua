<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata Sumatera Utara</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-[#0B1F33] text-white">

    <section class="w-full py-20 px-16">

        <h2 class="text-4xl font-bold mb-12 text-center">Wisata Sumatera Utara</h2>

        <!-- GRID FOTO -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

            @for($i = 13; $i <= 24; $i++)
                <div class="w-full h-56 bg-white/5 rounded-xl overflow-hidden border border-white/10 shadow-lg">
                    <img src="/images/wisata{{ $i }}.jpg"
                         class="w-full h-full object-cover"
                         alt="Foto Wisata {{ $i }}">
                </div>
            @endfor

        </div>

        <!-- PAGINATION -->
        <div class="flex justify-center mt-12 gap-4 text-lg">

            <a href="/" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg">1</a>

            <a href="/wisata/page2" class="px-4 py-2 bg-blue-600 rounded-lg">2</a>

            <a href="/wisata/page3" 
               class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg">
               3
            </a>

            <a href="/wisata/page4" 
               class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg">
               4
            </a>

        </div>

    </section>

</body>
</html>
