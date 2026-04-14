@extends('layouts.sidebar')

@section('content')
<div class="p-8">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            Riwayat Peminjaman Buku
        </h1>
        <p class="text-gray-600">
            Daftar seluruh buku yang pernah Anda pinjam
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-indigo-600 text-white">
                        <th class="px-6 py-4 text-left text-sm">No</th>
                        <th class="px-6 py-4 text-left text-sm">Kode Buku</th>
                        <th class="px-6 py-4 text-left text-sm">Judul Buku</th>
                        <th class="px-6 py-4 text-left text-sm">Tanggal Pinjam</th>
                        <th class="px-6 py-4 text-left text-sm">Tanggal Kembali</th>
                        <th class="px-6 py-4 text-center text-sm">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse ($riwayat as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 text-sm font-medium">
                            @foreach ($item->details as $detail)
                                <div>• {{ $detail->buku->kode_buku ?? '-' }}</div>
                            @endforeach
                        </td>

                       <td class="px-6 py-4 text-sm font-medium">
                            @foreach ($item->details as $detail)
                                <div>• {{ $detail->buku->judul ?? '-' }}</div>
                            @endforeach
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $item->tanggal_pinjam }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $item->tanggal_kembali }}
                        </td>

                        <td class="px-6 py-4 text-center text-sm">
                            @if ($item->status == 'dipinjam')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    Dipinjam
                                </span>
                            @elseif ($item->status == 'dikembalikan')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    Dikembalikan
                                </span>
                            @elseif ($item->status == 'ditolak')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    Ditolak
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            Belum ada riwayat peminjaman
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
