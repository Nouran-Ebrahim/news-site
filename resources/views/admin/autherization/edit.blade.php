@extends('layouts.dashboard.app')
@section('title', 'Edit Role')
@section('body')
    <center>
        <form action="{{ route('admin.autherizations.update', $autherization) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="card-body shadow mb-4 col-10">
                <h2>Edit Role</h2>
                <a href="{{ route('admin.autherizations.index', ['page' => request()->page]) }}">Roles/</a>
                <span>Edit</span>
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" name="role" value="{{ $autherization->role }}"
                                placeholder="Enter role name" class="form-control">
                            @error('role')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="row">
                    @foreach (config('authrizationPermessions.permessions') as $key => $value)
                        <div class="col-4">
                            <div class="form-group">
                                {{ $value }} : <input @checked(in_array($key, $autherization->permessions)) value="{{ $key }}"
                                    type="checkbox" name="permessions[]">

                                @error('permessions')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endforeach

                </div>



                <br>
                <button type="submit" class="btn btn-primary">Update Role</button>
            </div>
        </form>
    </center>
@endsection
