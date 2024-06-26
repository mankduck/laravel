<header class="header">
    <div class="container-fluid">
        {{-- <div class="row">
            a
        </div> --}}
        <div class="row">
            <div class="col-xl-3 col-lg-2">
                <div class="header__logo">
                    <a href="./index.html"><img src="frontend/img/logo.png" alt=""></a>
                </div>
            </div>
            <div class="col-xl-6 col-lg-7">
                <nav class="header__menu">
                    @if (isset($menu['menu-chinh']))
                        {!! $menu['menu-chinh'] !!}
                    @endif
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__right">
                    {{-- <div class="header__right__auth">
                        <select name="" id="">
                            <option value="">Tieensg Viet</option>
                        </select>
                    </div> --}}
                    <div class="header__right__auth">
                        <a href="#">Login</a>
                        <a href="#">Register</a>
                    </div>
                    <ul class="header__right__widget">
                        <li><span class="icon_search search-switch"></span></li>
                        <li><a href="#"><span class="icon_heart_alt"></span>
                                <div class="tip">2</div>
                            </a></li>
                        <li><a href="#"><span class="icon_bag_alt"></span>
                                <div class="tip">2</div>
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
