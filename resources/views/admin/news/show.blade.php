@extends('layouts.admin')

@section('title', $news->title)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Berita</h1>
        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Berita
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{ $news->title }}</h6>
            <div>
                <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-sm btn-info">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <form action="{{ route('admin.news.destroy', $news->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Judul:</h5>
                        <p>{{ $news->title }}</p>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Keterangan:</h5>
                        <p>{{ $news->content }}</p>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Status:</h5>
                        <span class="badge badge-{{ $news->status == 'published' ? 'success' : 'warning' }}">
                            {{ $news->status == 'published' ? 'Publikasi' : 'Draft' }}
                        </span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Tanggal Dibuat:</h5>
                        <p>{{ $news->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Terakhir Diperbarui:</h5>
                        <p>{{ $news->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Gambar:</h5>
                        <img src="{{ $news->getImageUrl() }}" alt="{{ $news->title }}" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection