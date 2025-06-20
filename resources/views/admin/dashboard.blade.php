@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<h2 class="text-center dashboard-title">Selamat Datang, Admin!</h2>
<p class="text-center mb-4">Silakan pilih menu untuk mengelola website SDN Bangunharjo.</p>

<div class="dashboard-cards">
    <div class="dashboard-card" data-toggle="modal" data-target="#newsModal" style="cursor: pointer;">
        <i class="bi bi-newspaper"></i>
        <h3>Kelola Berita</h3>
        <p>Tambah, edit, dan hapus berita terbaru sekolah.</p>
    </div>
    <div class="dashboard-card" data-toggle="modal" data-target="#galleryModal" style="cursor: pointer;">
        <i class="bi bi-images"></i>
        <h3>Kelola Galeri</h3>
        <p>Atur foto-foto kegiatan dan dokumentasi sekolah.</p>
    </div>
    <div class="dashboard-card" data-toggle="modal" data-target="#teacherModal" style="cursor: pointer;">
        <i class="bi bi-people"></i>
        <h3>Kelola Guru</h3>
        <p>Update informasi Guru.</p>
    </div>
</div>

<!-- News Table -->

<!-- News Modal -->
<div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newsModalLabel">Kelola Berita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                <div class="row">
                    <div class="col-12 text-center mb-4">
                        <a href="{{ route('admin.news.index') }}" class="btn btn-primary">
                            <i class="bi bi-newspaper"></i> Buka Halaman Manajemen Berita
                        </a>
                        <p class="mt-2 text-muted">Klik tombol di atas untuk mengelola berita sekolah</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gallery Modal -->
<div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalLabel">Kelola Galeri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
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

                <div class="row">
                    <div class="col-12 text-center mb-4">
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-primary">
                            <i class="bi bi-images"></i> Buka Halaman Manajemen Galeri
                        </a>
                        <p class="mt-2 text-muted">Klik tombol di atas untuk mengelola foto-foto galeri</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">Kelola Kontak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Form Tambah/Edit Kontak -->
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0" id="contactFormTitle">Tambah Kontak</h6>
                            </div>
                            <div class="card-body">
                                <form id="contactForm">
                                    <div class="form-group">
                                        <label for="contactName">Nama</label>
                                        <input type="text" class="form-control" id="contactName" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="contactEmail">Email</label>
                                        <input type="email" class="form-control" id="contactEmail" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="contactPhone">Telepon</label>
                                        <input type="text" class="form-control" id="contactPhone">
                                    </div>
                                    <div class="form-group">
                                        <label for="contactMessage">Pesan</label>
                                        <textarea class="form-control" id="contactMessage" rows="3" required></textarea>
                                    </div>
                                    <div class="form-group text-right mb-0">
                                        <button type="button" class="btn btn-secondary" id="cancelContactBtn">Batal</button>
                                        <button type="button" class="btn btn-primary" id="saveContactBtn">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabel Kontak -->
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Daftar Kontak</h6>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="25%">Nama</th>
                                                <th width="25%">Email</th>
                                                <th width="20%">Tanggal</th>
                                                <th width="25%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="contactTableBody">
                                            <!-- Data kontak akan ditampilkan di sini -->
                                        </tbody>
                                    </table>
                                </div>
                                <div id="emptyContactMessage" class="text-center p-3" style="display: block;">
                                    <p class="text-muted">Belum ada data kontak. Silakan tambahkan kontak baru.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Teacher Modal -->
<div class="modal fade" id="teacherModal" tabindex="-1" aria-labelledby="teacherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newsModalLabel">Kelola Guru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
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

                <div class="row">
                    <div class="col-12 text-center mb-4">
                        <a href="{{ route('admin.teachers.index') }}" class="btn btn-primary">
                            <i class="bi bi-newspaper"></i> Buka Halaman Manajemen Guru
                        </a>
                        <p class="mt-2 text-muted">Klik tombol di atas untuk mengelola guru sekolah</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Contact and Teacher functionality remains the same
    document.addEventListener('DOMContentLoaded', function() {
        // Show modals
        document.querySelectorAll('[data-toggle="modal"]').forEach(btn => {
            btn.addEventListener('click', function() {
                const target = this.getAttribute('data-target');
                if (target === '#contactModal') {
                    // Contact form is pre-filled
                } else if (target === '#teacherModal') {
                    document.getElementById('teacherForm').reset();
                }
            });
        });
    });
</script>
@endsection
