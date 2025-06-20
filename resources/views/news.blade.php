@extends('layouts.app')

@section('title', 'Berita - SDN Bangunharjo')
@section('navbar', 'navbarKu')

@section('content')
<div class="container titleArtikel">
    <!-- <h1>Latest Post</h1> -->
    <h1>Postingan Terbaru</h1>
</div>

<!-- Flash Messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- News List -->
<div class="container artikel">
    @forelse($news as $item )
        @if($item->status == 'published')
        <a href="{{ route('pages.perArtikel', $item->id) }}" class="text-decoration-none">
            <div class="perArtikel">
                <img src="{{ $item->getImageUrl() }}" class="card-img-top" alt="{{ $item->title }}">
                <div class="textArtikel">
                    <h3>{{ $item->title }}</h3>
                    <p>{!! $item->content !!}</p>
                </div>
            </div>
        </a>
        @endif
    @empty
    <div class="col-12 text-center">
        <p>Belum ada berita yang tersedia.</p>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="container d-flex justify-content-center mt-4">
    {{ $news->links() }}
</div>
@endsection

@section('styles')
<style>
    .news-card {
        transition: transform 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
</style>
@endsection