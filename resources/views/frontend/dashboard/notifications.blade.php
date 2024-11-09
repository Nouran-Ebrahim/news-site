@extends('layouts.frontend.app')
@section('title', 'Notifications')

@section('breadcrumb')
    @parent <!-- to get static li in the app-->
    <li class="breadcrumb-item"><a href="{{ route('frontend.dashboard.profile') }}">Dashboard</a></li>

    <li class="breadcrumb-item active">Notifications</li>
@endsection
@section('body')
    <!-- Dashboard Start-->
    <div class="dashboard container">
        <!-- Sidebar -->
        @include('layouts.frontend._sidebar')


        <!-- Main Content -->
        <div class="main-content">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <h2 class="mb-4">Notifications</h2>

                    </div>
                    <div class="col-6">
                        <a href="{{ route('frontend.dashboard.notifications.deleteAll') }}" style="float: right;"
                            class="btn btn-sm btn-danger">Delete All</a>
                    </div>
                </div>
                @forelse (auth()->user()->notifications as $notify)
                    <a href="{{ route('frontend.post.show', $notify->data['post_slug']) }}?notify={{ $notify->id }}">
                        <div class="notification alert {{ $notify->read_at == null ? 'alert-info' : 'alert-success' }}">
                            <strong>You have notification from: {{ $notify->data['user_name'] }}</strong> on Post
                            {{ $notify->data['post_title'] }}
                            <br>
                            {{$notify->created_at->diffForHumans()}}
                            <div class="float-right">
                                <button onclick="if(confirm('are you sure to delete')){document.getElementById('myForm').submit()}return false" class="btn btn-danger btn-sm">Delete</button>
                            </div>
                        </div>
                    </a>
                    <form id="myForm" style="display: none" method="post" action="{{route('frontend.dashboard.notifications.delete')}}">
                        @csrf
                        <input type="hidden" name="notify_id" value="{{$notify->id}}">
                    </form>
                @empty
                    <div class="alert alert-info">No Notifications yet</div>
                @endforelse


            </div>
        </div>
    </div>
    <!-- Dashboard End-->
@endsection
