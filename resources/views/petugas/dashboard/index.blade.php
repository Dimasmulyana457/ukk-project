@extends('layouts.sidebar')

@section('content')

<h1 class="text-2xl font-bold text-gray-800 mb-6">
    Dashboard Petugas
</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- Buku Dipinjam Hari Ini --}}
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-indigo-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Buku Dipinjam</p>
                <h2 class="text-3xl font-bold text-gray-800 mt-2">
                    {{ $dipinjam ?? 0 }}
                </h2>
            </div>
            <div class="p-3 bg-indigo-100 rounded-full">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13" />
                </svg>
            </div>
        </div>
    </div>

    {{-- Buku Jatuh Tempo Hari Ini --}}
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Buku Jatuh Tempo Hari Ini</p>
                <h2 class="text-3xl font-bold text-gray-800 mt-2">
                    {{ $jumlahJatuhTempo ?? 0 }}
                </h2>
            </div>
            <div class="p-3 bg-yellow-100 rounded-full">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    {{-- Buku Jatuh Tempo / Terlambat --}}
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-red-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Buku Jatuh Tempo / Terlambat</p>
                <h2 class="text-3xl font-bold text-gray-800 mt-2">
                    {{ $jumlahTerlambat ?? 0 }}
                </h2>
            </div>
            <div class="p-3 bg-red-100 rounded-full">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

</div>

{{-- 🔥 CHART FULL WIDTH --}}
<div class="bg-white rounded-xl shadow p-6 mt-8">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">
        Grafik Peminjaman per Bulan
    </h2>

    <div class="relative h-75"> <!-- 🔥 atur tinggi di sini -->
        <canvas id="chartPeminjaman"></canvas>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">

    <!-- 📅 TABEL JATUH TEMPO -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">
            Buku Jatuh Tempo Hari Ini
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="p-2">No</th>
                        <th class="p-2">Nama</th>
                        <th class="p-2">Buku</th>
                        <th class="p-2">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jatuhTempo as $i => $item)
                    <tr class="border-b">
                        <td class="p-2">{{ $i+1 }}</td>
                        <td class="p-2">{{ $item->user->name ?? '-' }}</td>
                        <td class="p-2"> @foreach ($item->bukuDipinjam as $buku)
                            <div>{{ $buku->judul }}</div> @endforeach </td>
                        <td class="p-2">{{ $item->tanggal_kembali }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-3 text-center text-gray-400">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 🚨 TABEL TERLAMBAT -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">
            Buku Terlambat
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="p-2">No</th>
                        <th class="p-2">Nama</th>
                        <th class="p-2">Buku</th>
                        <th class="p-2">Tanggal kembali</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($terlambat as $i => $item)
                    <tr class="border-b">
                        <td class="p-2">{{ $i+1 }}</td>
                        <td class="p-2">{{ $item->user->name ?? '-' }}</td>
                        <td class="p-2 text-red-500 font-semibold">
                            @foreach ($item->bukuDipinjam as $buku)
                                <div>{{ $buku->judul }}</div>
                            @endforeach
                        </td>
                        <td class="p-2">{{ $item->tanggal_kembali }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-3 text-center text-gray-400">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    new Chart(document.getElementById('chartPeminjaman'), {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: @json($data),
                borderWidth: 2,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false // 🔥 WAJIB biar tinggi bisa diatur
        }
    });

});
</script>
@endpush