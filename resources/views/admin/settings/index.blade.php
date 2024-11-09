@extends('layouts.dashboard.app')
@section('title', 'Settings')
@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">
@endpush
@section('body')
    <!-- Begin Page Content -->
    <center>
        <form action="{{ route('admin.settings.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body shadow mb-4 col-10">
                <h2>Update Settings</h2>
                <br>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" value="{{ $getSettings->site_name }}" name="site_name"
                                placeholder="Enter Site Name" class="form-control">
                            @error('site_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="email" value="{{ $getSettings->email }}" name="email" placeholder="Enter email"
                                class="form-control">
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="phone" value="{{ $getSettings->phone }}" placeholder="Enter phone"
                                class="form-control">
                            @error('phone')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="country" value="{{ $getSettings->country }}"
                                placeholder="Enter country" class="form-control">
                            @error('country')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="city" value="{{ $getSettings->city }}" placeholder="Enter city"
                                class="form-control">
                            @error('city')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="street" value="{{ $getSettings->street }}"
                                placeholder="Enter street" class="form-control">
                            @error('street')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input value="{{ $getSettings->facebook }}" type="text" name="facebook"
                                placeholder="Enter facebook name" class="form-control">
                            @error('facebook')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input value="{{ $getSettings->twitter }}" type="text" name="twitter"
                                placeholder="Enter twitter name" class="form-control">
                            @error('twitter')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input value="{{ $getSettings->instgram }}" type="text" name="instgram"
                                placeholder="Enter instgram name" class="form-control">
                            @error('instgram')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input value="{{ $getSettings->youtube }}" type="text" name="youtube"
                                placeholder="Enter youtube name" class="form-control">
                            @error('youtube')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <textarea rows="3" type="text" name="small_desc" placeholder="Enter small_desc name" class="form-control">{{ $getSettings->small_desc }}</textarea>
                            @error('small_desc')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            Favicon:
                            <input class="dropify" type="file" name="favicon" class="form-control">
                            <br>
                            <img width="150" height="150" class="img-thumbnail"
                                src="{{ $getSettings->favicon_path }}">

                            @error('favicon')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            Logo:<input class="dropify" type="file" name="logo" class="form-control">
                            <br>
                            <img width="150" height="150" class="img-thumbnail"
                                src="{{ $getSettings->logo_path }}">
                            @error('logo')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </center>
@endsection
@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script>
        $('.dropify').dropify({
            messages: {
                'default': 'Drop a file here',
                'replace': 'Drop or click to replace',
                'remove': 'Remove',
                'error': 'Ooops, something wrong happended.'
            }
        });
    </script>
@endpush
