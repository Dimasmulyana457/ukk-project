@extends('layouts.sidebar')

@section('content')
<div class="p-8">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Activity Log
    </h1>

    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full">
            <thead class="bg-indigo-600 text-white text-left">
                <tr>
                    <th class="px-4 py-3 text-sm font-semibold">Waktu</th>
                    <th class="px-4 py-3 text-sm font-semibold">Role</th>
                    <th class="px-4 py-3 text-sm font-semibold">Aktivitas</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm">
                        {{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }}
                    </td>
                    <td class="px-4 py-3 text-sm font-medium text-gray-700">
                        {{ $log->user->role ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">
                        {{ $log->aktivitas }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-6 text-gray-500">
                        Belum ada aktivitas
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>
@endsection