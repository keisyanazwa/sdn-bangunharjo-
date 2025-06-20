@extends('layouts.admin')

@section('title', 'Detail Guru')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Guru</h1>
        <div>
            <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-2">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('admin.teachers.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Teacher Details -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Guru</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    <img src="{{ $teacher->getPhotoUrl() }}" alt="{{ $teacher->name }}" class="img-fluid rounded" style="max-height: 300px;">
                </div>
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Nama Lengkap</th>
                            <td>{{ $teacher->name }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Ditambahkan</th>
                            <td>{{ $teacher->created_at->format('d F Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diperbarui</th>
                            <td>{{ $teacher->updated_at->format('d F Y, H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mb-4">
        <div class="col-12 text-right">
            <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus guru ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Hapus Guru
                </button>
            </form>
        </div>
    </div>
</div>
@endsection