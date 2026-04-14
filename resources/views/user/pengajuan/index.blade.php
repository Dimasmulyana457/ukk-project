@extends('layouts.sidebar')

@section('content')
{{-- Content Area --}}
<div class="p-8">
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Pengajuan Peminjaman</h1>
            <p class="text-gray-600">Daftar pengajuan peminjaman buku Anda</p>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-indigo-600 text-white">
                        <th class="px-6 py-4 text-left text-sm font-semibold">No</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Kode Buku</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Judul Buku</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Tanggal Pinjam</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Tanggal Kembali</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Jumlah</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php $no = 1; @endphp
                    @forelse ($pengajuan as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $no++ }}</td>

                        <td class="px-6 py-4 text-sm text-gray-900">
                            @foreach ($item->bukuDipinjam as $buku)
                                <div>{{ $buku->kode_buku }}</div>
                            @endforeach
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-900">
                            @foreach ($item->bukuDipinjam as $buku)
                                <div>{{ $buku->judul }}</div>
                            @endforeach
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $item->tanggal_pinjam }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $item->tanggal_kembali }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600 text-center">
                            {{ $item->bukuDipinjam->count() }}
                        </td>


                        <td class="px-6 py-4 text-sm text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                Diajukan
                            </span>
                        </td>
                    </tr>
                    @empty

                       <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            Belum ada data pengajuan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination (jika ada) --}}
        @if(isset($pengajuan) && method_exists($pengajuan, 'hasPages') && $pengajuan->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $pengajuan->links() }}
        </div>
        @endif
    </div>
</div>
@endsection