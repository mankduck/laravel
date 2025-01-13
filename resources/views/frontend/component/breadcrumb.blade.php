    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="/"><i class="fa fa-home"></i> Trang chủ</a>
                        @if (isset($breadcrumb) && !is_null($breadcrumb))
                            @php
                            @endphp
                            @foreach ($breadcrumb as $key => $val)
                                @php
                                    $nameBre = $val->languages->first()->pivot->name;
                                    $arrow = $key < count($breadcrumb) - 1 ? '>' : '';
                                @endphp
                                <span>{{ $nameBre }} {{ $arrow }}</span>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
