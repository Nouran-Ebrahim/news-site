@extends('layouts.frontend.app')
@section('title')
    Category {{ $category->name }}
@endsection
@push('header')
    {{-- to make each url spacial for seo used when there is pagination and slug for each post as a parmeter after the basic url --}}
    <link rel="canonical" href="{{url()->full()}}">
@endpush
@section('breadcrumb')
    @parent <!-- to get static li in the app-->
    <li class="breadcrumb-item"><a href="{{ route('frontend.index') }}">Home</a></li>

    <li class="breadcrumb-item active">{{ $category->name }}</li>
@endsection
@section('body')
    <br>
    <!-- Main News Start-->
    <div class="main-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        @forelse ($posts as $post)
                            <div class="col-md-4">
                                <div class="mn-img">
                                    <img src="{{ $post->images->first()->name }}" />
                                    <div class="mn-title">
                                        <a href="{{route('frontend.post.show',$post->slug)}}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert-info">
                                Category is Empty
                            </div>
                        @endforelse






                    </div>
                    {{ $posts->links() }}
                </div>

                <div class="col-lg-3">
                    <div class="mn-list">
                        <h2>Onther Categories</h2>
                        <ul>
                            @foreach ($otherCategories as $cat)
                                <li><a href="{{ route('frontend.categoryPosts', $cat->slug) }}">{{ $cat->name }}</a></li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main News End-->
@endsection
