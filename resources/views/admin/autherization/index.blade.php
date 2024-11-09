@extends('layouts.dashboard.app')
@section('title', 'Roles')
@section('body')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Roles Mangment</h1>

        <a href="{{ route('admin.autherizations.create') }}" role="button" class="btn btn-primary mb-4">Create</a>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Roles Mangment</h6>
            </div>
            @include('admin.autherization.filters.filter')
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th> Role Name</th>
                                <th>Permessions</th>
                                <th>Count of users</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th> Role Name</th>
                                <th>Permessions</th>
                                <th>Count of users</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($autherizations as $autherization)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $autherization->role }}</td>
                                    <td>
                                        @foreach ($autherization->permessions as $permession)
                                            {{ config('authrizationPermessions.permessions')[$permession] ?? 'Unknown Permission' }},
                                        @endforeach
                                    </td>
                                    <td>{{$autherization->admins->count()}}</td>

                                    <td>{{ $autherization->created_at }}</td>
                                    <td>
                                        <a href="javascript:;"
                                            onclick="if(confirm('do you want to delete the role')){document.getElementById('deleteautherization_{{ $autherization->id }}').submit()}return false"
                                            title="delete"><i class="fa fa-trash"></i></a>

                                        <a href="{{ route('admin.autherizations.edit', $autherization) }}" title="edit"><i
                                                class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                                <form style="display: none" id="deleteautherization_{{ $autherization->id }}" method="POST"
                                    action="{{ route('admin.autherizations.destroy', $autherization) }}">
                                    @csrf
                                    @method('delete')
                                </form>
                            @empty
                                <tr>
                                    <td class="alert alert-info" colspan="5">No Roles found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                    {{ $autherizations->appends(request()->input())->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection
