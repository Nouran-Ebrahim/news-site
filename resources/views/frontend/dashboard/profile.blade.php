@extends('layouts.frontend.app')
@section('title', 'Profile')

@section('breadcrumb')
    @parent <!-- to get static li in the app-->
    <li class="breadcrumb-item"><a href="{{ route('frontend.dashboard.profile') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Profile</li>

@endsection
@section('body')
    <!-- Profile Start -->
    <div class="dashboard container">
        <!-- Sidebar -->
        @include('layouts.frontend._sidebar')


        <!-- Main Content -->
        <div class="main-content">
            <!-- Profile Section -->
            <section id="profile" class="content-section active">
                <h2>User Profile</h2>
                <div class="user-profile mb-3">
                    <!-- we can use gaurd name but as defult gaurd is web so we can remove it  -->
                    <img src="{{ auth()->user()->image_path }}" alt="User Image" class="profile-img rounded-circle"
                        style="width: 100px; height: 100px;" />
                    <span class="username">{{ auth('web')->user()->name }}</span>
                </div>
                <br>

                <!-- Add Post Section -->
                @if (session()->has('errors'))
                    <div class="alert alert-danger">
                        @foreach (session('errors')->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>

                @endif
                <form method="POST" enctype="multipart/form-data" action="{{ route('frontend.dashboard.post.store') }}"
                    id="add-post" class="add-post-section mb-5">
                    @csrf
                    <h2>Add Post</h2>
                    <div class="post-form p-3 border rounded">
                        <!-- Post Title -->
                        <input name="title" type="text" id="postTitle" class="form-control mb-2"
                            placeholder="Post Title" />
                        @error('title')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                        <textarea rows="5" name="small_desc" type="text" id="small_desc" class="form-control mb-2"
                            placeholder="Enter small decription" ></textarea>
                        @error('small_desc')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <!-- Post Content -->
                        <textarea name="desc" id="postContent" class="form-control mb-2" rows="3" placeholder="What's on your mind?"></textarea>
                        @error('desc')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <!-- Image Upload -->
                        <input name="images[]" type="file" id="postImage" class="form-control mb-2" accept="image/*"
                            multiple />
                        <div class="tn-slider mb-2">
                            <div id="imagePreview" class="slick-slider"></div>
                        </div>
                        @error('images')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <!-- Category Dropdown -->
                        <select name="category_id" id="postCategory" class="form-select mb-2">
                            <option value="" selected>Select Category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select><br>
                        @error('category_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <!-- Enable Comments Checkbox -->
                        <label class="form-check-label mb-2">
                            Enable Comments: <input name="comment_able" type="checkbox" class="form-check-input" />
                        </label><br>

                        <!-- Post Button -->
                        <button type="submit" class="btn btn-primary post-btn">Post</button>
                    </div>
                </form>

                <!-- Posts Section -->
                <section id="posts" class="posts-section">
                    <h2>Recent Posts</h2>
                    <div class="post-list">

                        @forelse ($posts as $post)
                            <!-- Post Item -->
                            <div class="post-item mb-4 p-3 border rounded">
                                <div class="post-header d-flex align-items-center mb-2">
                                    <img src="{{ $post->user->image_path }}" alt="User Image" class="rounded-circle"
                                        style="width: 50px; height: 50px;" />
                                    <div class="ms-3">
                                        <h5 class="mb-0">{{ $post->user->username }}</h5>
                                        <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <h4 class="post-title">{{ $post->title }}</h4>
                                {{-- chunk_split to make new line after number of chars --}}
                                <p class="post-content">{!! chunk_split($post->desc, 30) !!}</p>

                                <div id="newsCarousel" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        @foreach ($post->images as $index => $image)
                                            <li data-target="#newsCarousel" data-slide-to="0"
                                                class="{{ $index == 0 ? 'active' : '' }}"></li>
                                        @endforeach
                                    </ol>
                                    <div class="carousel-inner">
                                        @foreach ($post->images as $index => $image)
                                            <div class="carousel-item  {{ $index == 0 ? 'active' : '' }}">
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

                                <div class="post-actions d-flex justify-content-between">
                                    <div class="post-stats">
                                        <!-- View Count -->
                                        <span class="me-3">
                                            <i class="fas fa-eye"></i> {{ $post->num_of_views }} views
                                        </span>
                                    </div>

                                    <div>
                                        <a href="{{ route('frontend.dashboard.post.edit', $post->slug) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>

                                        <a onclick="if(confirm('are you sure to delete?')){document.getElementById('deleteForm_{{ $post->id }}').submit()}else{return false} "
                                            href="javascript:;" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-thumbs-up"></i> Delete
                                        </a>

                                        <button id="commentBtn_{{ $post->id }}" post-id="{{ $post->id }}"
                                            class="getComments btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-comment"></i> Comments
                                        </button>
                                        <button style="display: none" id="commentHideBtn_{{ $post->id }}"
                                            post-id="{{ $post->id }}"
                                            class="hideComments btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-comment"></i> Hide Comments
                                        </button>
                                        <form style="display: none" id="deleteForm_{{ $post->id }}" method="POST"
                                            action="{{ route('frontend.dashboard.post.delete') }}">
                                            @csrf
                                            <input type="hidden" name="slug" value="{{ $post->slug }}">
                                        </form>
                                    </div>
                                </div>

                                <!-- Display Comments -->
                                <div id="displayComments_{{ $post->id }}" class="comments" style="display: none">

                                    <!-- Add more comments here for demonstration -->
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info"> No Posts</div>
                        @endforelse


                        <!-- Add more posts here dynamically -->
                    </div>
                </section>
            </section>
        </div>
    </div>
    <!-- Profile End -->
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            // initialize with defaults
            $("#postImage").fileinput({
                theme: 'fa5',
                showCancel: true,
                showUpload: false,
                allowedFileTypes: ['image'], // allow only images
                maxFileCount: 5,
                enableResumableUpload: false,
            });

            $('#postContent').summernote({
                height: 300, // set minimum height of editor
            });
            //getComments
            $('.getComments').on('click', function(e) {
                e.preventDefault();
                var post_id = $(this).attr('post-id');

                $.ajax({
                    type: 'GET',
                    url: '{{ route('frontend.dashboard.post.getComments', ':post_id') }}'.replace(
                        ':post_id', post_id),
                    success: function(response) {
                        $('#displayComments_' + post_id).show();
                        $('#displayComments_' + post_id).empty();

                        if (response.data != null) {
                            $.each(response.data, function(index, comment) {
                                $('#displayComments_' + post_id).append(
                                    `
                                    <div class="comment">
                                        <img src="${comment.user.image_path}" alt="User Image" class="comment-img" />
                                        <div class="comment-content">
                                            <span class="username">${comment.user.name}</span>
                                            <p class="comment-text">${comment.comment}</p>
                                        </div>
                                    </div>
                                `
                                )

                            })

                        } else {
                            $('#displayComments_' + post_id).append(
                                `
                                <div class="comment">
                                  <div class="alert alert-info">${response.msg}</div>
                                </div>
                                  `
                            );
                        }
                        $('#commentBtn_' + post_id).hide();
                        $('#commentHideBtn_' + post_id).show();




                    }
                })

            })

            $('.hideComments').on('click', function(e) {
                e.preventDefault();
                var post_id = $(this).attr('post-id');
                $('#displayComments_' + post_id).hide();
                $('#commentHideBtn_' + post_id).hide();
                $('#commentBtn_' + post_id).show();

            })

        });
    </script>
@endpush
