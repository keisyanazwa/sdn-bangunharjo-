@extends('layouts.app')

@section('title', $gallery->title . ' - SDN BANGUNHARJO')
@section('navbar', 'navbarKu')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <img src="{{ $gallery->image_url }}" class="card-img-top img-fluid" alt="{{ $gallery->title }}">
                <div class="card-body">
                    <h2 class="card-title">{{ $gallery->title }}</h2>
                    <div class="mt-4">
                        <a href="{{ route('pages.galeri') }}" class="btn btn-primary"><i class="fas fa-arrow-left mr-2"></i> Kembali ke Galeri</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection