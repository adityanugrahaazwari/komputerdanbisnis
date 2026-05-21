@extends('layouts.app')

@section('header', 'Dashboard')

@section('content')
<div class="bg-white rounded shadow p-6">
    <h3 class="text-lg font-semibold mb-4">Welcome to Dashboard</h3>
    <p class="text-gray-600">This is your main dashboard area. Your role is: 
        <strong>{{ auth()->user()->roles->pluck('name')->join(', ') }}</strong>
    </p>
    
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-blue-100 border-l-4 border-blue-500 p-4">
            <h4 class="font-bold text-blue-800">Your Permissions:</h4>
            <ul class="mt-2 list-disc ml-5 text-blue-700">
                @foreach(auth()->user()->roles as $role)
                    @foreach($role->permissions as $perm)
                        <li>{{ $perm->name }} ({{ $perm->slug }})</li>
                    @endforeach
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
