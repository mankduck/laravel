@extends('frontend.layout')
@section('styleCustom')
    <style>
        .about-content {
            line-height: 30px;
        }
    </style>
@endsection
@section('contentUser')
    @include('frontend.component.breadcrumb', [
        'name' => 'Giới thiệu',
    ])
    <div class="container">
        <h4 class="my-3 text-uppercase font-weight-bold">Về chúng tôi</h4>
        <p class="about-content">
            Chào mừng bạn đến với [Tên Shop] – nơi thời trang gặp gỡ phong cách! 🌿✨ <br>

            Tại [Tên Shop], chúng tôi tin rằng thời trang không chỉ là trang phục mà còn là cách bạn thể hiện cá tính và
            phong
            thái riêng. Với bộ sưu tập đa dạng từ trang phục hàng ngày đến những thiết kế ấn tượng cho các dịp đặc biệt,
            chúng
            tôi luôn cập nhật xu hướng mới nhất để mang đến cho bạn những lựa chọn thời thượng và chất lượng nhất.<br>

            Chất liệu cao cấp, kiểu dáng tinh tế cùng sự tận tâm trong từng đường kim mũi chỉ – đó là cam kết của chúng tôi
            để
            giúp bạn luôn tự tin và nổi bật. Đến với [Tên Shop], bạn không chỉ mua sắm mà còn tận hưởng một trải nghiệm
            phong
            cách đẳng cấp!<br>

            📍 Địa chỉ: [Địa chỉ shop]<br>
            📞 Hotline: [Số điện thoại]<br>
            🌐 Website/Facebook: [Link shop]<br>

            Cảm ơn bạn đã đồng hành cùng [Tên Shop]! 💖
        </p>
    </div>
@endsection
