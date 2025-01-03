<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-7">
                <div class="footer__about">
                    <div class="footer__logo">
                        <a href="./index.html"><img src="img/logo.png" alt=""></a>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                        cilisis.</p>
                    <div class="footer__payment">
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-5">
                <div class="footer__widget">
                    @if (isset($menu['menu-footer-1']))
                        <h6>Quick links</h6>
                        <ul>
                            @foreach ($menu['menu-footer-1'] as $key => $val)
                                @php
                                    $name = $val['item']->languages->first()->pivot->name;
                                    $canonical = write_url(
                                        $val['item']->languages->first()->pivot->canonical,
                                        true,
                                        true,
                                    );
                                @endphp
                                <li><a href="{{ $canonical }}">{{ $name }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4">
                <div class="footer__widget">
                    @if (isset($menu['menu-footer-2']))
                        <h6>Account</h6>
                        <ul>
                            @foreach ($menu['menu-footer-2'] as $key => $val)
                                @php
                                    $name = $val['item']->languages->first()->pivot->name;
                                    $canonical = write_url(
                                        $val['item']->languages->first()->pivot->canonical,
                                        true,
                                        true,
                                    );
                                @endphp
                                <li><a href="{{ $canonical }}">{{ $name }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <div class="col-lg-4 col-md-8 col-sm-8">
                <div class="footer__newslatter">
                    <h6>NEWSLETTER</h6>
                    <form action="#">
                        <input type="text" placeholder="Email">
                        <button type="submit" class="site-btn">Subscribe</button>
                    </form>
                    <div class="footer__social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-youtube-play"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                <div class="footer__copyright__text">
                    <p>Cần hỗ trợ? Liên hệ cho chúng tôi: {{ $system['contact_hotline'] }} <i class="fa fa-heart"
                            aria-hidden="true"></i> Design by <a href="https://colorlib.com" target="_blank">Phgmnhd</a>
                    </p>
                </div>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </div>
        </div>
    </div>
</footer>
