@extends('layouts.frontend.app')
@section('title', 'Edit Post')

@section('breadcrumb')
    @parent <!-- to get static li in the app-->
    <li class="breadcrumb-item"><a href="{{ route('frontend.dashboard.profile') }}">Dashboard</a></li>

    <li class="breadcrumb-item active">Edit {{ $post->title }}</li>
@endsection
@section('body')
    <div class="dashboard container">
        <!-- Sidebar -->
        @include('layouts.frontend._sidebar')


        <!-- Main Content -->
        <div class="main-content col-md-9">
            <!-- Show/Edit Post Section -->
            @if (session()->has('errors'))
                <div class="alert alert-danger">
                    @foreach (session('errors')->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>

            @endif
            <form enctype="multipart/form-data" action="{{ route('frontend.dashboard.post.update') }}" method="POST"
                id="posts-section" class="posts-section">
                @csrf
                @method('put')
                <h2>Your Posts</h2>
                <ul class="list-unstyled user-posts">
                    <!-- Example of a Post Item -->
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <li class="post-item">
                        <!-- Editable Title -->
                        <input name="title" type="text" class="form-control mb-2 post-title"
                            value="{{ $post->title }}" />
                        <textarea rows="5" name="small_desc" type="text" id="small_desc" class="form-control mb-2"
                            placeholder="Enter small decription">{{ $post->small_desc }}</textarea>
                        @error('small_desc')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <!-- Editable Content -->
                        <textarea id="postContent" name="desc" class="form-control mb-2 post-content">{!! $post->desc !!}</textarea>



                        <!-- Image Upload Input for Editing -->
                        <input id="postImage" name="images[]" type="file" class="form-control mt-2 edit-post-image"
                            accept="image/*" multiple />

                        <!-- Editable Category Dropdown -->
                        <select name="category_id" class="form-control mb-2 post-category">
                            @foreach ($categories as $category)
                                <option {{ $category->id == $post->category_id ? 'selected' : '' }}
                                    value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach


                        </select>

                        <!-- Editable Enable Comments Checkbox -->
                        <div class="form-check mb-2">
                            <input name="comment_able" {{ $post->comment_able == 1 ? 'checked' : '' }}
                                class="form-check-input enable-comments" type="checkbox" />
                            <label class="form-check-label">
                                Enable Comments
                            </label>
                        </div>

                        <!-- Post Meta: Views and Comments -->
                        <div class="post-meta d-flex justify-content-between">
                            <span class="views">
                                <i class="fa fa-eye"></i> {{ $post->num_of_views }} views
                            </span>
                            <span class="post-comments">
                                <i class="fa fa-comment"></i> {{ $post->comments->count() }} comments
                            </span>
                        </div>

                        <!-- Post Actions -->
                        <div class="post-actions mt-2">
                            <button type="submit" class="btn btn-success save-post-btn ">
                                Save
                            </button>
                            <a href="{{ route('frontend.dashboard.profile') }}" class="btn btn-secondary cancel-edit-btn ">
                                Cancel
                            </a>
                        </div>

                    </li>
                    <!-- Additional posts will be added dynamically -->
                </ul>
            </form>
        </div>
    </div>

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
                initialPreviewAsData: true,

                initialPreviewConfig: [
                    @if ($post->images->count() > 0)
                        @foreach ($post->images as $image)
                            {
                                caption: "{{ $image->path }}",
                                width: '120px',
                                url: "{{ route('frontend.dashboard.post.image.delete', ['_token' => csrf_token()]) }}", // server delete action
                                key: "{{ $image->id }}",

                            },
                        @endforeach
                    @endif

                ],

                initialPreview: [
                    @if ($post->images->count() > 0)
                        @foreach ($post->images as $image)
                            "{{ $image->name }}",
                        @endforeach
                    @endif

                ]
            });

            $('#postContent').summernote({
                height: 300, // set minimum height of editor
            });

        });
    </script>
@endpush
