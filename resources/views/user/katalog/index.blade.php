@extends('layouts.sidebar')

@section('content')
{{-- Header Section --}}
<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        
        {{-- Title --}}
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Katalog Buku</h2>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Pilih buku untuk mengajukan peminjaman</p>
        </div>
        
        {{-- Cart Summary --}}
        <div class="bg-white rounded-lg shadow-md px-4 py-3 w-full sm:w-auto">
            <div class="flex items-center justify-between sm:justify-start gap-3">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5"></path>
                    </svg>
                    <p class="text-sm text-gray-600">Dipilih</p>
                </div>
                <p class="text-xl sm:text-2xl font-bold text-blue-600" id="selectedCount">0</p>
            </div>
        </div>
    </div>
</div>

<form id="peminjamanForm" action="{{ route('user.peminjaman.index.multi') }}" method="GET">
    
    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4">

        @forelse ($bukus as $buku)
        {{-- Container dengan efek layered card --}}
        <label class="relative group book-card cursor-pointer" data-buku-id="{{ $buku->id }}">
            
            {{-- Hidden Checkbox --}}
            <input 
                type="checkbox" 
                name="buku_ids[]" 
                value="{{ $buku->id }}"
                class="buku-checkbox peer hidden"
                onchange="updateSelectedCount()"
            >

            {{-- Badge "Dipilih" - Muncul saat checked --}}
            <div class="absolute top-3 right-3 z-10 pointer-events-none">
                <div class="hidden peer-checked:flex items-center gap-1.5 bg-indigo-600 text-white px-3 py-1.5 rounded-full shadow-lg transform transition-all duration-200 animate-in fade-in zoom-in">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-xs font-bold">Dipilih</span>
                </div>
            </div>

            {{-- Efek layer background --}}
            <div class="absolute inset-0 bg-indigo-100 rounded-lg transform translate-x-1.5 translate-y-1.5 group-hover:translate-x-2 group-hover:translate-y-2 peer-checked:translate-x-2 peer-checked:translate-y-2 transition-transform"></div>
            <div class="absolute inset-0 bg-indigo-50 rounded-lg transform translate-x-0.5 translate-y-0.5 group-hover:translate-x-1 group-hover:translate-y-1 peer-checked:translate-x-1 peer-checked:translate-y-1 transition-transform"></div>
            
            {{-- Card utama --}}
            <div class="relative bg-white rounded-lg overflow-hidden shadow-sm transition-all duration-200 flex flex-col h-full group-hover:shadow-md group-hover:-translate-y-0.5 peer-checked:ring-4 peer-checked:ring-indigo-600 peer-checked:shadow-lg">
                
                {{-- Cover Buku --}}
                <div class="aspect-3/4 bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center overflow-hidden relative">
                    {{-- Overlay saat checked --}}
                    <div class="absolute inset-0 bg-indigo-600 opacity-0 peer-checked:opacity-10 transition-opacity pointer-events-none"></div>
                    
                    @if($buku->gambar)
                        <img 
                            src="{{ asset('storage/buku/'.$buku->gambar) }}"
                            alt="{{ $buku->judul }}"
                            class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300"
                        >
                    @else
                        <div class="text-center p-4">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="text-gray-400 text-xs">Tidak ada cover</span>
                        </div>
                    @endif
                </div>

                {{-- Info Buku - Flex grow untuk mengisi ruang --}}
                <div class="p-3 sm:p-4 flex flex-col grow">
                    <h3 class="font-semibold text-gray-900 text-xs sm:text-sm line-clamp-2 mb-2 leading-tight">
                        {{ $buku->judul }}
                    </h3>

                    <p class="text-[10px] sm:text-xs text-gray-600 mb-1 line-clamp-1">
                        <span class="font-medium">Penerbit:</span> {{ $buku->penerbit }}
                    </p>

                    <div class="flex items-center gap-1 mb-2">
                        <span class="text-[10px] sm:text-xs text-gray-600">Stok:</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] sm:text-xs font-medium 
                            {{ $buku->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $buku->stok }}
                        </span>
                    </div>
                </div>
            </div>
        </label>
        @empty
            <div class="col-span-full text-center py-16">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <p class="text-gray-500 text-sm font-medium">Tidak ada buku tersedia</p>
                <p class="text-gray-400 text-xs mt-1">Silakan cek kembali nanti</p>
            </div>
        @endforelse

    </div>

    {{-- Floating Action Button --}}
    <div class="fixed bottom-4 left-1/2 -translate-x-1/2 sm:left-auto sm:right-8 sm:translate-x-0 z-50 w-[90%] sm:w-auto" id="floatingButton" style="display: none;">;">
        <button 
            type="submit"
            class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 sm:py-4 px-6 sm:px-8 rounded-full shadow-xl transition-all duration-300 flex items-center justify-center gap-2">
            
            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"></path>
            </svg>

            <span class="text-sm sm:text-base">
                Lanjutkan (<span id="buttonCount">0</span>)
            </span>
        </button>
    </div>

</form>

<script>
function updateSelectedCount() {
    const checkboxes = document.querySelectorAll('.buku-checkbox:checked');
    const count = checkboxes.length;
    
    // Update counter
    document.getElementById('selectedCount').textContent = count;
    document.getElementById('buttonCount').textContent = count;
    
    // Show/hide floating button
    const floatingButton = document.getElementById('floatingButton');
    if (count > 0) {
        floatingButton.style.display = 'block';
    } else {
        floatingButton.style.display = 'none';
    }
}

// Prevent form submission if no book selected
document.getElementById('peminjamanForm').addEventListener('submit', function(e) {
    const checkboxes = document.querySelectorAll('.buku-checkbox:checked');
    if (checkboxes.length === 0) {
        e.preventDefault();
        alert('Silakan pilih minimal 1 buku untuk dipinjam');
    }
});
</script>

@endsection