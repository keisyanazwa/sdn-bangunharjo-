@extends('layouts.app')

@section('title', $news->title . ' - SDN Bangunharjo')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light p-3">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('news') }}">Berita</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $news->title }}</li>
                </ol>
            </nav>

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

            <!-- News Detail -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Berita</h6>
                </div>
                <div class="card-body">
                    <img src="{{ $news->getImageUrl() }}" class="img-fluid mb-4 w-100" alt="{{ $news->title }}" style="max-height: 400px; object-fit: cover;">
                    <h1 class="h3 mb-3">{{ $news->title }}</h1>
                    <div class="d-flex align-items-center mb-4">
                        <span class="text-muted mr-3"><i class="bi bi-calendar"></i> {{ $news->created_at->format('d M Y') }}</span>
                        <span class="text-muted"><i class="bi bi-person"></i> Admin</span>
                    </div>
                    <div class="news-content">
                        {{ $news->content }}
                    </div>
                </div>
            </div>

            <!-- Related News -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Berita Terkait</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($relatedNews as $item)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <img src="{{ $item->getImageUrl() }}" class="card-img-top" alt="{{ $item->title }}" style="height: 120px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title">{{ Str::limit($item->title, 40) }}</h6>
                                    <p class="card-text small text-muted">{{ $item->created_at->format('d M Y') }}</p>
                                    <a href="{{ route('news.show', $item->id) }}" class="btn btn-sm btn-primary">Baca</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <p class="text-center mb-0">Tidak ada berita terkait.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('news') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Berita
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .news-content {
        line-height: 1.8;
        font-size: 1.1rem;
    }
    
    .breadcrumb {
        border-radius: 0.5rem;
    }
    
    .card {
        border-radius: 0.5rem;
        overflow: hidden;
    }
</style>
@endsection