@extends('layouts.admin')

@section('title', 'Edit Foto Galeri')

@section('content')
<div class="container">
    <h2 class="text-center dashboard-title">Edit Foto Galeri</h2>
    <p class="text-center mb-4">Perbarui informasi foto galeri.</p>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">Form Edit Foto</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Judul Foto</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $gallery->title }}" required>
                            @error('title')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Foto Baru (Opsional)</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                            <small class="form-text text-muted">Pilih file gambar baru jika ingin mengganti (format: jpg, png, gif). Maksimal 2MB.</small>
                            @error('image')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Foto Saat Ini:</label>
                            <div>
                                <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        </div>

                        <div class="form-group text-right mb-0">
                            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection