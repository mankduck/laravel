@extends('backend.dashboard.layout')
@section('adminContent')
    @include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['create']['children'] . $menu->languages->first()->pivot->name])
@include('backend.dashboard.component.formError')
    {{-- @php
        $url = $config['method'] == 'create' ? route('menu.store') : route('menu.update', $user->id);
    @endphp --}}
    <form action="{{ route('menu.save.children', $menu->id) }}" method="post" class="box menuContainer">
        @csrf
        <div class="wrapper wrapper-content animated fadeInRight">
            @include('backend.menu.menu.component.list')

            <div class="text-right mb15">
                <button class="btn btn-primary" type="submit" name="send" value="send">Lưu lại</button>
            </div>
        </div>
    </form>

    @include('backend.menu.menu.component.popup')
@endsection
