@extends('backend.dashboard.layout')
@section('adminContent')
    @include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['create']['title']])
@include('backend.dashboard.component.formError')
    @php
        $url = $config['method'] == 'create' ? route('menu.store') : route('menu.update', $user->id);
    @endphp
    <form action="{{ $url }}" method="post" class="box menuContainer">
        @csrf
        <div class="wrapper wrapper-content animated fadeInRight">
            @include('backend.menu.menu.component.catalogue')
            <hr>
            @include('backend.menu.menu.component.list')

            <div class="text-right mb15">
                <button class="btn btn-primary" type="submit" name="send" value="send">Lưu lại</button>
            </div>
        </div>
    </form>

    @include('backend.menu.menu.component.popup')
@endsection
