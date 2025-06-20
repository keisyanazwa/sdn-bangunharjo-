@extends('layouts.admin')

@section('title', 'Tambah Guru')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-person-plus-fill mr-2"></i>Tambah Guru</h1>
        <a href="{{ route('admin.teachers.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Flash Messages -->
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle-fill mr-2"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle-fill mr-2"></i>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- Create Teacher Form -->
    <div class="card shadow mb-4 border-left-primary">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><i class="bi bi-pencil-square mr-1"></i>Form Tambah Guru</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Opsi:</div>
                    <a class="dropdown-item" href="#" id="resetFormBtn"><i class="bi bi-arrow-counterclockwise mr-1"></i>Reset Form</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle-fill mr-2"></i> Silakan isi data guru dengan lengkap. Field dengan tanda <span class="text-danger">*</span> wajib diisi.
            </div>
            <form action="{{ route('admin.teachers.store') }}" method="POST" enctype="multipart/form-data" id="teacherForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                </div>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap guru">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="position" class="font-weight-bold">Jabatan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                </div>
                                <input type="text" class="form-control" id="position" name="position" value="{{ old('position') }}" required placeholder="Masukkan jabatan guru">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="photo" class="font-weight-bold">Foto</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="photo" name="photo" accept="image/*">
                                <label class="custom-file-label" for="photo">Pilih file</label>
                            </div>
                            <small class="form-text text-muted"><i class="bi bi-info-circle mr-1"></i>Format: JPG, JPEG, PNG, GIF. Maks: 2MB</small>
                        </div>
                        <div class="mt-3">
                            <div id="preview-container" style="display: none;" class="text-center p-3 border rounded bg-light fade-in">
                                <p class="mb-2"><i class="bi bi-image mr-1"></i>Preview:</p>
                                <img id="preview-image" src="#" alt="Preview" class="img-thumbnail shadow-sm" style="max-height: 200px; transition: all 0.3s ease;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-right mt-4">
                    <button type="reset" class="btn btn-secondary mr-2">
                        <i class="bi bi-arrow-counterclockwise mr-1"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save mr-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Preview image before upload
    $(document).ready(function() {
        // Update file input label with selected filename
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
            
            // Preview image
            if (this.files && this.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-image').attr('src', e.target.result);
                    $('#preview-container').fadeIn('slow');
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        // Reset form button in dropdown
        $('#resetFormBtn').click(function(e) {
            e.preventDefault();
            $('#teacherForm')[0].reset();
            $('.custom-file-label').html('Pilih file');
            $('#preview-container').fadeOut('fast');
        });
    });
</script>

<style>
    .fade-in {
        animation: fadeIn 0.5s;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    #preview-image:hover {
        transform: scale(1.05);
    }
</style>
@endsection