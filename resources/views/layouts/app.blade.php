@php
    $isDark = View::hasSection('dark_theme');
@endphp
<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BengkelService - Dashboard Manajemen Perbaikan</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: {{ $isDark ? '#0a0a0a' : '#f8fafc' }}; }
        ::-webkit-scrollbar-thumb { background: {{ $isDark ? '#27272a' : '#cbd5e1' }}; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: {{ $isDark ? '#3f3f46' : '#94a3b8' }}; }
    </style>
</head>
<body class="h-full {{ $isDark ? 'bg-neutral-950 text-stone-100' : 'bg-slate-50 text-slate-800' }} font-sans antialiased flex flex-col justify-between selection:bg-red-600 selection:text-white transition-colors duration-200">

    <!-- NAVBAR UTAMA -->
    <header class="sticky top-0 z-50 {{ $isDark ? 'bg-neutral-950/90 border-zinc-800' : 'bg-white/90 border-slate-200' }} backdrop-blur-md border-b shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex justify-between items-center">
            
            <!-- Brand Logo -->
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="flex items-baseline gap-1 group">
                    <span class="{{ $isDark ? 'text-stone-100' : 'text-slate-900' }} text-2xl font-black tracking-tight group-hover:text-red-600 transition">Bengkel</span>
                    <span class="text-red-600 text-2xl font-black tracking-tight">Service</span>
                </a>
                @auth
                <span class="hidden md:inline-block px-2.5 py-0.5 bg-red-950/80 text-red-400 text-xs font-semibold rounded-full uppercase tracking-wider border border-red-800/60">
                    {{ Auth::user()->role }}
                </span>
                @endauth
            </div>

            <!-- Navigasi Dinamis Berdasarkan Aktor -->
            @auth
            <nav class="hidden lg:flex items-center gap-1 {{ $isDark ? 'bg-zinc-900 border-zinc-800' : 'bg-slate-100/80 border-slate-200/80' }} p-1.5 rounded-full border text-sm font-medium">
                @if(Auth::user()->role == 'pelanggan')
                    <a href="{{ route('pelanggan.device.create') }}" class="px-4 py-2 rounded-full hover:bg-red-600 hover:text-white transition {{ $isDark ? 'text-stone-300' : 'text-slate-600' }}">+ Perangkat</a>
                    <a href="{{ route('pelanggan.reservation.create') }}" class="px-4 py-2 rounded-full hover:bg-red-600 hover:text-white transition {{ $isDark ? 'text-stone-300' : 'text-slate-600' }}">Buat Reservasi</a>
                    <a href="{{ route('pelanggan.service.index') }}" class="px-4 py-2 rounded-full hover:bg-red-600 hover:text-white transition {{ $isDark ? 'text-stone-300' : 'text-slate-600' }}">Service & Tagihan</a>
                @elseif(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.reservation.index') }}" class="px-4 py-2 rounded-full hover:bg-red-600 hover:text-white transition {{ $isDark ? 'text-stone-300' : 'text-slate-600' }}">Reservasi Masuk</a>
                    <a href="{{ route('admin.payment.index') }}" class="px-4 py-2 rounded-full hover:bg-red-600 hover:text-white transition {{ $isDark ? 'text-stone-300' : 'text-slate-600' }}">Verifikasi Pembayaran</a>
                    <a href="{{ route('admin.inventory.index') }}" class="px-4 py-2 rounded-full hover:bg-red-600 hover:text-white transition {{ $isDark ? 'text-stone-300' : 'text-slate-600' }}">Stok Inventori</a>
                @elseif(Auth::user()->role == 'teknisi')
                    <a href="{{ route('teknisi.service.index') }}" class="px-4 py-2 rounded-full hover:bg-red-600 hover:text-white transition {{ $isDark ? 'text-stone-300' : 'text-slate-600' }}">Daftar Tugas Service</a>
                @endif
            </nav>
            @endauth

            <!-- User Profile / Auth Button -->
            <div class="flex items-center gap-4">
                @auth
                <div class="flex items-center gap-3 pl-3 border-l {{ $isDark ? 'border-zinc-800' : 'border-slate-200' }}">
                <div class="text-right hidden sm:block">
                    <a href="{{ route('profile.edit') }}" class="text-xs font-bold hover:text-red-600 transition">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="text-[10px] uppercase tracking-wide opacity-70">{{ Auth::user()->role }}</div>
                </div>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-3.5 py-2 bg-red-950/50 hover:bg-red-600 text-red-400 hover:text-white text-xs font-semibold rounded-lg transition border border-red-900/60 hover:border-red-600 cursor-pointer">
                            Keluar
                        </button>
                    </form>
                </div>
                @else
                <div class="flex items-center gap-2">
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold {{ $isDark ? 'text-stone-300' : 'text-slate-700' }} hover:text-red-600 transition">Masuk</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">Daftar</a>
                </div>
                @endauth
            </div>

        </div>
    </header>

    <!-- KONTEN UTAMA -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col">
        <!-- Flash Notifications -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-950 border-l-4 border-emerald-500 text-emerald-200 rounded-r-lg text-sm shadow-xs">
                ✓ {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 p-4 bg-red-950 border-l-4 border-red-600 text-red-200 rounded-r-lg text-sm shadow-xs">
                ✕ {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-950 border-l-4 border-red-600 text-red-200 rounded-r-lg text-sm shadow-xs">
                <p class="font-semibold mb-1">Terjadi kesalahan input:</p>
                <ul class="list-disc list-inside text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="w-full flex-1 flex flex-col justify-center">
            @yield('content')
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="{{ $isDark ? 'bg-neutral-950 border-zinc-800/80 text-stone-500' : 'bg-white border-slate-200 text-slate-500' }} border-t mt-auto py-8 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <span class="font-bold {{ $isDark ? 'text-stone-200' : 'text-slate-800' }}">BengkelService</span>
                <span>— Solusi Perbaikan Elektronik Terpercaya</span>
            </div>
            <div class="font-mono text-[11px] opacity-70">
                © {{ date('Y') }} ALL RIGHTS RESERVED
            </div>
        </div>
    </footer>

</body>
</html>