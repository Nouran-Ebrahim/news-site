@extends('layouts.dashboard.app')
@section('title', 'Edit Admin')
@section('body')
    <center>
        <form action="{{ route('admin.admins.update', $admin) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="card-body shadow mb-4 col-10">
                <h2>Edit Admin</h2>
                <a href="{{ route('admin.admins.index', ['page' => request()->page]) }}">Admins/</a>
                <span>Edit</span>
                <br>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input value="{{ $admin->name }}" type="text" name="name"
                                class="form-control">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" value="{{ $admin->username }}" name="username"
                                 class="form-control">
                            @error('username')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input value="{{ $admin->email }}" type="email" name="email"
                                class="form-control">
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <select name="status" class="form-control">
                                <option selected disabled>Select status</option>
                                <option @selected($admin->status == 1) value="1">Active</option>
                                <option @selected($admin->status == 0) value="0">Inactive</option>
                            </select>
                            @error('status')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-12">
                        <div class="form-group">
                            <select name="autherization_id" class="form-control">
                                <option selected disabled>Select Role</option>
                                @forelse ($roles as $role)
                                    <option @selected($admin->autherization_id == $role->id) value="{{ $role->id }}">{{ $role->role }}
                                    </option>

                                @empty
                                    <option selected disabled>No Roles</option>
                                @endforelse
                            </select>
                            @error('autherization_id')
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
                <button type="submit" class="btn btn-primary">Update admin</button>
            </div>
        </form>
    </center>
@endsection
