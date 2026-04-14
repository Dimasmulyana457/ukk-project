@extends('layouts.sidebar')

@section('content')
<div class="p-8">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Laporan Peminjaman (Admin)
    </h1>

    {{-- FILTER CARD --}}
    <div class="bg-linear-to-r from-indigo-50 via-white to-blue-50 rounded-2xl shadow-md p-6 mb-6 border border-indigo-100">

        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Filter Laporan</h2>
            <p class="text-sm text-gray-500">Pilih tanggal atau bulan untuk melihat data</p>
        </div>

        <form method="GET" action="{{ route('admin.laporan.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                {{-- Dari Tanggal --}}
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Dari Tanggal</label>
                    <input type="date" name="dari"
                        value="{{ request('dari') }}"
                        class="w-full border border-gray-200 rounded-xl px-3 py-2 bg-white shadow-sm
                        focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
                </div>

                {{-- Sampai Tanggal --}}
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Sampai Tanggal</label>
                    <input type="date" name="sampai"
                        value="{{ request('sampai') }}"
                        class="w-full border border-gray-200 rounded-xl px-3 py-2 bg-white shadow-sm
                        focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
                </div>

                {{-- Bulan --}}
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Bulan</label>
                    <input type="month" name="bulan"
                        value="{{ request('bulan') }}"
                        class="w-full border border-gray-200 rounded-xl px-3 py-2 bg-white shadow-sm
                        focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
                </div>

                {{-- Button --}}
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition shadow">
                        Filter
                    </button>

                    <a href="{{ route('admin.laporan.index') }}"
                        class="px-4 py-2 bg-gray-200 rounded-xl hover:bg-gray-300 transition">
                        Reset
                    </a>

                    {{-- EXPORT EXCEL --}}
                    <a href="{{ route('admin.laporan.export', request()->query()) }}"
                        class="px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition shadow">
                        Export Excel
                    </a>
                </div>

            </div>
        </form>
    </div>

    {{-- INFO FILTER --}}
    @if(request()->anyFilled(['bulan','dari','sampai','status']))
        <div class="mb-4 text-sm text-gray-600">
            Filter aktif:
            {{ request('bulan') ? ' Bulan: ' . request('bulan') : '' }}
            {{ request('dari') ? ' Dari: ' . request('dari') : '' }}
            {{ request('sampai') ? ' Sampai: ' . request('sampai') : '' }}
            {{ request('status') ? ' Status: ' . request('status') : '' }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow overflow-x-auto">
        <table class="w-full">
            <thead class="bg-indigo-600 text-white text-left">
                <tr>
                    <th class="px-4 py-3 text-sm">No</th>
                    <th class="px-4 py-3 text-sm">Nama User</th>
                    <th class="px-4 py-3 text-sm">Kode Buku</th>
                    <th class="px-4 py-3 text-sm">Judul Buku</th>
                    <th class="px-4 py-3 text-sm">Tanggal Pinjam</th>
                    <th class="px-4 py-3 text-sm">Tanggal Kembali</th>
                    <th class="px-4 py-3 text-sm">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($peminjaman as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm">{{ ($peminjaman->currentPage() - 1) * $peminjaman->perPage() + $loop->iteration }}</td>

                    <td class="px-4 py-3 text-sm">
                        {{ $item->user->name }}
                    </td>

                    <td class="px-4 py-3 text-sm text-indigo-600">
                        @foreach ($item->bukuDipinjam as $buku)
                            <div>{{ $buku->kode_buku }}</div>
                        @endforeach
                    </td>

                    <td class="px-4 py-3 text-sm">
                        @foreach ($item->bukuDipinjam as $buku)
                            <div>{{ $buku->judul }}</div>
                        @endforeach
                    </td>

                    <td class="px-4 py-3 text-sm">
                        {{ $item->tanggal_pinjam }}
                    </td>

                    <td class="px-4 py-3 text-sm">
                        {{ $item->tanggal_kembali ?? '-' }}
                    </td>

                    <td class="px-4 py-3 text-sm">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            @if($item->status == 'dipinjam') bg-blue-100 text-blue-600
                            @elseif($item->status == 'dikembalikan') bg-green-100 text-green-600
                            @elseif($item->status == 'ditolak') bg-red-100 text-red-600
                            @else bg-yellow-100 text-yellow-600
                            @endif">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-500">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $peminjaman->links() }}</div>
    </div>

</div>
@endsection