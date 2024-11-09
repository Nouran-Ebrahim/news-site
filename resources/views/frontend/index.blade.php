@extends('layouts.frontend.app')
@section('title', 'Home')
@section('meta_desc')
    {{ $getSettings->small_desc }}
@endsection
@push('header')
    {{-- to make each url spacial for seo used when there is pagination and slug for each post as a parmeter after the basic url --}}
    <link rel="canonical" href="{{url()->full()}}">
@endpush
@section('breadcrumb')
    @parent <!-- to get static li in the app-->
    <li class="breadcrumb-item"><a href="{{ route('frontend.index') }}">Home</a></li>

@endsection
@section('body')
    @php
        $latestThreePosts = $posts->take(3);
    @endphp
    <!-- Top News Start-->
    <div class="top-news">
        <div class="container">
            <div class="row">
                <div class="col-md-6 tn-left">
                    <div class="row tn-slider">
                        @foreach ($latestThreePosts as $post)
                            <div class="col-md-6">
                                <div class="tn-img">
                                    <img style="height: 383px;width:510px" src="{{ $post->images->first()->name }}" />
                                    <div class="tn-title">
                                        <a href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
                <div class="col-md-6 tn-right">
                    <div class="row">
                        @php
                            $fourPosts = $posts->take(4);
                        @endphp
                        @foreach ($fourPosts as $post)
                            <div class="col-md-6">
                                <div class="tn-img">
                                    <img src="{{ $post->images->first()->name }}" />
                                    <div class="tn-title">
                                        <a href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                        <div class="col-md-6">
                            <div class="tn-img">
                                <img src="{{ asset('assets/frontEnd') }}/img/news-350x223-4.jpg" />
                                <div class="tn-title">
                                    <a href="">Lorem ipsum dolor sit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top News End-->

    <!-- Category News Start-->
    <div class="cat-news">
        <div class="container">
            <div class="row">
                @foreach ($categories_with_posts as $cat)
                    <div class="col-md-6">
                        <h2>{{ $cat->name }}</h2>
                        <div class="row cn-slider">
                            @foreach ($cat->posts as $post)
                                <div class="col-md-6">
                                    <div class="cn-img">
                                        <img src="{{ $post->images->first()->name }}" />
                                        <div class="cn-title">
                                            <a
                                                href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </div>
    <!-- Category News End-->



    <!-- Tab News Start-->
    <div class="tab-news">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ul class="nav nav-pills nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#featured">Oldest News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#popular">Popular News</a>
                        </li>

                    </ul>

                    <div class="tab-content">
                        <div id="featured" class="container tab-pane active">
                            @foreach ($oldestNews as $news)
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="{{ $news->images->first()->name }}" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="{{ route('frontend.post.show', $news->slug) }}">{{ $news->title }}</a>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                        <div id="popular" class="container tab-pane fade">

                            @foreach ($gretestPostComments as $post)
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="{{ $post->images->first()->name }}" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}
                                            ({{ $post->comments_count }})
                                        </a>
                                    </div>
                                </div>
                            @endforeach



                        </div>

                    </div>
                </div>

                <div class="col-md-6">
                    <ul class="nav nav-pills nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#m-viewed">Latest News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#m-read">Most Read</a>
                        </li>

                    </ul>

                    <div class="tab-content">

                        <div id="m-viewed" class="container tab-pane active">
                            @foreach ($latestThreePosts as $post)
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="{{ $post->images->first()->name }}" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            @endforeach


                        </div>

                        <div id="m-read" class="container tab-pane fade">
                            @foreach ($mostThreeViewdPosts as $post)
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="{{ $post->images->first()->name }}" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="{{ route('frontend.post.show', $post->slug) }}"{{ $post->title }}
                                            ({{ $post->num_of_views }}) </a>
                                    </div>
                                </div>
                            @endforeach


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tab News Start-->

    <!-- Main News Start-->
    <div class="main-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        @foreach ($posts as $post)
                            <div class="col-md-4">
                                <div class="mn-img">
                                    <img src="{{ $post->images->first()->name }}" />
                                    <div class="mn-title">
                                        <a href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{ $posts->links() }}

                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="mn-list">
                        <h2>Read More</h2>
                        <ul>
                            @foreach ($read_more_posts as $post)
                                <li><a href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a></li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main News End-->
@endsection
