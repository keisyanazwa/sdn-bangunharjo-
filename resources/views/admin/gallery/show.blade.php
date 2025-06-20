@extends('layouts.admin')

@section('title', $gallery->title)

@section('content')
<div class="container">
    <h2 class="text-center dashboard-title">Detail Foto Galeri</h2>
    <p class="text-center mb-4">Informasi lengkap tentang foto galeri.</p>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">{{ $gallery->title }}</h6>
                    <div>
                        <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i> Edit</a>
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-left"></i> Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" class="img-fluid rounded" style="max-height: 400px;">
                    </div>
                    
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Judul</th>
                            <td>{{ $gallery->title }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Dibuat</th>
                            <td>{{ $gallery->created_at->format('d F Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diperbarui</th>
                            <td>{{ $gallery->updated_at->format('d F Y, H:i') }}</td>
                        </tr>
                    </table>
                    
                    <div class="mt-4 text-right">
                        <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')"><i class="bi bi-trash"></i> Hapus Foto</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection