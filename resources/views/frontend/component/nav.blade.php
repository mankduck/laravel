<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-2 col-lg-2">
                <div class="header__logo">
                    <a href="{{ route('home.index') }}"><img src="frontend/img/logo.png" alt=""></a>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9">
                <nav class="header__menu">
                    <ul>
                        @if (isset($menu['menu-header']))
                            {!! $menu['menu-header'] !!}
                        @endif
                        <li>
                            @if (Auth::check())
                                <a>Xin chào, {{ Auth::user()->name }}</a>
                                <ul class="dropdown">
                                    {{-- <li><a href="">Quản lý đơn hàng</a></li> --}}
                                    @if (Auth::user()->user_catalogue_id === 1)
                                    <li><a href="{{route('dashboard.index')}}">Đến trang admin</a></li>
                                    @endif
                                    <li><a href="{{route('auth.logout')}}">Đăng xuất</a></li>
                                </ul>
                            @else
                                <a href="{{ route('auth.signin') }}">Login</a>
                            @endif
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-1">
                <div class="header__right">
                    <ul class="header__right__widget">
                        {{-- <li><span class="icon_search search-switch"></span></li> --}}
                        {{-- <li><a href="#"><span class="icon_heart_alt"></span>
                                <div class="tip num-favaurite">2</div>
                            </a></li> --}}
                        <li><a href="{{ route('cart.index') }}"><span class="icon_bag_alt"></span>
                                <div class="tip num-card">{{ $countCartUser }}</div>
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="canvas__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
