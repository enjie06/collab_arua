<nav class="backdrop-blur-md bg-white/10 border-b border-white/20 fixed top-0 left-0 w-full z-50">
            <div class="max-w-6xl mx-auto px-6 py-3 flex justify-between items-center">

        <!-- Logo -->
        <h1 class="text-white text-xl font-bold tracking-wide">
            ARUA
        </h1>

        <!-- Menu -->
        <ul class="flex gap-10 text-white font-medium absolute left-1/2 -translate-x-1/2">
            <li><a href="/" class="hover:text-gray-300 transition">Home</a></li>
            <li><a href="/wisata" class="hover:text-gray-300 transition">Destination</a></li>
            <li><a href="/about" class="hover:text-gray-300 transition">About</a></li>
        </ul>

        <!-- Search Bar -->
        <div class="w-64">
            <form action="/wisata/search" method="GET" class="relative">
                <input 
                    type="text" 
                    name="q" 
                    placeholder="Cari wisata..." 
                    class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-2 text-white placeholder-gray-300 focus:outline-none focus:border-blue-400 text-sm pr-10"
                    value="{{ request('q') }}"
                >
                <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-300 hover:text-white transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- Spacer untuk fixed navbar -->
<div class="h-16"></div>