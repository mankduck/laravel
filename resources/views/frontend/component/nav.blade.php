<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3 col-lg-2">
                <div class="header__logo">
                    <a href="{{ route('home.index') }}"><img src="frontend/img/logo.png" alt=""></a>
                </div>
            </div>
            <div class="col-xl-6 col-lg-8">
                <nav class="header__menu">
                    @if (isset($menu['menu-header']))
                        {!! $menu['menu-header'] !!}
                    @endif
                </nav>
            </div>
            <div class="col-lg-2">
                <div class="header__right">
                    <div class="header__right__auth">
                        @if (Auth::check())
                            <a href="{{route('auth.logout')}}">Xin chào, {{Auth::user()->name}}</a>
                        @else
                            <a href="{{ route('auth.signin') }}">Login</a>
                        @endif
                    </div>
                    <ul class="header__right__widget">
                        {{-- <li><span class="icon_search search-switch"></span></li> --}}
                        <li><a href="#"><span class="icon_heart_alt"></span>
                                <div class="tip num-favaurite">2</div>
                            </a></li>
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
