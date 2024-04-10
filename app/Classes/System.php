<?php
namespace App\Classes;

class System
{

    public function config()
    {
        $data['homepage'] = [
            'label' => 'Thông tin chung',
            'description' => 'Cài đặt đầy đủ thông tin chung của website. Tên thương hiệu, logo, Favicon,...',
            'value' => [
                'company' => ['type' => 'text', 'label' => 'Tên công ty'],
                'brand' => ['type' => 'text', 'label' => 'Tên thương hiệu'],
                'logo' => ['type' => 'images', 'label' => 'Favicon', 'title' => 'Click vào ô phía dưới để upload ảnh'],
                'copyright' => ['type' => 'text', 'label' => 'Copyright'],
                'website' => [
                    'type' => 'select',
                    'label' => 'Tình trạng website',
                    'option' => [
                        'open' => 'Trang web đang hoạt động',
                        'close' => 'Trang web đang được bảo trì'
                    ]
                ],
                'short_intro' => ['type' => 'editor', 'label' => 'Giới thiệu ngắn']
            ],

        ];


        $data['contact'] = [
            'label' => 'Thông tin liên hệ',
            'description' => 'Cài đặt đầy đủ thông tin liên hệ của website. Địa chỉ, hotline,...',
            'value' => [
                'office' => ['type' => 'text', 'label' => 'Địa chỉ công ty'],
                'address' => ['type' => 'text', 'label' => 'Văn phòng giao dịch'],
                'hotline' => ['type' => 'text', 'label' => 'Hotline'],
                'technical_phone' => ['type' => 'text', 'label' => 'Hotline kĩ thuật'],
                'phone' => ['type' => 'text', 'label' => 'Liên hệ'],
                'fax' => ['type' => 'text', 'label' => 'Fax'],
                'email' => ['type' => 'text', 'label' => 'Email'],
                'tax' => ['type' => 'text', 'label' => 'Mã số thuế'],
                'website' => ['type' => 'text', 'label' => 'Website'],
                'map' => [
                    'type' => 'textarea',
                    'label' => 'Bản đồ',
                    'link' => [
                        'text' => 'Hướng dẫn lấy mã nhúng bản đồ',
                        'href' => 'https://manhan.vn/hoc-website-nang-cao/huong-dan-nhung-ban-do-google-maps-len-website/',
                        'target' => '_blank'
                    ]
                ],
            ],

        ];


        $data['seo'] = [
            'label' => 'Cấu hình SEO cho trang chủ',
            'description' => 'Cài đặt cấu hình SEO cho website',
            'value' => [
                'meta_title' => ['type' => 'text', 'label' => 'Tiêu đề SEO'],
                'meta_keyword' => ['type' => 'text', 'label' => 'Từ khóa SEO'],
                'meta_description' => ['type' => 'text', 'label' => 'Mô tả SEO'],
                'meta_images' => ['type' => 'images', 'label' => 'Ảnh SEO'],
            ],

        ];

        return $data;
    }

}
