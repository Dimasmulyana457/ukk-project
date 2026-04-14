@extends('layouts.sidebar')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Pengembalian Buku
    </h1>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-800 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full">
            <thead class="bg-indigo-600 text-white text-left">
                <tr>
                    <th class="px-4 py-3 text-sm font-semibold">No</th>
                    <th class="px-4 py-3 text-sm font-semibold">Nama User</th>
                    <th class="px-4 py-3 text-sm font-semibold">Kode Buku</th>
                    <th class="px-4 py-3 text-sm font-semibold">Judul Buku</th>
                    <th class="px-4 py-3 text-sm font-semibold">Tanggal Pinjam</th>
                    <th class="px-4 py-3 text-sm font-semibold">Tanggal Kembali</th>
                    <th class="px-4 py-3 text-sm font-semibold">No Telp</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($peminjaman as $item)

                @php
                    $today = \Carbon\Carbon::today();
                    $tanggalKembali = $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali) : null;
                    $terlambat = $tanggalKembali && $today->gt($tanggalKembali);
                @endphp

                <tr class="hover:bg-gray-50 text-left">
                    <td class="px-4 py-3 text-sm">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 text-sm">{{ $item->user->name }}</td>
                    <td class="px-4 py-3 text-sm text-left text-indigo-600">
                        @foreach ($item->bukuDipinjam as $buku)
                            <div>{{ $buku->kode_buku }}</div>
                        @endforeach
                    </td>
                    <td class="px-4 py-3 text-left">
                        @foreach ($item->bukuDipinjam as $buku)
                            <div class="text-sm">
                             {{ $buku->judul }}
                            </div>
                        @endforeach
                    </td>
                    <td class="px-4 py-3 text-sm">{{ $item->tanggal_pinjam }}</td>
                    <td class="px-4 py-3 text-sm">{{ $item->tanggal_kembali ?? '-' }}</td>
                    <td class="px-4 py-3 text-sm">{{ $item->no_telp ?? '-' }}</td>
                    <td class="px-4 py-3 text-sm text-center">
                         <div class="flex justify-center gap-2">

                   

                    <form action="{{ route('petugas.pengembalian.kembalikan', $item->id) }}" method="POST">
                    @csrf

                    @if($terlambat)
                        <!-- TERLAMBAT → pakai modal -->
                        <button
                            type="button"
                            onclick="openModal({{ $item->id }}, '{{ $item->tanggal_kembali }}')"
                            class="p-2 rounded-lg bg-red-100 text-red-600 hover:bg-red-200"
                            title="Kembalikan Buku (Terlambat)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 10h10a4 4 0 014 4v0a4 4 0 01-4 4H7" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 6l-4 4 4 4" />
                            </svg>
                        </button>
                    @else
                        <!-- TIDAK TERLAMBAT → langsung submit -->
                        <button
                            type="submit"
                            class="p-2 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200"
                            title="Kembalikan Buku">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 10h10a4 4 0 014 4v0a4 4 0 01-4 4H7" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 6l-4 4 4 4" />
                            </svg>
                        </button>
                    @endif

                </form>

                </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-gray-500 text-center">
                        Tidak ada buku yang sedang dipinjam
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

<!-- Modal -->
<div id="modalDenda" class="fixed inset-0 backdrop-blur-sm bg-black/20 hidden items-center justify-center">
    
    <div class="bg-white rounded-2xl shadow-2xl w-95 overflow-hidden animate-fadeIn">
        
        <!-- HEADER -->
        <div class="bg-indigo-600 text-white px-6 py-4">
            <h2 class="text-lg font-semibold">Input Denda</h2>
        </div>

        <!-- BODY -->
        <div class="p-6 space-y-4">
            <form id="formDenda" method="POST">
                @csrf

                <div id="infoTerlambat" class="hidden bg-red-100 text-red-600 text-sm px-3 py-2 rounded-xl"></div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Denda</label>
                    <input type="number" name="denda"
                        class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        required>
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1">Keterangan</label>
                    <textarea name="keterangan"
                        class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
                </div>

                <!-- FOOTER -->
                <div class="flex justify-end gap-2 pt-4">
                    <button type="button"
                        onclick="closeModal()"
                        class="px-4 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 transition">
                        Batal
                    </button>

                    <button type="submit"
                        class="px-4 py-2 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 transition shadow">
                        Simpan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
function closeModal() {
    const modal = document.getElementById('modalDenda');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function openModal(id, tanggalKembali) {
    const modal = document.getElementById('modalDenda');
    const form = document.getElementById('formDenda');
    const info = document.getElementById('infoTerlambat');

    form.action = `/petugas/pengembalian/${id}`;

    const today = new Date();
    const kembali = new Date(tanggalKembali);

    let selisih = 0;

    if (!isNaN(kembali) && today > kembali) {
        selisih = Math.floor((today - kembali) / (1000 * 60 * 60 * 24));
    }

    // tampilkan info terlambat
    if (selisih > 0) {
        info.classList.remove('hidden');
        info.innerHTML = `Terlambat <b>${selisih} hari</b>`;
    } else {
        info.classList.add('hidden');
    }

    // hitung denda
    const denda = selisih * 1000;
    form.querySelector('input[name="denda"]').value = denda;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
</script>
@endsection
