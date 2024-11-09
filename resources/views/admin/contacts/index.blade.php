@extends('layouts.dashboard.app')
@section('title', 'Contacts')
@section('body')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Contacts</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Contacts Mangment</h6>
            </div>
            @include('admin.contacts.filters.filter')
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>phone</th>
                                <th>title</th>
                                <th>status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>phone</th>
                                <th>title</th>
                                <th>status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->phone }}</td>
                                    <td>{{ $contact->title }}</td>
                                    <td>{{ $contact->status_name }}</td>
                                    <td>{{ $contact->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="javascript:;"
                                            onclick="if(confirm('do you want to delete the contact')){document.getElementById('deletecontact_{{ $contact->id }}').submit()}return false"
                                            title="delete"><i class="fa fa-trash"></i></a>

                                        <a href="{{ route('admin.contacts.show', $contact->id) }}" title="show"><i
                                                class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                <form style="display: none" id="deletecontact_{{ $contact->id }}" method="POST"
                                    action="{{ route('admin.contacts.destroy', $contact) }}">
                                    @csrf
                                </form>
                            @empty
                                <tr>
                                    <td class="alert alert-info" colspan="5">No contacts found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                    {{-- {{ $contacts->withQueryString()->links()  }} --}}
                    {{ $contacts->appends(request()->input())->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection
