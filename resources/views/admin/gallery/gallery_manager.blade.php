@extends('layouts.admin')

@section('title', 'Kelola Galeri')

@section('content')
<div class="container">
    <h2 class="text-center dashboard-title">Kelola Galeri</h2>
    <p class="text-center mb-4">Tambah, edit, dan hapus foto-foto kegiatan sekolah.</p>

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

    <div class="row">
        <!-- Form Tambah/Edit Foto -->
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">{{ isset($editGallery) ? 'Edit Foto' : 'Tambah Foto' }}</h6>
                </div>
                <div class="card-body">
                    @if(isset($editGallery))
                    <form action="{{ route('admin.gallery.update', $editGallery->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                    @else
                    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @endif
                        @csrf
                        <div class="form-group">
                            <label for="title">Judul Foto</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ isset($editGallery) ? $editGallery->title : old('title') }}" required>
                            @error('title')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Foto</label>
                            <input type="file" class="form-control-file" id="image" name="image" {{ isset($editGallery) ? '' : 'required' }}>
                            <small class="form-text text-muted">Pilih file gambar (format: jpg, png, gif). Maksimal 2MB.</small>
                            @error('image')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        @if(isset($editGallery) && $editGallery->image_url)
                        <div class="form-group">
                            <label>Gambar Saat Ini:</label>
                            <div>
                                <img src="{{ $editGallery->image_url }}" alt="{{ $editGallery->title }}" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        </div>
                        @endif

                        <div class="form-group text-right mb-0">
                            @if(isset($editGallery))
                            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Batal</a>
                            @endif
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Tabel Galeri -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Daftar Foto</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="30%">Judul</th>
                                    <th width="30%">Thumbnail</th>
                                    <th width="25%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($galleries as $index => $gallery)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $gallery->title }}</td>
                                    <td><img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" class="img-thumbnail" style="max-height: 80px;"></td>
                                    <td>
                                        <a href="{{ route('admin.gallery.edit', $gallery->id) }}?manager=true" class="btn btn-sm btn-info"><i class="bi bi-pencil"></i> Edit</a>
                                        <form action="{{ route('admin.gallery.destroy', $gallery->id) }}?manager=true" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')"><i class="bi bi-trash"></i> Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada foto dalam galeri</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection