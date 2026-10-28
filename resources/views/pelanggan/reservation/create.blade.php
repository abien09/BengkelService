@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Breadcrumb Navigasi -->
    <div>
        <a href="{{ route('pelanggan.dashboard') }}" class="text-xs font-semibold text-slate-500 hover:text-red-600 transition flex items-center gap-1 w-fit">
            <span>←</span>
            <span>Kembali ke Dashboard</span>
        </a>
    </div>

    <!-- Card Container -->
    <div class="bg-white p-8 md:p-10 rounded-2xl border border-slate-200 shadow-xs space-y-8">
        <!-- Header -->
        <div class="border-b border-slate-100 pb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                    <span class="text-xs font-mono font-bold uppercase tracking-wider text-red-600">[ RESERVASI SERVICE ]</span>
                </div>
                <h1 class="text-2xl font-black text-slate-900">Buat Jadwal Perbaikan Baru</h1>
                <p class="text-sm text-slate-500 mt-1">Pilih perangkat Anda, tentukan keluhan awal, dan atur waktu kedatangan ke studio kami.</p>
            </div>
        </div>

        @if($devices->count() > 0)
            <form action="{{ route('pelanggan.reservation.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Step 1: Pilih Perangkat & Jenis Service -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Pilih Perangkat -->
                    <div>
                        <label for="device_select" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">
                            Pilih Perangkat <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="device_id" id="device_select" required onchange="updateServiceOptions()" class="w-full pl-4 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition appearance-none cursor-pointer">
                                <option value="" disabled selected>-- Pilih Perangkat Terdaftar --</option>
                                @foreach($devices as $d)
                                    <option value="{{ $d->id }}" data-jenis="{{ $d->jenis }}">
                                        {{ $d->jenis }} - {{ $d->merek }} {{ $d->model }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400 text-xs">
                                ▼
                            </div>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1.5">Perangkat tidak ada dalam daftar? <a href="{{ route('pelanggan.device.create') }}" class="text-red-600 font-semibold underline">Daftarkan dulu di sini</a>.</p>
                    </div>

                    <!-- Jenis Service (Dinamis via JS) -->
                    <div>
                        <label for="jenis_service_select" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">
                            Jenis Service / Kategori Layanan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="jenis_service" id="jenis_service_select" required class="w-full pl-4 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition appearance-none cursor-pointer">
                                <option value="" disabled selected>-- Pilih Perangkat Terlebih Dahulu --</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400 text-xs">
                                ▼
                            </div>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1.5">Opsi menyesuaikan dengan kategori perangkat yang Anda pilih.</p>
                    </div>
                </div>

                <!-- Step 2: Keluhan Awal Kerusakan -->
                <div>
                    <label for="keluhan_awal" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">
                        Keluhan Awal / Catatan Gejala Kerusakan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="keluhan_awal" id="keluhan_awal" rows="4" required placeholder="Ceritakan detail kendala (misal: Layar bergaris, suka mati sendiri setelah 10 menit, baterai cepat kembung)..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition"></textarea>
                </div>

                <!-- Step 3: Tanggal & Waktu Perkiraan Kedatangan -->
                <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 space-y-4">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <span>🗓️</span>
                        <span>Jadwal Kedatangan ke Studio Servis</span>
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="tanggal" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">
                                Tanggal Kedatangan <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal" id="tanggal" min="{{ date('Y-m-d') }}" required class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm text-slate-800 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition">
                        </div>

                        <div>
                            <label for="waktu" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">
                                Waktu Perkiraan (Jam) <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="waktu" id="waktu" required class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm text-slate-800 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition">
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-500 italic">
                        * Jam operasional studio: 09:00 - 18:00 WIB. Teknisi kami akan menyiapkan tempat pengerjaan sesuai jam reservasi Anda.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="pt-4 border-t border-slate-100 flex flex-col-reverse md:flex-row items-center justify-end gap-3">
                    <a href="{{ route('pelanggan.dashboard') }}" class="w-full md:w-auto px-6 py-3 text-sm font-semibold text-slate-500 hover:text-slate-800 bg-transparent hover:bg-slate-100 rounded-xl transition text-center">
                        Batal
                    </a>
                    <button type="submit" class="w-full md:w-auto px-8 py-3 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl shadow-md shadow-red-600/20 transition cursor-pointer flex items-center justify-center gap-2">
                        <span>Kirim Reservasi Sekarang</span>
                        <span>→</span>
                    </button>
                </div>
            </form>
        @else
            <!-- Peringatan jika belum ada perangkat -->
            <div class="p-8 text-center bg-red-50 border border-red-200 rounded-xl space-y-3">
                <div class="text-3xl">⚠️</div>
                <h3 class="text-base font-bold text-red-900">Perangkat Belum Didaftarkan</h3>
                <p class="text-xs text-red-700 max-w-md mx-auto">
                    Sistem mewajibkan Anda mendaftarkan minimal 1 perangkat fisik (HP, Laptop, PC, Monitor, Tablet) sebelum membuat reservasi.
                </p>
                <div class="pt-2">
                    <a href="{{ route('pelanggan.device.create') }}" class="inline-block px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                        + Daftarkan Perangkat Sekarang
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Script Dinamis Opsi Service -->
<script>
    function updateServiceOptions() {
        const selectDevice = document.getElementById('device_select');
        const selectedOption = selectDevice.options[selectDevice.selectedIndex];
        const jenisDevice = selectedOption.getAttribute('data-jenis');
        const serviceSelect = document.getElementById('jenis_service_select');
        
        serviceSelect.innerHTML = '';
        
        let defaultOpt = document.createElement('option');
        defaultOpt.value = '';
        defaultOpt.disabled = true;
        defaultOpt.selected = true;
        defaultOpt.innerHTML = '-- Pilih Kategori Layanan --';
        serviceSelect.appendChild(defaultOpt);

        let options = [];

        if (jenisDevice === 'Laptop') {
            options = ['Ganti Kipas Laptop', 'LCD Laptop Mati', 'Ganti Baterai Laptop', 'Service Motherboard'];
        } else if (jenisDevice === 'HP') {
            options = ['LCD HP Rusak', 'Ganti Baterai HP', 'Port Charging Rusak'];
        } else if (jenisDevice === 'PC') {
            options = ['Ganti Power Supply', 'Upgrade RAM/SSD', 'PC Tidak Nyala'];
        } else if (jenisDevice === 'Monitor' || jenisDevice === 'Tablet') {
            options = ['Ganti Layar', 'Masalah Daya / Power', 'Port Koneksi Rusak'];
        } else {
            options = ['Diagnosis Menyeluruh'];
        }

        options.forEach(function(item) {
            let opt = document.createElement('option');
            opt.value = item;
            opt.innerHTML = item;
            serviceSelect.appendChild(opt);
        });
    }
</script>
@endsection    