@extends('backend.dashboard.layout')
@section('adminContent')
    @include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['create']['title']])
    @include('backend.dashboard.component.formError')
    @php
        $url = $config['method'] == 'create' ? route('widget.store') : route('widget.update', $slide->id);
    @endphp
    <form action="{{ $url }}" method="post" class="box">
        @csrf
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-9">
                </div>
                <div class="col-lg-3">
                    @include('backend.widget.component.aside')
                </div>
            </div>
            <div class="text-right mb15">
                <button class="btn btn-primary" type="submit" name="send" value="send">Lưu lại</button>
            </div>
        </div>
    </form>
@endsection
