@extends('frontend.layout')
@section('contentUser')
    <section class="blog spad">
        <div class="container">
            <div class="row">
                @if (isset($posts) && !is_null($posts) && count($posts))
                    @foreach ($posts as $post)
                    @endforeach
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic set-bg" data-setbg="{{ $post->image }}"></div>
                            <div class="blog__item__text">
                                <h6><a href="#">{!! $post->post_language->first()->name !!}</a></h6>
                                <ul>
                                    <li>by <span>{{ $post->users->name }}</span></li>
                                    <li>{{ $post->created_at }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- <div class="col-lg-12 text-center">
                    <a href="#" class="primary-btn load-btn">Load more posts</a>
                </div> --}}
            </div>
        </div>
    </section>
@endsection
