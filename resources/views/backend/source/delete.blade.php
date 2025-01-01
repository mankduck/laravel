@extends('backend.dashboard.layout')
@section('adminContent')
    @include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['create']['title']])
    @include('backend.dashboard.component.formError')
    <form action="{{ route('source.destroy', $source->id) }}" method="post" class="box">
        @include('backend.dashboard.component.destroy', ['model' => $source])
    </form>
@endsection
