@extends('layouts.dashboard.app')
@section('title', 'Posts')
@section('body')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Posts</h1>

        <a href="{{ route('admin.posts.create') }}" role="button" class="btn btn-primary mb-4">Create</a>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Posts Mangment</h6>
            </div>
            @include('admin.posts.filters.filter')
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>title</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>User</th>
                                <th>Category</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>title</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>User</th>
                                <th>Category</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($posts as $post)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->status_name }}</td>
                                    <td>{{ $post->num_of_views }}</td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>{{ $post->category->name }}</td>
                                    <td>{{ $post->created_at->format('Y-m-d H:i A') }}</td>

                                    <td>
                                        <a href="javascript:;"
                                            onclick="if(confirm('do you want to delete the post')){document.getElementById('deletepost_{{ $post->id }}').submit()}return false"
                                            title="delete"><i class="fa fa-trash"></i></a>
                                        <a href="{{ route('admin.posts.toggleStatus', $post) }}" title="block"><i
                                                class="fa {{ $post->status == 1 ? 'fa-stop' : 'fa-play' }}"></i></a>
                                        <a href="{{ route('admin.posts.show', ['post'=>$post,'page'=>request()->page]) }}" title="show"><i
                                                class="fa fa-eye"></i></a>

                                        {{-- @if ($post->user_id == null)
                                        so it post from admin so show edit icon --}}
                                        <a href="{{ route('admin.posts.edit', $post) }}" title="show"><i
                                                class="fa fa-edit"></i></a>
                                        {{-- @endif --}}

                                    </td>
                                </tr>
                                <form style="display: none" id="deletepost_{{ $post->id }}" method="POST"
                                    action="{{ route('admin.posts.destroy', $post) }}">
                                    @csrf
                                    @method('delete')
                                </form>
                            @empty
                                <tr>
                                    <td class="alert alert-info" colspan="5">No posts found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                    {{-- {{ $posts->withQueryString()->links()  }} --}}
                    {{ $posts->appends(request()->input())->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection
