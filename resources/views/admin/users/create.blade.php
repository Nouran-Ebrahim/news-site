@extends('layouts.dashboard.app')
@section('title', 'Create User')
@section('body')
    <center>
        <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body shadow mb-4 col-10">
                <h2>Create New User</h2>
                <br>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Enter user name" class="form-control">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="username" placeholder="Enter username" class="form-control">
                            @error('username')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Enter Email" class="form-control">
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="phone" placeholder="Enter phone" class="form-control">
                            @error('phone')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
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
                    <div class="col-6">
                        <div class="form-group">
                            <select name="email_verified_at" class="form-control">
                                <option selected disabled>Select Email status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            @error('email_verified_at')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="country" placeholder="Enter country name" class="form-control">
                            @error('country')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="city" placeholder="Enter city name" class="form-control">
                            @error('city')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="street" placeholder="Enter street name" class="form-control">
                            @error('street')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="file" name="image" class="form-control">
                            @error('image')
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
                <button type="submit" class="btn btn-primary">Create User</button>
            </div>
        </form>
    </center>
@endsection
