<nav id="navbar">
    <div class="nav-container">
        {{-- GANTI route('home') dengan URL langsung --}}
        <a href="/" class="logo">  {{-- ATAU /home jika mau --}}
            <div class="logo-icon">🏔️</div>
            <span>Wisata Sumut</span>
        </a>
        
        <ul class="flex gap-12 text-sm">
            {{-- GUNAKAN URL langsung, bukan named route --}}
            <li><a href="/" class="hover:text-white">Home</a></li>  {{-- ATAU /home --}}
            <li><a href="/wisata" class="hover:text-white">Wisata</a></li>
            <li><a href="/about" class="hover:text-white">About</a></li>
            {{-- Optional: Tambahkan link ke semua wisata --}}
            <li><a href="/wisata/all" class="hover:text-white">Semua Wisata</a></li>
        </ul>

        <div class="nav-right">
            <div class="search-btn">🔍</div>
            <div class="user-menu">
                <div class="user-avatar">A</div>
                <span class="user-name">Hello, Anney!</span>
            </div>
        </div>
    </div>
</nav>