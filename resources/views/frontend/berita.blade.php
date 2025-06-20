@extends('layouts.app')

@section('title', 'Berita - SDN BANGUNHARJO')
@section('navbar', 'navbarKu')

@section('content')
<div class="container titleArtikel">
    <!-- <h1>Latest Post</h1> -->
    <h1>Postingan Terbaru</h1>
</div>

<div class="container artikel">

    <a href="perArtikel.html" class="text-decoration-none">
        <div class="perArtikel">
            <img src="images/upc2.png" alt="Artikel">
            <div class="textArtikel">
                <h3>Perayaan HUT dan Peringatan Hari Sumpah Pemuda</h3>
                <p>
                    Bangunharjo, 28 Oktober 2024 — SD Negeri Bangunharjo menggelar upacara bendera dalam rangka memperingati Hari Sumpah Pemuda ke-96. Upacara berlangsung dengan khidmat di halaman sekolah, diikuti oleh seluruh siswa, guru, dan staf sekolah.
                </p>
            </div>
        </div>
    </a>

    <a href="perArtikel.html" class="text-decoration-none">
        <div class="perArtikel">
            <img src="images/5e72f72cca561-respect-desktop2.jpg" alt="Artikel">
            <div class="textArtikel">
                <h3>SDN Bangunharjo Raih Juara 2 Lomba Gerak Jalan Tingkat SD se-Kota Semarang</h3>
                <p>
                    Semarang, 12 Agustus 2024 — SD Negeri Bangunharjo kembali menorehkan prestasi membanggakan. Dalam ajang Lomba Gerak Jalan Tingkat Sekolah Dasar se-Kota Semarang yang digelar dalam rangka memperingati Hari Kemerdekaan Republik Indonesia ke-79, tim gerak jalan SDN Bangunharjo berhasil meraih Juara 2.
                </p>
            </div>
        </div>
    </a>
</div>
@endsection

@section('scripts')
<script src="js/script.js"></script>
@endsection