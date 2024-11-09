@extends('layouts.frontend.app')
@section('title')
    Show {{ $mainPost->title }}
@endsection
@section('meta_desc')
    {{ $mainPost->small_desc }}
@endsection
@push('header')
    {{-- to make each url spacial for seo used when there is pagination and slug for each post as a parmeter after the basic url --}}
    <link rel="canonical" href="{{ url()->full() }}">
@endpush
@section('breadcrumb')
    @parent <!-- to get static li in the app-->
    <li class="breadcrumb-item"><a href="{{ route('frontend.index') }}">Home</a></li>

    <li class="breadcrumb-item active">{{ $mainPost->title }}</li>
@endsection
@section('body')
    <!-- Single News Start-->
    <div class="single-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Carousel -->
                    <div id="newsCarousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach ($mainPost->images as $index => $image)
                                <li data-target="#newsCarousel" data-slide-to="{{ $index }}"
                                    class="{{ $loop->index == 0 ? 'active' : '' }}"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach ($mainPost->images as $index => $image)
                                <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}">
                                    <img src="{{ $image->name }}" class="d-block w-100" alt="First Slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>{{ $mainPost->title }}</h5>
                                        <p>
                                            created by: {{ $mainPost->user->name }}

                                        </p>
                                    </div>
                                </div>
                            @endforeach


                            <!-- Add more carousel-item blocks for additional slides -->
                        </div>
                        <a class="carousel-control-prev" href="#newsCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#newsCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <div class="sn-content">
                        {{-- {!! !!} to render html tags  --}}
                        {!! $mainPost->desc !!}
                    </div>

                    <!-- Comment Section -->
                    @auth
                        @if ($mainPost->comment_able == 1 && auth()->user()->status == 1)
                            <div class="comment-section">
                                <!-- Comment Input -->

                                <form id="comment-form" class="comment-input">
                                    @csrf
                                    <input id="commentInput" name="comment" type="text" placeholder="Add a comment..."
                                        id="commentBox" />

                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="post_id" value="{{ $mainPost->id }}">

                                    <button type="submit" id="addCommentBtn">Post</button>
                                </form>



                                <div style="display: none" id="errorMesg" class="alert alert-danger">

                                </div>
                                <!-- Display Comments -->
                                <div class="comments">
                                    @foreach ($mainPost->comments as $comment)
                                        <div class="comment">
                                            <img src="{{ $comment->user->image_path }}" alt="User Image" class="comment-img" />
                                            <div class="comment-content">
                                                <span class="username">{{ $comment->user->name }}</span>
                                                <p class="comment-text">{{ $comment->comment }}</p>
                                            </div>
                                        </div>
                                    @endforeach


                                    <!-- Add more comments here for demonstration -->
                                </div>

                                <!-- Show More Button -->
                                @if ($mainPost->comments->count() > 2)
                                    <button id="showMoreBtn" class="show-more-btn">Show more</button>
                                @endif
                            </div>
                        @endif
                    @endauth

                    <!-- Related News -->
                    <div class="sn-related">
                        <h2>Related News</h2>
                        <div class="row sn-slider">
                            @foreach ($posts as $post)
                                <div class="col-md-4">
                                    <div class="sn-img">
                                        <img src="{{ $post->images()->first()->name }}" class="img-fluid"
                                            alt="Related News 1" />
                                        <div class="sn-title">
                                            <a
                                                href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sidebar">
                        <div class="sidebar-widget">
                            <h2 class="sw-title">In This Category</h2>
                            <div class="news-list">
                                @foreach ($posts as $post)
                                    <div class="nl-item">
                                        <div class="nl-img">
                                            <img src="{{ $post->images->first()->name }}" />
                                        </div>
                                        <div class="nl-title">
                                            <a
                                                href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                        </div>
                                    </div>
                                @endforeach


                            </div>
                        </div>



                        <div class="sidebar-widget">
                            <div class="tab-news">
                                <ul class="nav nav-pills nav-justified">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#featured">Latest</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#popular">Popular</a>
                                    </li>

                                </ul>

                                <div class="tab-content">
                                    <div id="featured" class="container tab-pane active">
                                        @foreach ($latest_posts as $post)
                                            <div class="tn-news">
                                                <div class="tn-img">
                                                    <img src="{{ $post->images()->first()->name }}" />
                                                </div>
                                                <div class="tn-title">
                                                    <a
                                                        href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div id="popular" class="container tab-pane fade">
                                        @foreach ($gretestPostComments as $post)
                                            <div class="tn-news">
                                                <div class="tn-img">
                                                    <img src="{{ $post->images()->first()->name }}" />
                                                </div>
                                                <div class="tn-title">
                                                    <a
                                                        href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>



                        <div class="sidebar-widget">
                            <h2 class="sw-title">News Category</h2>
                            <div class="category">
                                <ul>
                                    @foreach ($categories as $category)
                                        <li><a
                                                href="">{{ $category->name }}</a><span>({{ $category->posts->count() }})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>



                        <div class="sidebar-widget">
                            <h2 class="sw-title">Tags Cloud</h2>
                            <div class="tags">
                                <a href="">National</a>
                                <a href="">International</a>
                                <a href="">Economics</a>
                                <a href="">Politics</a>
                                <a href="">Lifestyle</a>
                                <a href="">Technology</a>
                                <a href="">Trades</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single News End-->
@endsection
@push('script')
    <script>
        $(document).on('click', '#showMoreBtn', function(e) {
            e.preventDefault();
            // alert('yse')
            $.ajax({
                url: "{{ route('frontend.post.getAllcomments', $mainPost->slug) }}",
                type: 'GET',
                success: function(data) {
                    // console.log(response);
                    $('.comments').empty();
                    $.each(data, function(index, comment) {
                        $('.comments').append(`
                    <div class="comment">
                                <img src="${comment.user.image_path}" alt="User Image" class="comment-img" />
                                <div class="comment-content">
                                    <span class="username">${comment.user.name}</span>
                                    <p class="comment-text">${comment.comment}</p>
                                </div>
                            </div>

                    `)
                    });
                    $('#showMoreBtn').hide();
                },
                error: function(data) {

                }
            })

        })

        $(document).on('submit', '#comment-form', function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            // alert('yse')
            // $('#comment-form .error-message').remove();
            $('#commentInput').val('');
            $.ajax({
                url: "{{ route('frontend.post.storeComments') }}",
                type: 'post',
                data: formData,
                processData: false,
                contentType: false, // this make the csrf token submit with the form

                success: function(data) {
                    //preppend to add the element in the top
                    $('#errorMesg').hide();
                    $('.comments').prepend(`
                    <div class="comment">
                                <img src="${data.comment.user.image_path}" alt="User Image" class="comment-img" />
                                <div class="comment-content">
                                    <span class="username">${data.comment.user.name}</span>
                                    <p class="comment-text">${data.comment.comment}</p>
                                </div>
                            </div>

                    `)

                },
                error: function(data) {
                    // to parse php validation object to js object
                    var response = $.parseJSON(data.responseText);

                    // Display errors below each field

                    // Comment field error
                    if (response.errors.comment) {
                        // $('#commentInput').after('<div class="error-message alert alert-danger" >' +
                        //     response.errors.comment + '</div>');
                        $('#errorMesg').text(response.errors.comment).show();
                    }


                }
            })

        })
    </script>
@endpush
