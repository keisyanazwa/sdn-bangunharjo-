<nav class="navbar navbar-expand-lg navbar-light @yield('navbar', 'navbarHome') fixed-top">
    <div class="container">

        <a class="navbar-brand" href="{{ route('pages.home') }}">
            <img src="{{ asset('images/front_logo.png') }}" alt="Logo SDN Bangunharjo">
            <h1>SD Negeri<br>Bangunharjo</h1>
        </a>

        <button class="navbar-toggler hamburger" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('pages.home') }}">Home</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('pages.berita') }}">Berita</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="https://spmb.semarangkota.go.id/sd">PPDB</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('pages.galeri') }}">Galeri</a>
                </li>
                
                <li class="nav-item active">
                    <a href="#" class="nav-link dropdown-toggle" id="dropdownMenuLink" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Profile
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                        <a class="dropdown-item" href="{{ route('pages.profilguru') }}">Profil Guru</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('pages.kontak') }}">Contact Us</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">

                <input class="form-control sm-2" type="search" placeholder="Cari Berita" aria-label="Search">

                <button class="btn btn-primary sm-0" type="submit">
                    <i class="fas fa-search"></i>
                </button>

            </form>
            <a href="{{ route('pages.login') }}" class="btn btn-primary ml-2">Login</a>
        </div>

    </div>
</nav>