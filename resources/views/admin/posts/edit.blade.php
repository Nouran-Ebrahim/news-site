@extends('layouts.dashboard.app')
@section('title', 'Update Post')
@section('body')
    <center>
        <form action="{{ route('admin.posts.update',$post) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="card-body shadow mb-4 col-10">
                <h2>Update {{$post->title}}</h2>
                <a href="{{route('admin.posts.index')}}">Posts/</a>
                <span>Update</span>
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" value="{{@old('title',$post->title)}}" name="title" placeholder="Enter post title" class="form-control">
                            @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <textarea type="text" name="small_desc"  placeholder="Enter small Desc" class="form-control">{{@old('small_desc',$post->small_desc)}}</textarea>
                            @error('small_desc')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <textarea id="postContent" type="text" name="desc"  class="form-control">{!! @old('desc',$post->desc) !!}</textarea>
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
                                <option @selected($post->status==1) value="1">Active</option>
                                <option @selected($post->status==0) value="0">Inactive</option>
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
                                    <option @selected($cat->id==$post->category_id) value="{{ $cat->id }}">{{ $cat->name }}</option>
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

                            <input name="comment_able" {{ $post->comment_able == 1 ? 'checked' : '' }} type="checkbox" class="form-check-input" />
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
                                    <option @selected($user->id==$post->user_id) value="{{ $user->id }}">{{ $user->name }}</option>
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
                <button type="submit" class="btn btn-primary">Update post</button>
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
                initialPreviewAsData: true,

                initialPreviewConfig: [
                    @if ($post->images->count() > 0)
                        @foreach ($post->images as $image)
                            {
                                caption: "{{ $image->path }}",
                                width: '120px',
                                url: "{{ route('admin.posts.image.delete', ['_token' => csrf_token()]) }}", // server delete action
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
