@extends('errors.minimal')

@section('title', 'Server Error')
@section('code', '500')
@section('icon')
    <i class="fas fa-exclamation-triangle"></i>
@endsection
@section('message', 'Kesalahan Sistem')
@section('description', 'Terjadi kesalahan pada server kami. Tim teknis kami telah diberitahu dan akan segera memperbaikinya.')
