@extends('layouts.app')

@section('header', 'Detail Pesan')

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="mb-6 border-b pb-4">
        <h3 class="text-xl font-bold">{{ $contact->subject }}</h3>
        <p class="text-gray-500">Dari: {{ $contact->name }} ({{ $contact->email }})</p>
        <p class="text-gray-400 text-sm">Diterima pada: {{ $contact->created_at->format('d M Y H:i') }}</p>
    </div>

    <div class="mb-8 p-4 bg-gray-50 rounded">
        <p class="whitespace-pre-wrap">{{ $contact->message }}</p>
    </div>

    <div class="flex justify-between">
        <a href="{{ route('contacts.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Kembali ke Inbox</a>
        <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Hapus Pesan</button>
        </form>
    </div>
</div>
@endsection
