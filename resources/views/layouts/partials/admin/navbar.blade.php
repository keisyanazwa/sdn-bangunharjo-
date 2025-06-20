<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/front_logo.png') }}" alt="Logo SDN Bangunharjo">
            SD NEGERI BANGUNHARJO
        </a>
        <div class="ml-auto">
            <a href="{{ route('admin.logout') }}" class="btn logout-btn">Logout</a>
        </div>
    </div>
</nav>