@extends('layouts.dashboard.app')
@section('title', 'Admins')
@section('body')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Admins</h1>

<a href="{{route('admin.admins.create')}}" role="button" class="btn btn-primary mb-4">Create</a>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">admins Mangment</h6>
            </div>
            @include('admin.admins.filters.filter')
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Role</th>
                                <th>username</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Role</th>
                                <th>username</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($admins as $admin)
                                <tr>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->status_name }}</td>
                                    <td>{{ $admin->role?$admin->role->role:'no role' }}</td>
                                    <td>{{ $admin->username }}</td>
                                    <td>{{ $admin->created_at }}</td>
                                    <td>
                                        @if ($admin->id != auth('admin')->user()->id)
                                        <a href="javascript:;"
                                        onclick="if(confirm('do you want to delete the admin')){document.getElementById('deleteadmin_{{ $admin->id }}').submit()}return false"
                                        title="delete"><i class="fa fa-trash"></i></a>
                                        @endif

                                        <a href="{{ route('admin.admins.toggleStatus', $admin) }}" title="block"><i
                                                class="fa {{ $admin->status == 1 ? 'fa-stop' : 'fa-play' }}"></i></a>
                                        <a href="{{ route('admin.admins.edit', $admin) }}" title="show"><i
                                                class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                                <form style="display: none" id="deleteadmin_{{ $admin->id }}" method="POST"
                                    action="{{ route('admin.admins.destroy', $admin) }}">
                                    @csrf
                                    @method('delete')
                                </form>
                            @empty
                                <tr>
                                    <td class="alert alert-info" colspan="5">No admins found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                    {{-- {{ $admins->withQueryString()->links()  }} --}}
                    {{ $admins->appends(request()->input())->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection
