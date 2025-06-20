@extends('layouts.admin')

@section('title', 'News Manager')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">News Manager</h1>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-primary shadow-sm mr-2">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Dashboard
            </a>
            <a href="{{ route('admin.gallery.manager') }}" class="btn btn-sm btn-info shadow-sm">
                <i class="fas fa-image fa-sm text-white-50"></i> Gallery Manager
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
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

    <!-- News Manager Content -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Manage News</h6>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewsModal">
                <i class="fas fa-plus fa-sm text-white-50"></i> Add News
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="newsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="newsTableBody">
                        <!-- News data will be loaded here via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add News Modal -->
<div class="modal fade" id="addNewsModal" tabindex="-1" role="dialog" aria-labelledby="addNewsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewsModalLabel">Add News</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addNewsForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="6" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control-file" id="image" name="image" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit News Modal -->
<div class="modal fade" id="editNewsModal" tabindex="-1" role="dialog" aria-labelledby="editNewsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNewsModalLabel">Edit News</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editNewsForm" enctype="multipart/form-data">
                <input type="hidden" id="edit_news_id" name="news_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_title">Title</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_content">Content</label>
                        <textarea class="form-control" id="edit_content" name="content" rows="6" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_image">Image</label>
                        <div class="mb-2">
                            <img id="current_image" src="" alt="Current Image" style="max-width: 200px; max-height: 200px;" class="img-thumbnail">
                        </div>
                        <input type="file" class="form-control-file" id="edit_image" name="image">
                        <small class="form-text text-muted">Leave empty to keep current image</small>
                    </div>
                    <div class="form-group">
                        <label for="edit_status">Status</label>
                        <select class="form-control" id="edit_status" name="status" required>
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteNewsModal" tabindex="-1" role="dialog" aria-labelledby="deleteNewsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteNewsModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this news?</p>
                <p>Title: <span id="delete_news_title"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        var newsTable = $('#newsTable').DataTable({
            processing: true,
            order: [[4, 'desc']], // Sort by created_at by default
            columns: [
                { data: 'id' },
                { 
                    data: 'image_url',
                    render: function(data) {
                        return '<img src="' + data + '" alt="News Image" style="width: 100px; height: auto;">';
                    } 
                },
                { data: 'title' },
                { 
                    data: 'status',
                    render: function(data) {
                        if (data === 'published') {
                            return '<span class="badge badge-success">Published</span>';
                        } else {
                            return '<span class="badge badge-secondary">Draft</span>';
                        }
                    } 
                },
                { 
                    data: 'created_at',
                    render: function(data) {
                        return new Date(data).toLocaleString();
                    } 
                },
                { 
                    data: null,
                    render: function(data) {
                        return `
                            <button class="btn btn-sm btn-info edit-btn" data-id="${data.id}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${data.id}" data-title="${data.title}">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        `;
                    } 
                }
            ]
        });

        // Load news data
        function loadNews() {
            $.ajax({
                url: '/api/news',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    newsTable.clear();
                    newsTable.rows.add(response);
                    newsTable.draw();
                },
                error: function(xhr) {
                    console.error('Error loading news:', xhr.responseText);
                    alert('Failed to load news data. Please try again.');
                }
            });
        }

        // Initial load
        loadNews();

        // Add News Form Submit
        $('#addNewsForm').on('submit', function(e) {
            e.preventDefault();
            
            var formData = new FormData(this);
            
            $.ajax({
                url: '/api/news',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#addNewsModal').modal('hide');
                    $('#addNewsForm')[0].reset();
                    loadNews();
                    alert('News added successfully!');
                },
                error: function(xhr) {
                    console.error('Error adding news:', xhr.responseText);
                    var errors = xhr.responseJSON?.errors;
                    if (errors) {
                        var errorMsg = 'Please correct the following errors:\n';
                        $.each(errors, function(key, value) {
                            errorMsg += '- ' + value[0] + '\n';
                        });
                        alert(errorMsg);
                    } else {
                        alert('Failed to add news. Please try again.');
                    }
                }
            });
        });

        // Edit News Button Click
        $(document).on('click', '.edit-btn', function() {
            var newsId = $(this).data('id');
            
            $.ajax({
                url: '/api/news/' + newsId,
                type: 'GET',
                success: function(news) {
                    $('#edit_news_id').val(news.id);
                    $('#edit_title').val(news.title);
                    $('#edit_content').val(news.content);
                    $('#edit_status').val(news.status);
                    $('#current_image').attr('src', news.image_url);
                    $('#editNewsModal').modal('show');
                },
                error: function(xhr) {
                    console.error('Error fetching news details:', xhr.responseText);
                    alert('Failed to load news details. Please try again.');
                }
            });
        });

        // Edit News Form Submit
        $('#editNewsForm').on('submit', function(e) {
            e.preventDefault();
            
            var newsId = $('#edit_news_id').val();
            var formData = new FormData(this);
            
            $.ajax({
                url: '/api/news/' + newsId,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-HTTP-Method-Override': 'PUT'
                },
                success: function(response) {
                    $('#editNewsModal').modal('hide');
                    loadNews();
                    alert('News updated successfully!');
                },
                error: function(xhr) {
                    console.error('Error updating news:', xhr.responseText);
                    var errors = xhr.responseJSON?.errors;
                    if (errors) {
                        var errorMsg = 'Please correct the following errors:\n';
                        $.each(errors, function(key, value) {
                            errorMsg += '- ' + value[0] + '\n';
                        });
                        alert(errorMsg);
                    } else {
                        alert('Failed to update news. Please try again.');
                    }
                }
            });
        });

        // Delete News Button Click
        $(document).on('click', '.delete-btn', function() {
            var newsId = $(this).data('id');
            var newsTitle = $(this).data('title');
            
            $('#delete_news_title').text(newsTitle);
            $('#confirmDelete').data('id', newsId);
            $('#deleteNewsModal').modal('show');
        });

        // Confirm Delete Button Click
        $('#confirmDelete').on('click', function() {
            var newsId = $(this).data('id');
            
            $.ajax({
                url: '/api/news/' + newsId,
                type: 'DELETE',
                success: function(response) {
                    $('#deleteNewsModal').modal('hide');
                    loadNews();
                    alert('News deleted successfully!');
                },
                error: function(xhr) {
                    console.error('Error deleting news:', xhr.responseText);
                    alert('Failed to delete news. Please try again.');
                }
            });
        });
    });
</script>
@endsection