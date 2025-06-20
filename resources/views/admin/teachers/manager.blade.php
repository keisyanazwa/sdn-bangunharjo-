@extends('layouts.admin')

@section('title', 'Manajemen Guru')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Guru</h1>
        <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="addTeacherBtn">
            <i class="bi bi-plus-circle"></i> Tambah Guru
        </button>
    </div>

    <!-- Alert Container -->
    <div id="alertContainer"></div>

    <!-- Teachers Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Guru</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="teachersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Foto</th>
                            <th width="60%">Nama</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded here via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Teacher Modal -->
<div class="modal fade" id="teacherModal" tabindex="-1" aria-labelledby="teacherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="teacherModalLabel">Tambah Guru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="teacherForm" enctype="multipart/form-data">
                    <input type="hidden" id="teacherId" name="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="photo">Foto</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="photo" name="photo">
                                    <label class="custom-file-label" for="photo">Pilih file</label>
                                </div>
                                <small class="form-text text-muted">Format: JPG, JPEG, PNG, GIF. Maks: 2MB</small>
                            </div>
                            <div class="mt-3">
                                <div id="currentPhotoContainer" style="display: none;">
                                    <p>Foto saat ini:</p>
                                    <img id="currentPhoto" src="#" alt="Foto Guru" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                                <div id="previewContainer" style="display: none; margin-top: 10px;">
                                    <p>Preview foto baru:</p>
                                    <img id="previewPhoto" src="#" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveTeacherBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus guru ini?</p>
                <p class="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        const table = $('#teachersTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            }
        });

        // Load teachers data
        function loadTeachers() {
            $.ajax({
                url: '/api/teachers',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    table.clear();
                    
                    if (response.length === 0) {
                        table.row.add([
                            '',
                            '',
                            'Belum ada data guru',
                            ''
                        ]).draw();
                        return;
                    }
                    
                    $.each(response, function(index, teacher) {
                        const photoUrl = teacher.photo ? 
                            '/storage/' + teacher.photo : 
                            '/images/default-teacher.png';
                            
                        const actions = `
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-primary edit-btn" data-id="${teacher.id}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="${teacher.id}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        `;
                        
                        table.row.add([
                            index + 1,
                            `<img src="${photoUrl}" alt="${teacher.name}" class="img-thumbnail" style="max-height: 80px;">`,
                            teacher.name,
                            actions
                        ]).draw();
                    });
                },
                error: function(xhr, status, error) {
                    showAlert('danger', 'Gagal memuat data guru: ' + error);
                }
            });
        }

        // Initial load
        loadTeachers();

        // Show alert message
        function showAlert(type, message) {
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `;
            $('#alertContainer').html(alertHtml);
            
            // Auto dismiss after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        }

        // Reset form
        function resetForm() {
            $('#teacherForm')[0].reset();
            $('#teacherId').val('');
            $('.custom-file-label').html('Pilih file');
            $('#currentPhotoContainer').hide();
            $('#previewContainer').hide();
        }

        // Add Teacher button click
        $('#addTeacherBtn').click(function() {
            resetForm();
            $('#teacherModalLabel').text('Tambah Guru');
            $('#teacherModal').modal('show');
        });

        // Preview image before upload
        $('#photo').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewPhoto').attr('src', e.target.result);
                    $('#previewContainer').show();
                }
                reader.readAsDataURL(file);
                
                // Update file input label
                const fileName = file.name;
                $(this).next('.custom-file-label').html(fileName);
            }
        });

        // Edit button click (delegated event)
        $('#teachersTable').on('click', '.edit-btn', function() {
            const teacherId = $(this).data('id');
            
            // Reset form
            resetForm();
            
            // Load teacher data
            $.ajax({
                url: `/api/teachers/${teacherId}`,
                type: 'GET',
                dataType: 'json',
                success: function(teacher) {
                    $('#teacherId').val(teacher.id);
                    $('#name').val(teacher.name);
                    
                    // Show current photo if exists
                    if (teacher.photo) {
                        const photoUrl = '/storage/' + teacher.photo;
                        $('#currentPhoto').attr('src', photoUrl);
                        $('#currentPhotoContainer').show();
                    }
                    
                    $('#teacherModalLabel').text('Edit Guru');
                    $('#teacherModal').modal('show');
                },
                error: function(xhr, status, error) {
                    showAlert('danger', 'Gagal memuat data guru: ' + error);
                }
            });
        });

        // Delete button click (delegated event)
        $('#teachersTable').on('click', '.delete-btn', function() {
            const teacherId = $(this).data('id');
            $('#confirmDeleteBtn').data('id', teacherId);
            $('#deleteModal').modal('show');
        });

        // Confirm delete button click
        $('#confirmDeleteBtn').click(function() {
            const teacherId = $(this).data('id');
            
            $.ajax({
                url: `/api/teachers/${teacherId}`,
                type: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    $('#deleteModal').modal('hide');
                    showAlert('success', 'Guru berhasil dihapus');
                    loadTeachers();
                },
                error: function(xhr, status, error) {
                    $('#deleteModal').modal('hide');
                    showAlert('danger', 'Gagal menghapus guru: ' + error);
                }
            });
        });

        // Save teacher button click
        $('#saveTeacherBtn').click(function() {
            const teacherId = $('#teacherId').val();
            const isEdit = teacherId !== '';
            
            // Create FormData object
            const formData = new FormData($('#teacherForm')[0]);
            
            // AJAX request
            $.ajax({
                url: isEdit ? `/api/teachers/${teacherId}` : '/api/teachers',
                type: isEdit ? 'POST' : 'POST', // Using POST with _method for PUT
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function(xhr) {
                    if (isEdit) {
                        xhr.setRequestHeader('X-HTTP-Method-Override', 'PUT');
                    }
                },
                success: function(response) {
                    $('#teacherModal').modal('hide');
                    showAlert('success', isEdit ? 'Guru berhasil diperbarui' : 'Guru berhasil ditambahkan');
                    loadTeachers();
                },
                error: function(xhr, status, error) {
                    let errorMessage = 'Terjadi kesalahan';
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = '<ul class="mb-0">';
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            errorMessage += `<li>${value}</li>`;
                        });
                        errorMessage += '</ul>';
                    } else if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    }
                    
                    showAlert('danger', errorMessage);
                }
            });
        });
    });
</script>
@endsection