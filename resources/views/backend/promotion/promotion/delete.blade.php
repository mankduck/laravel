@extends('backend.dashboard.layout')
@section('adminContent')
    @include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['create']['title']])
    @include('backend.dashboard.component.formError')
    <form action="{{ route('widget.destroy', $widget->id) }}" method="post" class="box">
        @include('backend.dashboard.component.destroy', ['model' => $widget])
    </form>
@endsection
