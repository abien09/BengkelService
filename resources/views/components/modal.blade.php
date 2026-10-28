@props([
    'id' => 'modal-dialog',
    'title' => 'Konfirmasi Tindakan',
    'description' => 'Apakah Anda yakin ingin melanjutkan tindakan ini?'
])

<div id="{{ $id }}" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-neutral-950/70 backdrop-blur-xs p-4">
    <div class="bg-white w-full max-w-md rounded-2xl border border-slate-200 shadow-2xl overflow-hidden p-6 space-y-5 animate-in fade-in zoom-in-95 duration-150">
        <!-- Header Modal -->
        <div class="flex items-start justify-between gap-3">
            <div class="flex items-center gap-2">
                <span class="text-xl">⚠️</span>
                <h3 class="text-base font-bold text-slate-900">{{ $title }}</h3>
            </div>
            <button onclick="closeModal('{{ $id }}')" class="text-slate-400 hover:text-slate-700 text-sm font-bold p-1 transition cursor-pointer">
                ✕
            </button>
        </div>

        <!-- Deskripsi -->
        <p class="text-xs text-slate-500 leading-relaxed">
            {{ $description }}
        </p>

        <!-- Area Slot Form / Tombol Aksi -->
        <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
            <button type="button" onclick="closeModal('{{ $id }}')" class="px-4 py-2 text-xs font-semibold text-slate-500 hover:text-slate-800 bg-slate-100 rounded-xl transition cursor-pointer">
                Batal
            </button>
            {{ $slot }}
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id)?.classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById(id)?.classList.add('hidden');
    }
</script>