@extends('layouts.dashboard.app')
@section('title', 'Show Contact')
@section('body')
    <center>

        <div class="card-body shadow mb-4 col-10">

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input disabled type="text" name="name" value="{{ $contact->name }}" class="form-control">

                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Email</label>

                        <input disabled type="email" name="email" value="{{ $contact->email }}" class="form-control">

                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Phone</label>

                        <input disabled type="text" name="phone" value="{{ $contact->phone }}" class="form-control">

                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">title</label>

                        <input type="text" class="form-control" disabled value="{{ $contact->title }}">
                    </div>
                </div>
            </div>
         
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">body</label>

                        <textarea disabled type="text" name="body" class="form-control">{{ $contact->body }}</textarea>

                    </div>
                </div>

            </div>


            <br>
            <a href="mailto:{{ $contact->email }}?subject=Re{{urlencode($contact->title)}}" class="btn btn-info" role="button">
                Replay
            </a>
            <a href="javascript:;"
                onclick="if(confirm('do you want to delete the contact')){document.getElementById('deletecontact').submit()}return false"
                class="btn btn-danger" role="button">Delete</a>
            <form style="display: none" id="deletecontact" method="POST"
                action="{{ route('admin.contacts.destroy', $contact) }}">
                @csrf
                @method('delete')
            </form>
        </div>

    </center>
@endsection
