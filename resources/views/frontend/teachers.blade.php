@extends('layouts.app')

@section('title', 'Profil Guru - SDN BANGUNHARJO')
@section('navbar', 'navbarKu')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/teacher-info.css') }}">
@endsection

@section('content')
<div class="title">
    <h1 class="text-center">Profil Guru</h1>
    <p class="text-center">Beberapa Guru di SD Negeri Bangunharjo</p>
</div>

<div class="container ekstrakulikuler">
    @forelse($teachers as $teacher)
        <a class="perEkstrakulikuler">
            <img src="{{ $teacher->image_url && filter_var($teacher->image_url, FILTER_VALIDATE_URL) ? $teacher->image_url : ( $teacher->image_url ? asset('storage/' . $teacher->image_url) : asset('images/front_logo.png') ) }}" style="object-fit: cover; width: 100%; height: 100%; aspect-ratio: 1/1;">
            <div class="teacher-info">
                <div class="teacher-name">{{ $teacher->name }}</div>
                <div class="teacher-position">{{ $teacher->position }}</div>
            </div>
        </a>
    @empty
        <div class="col-12 text-center py-5">
            <p>Belum ada data guru.</p>
        </div>
    @endforelse
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/script.js') }}"></script>
@endsection