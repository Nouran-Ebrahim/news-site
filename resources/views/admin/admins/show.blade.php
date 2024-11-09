@extends('layouts.dashboard.app')
@section('title', 'Show User')
@section('body')
    <center>

        <div class="card-body shadow mb-4 col-10">
            <h2>User : {{ $user->name }}</h2>
            <br>
            <img width="150" height="150" class="img-thumbnail" src="{{ $user->image_path }}">
            <br>
            <br>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input disabled type="text" name="name" value="{{ $user->name }}" class="form-control">

                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">UserName</label>

                        <input disabled type="text" name="username" value="{{ $user->username }}" class="form-control">

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Email</label>

                        <input disabled type="email" name="email" value="{{ $user->email }}" class="form-control">

                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Phone</label>

                        <input disabled type="text" name="phone" value="{{ $user->phone }}" class="form-control">

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Status</label>

                        <input type="text" class="form-control" disabled value="{{ $user->status_name }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Email verified Status</label>

                        <input type="text" class="form-control" disabled
                            value="{{ $user->email_verified_at == null ? 'Inactive' : 'Active' }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Country</label>

                        <input disabled type="text" name="country" value="{{ @$user->country }}" class="form-control">

                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">City</label>

                        <input disabled type="text" name="city" value="{{ @$user->city }}" class="form-control">

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Street</label>

                        <input disabled type="text" name="street" value="{{ @$user->street }}" class="form-control">

                    </div>
                </div>

            </div>

            <br>
            <a href="{{ route('admin.users.toggleStatus', $user) }}" class="btn btn-warning" role="button">
                Toggle Status</a>
            <a href="javascript:;"
                onclick="if(confirm('do you want to delete the user')){document.getElementById('deleteUser').submit()}return false"
                class="btn btn-danger" role="button">Delete</a>
            <form style="display: none" id="deleteUser" method="POST" action="{{ route('admin.users.destroy', $user) }}">
                @csrf
                @method('delete')
            </form>
        </div>

    </center>
@endsection
