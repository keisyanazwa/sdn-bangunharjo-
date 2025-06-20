@extends('layouts.app')

@section('title', 'Galeri - SDN BANGUNHARJO')
@section('navbar', 'navbarKu')

@section('content')
<div class="title">
    <h1 class="text-center">Galeri Kami</h1>
</div>

<div class="container perGaleri">
        @forelse($galleries as $gallery)
                <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}">
            
        @empty
            <div class="col-12 text-center py-5">
                <p>Belum ada foto dalam galeri.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection