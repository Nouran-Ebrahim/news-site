@extends('layouts.dashboard.app')
@section('title', 'Create Post')
@section('body')
    <center>
        <form action="{{ route('admin.posts.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body shadow mb-4 col-10">
                <h2>Create New Post</h2>
                <a href="{{route('admin.posts.index')}}">Posts/</a>
                <span>Create</span>
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" name="title" placeholder="Enter post title" class="form-control">
                            @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <textarea type="text" name="small_desc" placeholder="Enter small Desc" class="form-control"></textarea>
                            @error('small_desc')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <textarea id="postContent" type="text" name="desc"  class="form-control"></textarea>
                            @error('desc')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <select name="status" class="form-control">
                                <option selected disabled>Select status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            @error('status')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <select name="category_id" class="form-control">
                                <option selected disabled>Select Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label pr-5">
                                Enable Comments:
                            </label>

                            <input name="comment_able" type="checkbox" class="form-check-input" />
                            @error('comment_able')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <select name="user_id" class="form-control">
                                <option selected disabled>Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                </div>
                <div class="row">

                    <div class="col-12">
                        <div class="form-group">
                            <input multiple id="postImage" type="file" name="images[]" class="form-control">
                            @error('images')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <br>
                <button type="submit" class="btn btn-primary">Create post</button>
            </div>
        </form>
    </center>
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




        });
    </script>
@endpush
