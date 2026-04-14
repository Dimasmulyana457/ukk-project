@extends('layouts.sidebar')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    
    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Ajukan Peminjaman Buku</h2>
        <p class="text-gray-600 mt-1">Lengkapi form di bawah untuk mengajukan peminjaman {{ count($bukus) }} buku</p>
    </div>

    <form action="{{ route('user.peminjaman.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            
            {{-- Left Column: Books Info --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700 flex items-center justify-between">
                        <span>Buku yang Dipilih</span>
                        <span class="bg-blue-100 text-blue-800 text-sm font-bold px-3 py-1 rounded-full">
                            {{ count($bukus) }} Buku
                        </span>
                    </h3>
                    
                    <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2">
                        @foreach($bukus as $buku)
                            {{-- Hidden input untuk buku_ids --}}
                            <input type="hidden" name="buku_ids[]" value="{{ $buku->id }}">
                            
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex gap-4">
                                    {{-- Book Cover --}}
                                    <div class="flex-shrink-0">
                                        @if($buku->gambar)
                                            <img src="{{ asset('storage/buku/'.$buku->gambar) }}"
                                                 class="w-20 h-28 object-cover rounded shadow-sm">
                                        @else
                                            <div class="w-20 h-28 bg-gray-100 rounded flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    {{-- Book Info --}}
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-gray-900 text-sm mb-1 line-clamp-2">
                                            {{ $buku->judul }}
                                        </h4>
                                        <p class="text-xs text-gray-600 mb-1">
                                            <span class="font-medium">Penerbit:</span> {{ $buku->penerbit }}
                                        </p>
                                        <p class="text-xs text-gray-600 mb-2">
                                            <span class="font-medium">Tahun:</span> {{ $buku->tahun_terbit }}
                                        </p>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $buku->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            Stok: {{ $buku->stok }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Total Stock Summary --}}
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-700">Total Stok Tersedia</span>
                            <span class="text-2xl font-bold text-green-600">
                                {{ $bukus->sum('stok') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Form --}}
            <div class="lg:col-span-3">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold mb-6 text-gray-700">Detail Peminjaman</h3>
                    
                    <div class="space-y-6">
                        
                        {{-- Nama User --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Peminjam
                            </label>
                            <input type="text" value="{{ $user->name }}" readonly
                                class="w-full bg-gray-100 border border-gray-300 rounded-lg px-4 py-3 text-gray-700 cursor-not-allowed">
                        </div>

                        {{-- No Telepon --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nomor Telepon
                            </label>
                            <input 
                                type="text" 
                                value="{{ $user->no_telp ?? '-' }}"
                                readonly
                                class="w-full bg-gray-100 border border-gray-300 rounded-lg px-4 py-3 text-gray-700 cursor-not-allowed"
                            >
                        </div>

                        {{-- Tanggal --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tanggal Pinjam <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="date" 
                                    name="tanggal_pinjam" 
                                    value="{{ old('tanggal_pinjam') }}"
                                    required
                                    min="{{ date('Y-m-d') }}"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    onchange="setTanggalKembaliMin(this.value)"
                                >
                                @error('tanggal_pinjam')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tanggal Kembali <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="date" 
                                    name="tanggal_kembali" 
                                    value="{{ old('tanggal_kembali') }}"
                                    required
                                    id="tanggal_kembali"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                                @error('tanggal_kembali')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Info Notice --}}
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-blue-800">Perhatian</p>
                                    <ul class="text-sm text-blue-700 mt-1 space-y-1">
                                        <li>• Anda akan meminjam <strong>{{ count($bukus) }} buku</strong> sekaligus</li>
                                        <li>• Pastikan tanggal pengembalian sesuai dengan peraturan perpustakaan</li>
                                        <li>• Keterlambatan pengembalian akan dikenakan sanksi</li>
                                        <li>• Semua buku harus dikembalikan pada tanggal yang sama</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Warning if stock insufficient --}}
                        @php
                            $hasInsufficientStock = $bukus->where('stok', '<', 1)->count() > 0;
                        @endphp
                        
                        @if($hasInsufficientStock)
                            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-red-800">Stok Tidak Mencukupi</p>
                                        <p class="text-sm text-red-700 mt-1">
                                            Beberapa buku yang Anda pilih stoknya habis. Silakan kembali dan pilih buku lain.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Button --}}
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('user.katalog') }}" 
                               class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Kembali
                            </a>
                            <button type="submit"
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-blue-600"
                                {{ $hasInsufficientStock ? 'disabled' : '' }}>
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Ajukan Peminjaman ({{ count($bukus) }} Buku)
                                </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </form>

</div>
@endsection

<script>
    function setTanggalKembaliMin(tanggalPinjam) {
        const tanggalKembaliInput = document.getElementById('tanggal_kembali');
        tanggalKembaliInput.min = tanggalPinjam;
        
        // Reset nilai jika tanggal kembali lebih kecil dari tanggal pinjam
        if (tanggalKembaliInput.value && tanggalKembaliInput.value < tanggalPinjam) {
            tanggalKembaliInput.value = '';
        }
    }
</script>