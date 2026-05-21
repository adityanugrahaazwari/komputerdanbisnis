@extends('layouts.app')

@section('header', 'Audit Logs')

@section('content')
<div class="bg-white rounded shadow p-6">
    <h3 class="text-lg font-semibold mb-4">Aktivitas Sistem</h3>

    <table class="min-w-full bg-white border text-sm">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b text-left">Waktu</th>
                <th class="py-2 px-4 border-b text-left">User</th>
                <th class="py-2 px-4 border-b text-left">Aksi</th>
                <th class="py-2 px-4 border-b text-left">Deskripsi</th>
                <th class="py-2 px-4 border-b text-left">IP Address</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td class="py-2 px-4 border-b whitespace-nowrap">{{ $log->created_at->format('d M Y H:i:s') }}</td>
                <td class="py-2 px-4 border-b">{{ $log->user->name ?? 'System' }}</td>
                <td class="py-2 px-4 border-b">
                    <span class="px-2 py-1 rounded text-[10px] uppercase font-bold bg-slate-100">{{ $log->action }}</span>
                </td>
                <td class="py-2 px-4 border-b">{{ $log->description }}</td>
                <td class="py-2 px-4 border-b text-xs text-gray-400">{{ $log->ip_address }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>
@endsection
