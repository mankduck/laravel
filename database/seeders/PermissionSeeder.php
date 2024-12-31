<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['id' => 1, 'name' => 'Thêm mới nhóm thành viên', 'canonical' => 'user.catalogue.create'],
            ['id' => 2, 'name' => 'Xem danh sách nhóm thành viên', 'canonical' => 'user.catalogue.index'],
            ['id' => 3, 'name' => 'Chỉnh sửa nhóm thành viên', 'canonical' => 'user.catalogue.edit'],
            ['id' => 4, 'name' => 'Xóa nhóm thành viên', 'canonical' => 'user.catalogue.delete'],
            ['id' => 5, 'name' => 'Quản lý phân quyền User', 'canonical' => 'user.catalogue.permission'],
            ['id' => 6, 'name' => 'Thêm mới thành viên', 'canonical' => 'user.create'],
            ['id' => 7, 'name' => 'Xam danh sách thành viên', 'canonical' => 'user.index'],
            ['id' => 8, 'name' => 'Chỉnh sửa thành viên', 'canonical' => 'user.edit'],
            ['id' => 9, 'name' => 'Xóa thành viên', 'canonical' => 'user.delete'],
            ['id' => 10, 'name' => 'Xem danh sách phân quyền', 'canonical' => 'permission.index'],
            ['id' => 11, 'name' => 'Thêm mới phân quyền', 'canonical' => 'permission.create'],
            ['id' => 12, 'name' => 'Chỉnh sửa phân quyền', 'canonical' => 'permission.edit'],
            ['id' => 13, 'name' => 'Xóa phân quyền', 'canonical' => 'permission.delete'],
            ['id' => 14, 'name' => 'Xem danh sách bài viết', 'canonical' => 'post.index'],
            ['id' => 15, 'name' => 'Thêm mới bài viết', 'canonical' => 'post.create'],
            ['id' => 16, 'name' => 'Chỉnh sửa bài viết', 'canonical' => 'post.edit'],
            ['id' => 17, 'name' => 'Xóa bài viết', 'canonical' => 'post.delete'],
            ['id' => 18, 'name' => 'Xem danh sách nhóm bài viết', 'canonical' => 'post.catalogue.index'],
            ['id' => 19, 'name' => 'Thêm mới nhóm bài viết', 'canonical' => 'post.catalogue.create'],
            ['id' => 20, 'name' => 'Chỉnh sửa nhóm bài viết', 'canonical' => 'post.catalogue.edit'],
            ['id' => 21, 'name' => 'Xóa nhóm bài viết', 'canonical' => 'post.catalogue.delete'],
            ['id' => 22, 'name' => 'Quản lý loại thuộc tính', 'canonical' => 'attribute.catalogue.index'],
            ['id' => 23, 'name' => 'Thêm mới loại thuộc tính', 'canonical' => 'attribute.catalogue.create'],
            ['id' => 24, 'name' => 'Chỉnh sửa loại thuộc tính', 'canonical' => 'attribute.catalogue.edit'],
            ['id' => 25, 'name' => 'Xóa loại thuộc tính', 'canonical' => 'attribute.catalogue.delete'],
            ['id' => 26, 'name' => 'Quản lý thuộc tính', 'canonical' => 'attribute.index'],
            ['id' => 27, 'name' => 'Chỉnh sửa thuộc tính', 'canonical' => 'attribute.edit'],
            ['id' => 28, 'name' => 'Thêm mới thuộc tính', 'canonical' => 'attribute.create'],
            ['id' => 29, 'name' => 'Xóa thuộc tính', 'canonical' => 'attribute.delete'],
            ['id' => 30, 'name' => 'Quản lý ngôn ngữ', 'canonical' => 'language.index'],
            ['id' => 31, 'name' => 'Thêm mới ngôn ngữ', 'canonical' => 'language.create'],
            ['id' => 32, 'name' => 'Chỉnh sửa ngôn ngữ', 'canonical' => 'language.edit'],
            ['id' => 33, 'name' => 'Xóa ngôn ngữ', 'canonical' => 'language.delete'],
            ['id' => 34, 'name' => 'Tạo bản dịch', 'canonical' => 'language.translate'],
            ['id' => 35, 'name' => 'Quản lý Menu', 'canonical' => 'menu.index'],
            ['id' => 36, 'name' => 'Thêm mới Menu', 'canonical' => 'menu.create'],
            ['id' => 37, 'name' => 'Chỉnh sửa Menu', 'canonical' => 'menu.edit'],
            ['id' => 38, 'name' => 'Chỉnh sửa Menu cấp 1', 'canonical' => 'menu.editMenu'],
            ['id' => 39, 'name' => 'Quản lý Menu con', 'canonical' => 'menu.children'],
            ['id' => 40, 'name' => 'Tạo bản dịch cho Menu', 'canonical' => 'menu.translate'],
            ['id' => 41, 'name' => 'Quản lý nhóm sản phẩm', 'canonical' => 'product.catalogue.index'],
            ['id' => 42, 'name' => 'Thêm mới nhóm sản phẩm', 'canonical' => 'product.catalogue.create'],
            ['id' => 43, 'name' => 'Chỉnh sửa nhóm sản phẩm', 'canonical' => 'product.catalogue.edit'],
            ['id' => 44, 'name' => 'Xóa nhóm sản phẩm', 'canonical' => 'product.catalogue.delete'],
            ['id' => 45, 'name' => 'Quản lý sản phẩm', 'canonical' => 'product.index'],
            ['id' => 46, 'name' => 'Thêm mới sản phẩm', 'canonical' => 'product.create'],
            ['id' => 47, 'name' => 'Chỉnh sửa sản phẩm', 'canonical' => 'product.edit'],
            ['id' => 48, 'name' => 'Xóa sản phẩm', 'canonical' => 'product.delete'],
            ['id' => 49, 'name' => 'Quản lý Slide, Banner', 'canonical' => 'slide.index'],
            ['id' => 50, 'name' => 'Thêm mới Slide, Banner', 'canonical' => 'slide.create'],
            ['id' => 51, 'name' => 'Chỉnh sửa Slide, Banner', 'canonical' => 'slide.edit'],
            ['id' => 52, 'name' => 'Xóa Slide, Banner', 'canonical' => 'slide.delete'],
            ['id' => 53, 'name' => 'Quản lý cấu hình hệ thống', 'canonical' => 'system.index'],
            ['id' => 54, 'name' => 'Tạo bản dịch cho cấu hình hệ thống', 'canonical' => 'system.translate'],
            ['id' => 55, 'name' => 'Quản lý Widget', 'canonical' => 'widget.index'],
            ['id' => 56, 'name' => 'Thêm mới Widget', 'canonical' => 'widget.create'],
            ['id' => 57, 'name' => 'Chỉnh sửa Widget', 'canonical' => 'widget.edit'],
            ['id' => 58, 'name' => 'Xóa Widget', 'canonical' => 'widget.delete'],
        ];

        DB::table('permissions')->insert($permissions);

        $cataloguePermissions = [];

        foreach ($permissions as $permission) {
            $permissionId = DB::table('permissions')->where('canonical', $permission['canonical'])->value('id');

            $cataloguePermissions[] = ['permission_id' => $permissionId, 'user_catalogue_id' => 1];
        }

        DB::table('user_catalogue_permission')->insert($cataloguePermissions);
    }
}
