@extends('layouts.dashboard.app')
@section('title', 'Admins')
@section('body')
    <div class="d-flex justify-content-center">
        <!-- Sidebar -->


        <!-- Main Content -->
        <div class="card-body shadow mb-4" style="max-width: 100ch">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <h2 class="mb-4">Notifications</h2>

                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.notifications.deleteAll') }}" style="float: right;"
                            class="btn btn-sm btn-danger">Delete All</a>
                    </div>

                </div>
                @forelse (auth('admin')->user()->notifications as $notify)
                    <a style="text-decoration: none" href="{{ $notify->data['link'] }}?notify_admin={{ $notify->id }}">
                        <div class="notification alert {{ $notify->read_at == null ? 'alert-info' : 'alert-success' }}">
                            <strong>You have Contact from: {{ $notify->data['user_name'] }}</strong>
                            <br>
                            with title
                            {{ $notify->data['contact_title'] }}
                            <br>
                           <strong style="color: red">{{ $notify->data['date'] }}</strong>
                            <div class="float-right">
                                <button
                                    onclick="if(confirm('are you sure to delete')){document.getElementById('myForm').submit()}return false"
                                    class="btn btn-danger btn-sm">Delete</button>
                            </div>
                        </div>
                    </a>
                    <form id="myForm" style="display: none" method="post"
                        action="{{ route('admin.notifications.delete') }}">
                        @csrf
                        <input type="hidden" name="notify_id" value="{{ $notify->id }}">
                    </form>
                @empty
                    <div class="alert alert-info">No Notifications yet</div>
                @endforelse





            </div>
        </div>
    </div>
@endsection
