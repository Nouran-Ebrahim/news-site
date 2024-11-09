@extends('layouts.dashboard.app')
@section('title', 'Categories')
@section('body')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Categories</h1>
        <!-- Button trigger modal -->
        <button type="button" class=" mb-4 btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Create
        </button>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Categories Mangment</h6>
            </div>
            @include('admin.categories.filters.filter')

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Posts Count</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Posts Count</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->status_name }}</td>
                                    <td>{{ $category->posts_count }}</td>
                                    <td>{{ $category->created_at }}</td>
                                    <td>
                                        <a href="javascript:;"
                                            onclick="if(confirm('do you want to delete the category')){document.getElementById('deletecategory_{{ $category->id }}').submit()}return false"
                                            title="delete"><i class="fa fa-trash"></i></a>
                                        <a href="{{ route('admin.categories.toggleStatus', $category) }}" title="block"><i
                                                class="fa {{ $category->status == 1 ? 'fa-stop' : 'fa-play' }}"></i></a>
                                        <a data-toggle="modal" data-target="#updateCategory_{{ $category->id }}"
                                            href="javascript:;" title="edit"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                                <form style="display: none" id="deletecategory_{{ $category->id }}" method="POST"
                                    action="{{ route('admin.categories.destroy', $category) }}">
                                    @csrf
                                    @method('delete')
                                </form>
                                @include('admin.categories.edit')

                            @empty
                                <tr>
                                    <td class="alert alert-info" colspan="5">No categories found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                    {{-- {{ $categories->withQueryString()->links()  }} --}}
                    {{ $categories->appends(request()->input())->links() }}
                </div>
            </div>


        </div>


        @include('admin.categories.create')


    </div>
@endsection
