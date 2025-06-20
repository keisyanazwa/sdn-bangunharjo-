@extends('layouts.app')

@section('title', 'Detail Artikel')
@section('navbar', 'navbarKu')

@section('content')
<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-8">
            <h1 class="mb-4">Judul Artikel</h1>
            <p class="text-muted">Diposting pada: 12 Januari 2023</p>
            
            <img src="{{ asset('images/fotosd.png') }}" alt="Gambar Artikel" class="img-fluid mb-4 rounded">
            
            <div class="artikel-content">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget ultricies nisl nisl eget nisl. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget ultricies nisl nisl eget nisl.</p>
                
                <p>Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget ultricies nisl nisl eget nisl. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget ultricies nisl nisl eget nisl.</p>
                
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget ultricies nisl nisl eget nisl. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget ultricies nisl nisl eget nisl.</p>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Artikel Terkait</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Artikel Terkait 1</a></li>
                        <li class="mb-2"><a href="#">Artikel Terkait 2</a></li>
                        <li class="mb-2"><a href="#">Artikel Terkait 3</a></li>
                        <li class="mb-2"><a href="#">Artikel Terkait 4</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Kategori</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Berita Sekolah</a></li>
                        <li class="mb-2"><a href="#">Prestasi Siswa</a></li>
                        <li class="mb-2"><a href="#">Kegiatan Ekstrakurikuler</a></li>
                        <li class="mb-2"><a href="#">Pengumuman</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection