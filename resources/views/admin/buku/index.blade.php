@php
    $user = Auth::user();
    $role = $user->role;
@endphp

@extends('layouts.sidebar')

@section('content')
        {{-- Content Area --}}
        <div class="p-8">
            {{-- Page Header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Kelola Buku</h1>
                    <p class="text-gray-600">Manajemen data buku perpustakaan</p>
                </div>
                <a href="{{ route('admin.buku.create') }}" class="flex items-center space-x-2 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span class="font-medium">Tambah Buku</span>
                </a>
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
                            <tr class="bg-indigo-500 text-white">
                                <th class="px-6 py-4 text-left text-sm font-semibold">No</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Gambar</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Kode Buku</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Judul</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Pengarang</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Penerbit</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Tahun Terbit</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Stok</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Kategori</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($buku ?? [] as $index => $buku)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    @if($buku->gambar)
                                        <img src="{{ url('storage/buku/'.$buku->gambar) }}"
                                             class="w-12 h-16 object-cover rounded">
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-indigo-600">{{ $buku->kode_buku }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $buku->judul }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $buku->pengarang }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $buku->penerbit }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $buku->tahun_terbit }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $buku->stok > 5 ? 'bg-green-100 text-green-800' : ($buku->stok > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $buku->stok }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $buku->kategori->nama_kategori ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.buku.edit', $buku->id) }}" class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.buku.destroy', $buku->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        <p class="text-gray-500 text-lg font-medium">Belum ada data buku</p>
                                        <p class="text-gray-400 text-sm mt-1">Klik tombol "Tambah Buku" untuk menambahkan buku baru</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if(isset($bukus) && $bukus->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $bukus->links() }}
                </div>
                @endif
            </div>
        </div>
    </main>

</div>
@endsection