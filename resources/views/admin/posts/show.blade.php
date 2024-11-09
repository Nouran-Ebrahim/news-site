@extends('layouts.dashboard.app')
@section('title', 'Show Post')
@section('body')

    <div class="d-flex justify-content-center">
        <div class="card-body shadow mb-4 " style="max-width: 100ch">
            <h2>Post : {{ $post->title }}</h2>
            <a href="{{ route('admin.posts.index', ['page' => request()->page]) }}">Posts/</a>
            <span>show</span>
            <br>
            <div id="newsCarousel" class="carousel slide " data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach ($post->images as $index => $image)
                        <li data-target="#newsCarousel" data-slide-to="{{ $index }}"
                            class="{{ $loop->index == 0 ? 'active' : '' }}"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach ($post->images as $index => $image)
                        <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}">
                            <img src="{{ $image->name }}" class="d-block w-100" alt="First Slide">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>{{ $post->title }}</h5>

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
            <br>
            <div class="row">
                <div class="col-4">
                    <h6>
                        <i class="fa fa-user"></i> {{ $post->user->name }}
                    </h6>

                </div>
                <div class="col-4">
                    <h6>
                        <i class="fa fa-eye"></i> {{ $post->num_of_views }}

                    </h6>
                </div>
                <div class="col-4">
                    <h6>
                        <i class="fa fa-edit"></i> {{ $post->created_at->format('Y-m-d') }}

                    </h6>
                </div>


            </div>
            <div class="row">
                <div class="col-4">
                    <h6>
                        <i class="fa fa-wifi"></i> {{ $post->status_name }}
                    </h6>

                </div>
                <div class="col-4">
                    <h6>
                        <i class="fa fa-folder"></i> {{ $post->category->name }}

                    </h6>
                </div>
                <div class="col-4">
                    <h6>
                        <i class="fa fa-comment"></i> {{ $post->comment_able == 1 ? 'Active' : 'Not Active' }}

                    </h6>

                </div>


            </div>
            <div class="sn-content">
                {{-- {!! !!} to render html tags  --}}
                {!! $post->desc !!}
            </div>
            <br>
            <div class="sn-content">
                <strong>{{ $post->small_desc }}</strong>
            </div>
            <br>
            <a href="{{ route('admin.posts.toggleStatus', $post) }}" class="btn btn-warning" role="button">
                Toggle Status</a>
            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-info" role="button">
                Edit</a>
            <a href="javascript:;"
                onclick="if(confirm('do you want to delete the post')){document.getElementById('deletepost').submit()}return false"
                class="btn btn-danger" role="button">Delete</a>
            <form style="display: none" id="deletepost" method="POST" action="{{ route('admin.posts.destroy', $post) }}">
                @csrf
                @method('delete')
            </form>
        </div>

    </div>
    <div class="d-flex justify-content-center">
        <!-- Sidebar -->


        <!-- Main Content -->
        <div class="card-body shadow mb-4" style="max-width: 100ch">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <h2 class="mb-4">Comments</h2>

                    </div>

                </div>
                <div class="comments">
                    @forelse ($post->comments as $comment)
                        <div class="notification alert alert-info">
                            <strong>
                                <img src="{{ $comment->user->image_path }}" width="50" class="img-thumbnail rounded">
                                <a style="text-decoration: none" href="{{ route('admin.users.show', $comment->user) }}">
                                    {{ $comment->user->name }}
                                </a>:
                            </strong>
                            on {{ $comment->comment }}
                            <br>
                            <strong style="color: red">{{ $comment->created_at->diffForHumans() }}</strong>
                            <div class="float-right">
                                <a href="{{ route('admin.posts.deleteComment', $comment->id) }}"
                                    class="btn btn-danger btn-sm">Delete</a>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">No comments yet</div>
                    @endforelse
                </div>


                    <button id="showMoreBtn" class="show-more-btn btn btn-primary">Show more</button>

                <!-- Change this to 2 if you load only 2 initially -->




            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

    <script>
        let currentPage = 1; // Track the current page

        $(document).on('click', '#showMoreBtn', function(e) {
            e.preventDefault();
            currentPage++; // Increment the page number

            $.ajax({
                url: "{{ route('admin.posts.getAllcomments', $post) }}",
                type: 'GET',
                data: {
                    page: currentPage // Send the current page to the server
                },
                success: function(data) {
                    if (data.length === 0) {
                        $('.comments').append(
                            '<div class="alert alert-warning">No more comments found.</div>');
                        $('#showMoreBtn').hide(); // Hide the button if no more comments
                    } else {
                        $.each(data, function(index, comment) {
                            $('.comments').append(`
                        <div class="notification alert alert-info">
                            <strong>
                                <img src="${comment.user.image_path}" width="50" class="img-thumbnail rounded">
                                <a style="text-decoration: none" href="{{ route('admin.users.show', '') }}/${comment.user.id}">
                                    ${comment.user.name}
                                </a>:
                            </strong>
                            on ${comment.comment}
                            <br>
                            <strong style="color: red">${moment(comment.created_at).fromNow()}</strong>
                            <div class="float-right">
                                <a href="{{ route('admin.posts.deleteComment', '') }}/${comment.id}"
                                   class="btn btn-danger btn-sm">Delete</a>
                            </div>
                        </div>
                    `);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching comments:', error);
                    $('.comments').append(
                        '<div class="alert alert-danger">An error occurred while fetching comments.</div>'
                    );
                }
            });
        });
    </script>
@endpush
