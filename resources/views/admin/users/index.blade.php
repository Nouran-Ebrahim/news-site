@extends('layouts.dashboard.app')
@section('title', 'Users')
@section('body')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Users</h1>

<a href="{{route('admin.users.create')}}" role="button" class="btn btn-primary mb-4">Create</a>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Users Mangment</h6>
            </div>
            @include('admin.users.filters.filter')
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->status_name }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        <a href="javascript:;"
                                            onclick="if(confirm('do you want to delete the user')){document.getElementById('deleteUser_{{ $user->id }}').submit()}return false"
                                            title="delete"><i class="fa fa-trash"></i></a>
                                        <a href="{{ route('admin.users.toggleStatus', $user) }}" title="block"><i
                                                class="fa {{ $user->status == 1 ? 'fa-stop' : 'fa-play' }}"></i></a>
                                        <a href="{{ route('admin.users.show', $user->id) }}" title="show"><i
                                                class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                <form style="display: none" id="deleteUser_{{ $user->id }}" method="POST"
                                    action="{{ route('admin.users.destroy', $user) }}">
                                    @csrf
                                    @method('delete')
                                </form>
                            @empty
                                <tr>
                                    <td class="alert alert-info" colspan="5">No users found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                    {{-- {{ $users->withQueryString()->links()  }} --}}
                    {{ $users->appends(request()->input())->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection
