<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BengkelService - Solusi Perbaikan Elektronik Terpercaya</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- AOS (Animate On Scroll) Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        /* Efek Parallax Background sederhana */
        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body class="bg-neutral-950 text-stone-100 font-sans selection:bg-red-600 selection:text-white overflow-x-hidden">

    <!-- NAVBAR -->
    <header class="fixed top-0 left-0 w-full z-50 bg-neutral-950/80 backdrop-blur-md border-b border-zinc-800">
      <div class="max-w-7xl mx-auto px-6 md:px-16 h-24 flex justify-between items-center">
        <div class="flex items-baseline gap-2">
          <span class="text-stone-100 text-3xl font-black">Bengkel</span>
          <span class="text-red-600 text-3xl font-black">Service</span>
        </div>
        <nav class="hidden md:flex items-center gap-9">
          <a href="#layanan" class="text-stone-100 text-xs font-normal hover:text-red-500 transition">Layanan</a>
          <a href="#alur" class="text-stone-100 text-xs font-normal hover:text-red-500 transition">Alur servis</a>
          <a href="#about" class="text-stone-100 text-xs font-normal hover:text-red-500 transition">Tentang kami</a>
          <a href="#faq" class="text-stone-100 text-xs font-normal hover:text-red-500 transition">FAQ</a>
        </nav>
        <div class="flex items-center gap-4">
          @auth
            <a href="{{ url('/dashboard') }}" class="h-12 px-5 bg-red-600 hover:bg-red-700 transition flex items-center text-stone-100 text-sm font-semibold rounded">Dashboard Saya</a>
          @else
            <a href="{{ route('login') }}" class="text-stone-100 text-xs font-semibold hover:text-red-500 transition px-3 py-2">Masuk</a>
            <a href="{{ route('register') }}" class="h-12 px-6 bg-red-600 hover:bg-red-700 transition flex items-center text-stone-100 text-sm font-semibold rounded">Konsultasi perangkat</a>
          @endauth
        </div>
      </div>
    </header>

    <!-- HERO SECTION -->
    <section class="relative min-h-screen pt-32 px-6 md:px-16 flex flex-col justify-between items-start parallax-bg" style="background-image: linear-gradient(to bottom, rgba(10,10,10,0.9), rgba(10,10,10,0.95)), url('https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=1600&q=80');">
      
      <div class="w-full max-w-4xl py-16 my-auto" data-aos="fade-up" data-aos-duration="1000">
        <h1 class="text-stone-100 text-6xl md:text-7xl font-normal leading-tight">ada yang <br/>bisa dibenerin?</h1>
        <div class="text-red-600 text-8xl md:text-9xl font-normal my-4 leading-none tracking-tight">CEPAT</div>
        <p class="text-stone-300 text-lg font-normal leading-7 max-w-xl mb-8">Beri perangkatmu kesempatan kedua. Dari diagnosis hingga perbaikan, kami mulai dari memahami sumber masalah secara transparan.</p>
        <div>
          <a href="{{ route('register') }}" class="h-14 px-8 bg-red-600 hover:bg-red-700 transition inline-flex items-center gap-4 text-stone-100 text-sm font-semibold rounded shadow-lg shadow-red-900/20">
            <span>Konsultasikan kerusakan</span>
            <span class="text-lg">→</span>
          </a>
        </div>
      </div>

      <div class="w-full py-6 flex justify-between items-end border-t border-zinc-900 text-stone-400 text-xs font-mono">
        <div>GULIR UNTUK MELIHAT LEBIH DEKAT</div>
        <div>DIAGNOSIS TELITI / KEPUTUSAN DI TANGANMU</div>
      </div>
    </section>

    <!-- SECTION 01: DETAIL KECIL (Dengan Estetik Gambar & Parallax Fade) -->
    <section id="about" class="px-6 md:px-16 py-28 flex flex-col gap-16 border-b border-zinc-800 bg-neutral-950">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-10" data-aos="fade-up">
        <div class="max-w-2xl flex flex-col gap-6">
          <div class="flex items-center gap-2.5">
            <div class="w-1.5 h-1.5 bg-red-600"></div>
            <span class="text-stone-400 text-xs font-mono">01 / DI BALIK SETIAP PERBAIKAN</span>
          </div>
          <h2 class="text-stone-100 text-5xl md:text-6xl font-semibold leading-tight">Detail kecil.<br/>Dampak besar.</h2>
        </div>
        <p class="max-w-md text-stone-400 text-base leading-7">Satu sambungan komponen, pengukuran jalur daya yang presisi. Perbaikan perangkat elektronik yang tepat dimulai dari ketelitian pada hal-hal utama.</p>
      </div>
      
      <!-- Grid Gambar Estetik & Kartu -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6" data-aos="fade-up" data-aos-delay="200">
        <div class="bg-neutral-900 p-6 border border-zinc-800 rounded-lg flex flex-col justify-between group hover:border-red-600 transition">
            <span class="text-red-600 font-mono text-xs">PENGAMATAN</span>
            <div class="my-6 overflow-hidden rounded">
                <img src="https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?auto=format&fit=crop&w=600&q=80" alt="Pengamatan" class="w-full h-40 object-cover group-hover:scale-105 transition duration-500">
            </div>
            <p class="text-stone-300 text-sm">Pemeriksaan awal gejala kerusakan fisik maupun komponen internal secara menyeluruh.</p>
        </div>
        <div class="bg-neutral-900 p-6 border border-zinc-800 rounded-lg flex flex-col justify-between group hover:border-red-600 transition">
            <span class="text-red-600 font-mono text-xs">PENGUKURAN</span>
            <div class="my-6 overflow-hidden rounded">
                <img src="https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=600&q=80" alt="Pengukuran" class="w-full h-40 object-cover group-hover:scale-105 transition duration-500">
            </div>
            <p class="text-stone-300 text-sm">Analisis akar masalah (Root Cause) menggunakan alat ukur elektronik akurat.</p>
        </div>
        <div class="bg-neutral-900 p-6 border border-zinc-800 rounded-lg flex flex-col justify-between group hover:border-red-600 transition">
            <span class="text-red-600 font-mono text-xs">PERBAIKAN</span>
            <div class="my-6 overflow-hidden rounded">
                <img src="https://images.unsplash.com/photo-1517077304055-6e89abbf09b0?auto=format&fit=crop&w=600&q=80" alt="Perbaikan" class="w-full h-40 object-cover group-hover:scale-105 transition duration-500">
            </div>
            <p class="text-stone-300 text-sm">Eksekusi penanganan dengan persetujuan pelanggan dan pengujian fungsi akhir.</p>
        </div>
      </div>
    </section>

    <!-- SECTION 02: LAYANAN KAMI (HP, Laptop, PC, Monitor, Tablet) -->
    <section id="layanan" class="px-6 md:px-16 py-28 flex flex-col gap-12 border-b border-zinc-800 bg-neutral-950">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-10" data-aos="fade-up">
        <div class="max-w-2xl flex flex-col gap-6">
          <div class="flex items-center gap-2.5">
            <div class="w-1.5 h-1.5 bg-red-600"></div>
            <span class="text-stone-400 text-xs font-mono">02 / LAYANAN KAMI</span>
          </div>
          <h2 class="text-stone-100 text-5xl md:text-6xl font-semibold leading-tight">Beda perangkat.<br/>Sama telitinya.</h2>
        </div>
        <p class="max-w-sm text-stone-400 text-base leading-7">Ceritakan gejalanya. Kelayakan perbaikan dan ketersediaan komponen akan dikonfirmasi secara transparan.</p>
      </div>

      <!-- Grid Layanan Utama -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6" data-aos="fade-up" data-aos-delay="200">
        
        <!-- 1. Laptop -->
        <div class="min-h-60 p-7 bg-neutral-900 border border-zinc-800 rounded-lg flex flex-col justify-between hover:border-red-600 transition">
          <div class="flex justify-between items-start">
            <span class="text-red-600 text-2xl">💻</span>
            <span class="text-stone-400 text-xs font-mono">01</span>
          </div>
          <div class="flex flex-col gap-2 my-4">
            <h3 class="text-stone-100 text-2xl font-normal">Laptop</h3>
            <p class="text-stone-400 text-sm leading-6">Mati total, overheat, ganti kipas, ganti baterai, hingga perbaikan motherboard.</p>
          </div>
          <span class="text-stone-400 text-[10px] font-mono">MOTHERBOARD / KIPAS / LAYAR</span>
        </div>

        <!-- 2. HP / Smartphone -->
        <div class="min-h-60 p-7 bg-neutral-900 border border-zinc-800 rounded-lg flex flex-col justify-between hover:border-red-600 transition">
          <div class="flex justify-between items-start">
            <span class="text-red-600 text-2xl">📱</span>
            <span class="text-stone-400 text-xs font-mono">02</span>
          </div>
          <div class="flex flex-col gap-2 my-4">
            <h3 class="text-stone-100 text-2xl font-normal">HP / Smartphone</h3>
            <p class="text-stone-400 text-sm leading-6">LCD pecah/mati, baterai drop, port charging rusak, dan kendala daya lainnya.</p>
          </div>
          <span class="text-stone-400 text-[10px] font-mono">LCD / BATERAI / KONEKTOR</span>
        </div>

        <!-- 3. PC / Komputer -->
        <div class="min-h-60 p-7 bg-neutral-900 border border-zinc-800 rounded-lg flex flex-col justify-between hover:border-red-600 transition">
          <div class="flex justify-between items-start">
            <span class="text-red-600 text-2xl">🖥️</span>
            <span class="text-stone-400 text-xs font-mono">03</span>
          </div>
          <div class="flex flex-col gap-2 my-4">
            <h3 class="text-stone-100 text-2xl font-normal">PC (Komputer)</h3>
            <p class="text-stone-400 text-sm leading-6">Ganti power supply, upgrade RAM/SSD, perakitan, dan kendala tidak mau menyala.</p>
          </div>
          <span class="text-stone-400 text-[10px] font-mono">POWER SUPPLY / MAINBOARD / STORAGE</span>
        </div>

        <!-- 4. Monitor -->
        <div class="min-h-60 p-7 bg-neutral-900 border border-zinc-800 rounded-lg flex flex-col justify-between hover:border-red-600 transition">
          <div class="flex justify-between items-start">
            <span class="text-red-600 text-2xl">🖥️</span>
            <span class="text-stone-400 text-xs font-mono">04</span>
          </div>
          <div class="flex flex-col gap-2 my-4">
            <h3 class="text-stone-100 text-2xl font-normal">Monitor</h3>
            <p class="text-stone-400 text-sm leading-6">Layar bergaris, masalah back-light, mati total, atau kendala daya/power.</p>
          </div>
          <span class="text-stone-400 text-[10px] font-mono">PANEL / BACKLIGHT / DAYA</span>
        </div>

        <!-- 5. Tablet -->
        <div class="min-h-60 p-7 bg-neutral-900 border border-zinc-800 rounded-lg flex flex-col justify-between hover:border-red-600 transition">
          <div class="flex justify-between items-start">
            <span class="text-red-600 text-2xl">📟</span>
            <span class="text-stone-400 text-xs font-mono">05</span>
          </div>
          <div class="flex flex-col gap-2 my-4">
            <h3 class="text-stone-100 text-2xl font-normal">Tablet</h3>
            <p class="text-stone-400 text-sm leading-6">Perbaikan layar sentuh, baterai kembung, port koneksi dan masalah pengisian daya.</p>
          </div>
          <span class="text-stone-400 text-[10px] font-mono">LAYAR / BATERAI / PORT KONEKSI</span>
        </div>

        <!-- 6. Diagnosis Umum -->
        <div class="min-h-60 p-7 bg-neutral-900 border border-zinc-800 rounded-lg flex flex-col justify-between hover:border-red-600 transition">
          <div class="flex justify-between items-start">
            <span class="text-red-600 text-2xl">⚙️</span>
            <span class="text-stone-400 text-xs font-mono">06</span>
          </div>
          <div class="flex flex-col gap-2 my-4">
            <h3 class="text-stone-100 text-2xl font-normal">Diagnosis Menyeluruh</h3>
            <p class="text-stone-400 text-sm leading-6">Penelusuran komponen secara akurat untuk memastikan Root, Primary, dan Secondary Cause.</p>
          </div>
          <span class="text-stone-400 text-[10px] font-mono">ANALISIS / PENGUKURAN / REKOMENDASI</span>
        </div>

      </div>
    </section>

    <!-- SECTION 03: ALUR SERVIS -->
    <section id="alur" class="px-6 md:px-16 py-28 bg-stone-100 text-neutral-900 flex flex-col gap-16 border-b border-zinc-300">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6" data-aos="fade-up">
        <div class="max-w-2xl flex flex-col gap-6">
          <div class="flex items-center gap-2.5">
            <div class="w-1.5 h-1.5 bg-neutral-900"></div>
            <span class="text-neutral-900 text-xs font-mono">03 / ALUR SERVIS</span>
          </div>
          <h2 class="text-5xl md:text-6xl font-semibold leading-tight">Jelas sejak langkah pertama.</h2>
        </div>
        <span class="text-xs font-mono">Sistem terstruktur transparan</span>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-4 gap-8" data-aos="fade-up" data-aos-delay="200">
        <div class="flex flex-col gap-6">
          <div class="text-red-600 text-5xl font-mono">01</div>
          <div class="h-px bg-stone-300"></div>
          <div class="flex flex-col gap-3">
            <h3 class="text-2xl font-semibold">Daftar & Perangkat</h3>
            <p class="text-zinc-600 text-sm leading-6">Pengguna mendaftarkan akun dan mencatatkan perangkat fisik miliknya.</p>
          </div>
        </div>
        <div class="flex flex-col gap-6">
          <div class="text-red-600 text-5xl font-mono">02</div>
          <div class="h-px bg-stone-300"></div>
          <div class="flex flex-col gap-3">
            <h3 class="text-2xl font-semibold">Reservasi</h3>
            <p class="text-zinc-600 text-sm leading-6">Pilih jenis service spesifik perangkat, jadwalkan kedatangan dan kirim keluhan awal.</p>
          </div>
        </div>
        <div class="flex flex-col gap-6">
          <div class="text-red-600 text-5xl font-mono">03</div>
          <div class="h-px bg-stone-300"></div>
          <div class="flex flex-col gap-3">
            <h3 class="text-2xl font-semibold">Lacak Progres & Approval</h3>
            <p class="text-zinc-600 text-sm leading-6">Pantau status pengerjaan ala Shopee, setujui atau tolak item tambahan (Secondary Cause).</p>
          </div>
        </div>
        <div class="flex flex-col gap-6">
          <div class="text-red-600 text-5xl font-mono">04</div>
          <div class="h-px bg-stone-300"></div>
          <div class="flex flex-col gap-3">
            <h3 class="text-2xl font-semibold">Bayar & Ambil</h3>
            <p class="text-zinc-600 text-sm leading-6">Periksa invoice dari admin, bayar dengan mudah, dan perangkat siap diambil kembali.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION 04: MENGAPA BENGKEL SERVICE (Dengan Foto Studio Reparasi Estetik) -->
    <section class="px-6 md:px-16 py-28 flex flex-col md:flex-row gap-16 items-center border-b border-zinc-800 bg-neutral-950">
      <div class="w-full md:w-1/2 relative overflow-hidden rounded-lg shadow-2xl" data-aos="fade-right">
        <img src="https://images.unsplash.com/photo-1588508065123-287b28e013da?auto=format&fit=crop&w=800&q=80" alt="Studio Reparasi" class="w-full h-[450px] object-cover hover:scale-105 transition duration-700">
        <div class="absolute bottom-6 left-6 bg-red-600 p-4 text-stone-100 rounded">
          <span class="text-[10px] font-mono block">PRINSIP KERJA KAMI</span>
          <span class="text-lg font-medium">Teliti, bukan terburu-buru.</span>
        </div>
      </div>
      <div class="w-full md:w-1/2 flex flex-col gap-6" data-aos="fade-left">
        <div class="flex items-center gap-2.5">
          <div class="w-1.5 h-1.5 bg-red-600"></div>
          <span class="text-stone-400 text-xs font-mono">04 / KEUNGGULAN KAMI</span>
        </div>
        <h2 class="text-stone-100 text-4xl md:text-5xl font-semibold leading-tight">Yang kami jaga,<br/>bukan cuma perangkat.</h2>
        
        <div class="flex flex-col gap-4 mt-4">
          <div class="py-4 border-t border-zinc-800">
            <h3 class="text-stone-100 text-lg font-medium">Root Cause otomatis & akurat.</h3>
            <p class="text-stone-400 text-sm mt-1">Sistem langsung mengenali sparepart utama berdasarkan jenis service yang kamu pilih.</p>
          </div>
          <div class="py-4 border-t border-zinc-800">
            <h3 class="text-stone-100 text-lg font-medium">Persetujuan Secondary Cause di tanganmu.</h3>
            <p class="text-stone-400 text-sm mt-1">Tidak ada biaya tersembunyi. Teknisi mengajukan komponen ekstra dan kamu bebas setuju atau menolak.</p>
          </div>
          <div class="py-4 border-t border-zinc-800">
            <h3 class="text-stone-100 text-lg font-medium">Lacak progres secara real-time.</h3>
            <p class="text-stone-400 text-sm mt-1">Lihat tahapan pengerjaan teknisi dari proses pembongkaran hingga pengujian akhir.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION 05: PERTANYAAN UMUM (FAQ) -->
    <section id="faq" class="px-6 md:px-16 py-28 flex flex-col md:flex-row gap-24 border-b border-zinc-800 bg-neutral-950">
      <div class="w-full md:w-96 flex flex-col gap-6" data-aos="fade-up">
        <div class="flex items-center gap-2.5">
          <div class="w-1.5 h-1.5 bg-red-600"></div>
          <span class="text-stone-400 text-xs font-mono">05 / PERTANYAAN UMUM</span>
        </div>
        <h2 class="text-stone-100 text-5xl md:text-6xl font-semibold leading-tight">Masih ada<br/>tanda tanya?</h2>
        <p class="text-stone-400 text-base leading-7">Berikut adalah beberapa hal yang perlu kamu tahu sebelum mendaftarkan perangkat.</p>
        <div class="pt-3">
          <a href="{{ route('register') }}" class="text-red-600 text-sm font-semibold flex items-center gap-2">Mulai konsultasi sekarang →</a>
        </div>
      </div>
      <div class="flex-1 flex flex-col" data-aos="fade-up" data-aos-delay="200">
        <div class="py-6 border-t border-zinc-800 flex flex-col gap-2">
          <h3 class="text-red-600 text-lg font-medium">Berapa biaya servisnya?</h3>
          <p class="text-stone-400 text-sm leading-6">Biaya dihitung dari harga suku cadang ditambah biaya jasa teknisi tetap sebesar Rp 50.000. Rincian otomatis masuk ke dalam invoice transparan.</p>
        </div>
        <div class="py-6 border-t border-zinc-800 flex flex-col gap-2">
          <h3 class="text-stone-100 text-lg font-medium">Bagaimana cara kerja pengurangan stok sparepart?</h3>
          <p class="text-stone-400 text-sm leading-6">Sistem secara otomatis mengurangi stok inventori begitu teknisi menetapkan Root Cause atau Primary Cause pada perangkatmu.</p>
        </div>
        <div class="py-6 border-t border-zinc-800 flex flex-col gap-2">
          <h3 class="text-stone-100 text-lg font-medium">Apakah saya bisa menolak rekomendasi komponen tambahan?</h3>
          <p class="text-stone-400 text-sm leading-6">Ya, untuk kategori Secondary Cause, kamu diberikan tombol opsi untuk menyetujui atau menolak langsung dari dashboard pelanggan.</p>
        </div>
        <div class="py-6 border-t border-b border-zinc-800 flex flex-col gap-2">
          <h3 class="text-stone-100 text-lg font-medium">Bagaimana cara memantau progres perbaikan?</h3>
          <p class="text-stone-400 text-sm leading-6">Kamu bisa masuk ke menu "Service & Tagihan" lalu klik "Lacak" untuk melihat linimasa progres pengerjaan teknisi secara real-time.</p>
        </div>
      </div>
    </section>

    <!-- SECTION 06: CALL TO ACTION (CTA) -->
    <section class="px-6 md:px-16 py-24 bg-red-600 text-neutral-950 flex flex-col md:flex-row justify-between items-center gap-16" data-aos="zoom-in">
      <div class="max-w-xl flex flex-col gap-6">
        <div class="flex items-center gap-2.5">
          <div class="w-1.5 h-1.5 bg-neutral-950"></div>
          <span class="text-neutral-950 text-xs font-mono">06 / MULAI SEKARANG</span>
        </div>
        <h2 class="text-5xl md:text-7xl font-semibold leading-tight text-neutral-950">Jangan<br/>buru-buru<br/>ganti baru.</h2>
        <p class="text-neutral-900 text-lg leading-7">Daftarkan akunmu sekarang, daftarkan perangkatmu, dan buat reservasi service dengan mudah.</p>
        <div>
          <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-neutral-950 text-stone-100 font-semibold text-sm rounded shadow hover:bg-neutral-900 transition">Buat Akun & Reservasi</a>
        </div>
      </div>
      <div class="w-full md:w-96 p-8 bg-neutral-950 text-stone-100 rounded-lg border border-neutral-800 shadow-2xl">
        <h3 class="text-xl font-normal mb-2">Sudah punya akun?</h3>
        <p class="text-stone-400 text-xs mb-6 leading-5">Masuk ke sistem untuk melacak perangkat yang sedang diservice atau mengelola antrean reservasi.</p>
        <a href="{{ route('login') }}" class="block text-center py-3 bg-red-600 text-stone-100 font-semibold text-xs uppercase tracking-wider rounded hover:bg-red-700 transition">Masuk ke Sistem</a>
      </div>
    </section>

    <!-- FOOTER -->
    <footer class="px-6 md:px-16 pt-16 pb-8 flex flex-col gap-12 bg-neutral-950 text-stone-400 border-t border-zinc-800">
      <div class="flex flex-col md:flex-row justify-between items-start gap-8">
        <div>
          <div class="flex items-baseline gap-2">
            <span class="text-stone-100 text-4xl font-black">Bengkel</span>
            <span class="text-red-600 text-xl font-mono">/ SERVICE</span>
          </div>
          <p class="text-stone-400 text-sm mt-2">Rawat yang ada. Hidupkan kembali perangkat elektronikmu.</p>
        </div>
        <div class="flex gap-16">
          <div class="flex flex-col gap-2 text-sm">
            <span class="text-stone-100 text-xs font-mono mb-2">NAVIGASI</span>
            <a href="#layanan" class="hover:text-red-500 transition">Layanan</a>
            <a href="#alur" class="hover:text-red-500 transition">Alur servis</a>
            <a href="#about" class="hover:text-red-500 transition">Tentang kami</a>
          </div>
          <div class="flex flex-col gap-2 text-sm">
            <span class="text-stone-100 text-xs font-mono mb-2">AKUN</span>
            <a href="{{ route('login') }}" class="hover:text-red-500 transition">Masuk</a>
            <a href="{{ route('register') }}" class="hover:text-red-500 transition">Daftar</a>
          </div>
        </div>
      </div>
      <div class="h-px bg-zinc-800"></div>
      <div class="flex flex-col md:flex-row justify-between items-center text-xs font-mono gap-4">
        <div>© 2026 BENGKEL SERVICE SYSTEM. HAK CIPTA DILINDUNGI.</div>
        <div>DIKEMBANGKAN DENGAN LARAVEL 12</div>
      </div>
    </footer>

    <!-- AOS (Animate On Scroll) Script Initialization -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init({
        duration: 800, // Durasi animasi dalam milidetik
        once: true,    // Animasi hanya berjalan sekali saat digulir ke bawah
        offset: 100,   // Jarak pemicu sebelum elemen masuk layar
      });
    </script>
</body>
</html>