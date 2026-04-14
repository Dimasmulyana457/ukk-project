<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Peminjaman Buku</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite('resources/css/app.css')
    <style>[x-cloak] { display: none !important; }</style>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100" x-data="{ open: false, openProfil: false }">

    @php
        $user = Auth::user();
        $role = $user->role;
    @endphp

    <div class="flex min-h-screen bg-linear-to-br from-purple-50 via-blue-50 to-pink-50">

        {{-- Overlay (mobile) --}}
        <div x-cloak x-show="open" x-transition.opacity
            @click="open = false"
            class="fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

        {{-- Sidebar --}}
        <aside 
            x-cloak
            :class="open ? 'translate-x-0' : '-translate-x-full'"
            class="fixed z-[60] inset-y-0 left-0 w-64 bg-white shadow-xl transform lg:translate-x-0 lg:static lg:inset-0 transition-transform duration-300 flex flex-col">
            
            {{-- Logo --}}
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-xl">=</span>
                    </div>
                    <span class="text-xl font-bold text-gray-800">books</span>
                </div>

                {{-- Close button (mobile) --}}
                <button @click="open = false" class="lg:hidden">
                    ✕
                </button>
            </div>

            {{-- Navigation Menu --}}
            <nav class="flex-1 px-4 py-6 space-y-1">
                @if ($role === 'admin')
                    {{-- Dashboard --}}
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600 bg-indigo-50 rounded-lg border-l-4 border-indigo-600' : 'text-gray-600 hover:bg-gray-50 rounded-lg transition-colors' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    {{-- Kelola Anggota --}}
                    <a href="{{ route('admin.anggota.index') }}"
                       class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('admin.anggota.*') ? 'text-indigo-600 bg-indigo-50 rounded-lg border-l-4 border-indigo-600' : 'text-gray-600 hover:bg-gray-50 rounded-lg transition-colors' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span class="font-medium">Kelola Anggota</span>
                    </a>

                    {{-- Kelola Buku --}}
                    <a href="{{ route('admin.buku.index') }}"
                       class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('admin.buku.*') ? 'text-indigo-600 bg-indigo-50 rounded-lg border-l-4 border-indigo-600' : 'text-gray-600 hover:bg-gray-50 rounded-lg transition-colors' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span class="font-medium">Kelola Buku</span>
                    </a>
                    
                    {{-- Laporan --}}
                    <a href="{{ route('admin.laporan.index') }}"
                       class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('admin.laporan.*') ? 'text-indigo-600 bg-indigo-50 rounded-lg border-l-4 border-indigo-600' : 'text-gray-600 hover:bg-gray-50 rounded-lg transition-colors' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6M4 3h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4a1 1 0 011-1z" />
                        </svg>
                        <span class="font-medium">Laporan</span>
                    </a>

                    {{-- Activity Log --}}
                    <a href="{{ route('admin.activity-log') }}"
                    class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('admin.activity-log') ? 'text-indigo-600 bg-indigo-50 rounded-lg border-l-4 border-indigo-600' : 'text-gray-600 hover:bg-gray-50 rounded-lg transition-colors' }}">
                        
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 7h6m-6 4h6"/>
                        </svg>

                        <span class="font-medium">Activity Log</span>
                    </a>

                {{-- Menu untuk Petugas --}}
                @elseif ($role === 'petugas')
                    <a href="{{ route('petugas.dashboard') }}"
                       class="flex items-center space-x-3 px-4 py-3 {{ request()->is('petugas/dashboard') ? 'text-indigo-600 bg-indigo-50 rounded-lg border-l-4 border-indigo-600' : 'text-gray-600 hover:bg-gray-50 rounded-lg transition-colors' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <a href="{{ route('petugas.kelola.pengajuan') }}"
                       class="flex items-center space-x-3 px-4 py-3 {{ request()->is('petugas/kelola-pengajuan') ? 'text-indigo-600 bg-indigo-50 rounded-lg border-l-4 border-indigo-600' : 'text-gray-600 hover:bg-gray-50 rounded-lg transition-colors' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 7h6m-6 4h6"/>
                        </svg>
                        <span class="font-medium">Kelola Peminjaman</span>
                    </a>

                    <a href="{{ route('petugas.pengembalian.index') }}"
                       class="flex items-center space-x-3 px-4 py-3 {{ request()->is('petugas/pengembalian') ? 'text-indigo-600 bg-indigo-50 rounded-lg border-l-4 border-indigo-600' : 'text-gray-600 hover:bg-gray-50 rounded-lg transition-colors' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium">Pengembalian</span>
                    </a>

                    <a href="{{ route('petugas.laporan.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('petugas.laporan.*') ? 'text-indigo-600 bg-indigo-50 rounded-lg border-l-4 border-indigo-600' : 'text-gray-600 hover:bg-gray-50 rounded-lg transition-colors' }}">                        
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6M4 3h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4a1 1 0 011-1z" />
                            </svg>
                            <span class="font-medium">Laporan</span>
                        </a>

                {{-- Menu untuk User --}}
                @elseif ($role === 'user')
                    <a href="{{ route('user.katalog') }}"
                       class="flex items-center space-x-3 px-4 py-3 {{ request()->is('user/katalog') ? 'text-indigo-600 bg-indigo-50 rounded-lg border-l-4 border-indigo-600' : 'text-gray-600 hover:bg-gray-50 rounded-lg transition-colors' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span class="font-medium">Katalog Buku</span>
                    </a>

                    <a href="{{ route('user.pengajuan') }}"
                       class="flex items-center space-x-3 px-4 py-3 {{ request()->is('user/pengajuan') ? 'text-indigo-600 bg-indigo-50 rounded-lg border-l-4 border-indigo-600' : 'text-gray-600 hover:bg-gray-50 rounded-lg transition-colors' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium">Pengajuan Pending</span>
                    </a>

                    <a href="{{ route('user.informasi-pengajuan') }}"
                       class="flex items-center space-x-3 px-4 py-3 {{ request()->is('user/informasi-pengajuan') ? 'text-indigo-600 bg-indigo-50 rounded-lg border-l-4 border-indigo-600' : 'text-gray-600 hover:bg-gray-50 rounded-lg transition-colors' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium">Informasi Pengajuan</span>
                    </a>

                    <a href="{{ route('user.riwayat') }}"
                       class="flex items-center space-x-3 px-4 py-3 {{ request()->is('user/riwayat-peminjaman') ? 'text-indigo-600 bg-indigo-50 rounded-lg border-l-4 border-indigo-600' : 'text-gray-600 hover:bg-gray-50 rounded-lg transition-colors' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <span class="font-medium">Riwayat Peminjaman</span>
                    </a>
                @endif
            </nav>

            {{-- Logout Button --}}
            <div class="p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center space-x-2 px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 overflow-y-auto">
            {{-- Header --}}
            <header class="bg-white shadow-sm">
                <div class="px-4 lg:px-8 py-4 flex items-center justify-between">

                    {{-- LEFT --}}
                    <div class="flex items-center space-x-4">

                        {{-- BURGER BUTTON --}}
                        <button @click="open = true" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        <input type="text" placeholder="Cari..."
                            class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 w-40 lg:w-80">
                    </div>

                    {{-- RIGHT --}}
                    <div class="flex items-center space-x-4">
                        <button class="p-2 hover:bg-gray-100 rounded-lg">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </button>

                        <div @click="openProfil = true" class="flex items-center space-x-3 cursor-pointer hover:bg-gray-100 p-2 rounded-lg transition">
                            <div class="w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div class="hidden sm:block">
                                <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ ucfirst($role) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Content Area --}}
            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>
@stack('scripts')

{{-- MODAL PROFIL --}}
<div x-cloak x-show="openProfil" x-transition
     class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50">

    <div @click.away="openProfil = false"
         class="bg-white w-full max-w-lg rounded-2xl shadow-xl p-6">

        <h2 class="text-xl font-bold mb-4">Profil Saya</h2>

        <form action="{{ route('profil.update') }}" method="POST">
            @csrf

            {{-- Nama --}}
            <div class="mb-3">
                <label class="text-sm">Nama</label>
                <input type="text" name="name" value="{{ $user->name }}"
                    class="w-full mt-1 px-3 py-2 border rounded-lg">
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label class="text-sm">Email</label>
                <input type="email" name="email" value="{{ $user->email }}"
                    class="w-full mt-1 px-3 py-2 border rounded-lg">
            </div>

            {{-- No Telp (user only) --}}
            @if($role === 'user')
            <div class="mb-3">
                <label class="text-sm">No Telepon</label>
                <input type="text" name="no_telp" value="{{ $user->no_telp }}"
                    class="w-full mt-1 px-3 py-2 border rounded-lg">
            </div>
            @endif

            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" @click="openProfil = false"
                    class="px-4 py-2 bg-gray-200 rounded-lg">
                    Batal
                </button>

                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>