@extends('layouts.dashboard.app')
@section('title', 'Add New Role')
@section('body')
    <center>
        <form action="{{ route('admin.autherizations.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body shadow mb-4 col-10">
                <h2>Add New Role</h2>
                <a href="{{ route('admin.autherizations.index', ['page' => request()->page]) }}">Roles/</a>
                <span>Add</span>
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" name="role" placeholder="Enter role name" class="form-control">
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
                                {{ $value }} : <input value="{{ $key }}" type="checkbox"
                                    name="permessions[]">

                                @error('permessions')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endforeach

                </div>



                <br>
                <button type="submit" class="btn btn-primary">Create Role</button>
            </div>
        </form>
    </center>
@endsection
