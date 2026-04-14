@extends('layouts.sidebar')

@section('content')
<div class="p-8">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            Informasi Pengajuan Peminjaman
        </h1>
        <p class="text-gray-600">
            Status pengajuan peminjaman buku Anda
        </p>
    </div>

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
                        <th class="px-6 py-4 text-center text-sm font-semibold">Status</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse ($pengajuan as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm">{{ $loop->iteration }}</td>

                        {{-- Kode Buku --}}
                        <td class="px-6 py-4 text-sm text-indigo-600 font-medium">
                            @foreach ($item->details as $detail)
                                <div> {{ $detail->buku->kode_buku ?? '-' }}</div>
                            @endforeach
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                            @foreach ($item->details as $detail)
                                <div> {{ $detail->buku->judul ?? '-' }}</div>
                            @endforeach
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $item->tanggal_pinjam }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $item->tanggal_kembali }}
                        </td>

                        <td class="px-6 py-4 text-sm text-center">
                            @if ($item->status === 'dipinjam')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    Diterima
                                </span>
                            @elseif ($item->status === 'ditolak')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    Ditolak
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if ($item->status === 'dipinjam')
                                <a href="{{ route('user.pengajuan.download', $item->id) }}" 
                                   class="flex items-center justify-center text-indigo-600 hover:text-indigo-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v12m0 0l-4-4m4 4l4-4M4 20h16"/>
                                    </svg>
                                </a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
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
    </div>

</div>
@endsection
