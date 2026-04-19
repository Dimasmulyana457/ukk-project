@php
    $user = Auth::user();
    $role = $user->role;
@endphp

@extends('layouts.sidebar')

@section('content')
            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                {{-- Total Anggota --}}
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total Anggota</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $totalAnggota }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Total Buku --}}
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total Buku</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $totalBuku }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Dipinjam --}}
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">dipinjam</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $dipinjam ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Terlambat --}}
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Terlambat</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $terlambat ?? 100 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- GrafiK Chart--}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">

                <!-- 📈 Grafik Peminjaman -->
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">
                        Grafik Peminjaman per Bulan
                    </h2>
                    <canvas id="chartPeminjaman"></canvas>
                </div>

                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-5">
                        Status Buku
                    </h2>

                    {{-- 2 Card Grid --}}
                    <div class="grid grid-cols-2 gap-4 mb-6">

                        {{-- Total Stok --}}
                        <div class="bg-gray-50 rounded-xl p-6 flex flex-col gap-8">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-gray-400 inline-block"></span>
                                <span class="text-base text-gray-500">Total Stok</span>
                            </div>
                            <span class="text-6xl font-bold text-gray-800 leading-none">{{ $totalStok }}</span>
                            <span class="text-sm text-gray-400">Total semua buku</span>
                        </div>

                        {{-- Tersedia --}}
                        <div class="bg-green-50 rounded-xl p-6 flex flex-col gap-3">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span>
                                <span class="text-base text-green-700">Tersedia</span>
                            </div>
                            <span class="text-6xl font-bold text-green-800 leading-none">{{ $tersedia }}</span>
                            <span class="text-sm text-green-600">Siap dipinjam</span>
                        </div>

                    </div>

                    {{-- Progress Bar --}}
                    <div>
                        <div class="flex justify-between text-sm text-gray-400 mb-2">
                            <span>Persentase tersedia</span>
                            <span class="font-semibold text-green-600">
                                {{ $totalStok > 0 ? round(($tersedia / $totalStok) * 100) : 0 }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden">
                            <div class="bg-green-500 h-4 rounded-full transition-all duration-500"
                                style="width: {{ $totalStok > 0 ? ($tersedia / $totalStok) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Peminjam Aktif --}}
            <div class="mt-10 bg-white rounded-2xl shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Data Peminjam Aktif
                </h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-600">
                        <thead class="bg-indigo-600 text-gray-100 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Buku</th>
                                <th class="px-4 py-3">Tanggal Pinjam</th>
                                <th class="px-4 py-3">Tanggal Kembali</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjamAktif as $index => $item)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">{{ $item->user->name ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $item->bukuDipinjam->pluck('judul')->join(', ') ?: '-' }}</td>
                                    <td class="px-4 py-3">
                                        {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                                    </td>
                                    @php
                                        $terlambat = \Carbon\Carbon::parse($item->tanggal_kembali)->lt(now()->startOfDay());
                                    @endphp

                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $terlambat ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                            {{ $terlambat ? 'Terlambat' : 'Dipinjam' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-400">
                                        Tidak ada data peminjam
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
                        
        </div>
    </main>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    // LINE CHART
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
        }
    });

});
</script>
@endpush
