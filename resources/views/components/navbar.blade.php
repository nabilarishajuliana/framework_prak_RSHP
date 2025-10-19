<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

<nav>
    <h2>RSHP</h2>
    <ul>
        <li>
            <a href="{{ url('/home') }}" class="{{ request()->is('home') ? 'active' : '' }}">
                Home
            </a>
        </li>
        <li>
            <a href="{{ url('/layanan') }}" class="{{ request()->is('layanan') ? 'active' : '' }}">
                Layanan
            </a>
        </li>
        <li>
            <a href="{{ url('/kontak') }}" class="{{ request()->is('kontak') ? 'active' : '' }}">
                Kontak
            </a>
        </li>
        <li>
            <a href="{{ url('/login') }}" class="{{ request()->is('login') ? 'active' : '' }}">
                Login
            </a>
        </li>
    </ul>
</nav>
