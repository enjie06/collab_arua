<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Wisata Sumut</title>
    
    <!-- Pastikan CSS dan JS load -->
    @vite(['resources/css/app.css','resources/js/app.js'])
    
    <!-- Fallback jika Vite tidak work -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-[#0B1F33]">
    @include('layouts.navbar')
    
    <main>
        @yield('content')
    </main>
    
    @include('layouts.footer')
    
    <script src="{{ asset('js/script.js') }}"></script>
    @yield('scripts')
</body>
</html>