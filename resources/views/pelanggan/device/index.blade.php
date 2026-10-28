@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                <span class="text-xs font-mono font-semibold uppercase tracking-wider text-slate-400">Inventaris Pelanggan</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900">Perangkat Saya</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola daftar perangkat elektronik fisik Anda sebelum melakukan reservasi perbaikan.</p>
        </div>
        <a href="{{ route('pelanggan.device.create') }}" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-xl shadow-sm transition flex items-center gap-2">
            <span class="text-lg leading-none">+</span>
            <span>Tambah Perangkat</span>
        </a>
    </div>

    <!-- Data Table Section -->
    @if($devices->count() > 0)
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs font-bold uppercase tracking-wider">
                            <th class="p-5">Jenis Perangkat</th>
                            <th class="p-5">Merek & Model</th>
                            <th class="p-5">Warna</th>
                            <th class="p-5">Didaftarkan Pada</th>
                            <th class="p-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach($devices as $device)
                        <tr class="hover:bg-slate-50/80 transition group">
                            <td class="p-5 font-semibold text-slate-900 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center text-sm">
                                    @if($device->jenis == 'HP') 📱 
                                    @elseif($device->jenis == 'Laptop') 💻 
                                    @elseif($device->jenis == 'PC') 🖥️ 
                                    @elseif($device->jenis == 'Monitor') 🖥️ 
                                    @elseif($device->jenis == 'Tablet') 📟 
                                    @else ⚙️ @endif
                                </div>
                                <span>{{ $device->jenis }}</span>
                            </td>
                            <td class="p-5">
                                <div class="text-slate-900 font-bold">{{ $device->merek }}</div>
                                <div class="text-slate-500 text-xs">{{ $device->model }}</div>
                            </td>
                            <td class="p-5 text-slate-600">{{ $device->warna ?? '-' }}</td>
                            <td class="p-5 text-slate-500 text-xs">{{ $device->created_at ? $device->created_at->format('d M Y') : '-' }}</td>
                            <td class="p-5 text-right space-x-2">
                                <!-- Tombol Hapus memicu Pop-up Modal -->
                                <button type="button" onclick="openModal('modal-delete-{{ $device->id }}')" class="inline-block px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-[11px] font-semibold rounded-lg transition cursor-pointer" title="Hapus Perangkat">
                                    Hapus
                                </button>

                                <!-- Komponen Modal Konfirmasi Hapus -->
                                <x-modal id="modal-delete-{{ $device->id }}" title="Hapus Perangkat" description="Apakah Anda yakin ingin menghapus perangkat {{ $device->merek }} {{ $device->model }}? Data perangkat yang terhapus tidak dapat dikembalikan.">
                                    <form action="{{ route('pelanggan.device.destroy', $device->id) ?? '#' }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition cursor-pointer">
                                            Ya, Hapus Sekarang
                                        </button>
                                    </form>
                                </x-modal>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white p-12 text-center rounded-2xl border border-slate-200 flex flex-col items-center justify-center space-y-4">
            <div class="w-16 h-16 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center text-3xl mb-2">
                📦
            </div>
            <h3 class="text-lg font-bold text-slate-800">Belum Ada Perangkat Terdaftar</h3>
            <p class="text-sm text-slate-500 max-w-md mx-auto leading-relaxed">
                Anda wajib mendaftarkan minimal 1 perangkat elektronik (HP, Laptop, PC, Monitor, atau Tablet) ke dalam sistem sebelum dapat membuat jadwal reservasi perbaikan.
            </p>
            <div class="pt-4">
                <a href="{{ route('pelanggan.device.create') }}" class="inline-block px-6 py-3 bg-red-600 text-white text-sm font-semibold rounded-xl hover:bg-red-700 shadow-sm transition">
                    + Daftarkan Perangkat Sekarang
                </a>
            </div>
        </div>
    @endif

    <div class="pt-4 border-t border-slate-200">
        <a href="{{ route('pelanggan.dashboard') }}" class="text-xs font-semibold text-slate-500 hover:text-red-600 transition flex items-center gap-1 w-fit">
            <span>←</span>
            <span>Kembali ke Dashboard Utama</span>
        </a>
    </div>
</div>
@endsection