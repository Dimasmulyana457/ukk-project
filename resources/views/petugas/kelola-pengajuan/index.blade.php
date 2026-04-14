@extends('layouts.sidebar')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Kelola Pengajuan Peminjaman
    </h1>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-800 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow ">
        <table class="w-full">
            <thead class="bg-indigo-600 text-white text-left">
                <tr>
                    <th class="px-4 py-3 text-sm font-semibold">No</th>
                    <th class="px-4 py-3 text-sm font-semibold">Nama User</th>
                    <th class="px-4 py-3 text-sm font-semibold">Kode Buku</th>
                    <th class="px-4 py-3 text-sm font-semibold">Judul Buku</th>
                    <th class="px-4 py-3 text-sm font-semibold">Tgl Pinjam</th>
                    <th class="px-4 py-3 text-sm font-semibold">Tgl Kembali</th>
                    <th class="px-4 py-3 text-sm font-semibold">No Telp</th>
                    <th class="px-4 py-3 text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($pengajuan as $item)
                <tr class="hover:bg-gray-50 text-left">
                    <td class="px-4 py-3 text-sm text-grey-900 ">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 text-sm text-grey-900">{{ $item->user->name }}</td>
                    <td class="px-4 py-3 text-sm text-left text-indigo-600">
                        @foreach ($item->bukuDipinjam as $buku)
                            <div>{{ $buku->kode_buku }}</div>
                        @endforeach
                    </td>
                    <td class="px-4 py-3 text-sm text-left">
                        @foreach ($item->bukuDipinjam as $buku)
                            <div>{{ $buku->judul }}</div>
                        @endforeach
                    </td>
                    <td class="px-4 py-3 text-sm text-grey-900">{{ $item->tanggal_pinjam }}</td>
                    <td class="px-4 py-3 text-sm text-grey-900">{{ $item->tanggal_kembali }}</td>
                    <td class="px-4 py-3 text-sm text-grey-900">{{ $item->no_telp }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">
                    <div class="flex items-center gap-3">
                        
                        {{-- Terima --}}
                        <form action="{{ route('petugas.pengajuan.terima', $item->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="p-2 bg-green-100 text-green-600 rounded-lg hover:bg-green-200 transition-colors"
                                title="Terima Pengajuan"
                                onclick="return confirm('Yakin terima pengajuan ini?')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                        </form>

                        {{-- Tolak --}}
                        <form action="{{ route('petugas.pengajuan.tolak', $item->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors"
                                title="Tolak Pengajuan"
                                onclick="return confirm('Yakin tolak pengajuan ini?')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>

                    </div>
                </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-8 text-gray-500">
                        Tidak ada pengajuan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
