<header class="site-header" id="top">
    <div class="container header-inner">
        <a href="{{ route('home') }}#home" class="brand" aria-label="Lumiere Beauty Clinic">
            <span class="brand-mark">LB</span>
            <div>
                <strong>Lumiere Beauty</strong>
                <span>Beauty & Skin Clinic</span>
            </div>
        </a>

        <button class="menu-toggle" id="menuToggle" aria-label="Buka menu" aria-expanded="false" aria-controls="siteNav">
            <span></span><span></span><span></span>
        </button>

        <nav class="site-nav" id="siteNav" aria-label="Navigasi utama">
            <a href="{{ route('home') }}#home" class="nav-link active">Homepage</a>
            <a href="{{ route('treatments.index') }}" class="nav-link">Treatments</a>
            <a href="{{ route('promotions.index') }}" class="nav-link">Promotion</a>
            <a href="{{ route('home') }}#membership" class="nav-link">Membership</a>
            <a href="{{ route('home') }}#contact" class="nav-link">Contact</a>
        </nav>

        <div class="header-actions">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="header-cta header-cta-light">
                        Admin
                    </a>
                @else
                    <details class="account-dropdown">
                        <summary class="header-cta header-cta-light">
                            Account
                        </summary>

                        <div class="account-menu">
                            <a href="{{ route('bookings.mine') }}">My Bookings</a>
                            <a href="{{ route('points.index') }}">My Points</a>
                            <a href="{{ route('profile.index') }}">Profile</a>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit">Logout</button>
                            </form>
                        </div>
                    </details>
                @endif

                @if(auth()->user()->isAdmin())
                    <form action="{{ route('logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="header-cta header-cta-light">
                            Logout
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="header-cta header-cta-light">
                    Login
                </a>
            @endauth

            <a href="{{ route('treatments.index') }}" class="header-cta">
                Book Now
            </a>
        </div>
    </div>
</header>