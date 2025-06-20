@extends('layouts.app')

@section('title', 'Kontak - SDN BANGUNHARJO')
@section('navbar', 'navbarKu')

@section('content')
<div class="container kontak">

    <h1 class="mb-0">Hubungi Kami</h1>
    <p class="mb-4">Silakan kirimkan aduan Anda kepada SDN Bangunharjo melalui form berikut.</p>
    <form action="">
        <div class="formKontakKiri">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama">
            </div>

            <div class="form-group">
                <label for="nama">Email</label>
                <input type="email" class="form-control" id="nama">
            </div>

            <div class="form-group">
                <label for="nama">No Telp</label>
                <input type="number" class="form-control" id="nama">
            </div>
        </div>


        <div class="formKontakKanan">
            <div class="form-group">
                <label for="pesan">Pesan</label>
                <textarea name="pesan" id="pesan" cols="30" rows="8" class="form-control"></textarea>
            </div>

            <button class="btn btn-primary float-right">Kirim</button>
        </div>
    </form>
</div>

<iframe
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.298840079316!2d110.4191341748102!3d-6.9740258930267025!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e70f4ab721ee0c5%3A0xb3b11d052bdab523!2sSekolah%20Dasar%20Negeri%20Bangunharjo!5e0!3m2!1sid!2sid!4v1749809311415!5m2!1sid!2sid"
    width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy">
</iframe>
@endsection

@section('scripts')
<script src="js/script.js"></script>
@endsection