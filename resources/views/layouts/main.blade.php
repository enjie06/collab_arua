<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Arua Tourism' }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
    body {
        font-family: 'Inter', sans-serif;
    }

    /* GRADIENT BLUE OCEAN - Lebih smooth & visible */
    .gradient-bg {
        background: linear-gradient(180deg,
            #0B1929 0%,      /* Very Dark Navy - top */
            #152238 25%,     /* Dark Slate Blue */
            #1E3A5F 50%,     /* Deep Blue - tengah */
            #2C5282 75%,     /* Muted Blue */
            #3D5A7C 100%     /* Soft Blue - bottom */
        );
    }

    /* Atau mau diagonal yang lebih dramatis? */
    .gradient-bg-diagonal {
        background: linear-gradient(135deg,
            #0B1929 0%,
            #1E3A5F 30%,
            #2C5282 60%,
            #4A7BA7 100%
        );
    }

    /* Atau radial dari tengah? */
    .gradient-bg-radial {
        background: radial-gradient(ellipse at center,
            #2C5282 0%,
            #1E3A5F 40%,
            #152238 70%,
            #0B1929 100%
        );
    }

    /* Glass card tetap sama */
    .glass-card {
        backdrop-filter: blur(18px) saturate(150%);
        background-color: rgba(21, 34, 56, 0.45);
        border: 1px solid rgba(74, 123, 167, 0.15);
    }

    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
</head>

<body class="bg-slate-900 text-white">
    <nav class="backdrop-blur-md bg-white/10 border-b border-white/20 fixed top-0 left-0 w-full z-50">
        <div class="max-w-6xl mx-auto px-6 py-3 flex items-center justify-between">
            <h1 class="text-white text-xl font-bold tracking-wide">ARUA</h1>
            <ul class="flex gap-10 text-white font-medium absolute left-1/2 -translate-x-1/2">
                <li><a href="/" class="hover:text-gray-300 transition">Home</a></li>
                <li><a href="/wisata" class="hover:text-gray-300 transition">Wisata</a></li>
                <li><a href="/about" class="hover:text-gray-300 transition">About</a></li>
            </ul>
            <div class="w-32"></div>
        </div>
    </nav>

    <div class="pt-24">
        @yield('content')
    </div>
</body>
</html>