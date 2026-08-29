<nav class="navbar navbar-expand-lg bg-white shadow-sm py-3">

    <div class="container">

        <a class="navbar-brand fw-bold" href="/" style="color: #6B3F1D;">
            Gudeg Yu yem
        </a>

        <button class="navbar-toggler"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse"
             id="navbarNav">

            <ul class="navbar-nav mx-auto">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('menu') ? 'active' : '' }}" href="{{ route('menu') }}">
                        Menu
                    </a>
                </li>

                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('order.history') ? 'active' : '' }}" href="{{ route('order.history') }}">
                            Riwayat Pesanan
                        </a>
                    </li>
                @endauth

            </ul>

            <div class="d-flex gap-3 align-items-center flex-wrap">

                @auth
                    <a href="{{ route('cart.index') }}" class="text-dark">
                        <i class="bi bi-cart fs-5"></i>
                    </a>
                @endauth

                @auth
                    <div class="dropdown">
                        <button class="btn btn-link text-dark text-decoration-none dropdown-toggle" 
                                type="button" 
                                id="userDropdown" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false">
                            <i class="bi bi-person-circle fs-5"></i>
                            <span class="d-none d-md-inline ms-2" style="color: #8B4513;">{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary" style="color: #8B4513; border-color: #8B4513;">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="btn" style="background-color: #8B4513; color: white;">
                        Register
                    </a>
                @endauth

            </div>

        </div>

    </div>

</nav>