@php
    $user = Auth::user();
    $role = $user->role;
@endphp

@extends('layouts.sidebar')

@section('content')
    {{-- Content Area --}}
    <div class="p-8">
        {{-- Page Header --}}
        <div class="mb-8">
            <div class="flex items-center space-x-2 text-sm text-gray-600 mb-4">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <span>/</span>
                <a href="{{ route('admin.buku.index') }}" class="hover:text-indigo-600">Kelola Buku</a>
                <span>/</span>
                <span class="text-indigo-600 font-medium">Edit Buku</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit Buku</h1>
            <p class="text-gray-600">Perbarui informasi buku</p>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Kode Buku --}}
                <div>
                    <label for="kode_buku" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kode Buku <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="kode_buku" 
                           id="kode_buku" 
                           value="{{ old('kode_buku', $buku->kode_buku) }}"
                           class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('kode_buku') @enderror"
                           placeholder="Contoh: BK001"
                           required>
                    @error('kode_buku')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Judul --}}
                <div>
                    <label for="judul" class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul Buku <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="judul" 
                           id="judul" 
                           value="{{ old('judul', $buku->judul) }}"
                           class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('judul') @enderror"
                           placeholder="Masukkan judul buku"
                           required>
                    @error('judul')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Gambar Buku --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Gambar Buku
                    </label>

                    @if($buku->gambar)
                        <div class="flex items-center space-x-4 mb-3">
                            <img src="{{ asset('storage/buku/'.$buku->gambar) }}"
                                 class="w-24 h-32 object-cover rounded-lg border border-gray-300">
                            <div class="text-sm text-gray-600">
                                <p>Gambar saat ini</p>
                                <p class="text-xs mt-1">Unggah gambar baru untuk mengganti</p>
                            </div>
                        </div>
                    @endif

                    <input type="file"
                           name="gambar"
                           accept="image/*"
                           class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (max 2MB). Kosongkan jika tidak ingin mengubah gambar.</p>
                </div>

                {{-- Pengarang --}}
                <div>
                    <label for="pengarang" class="block text-sm font-semibold text-gray-700 mb-2">
                        Pengarang <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="pengarang" 
                           id="pengarang" 
                           value="{{ old('pengarang', $buku->pengarang) }}"
                           class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('pengarang') @enderror"
                           placeholder="Nama pengarang"
                           required>
                    @error('pengarang')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Penerbit --}}
                <div>
                    <label for="penerbit" class="block text-sm font-semibold text-gray-700 mb-2">
                        Penerbit <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="penerbit" 
                           id="penerbit" 
                           value="{{ old('penerbit', $buku->penerbit) }}"
                           class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('penerbit') @enderror"
                           placeholder="Nama penerbit"
                           required>
                    @error('penerbit')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tahun Terbit --}}
                <div>
                    <label for="tahun_terbit" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tahun Terbit <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="tahun_terbit" 
                           id="tahun_terbit" 
                           value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                           class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('tahun_terbit') @enderror"
                           placeholder="2024"
                           min="1900"
                           max="2099"
                           required>
                    @error('tahun_terbit')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="kategori_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori_id" 
                            id="kategori_id" 
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('kategori_id') @enderror"
                            required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $buku->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stok --}}
                <div>
                    <label for="stok" class="block text-sm font-semibold text-gray-700 mb-2">
                        Stok <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="stok" 
                           id="stok" 
                           value="{{ old('stok', $buku->stok) }}"
                           class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('stok') @enderror"
                           placeholder="Jumlah stok"
                           min="0"
                           required>
                    @error('stok')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.buku.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium shadow-lg hover:shadow-xl">
                    Update Buku
                </button>
            </div>
        </form>
    </div>
@endsection