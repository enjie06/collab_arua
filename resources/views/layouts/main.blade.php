<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Arua Tourism' }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <!-- Tambahkan Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-[#0B1F33] text-white">

    <!-- NAVBAR -->
    <nav class="backdrop-blur-md bg-white/10 border-b border-white/20 fixed top-0 left-0 w-full z-50">
        <div class="max-w-6xl mx-auto px-6 py-3 flex items-center justify-between">

            <!-- Logo kiri -->
            <h1 class="text-white text-xl font-bold tracking-wide">
                ARUA
            </h1>

            <!-- Menu tengah -->
            <ul class="flex gap-10 text-white font-medium absolute left-1/2 -translate-x-1/2">
                <li><a href="/" class="hover:text-gray-300 transition">Home</a></li>
                <li><a href="/wisata" class="hover:text-gray-300 transition">Wisata</a></li>
                <li><a href="/about" class="hover:text-gray-300 transition">About</a></li>
            </ul>

            <div class="w-32"></div>
        </div>
    </nav>

    <!-- HALAMAN -->
    <div class="pt-24">
        @yield('content')
    </div>

</body>
</html>