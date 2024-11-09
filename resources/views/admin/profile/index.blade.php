@extends('layouts.dashboard.app')
@section('title', 'Profile')

@section('body')
    <!-- Begin Page Content -->
    <center>
        <form action="{{ route('admin.profile.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body shadow mb-4 col-10">
                <h2>Update Profile</h2>
                <br>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" value="{{ auth('admin')->user()->name }}" name="name"
                                placeholder="Enter Name" class="form-control">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="email" value="{{ auth('admin')->user()->email }}" name="email"
                                placeholder="Enter email" class="form-control">
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="username" value="{{ auth('admin')->user()->username }}"
                                placeholder="Enter username" class="form-control">
                            @error('username')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <select name="status" class="form-control">
                                <option selected disabled>Select status</option>
                                <option @selected(auth()->user()->status == 1) value="1">Active</option>
                                <option @selected(auth()->user()->status == 0) value="0">Inactive</option>
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
                            <input type="password" name="password" placeholder="Enter password" class="form-control">
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="password" name="password_confirmation" placeholder="Enter password again"
                                class="form-control">
                            @error('password_confirmation')
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
@endpush
