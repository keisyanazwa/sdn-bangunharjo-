@extends('layouts.app')

@section('title', 'Detail Ekstrakurikuler')
@section('navbar', 'navbarKu')

@section('content')
<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-8">
            <h1 class="mb-4">Ekstrakurikuler Pramuka</h1>
            
            <img src="{{ asset('images/pramuka1.png') }}" alt="Ekstrakurikuler Pramuka" class="img-fluid mb-4 rounded">
            
            <div class="ekskul-content">
                <h4>Deskripsi</h4>
                <p>Ekstrakurikuler Pramuka SD Negeri Bangunharjo merupakan kegiatan yang wajib diikuti oleh seluruh siswa kelas 3 sampai kelas 6. Kegiatan ini dilaksanakan setiap hari Sabtu pukul 08.00 - 10.00 WIB.</p>
                
                <h4 class="mt-4">Tujuan</h4>
                <p>Kegiatan Pramuka bertujuan untuk membentuk karakter siswa yang disiplin, mandiri, dan bertanggung jawab. Selain itu, kegiatan ini juga bertujuan untuk melatih keterampilan siswa dalam berorganisasi dan bekerja sama dalam tim.</p>
                
                <h4 class="mt-4">Pembina</h4>
                <p>Kegiatan Pramuka dibina oleh Bapak/Ibu Guru yang telah memiliki sertifikat sebagai Pembina Pramuka. Pembina Pramuka SD Negeri Bangunharjo adalah:</p>
                <ul>
                    <li>Bapak Agus Supriyanto, S.Pd.</li>
                    <li>Ibu Siti Nurjanah, S.Pd.</li>
                </ul>
                
                <h4 class="mt-4">Prestasi</h4>
                <p>Ekstrakurikuler Pramuka SD Negeri Bangunharjo telah meraih berbagai prestasi, di antaranya:</p>
                <ul>
                    <li>Juara 1 Lomba Pramuka Tingkat Kecamatan Tahun 2022</li>
                    <li>Juara 2 Lomba Pramuka Tingkat Kabupaten Tahun 2022</li>
                    <li>Juara 3 Lomba Pramuka Tingkat Provinsi Tahun 2023</li>
                </ul>
            </div>
            
            <div class="ekskul-gallery mt-5">
                <h4 class="mb-3">Galeri Kegiatan</h4>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <img src="{{ asset('images/pramuka1.png') }}" alt="Galeri Pramuka" class="img-fluid rounded">
                    </div>
                    <div class="col-md-4 mb-3">
                        <img src="{{ asset('images/pramuka2.png') }}" alt="Galeri Pramuka" class="img-fluid rounded">
                    </div>
                    <div class="col-md-4 mb-3">
                        <img src="{{ asset('images/grakjalan.png') }}" alt="Galeri Pramuka" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Ekstrakurikuler Lainnya</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Karawitan</a></li>
                        <li class="mb-2"><a href="#">Tari</a></li>
                        <li class="mb-2"><a href="#">Karate</a></li>
                        <li class="mb-2"><a href="#">Paduan Suara</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Jadwal Ekstrakurikuler</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2"><strong>Pramuka:</strong> Sabtu, 08.00 - 10.00 WIB</li>
                        <li class="mb-2"><strong>Karawitan:</strong> Senin, 14.00 - 16.00 WIB</li>
                        <li class="mb-2"><strong>Tari:</strong> Selasa, 14.00 - 16.00 WIB</li>
                        <li class="mb-2"><strong>Karate:</strong> Rabu, 14.00 - 16.00 WIB</li>
                        <li class="mb-2"><strong>Paduan Suara:</strong> Kamis, 14.00 - 16.00 WIB</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection