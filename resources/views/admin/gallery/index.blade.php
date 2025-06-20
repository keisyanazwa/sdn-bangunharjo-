@extends('layouts.admin')

@section('title', 'Daftar Galeri')

@section('content')
<div class="container">
    <h2 class="text-center dashboard-title">Daftar Galeri</h2>
    <p class="text-center mb-4">Daftar foto-foto kegiatan sekolah.</p>

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
    
    <div class="row mb-3">
        <div class="col-md-6 text-left">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addGalleryModal">
                <i class="bi bi-plus-circle"></i> Tambah Foto Baru
            </button>
        </div>
    </div>

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
                                <button class="btn btn-sm btn-info edit-btn" 
                                    data-id="{{ $gallery->id }}" 
                                    data-title="{{ $gallery->title }}" 
                                    data-image="{{ $gallery->image_url }}"
                                    data-toggle="modal" 
                                    data-target="#editGalleryModal">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST" class="d-inline">
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
@endsection

<!-- Add Gallery Modal -->
<div class="modal fade" id="addGalleryModal" tabindex="-1" role="dialog" aria-labelledby="addGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addGalleryModalLabel">Tambah Foto Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addGalleryForm" action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Judul Foto <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Gambar <span class="text-danger">*</span></label>
                        <input type="file" class="form-control-file" id="image" name="image" required>
                        <small class="form-text text-muted">Format: JPG, PNG, JPEG. Maks: 2MB</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <span class="button-text">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Gallery Modal -->
<div class="modal fade" id="editGalleryModal" tabindex="-1" role="dialog" aria-labelledby="editGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGalleryModalLabel">Edit Foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editGalleryForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_title">Judul Foto <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label>Gambar Saat Ini</label>
                        <div>
                            <img id="current_image" src="" alt="Current Image" class="img-thumbnail mb-2" style="max-height: 150px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_image">Ganti Gambar</label>
                        <input type="file" class="form-control-file" id="edit_image" name="image">
                        <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengganti gambar</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <span class="button-text">Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('.table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });

        // Handle edit button click
        $('.edit-btn').click(function() {
            const id = $(this).data('id');
            const title = $(this).data('title');
            const image = $(this).data('image');
            
            // Set form action URL
            $('#editGalleryForm').attr('action', `/admin/gallery/${id}`);
            
            // Fill form fields
            $('#edit_title').val(title);
            $('#current_image').attr('src', image);
        });

        // Generate a unique submission token
        function generateSubmissionToken() {
            return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
        }
        
        // Set initial submission token for add form
        $('#addGalleryForm').data('submission-token', generateSubmissionToken());
        
        // Handle add gallery form submission with AJAX
        $('#addGalleryForm').submit(function(e) {
            e.preventDefault();
            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');
            const $spinner = $submitBtn.find('.spinner-border');
            const $buttonText = $submitBtn.find('.button-text');
            
            // Immediately mark as submitting and disable button to prevent multiple clicks
            $form.data('submitting', true);
            $submitBtn.prop('disabled', true);

            // Validate form before submission
            if (!validateForm($form)) {
                console.log('Form submission prevented: validation failed');
                // Reset state if validation fails
                $form.data('submitting', false);
                $submitBtn.prop('disabled', false);
                return false;
            }
            
            // Check submission token to ensure this is a fresh submission
            const currentToken = $form.data('submission-token');
            if (!currentToken) {
                console.log('Form submission prevented: missing token');
                // Reset state if token is missing (shouldn't happen if token is generated on modal show)
                $form.data('submitting', false);
                $submitBtn.prop('disabled', false);
                return false;
            }
            
            // Clear the submission token to prevent reuse
            $form.data('submission-token', null);
            
            // Show visual feedback
            $spinner.removeClass('d-none');
            $buttonText.text('Menambahkan...');
            
            // Disable all interactive elements on the page
            $('button, a, input, select, textarea').not($submitBtn).prop('disabled', true);
            
            // Create form data after all checks have passed
            const formData = new FormData(this);
            
            // Add the submission token to the form data for server-side validation
            formData.append('submission_token', currentToken);
            
            // Show loading overlay with a slight delay to ensure it appears
            setTimeout(function() {
                showLoading('Menambahkan foto...');
            }, 100);

            $.ajax({
                url: '/api/galleries',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Hide loading overlay
                    hideLoading();
                    
                    // Reset button state
                    $spinner.addClass('d-none');
                    $buttonText.text('Simpan');
                    
                    // Keep form marked as submitting to prevent resubmission
                    // We'll reset this when the modal is closed or page is reloaded
                    
                    // Re-enable all interactive elements except submit button
                    $('button:not([type="submit"]), a, input, select, textarea').prop('disabled', false);
                    
                    // Hide modal and show success message
                    $('#addGalleryModal').modal('hide');
                    alert(response.message);
                    window.location.reload();
                },
                error: function(xhr) {
                    // Hide loading overlay
                    hideLoading();
                    
                    // Generate a new submission token to allow resubmission after fixing errors
                    const newToken = generateSubmissionToken();
                    $form.data('submission-token', newToken);
                    console.log('New token generated after error:', newToken);
                    
                    // Keep form marked as submitting to prevent resubmission
                    // We'll reset this when the modal is closed or page is reloaded
                    
                    // Reset button state
                    $submitBtn.prop('disabled', false);
                    $spinner.addClass('d-none');
                    $buttonText.text('Simpan');
                    
                    // Re-enable all interactive elements
                    $('button, a, input, select, textarea').prop('disabled', false);
                    
                    // Show error message
                    const response = xhr.responseJSON;
                    let errorMessage = 'Terjadi kesalahan saat menambahkan foto';
                    
                    if (response && response.message) {
                        errorMessage = response.message;
                    }
                    
                    alert(errorMessage);
                    
                    // Display validation errors if any
                    if (response && response.errors) {
                        const errors = response.errors;
                        for (const field in errors) {
                            const inputField = $('#addGalleryModal #' + field);
                            if (inputField.length) {
                                inputField.addClass('is-invalid');
                                inputField.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                            }
                        }
                    }
                }
            });
        });

        // Handle edit button click to load data and validate form
        $('.edit-btn').click(function() {
            const $form = $('#editGalleryForm');
            const $submitBtn = $form.find('button[type="submit"]');
            
            // Ensure token is set (although this is also done in modal show event)
            $form.data('submission-token', generateSubmissionToken());
            
            // After data is loaded into the form (which happens elsewhere),
            // we need to validate the form and enable/disable the submit button
            setTimeout(function() {
                // Use setTimeout to ensure data is fully loaded into the form
                if (validateForm($form)) {
                    $submitBtn.prop('disabled', false);
                } else {
                    $submitBtn.prop('disabled', true);
                }
            }, 500); // Longer timeout to ensure data is loaded
        });
        
        // Handle edit gallery form submission with AJAX
        $('#editGalleryForm').submit(function(e) {
            e.preventDefault();
            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');
            const $spinner = $submitBtn.find('.spinner-border');
            const $buttonText = $submitBtn.find('.button-text');
            const id = $(this).attr('action').split('/').pop();
            
            // Immediately mark as submitting and disable button to prevent multiple clicks
            $form.data('submitting', true);
            $submitBtn.prop('disabled', true);

            // Validate form before submission
            if (!validateForm($form)) {
                console.log('Edit form submission prevented: validation failed');
                // Reset state if validation fails
                $form.data('submitting', false);
                $submitBtn.prop('disabled', false);
                return false;
            }
            
            // Check submission token to ensure this is a fresh submission
            const currentToken = $form.data('submission-token');
            if (!currentToken) {
                console.log('Edit form submission prevented: missing token');
                // Reset state if token is missing (shouldn't happen if token is generated on modal show)
                $form.data('submitting', false);
                $submitBtn.prop('disabled', false);
                return false;
            }
            
            // Clear the submission token to prevent reuse
            $form.data('submission-token', null);
            
            // Show visual feedback
            $spinner.removeClass('d-none');
            $buttonText.text('Memperbarui...');
            
            // Disable all interactive elements on the page
            $('button, a, input, select, textarea').not($submitBtn).prop('disabled', true);
            
            // Create form data after all checks have passed
            const formData = new FormData(this);
            formData.append('_method', 'PUT');
            
            // Add the submission token to the form data for server-side validation
            formData.append('submission_token', currentToken);
            
            // Show loading overlay with a slight delay to ensure it appears
            setTimeout(function() {
                showLoading('Memperbarui foto...');
            }, 100);

            $.ajax({
                url: `/api/galleries/${id}`,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Hide loading overlay
                    hideLoading();
                    
                    // Reset button state
                    $spinner.addClass('d-none');
                    $buttonText.text('Simpan Perubahan');
                    
                    // Reset submission state
                    $form.data('submitting', false);
                    
                    // Re-enable all interactive elements except submit button
                    $('button:not([type="submit"]), a, input, select, textarea').prop('disabled', false);
                    
                    // Hide modal and show success message
                    $('#editGalleryModal').modal('hide');
                    alert(response.message);
                    window.location.reload();
                },
                error: function(xhr) {
                    // Hide loading overlay
                    hideLoading();
                    
                    // Generate a new submission token to allow resubmission after fixing errors
                    const newToken = generateSubmissionToken();
                    $form.data('submission-token', newToken);
                    console.log('New token generated after error:', newToken);
                    
                    // Reset submission state
                    $form.data('submitting', false);
                    
                    // Reset button state
                    $submitBtn.prop('disabled', false);
                    $spinner.addClass('d-none');
                    $buttonText.text('Simpan Perubahan');
                    
                    // Re-enable all interactive elements
                    $('button, a, input, select, textarea').prop('disabled', false);
                    
                    // Show error message
                    const response = xhr.responseJSON;
                    let errorMessage = 'Terjadi kesalahan saat memperbarui foto';
                    
                    if (response && response.message) {
                        errorMessage = response.message;
                    }
                    
                    alert(errorMessage);
                    
                    // Display validation errors if any
                    if (response && response.errors) {
                        const errors = response.errors;
                        for (const field in errors) {
                            const inputField = $('#editGalleryModal #edit_' + field);
                            if (inputField.length) {
                                inputField.addClass('is-invalid');
                                inputField.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                            }
                        }
                    }
                }
            });
        });

        // Function to generate unique submission token
        function generateSubmissionToken() {
            return 'token-' + Math.random().toString(36).substr(2, 9) + '-' + Date.now();
        }
        
        // Function to validate form fields
        function validateForm($form) {
            let isValid = true;
            const requiredFields = $form.find('[required]');
            
            // Reset previous validation state
            $form.find('.is-invalid').removeClass('is-invalid');
            $form.find('.invalid-feedback').remove();
            
            // Check each required field
            requiredFields.each(function() {
                const $field = $(this);
                if (!$field.val().trim()) {
                    isValid = false;
                    $field.addClass('is-invalid');
                    $field.after('<div class="invalid-feedback">Field ini wajib diisi</div>');
                }
            });
            
            // Special validation for file input in add form
            if ($form.attr('id') === 'addGalleryForm') {
                const $fileInput = $form.find('input[type="file"]');
                if ($fileInput.length && !$fileInput[0].files.length) {
                    isValid = false;
                    $fileInput.addClass('is-invalid');
                    $fileInput.after('<div class="invalid-feedback">Silakan pilih file gambar</div>');
                }
            }
            
            return isValid;
        }
        
        // Reset form state and generate new submission token when modals are opened
        $('#addGalleryModal').on('show.bs.modal', function() {
            const $form = $(this).find('form');
            const $submitBtn = $form.find('button[type="submit"]');
            
            // Generate new token
            $form.data('submission-token', generateSubmissionToken());
            console.log('New token generated for add form:', $form.data('submission-token'));
            
            // Disable submit button by default until form is valid
            $submitBtn.prop('disabled', true);
            
            // Trigger validation to update button state
            setTimeout(function() {
                // Use setTimeout to ensure DOM is fully updated
                if (validateForm($form)) {
                    $submitBtn.prop('disabled', false);
                }
            }, 100);
        });
        
        $('#editGalleryModal').on('show.bs.modal', function() {
            const $form = $(this).find('form');
            const $submitBtn = $form.find('button[type="submit"]');
            
            // Generate new token
            $form.data('submission-token', generateSubmissionToken());
            console.log('New token generated for edit form:', $form.data('submission-token'));
            
            // For edit form, we need to wait until data is loaded before validating
            // This is handled by the edit button click handler
            $submitBtn.prop('disabled', true);
            
            // We'll enable the button after data is loaded if the form is valid
            // This happens in the edit button click handler
        });
        
        // Enable/disable submit button based on form validity for add form
        $('#addGalleryForm input, #addGalleryForm textarea, #addGalleryForm select').on('input change', function() {
            const $form = $('#addGalleryForm');
            const $submitBtn = $form.find('button[type="submit"]');
            
            // Only enable the button if the form is valid and not currently submitting
            if (validateForm($form) && !$form.data('submitting')) {
                $submitBtn.prop('disabled', false);
            } else {
                $submitBtn.prop('disabled', true);
            }
        });
        
        // Enable/disable submit button based on form validity for edit form
        $('#editGalleryForm input, #editGalleryForm textarea, #editGalleryForm select').on('input change', function() {
            const $form = $('#editGalleryForm');
            const $submitBtn = $form.find('button[type="submit"]');
            
            // Only enable the button if the form is valid and not currently submitting
            if (validateForm($form) && !$form.data('submitting')) {
                $submitBtn.prop('disabled', false);
            } else {
                $submitBtn.prop('disabled', true);
            }
        });
        
        // Clear validation errors and reset form state when modal is closed
        $('#addGalleryModal, #editGalleryModal').on('hidden.bs.modal', function() {
            const $form = $(this).find('form');
            const $submitBtn = $form.find('button[type="submit"]');
            const $spinner = $submitBtn.find('.spinner-border');
            const $buttonText = $submitBtn.find('.button-text');
            
            // Reset form
            $form[0].reset();
            $form.find('.is-invalid').removeClass('is-invalid');
            $form.find('.invalid-feedback').remove();
            $form.data('submitting', false);
            
            // Reset button state - always disable button initially until form is valid
            $submitBtn.prop('disabled', true);
            $spinner.addClass('d-none');
            
            // Reset button text
            if ($(this).attr('id') === 'addGalleryModal') {
                $buttonText.text('Simpan');
            } else {
                $buttonText.text('Simpan Perubahan');
            }
            
            // Re-enable all interactive elements except submit buttons
            $('button:not([type="submit"]), a, input, select, textarea').prop('disabled', false);
            
            // Clear submission token when modal is closed
            $form.data('submission-token', null);
            console.log('Submission token cleared for form');
            
            // Reset file input if exists (for add form)
            const $fileInput = $form.find('input[type="file"]');
            if ($fileInput.length) {
                // This is a bit tricky in some browsers, but we can try
                try {
                    $fileInput.val('');
                    // For some browsers, we need to clone and replace the element
                    const $newFileInput = $fileInput.clone(true).val('');
                    $fileInput.replaceWith($newFileInput);
                } catch (e) {
                    console.log('Error resetting file input:', e);
                }
            }
        });

        // Handle delete button with AJAX
        $('form[action^="/admin/gallery"]').submit(function(e) {
            e.preventDefault();
            const $form = $(this);
            const $deleteBtn = $form.find('button[type="submit"]');
            
            // Prevent double submission
            if ($form.data('submitting')) {
                return false;
            }
            
            if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
                const id = $form.attr('action').split('/').pop();
                
                // Disable delete button and show loading
                $deleteBtn.prop('disabled', true);
                $deleteBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menghapus...');
                
                // Mark as submitting and show loading
                $form.data('submitting', true);
                showLoading('Menghapus foto...');
                
                // Disable all interactive elements on the page
                $('button, a, input, select, textarea').not($deleteBtn).prop('disabled', true);
                
                $.ajax({
                    url: `/api/galleries/${id}`,
                    type: 'DELETE',
                    success: function(response) {
                        // Hide loading overlay
                        hideLoading();
                        
                        // Re-enable all interactive elements
                        $('button, a, input, select, textarea').prop('disabled', false);
                        
                        // Show success message and reload
                        alert(response.message);
                        window.location.reload();
                    },
                    error: function(xhr) {
                        // Hide loading overlay
                        hideLoading();
                        
                        // Reset button state
                        $deleteBtn.prop('disabled', false);
                        $deleteBtn.html('<i class="bi bi-trash"></i> Hapus');
                        $form.data('submitting', false);
                        
                        // Re-enable all interactive elements
                        $('button, a, input, select, textarea').prop('disabled', false);
                        
                        // Show error message
                        const response = xhr.responseJSON;
                        let errorMessage = 'Terjadi kesalahan saat menghapus foto';
                        
                        if (response && response.message) {
                            errorMessage = response.message;
                        }
                        
                        alert(errorMessage);
                    }
                });
            }
        });}
    );
</script>
@endsection