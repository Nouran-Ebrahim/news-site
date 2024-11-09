@extends('layouts.frontend.app')
@section('title', 'Settings')

@section('breadcrumb')
    @parent <!-- to get static li in the app-->
    <li class="breadcrumb-item"><a href="{{ route('frontend.dashboard.profile') }}">Dashboard</a></li>

    <li class="breadcrumb-item active">Settings</li>
@endsection
@section('body')
    <!-- Dashboard Start-->

    <div class="dashboard container">
        <!-- Sidebar -->
        @include('layouts.frontend._sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <!-- Settings Section -->
            <section id="settings" class="content-section">
                <h2>Settings</h2>
                <form action="{{ route('frontend.dashboard.settings.update') }}" class="settings-form" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    {{-- <input type="hidden" name="id" value="{{$user->id}}"> --}}
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" name="username" id="username" value="{{ $user->username }}" />
                        @error('username')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">name:</label>
                        <input type="text" name="name" id="name" value="{{ $user->name }}" />
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" />
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">phone:</label>
                        <input type="text" name="phone" id="phone" value="{{ $user->phone }}" />
                        @error('phone')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="profile-image">Profile Image:</label>
                        <input type="file" name="image" id="profile-image" accept="image/*" />
                        @error('image')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <img width="180px" src="{{ $user->image_path }}" id="profile-image-preview" class="img-thumbnail">
                    </div>
                    <div class="form-group">
                        <label for="country">Country:</label>
                        <input type="text" name="country" value="{{ @$user->country }}" id="country"
                            placeholder="Enter your country" />
                        @error('country')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="city">City:</label>
                        <input type="text" id="city" name="city" value="{{ @$user->city }}"
                            placeholder="Enter your city" />
                        @error('city')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="street">Street:</label>
                        <input type="text" name="street" value="{{ @$user->street }}" id="street"
                            placeholder="Enter your street" />
                        @error('street')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="save-settings-btn">
                        Save Changes
                    </button>
                </form>

                <!-- Form to change the password -->
                <form method="POST" action="{{ route('frontend.dashboard.settings.updatePassword') }}"
                    class="change-password-form">
                    @csrf
                    <h2>Change Password</h2>
                    <div class="form-group">
                        <label for="current-password">Current Password:</label>
                        <input name="current_password" type="password" id="current-password"
                            placeholder="Enter Current Password" />
                        @error('current_password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="new-password">New Password:</label>
                        <input name="password" type="password" id="new-password" placeholder="Enter New Password" />
                        @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm New Password:</label>
                        <input name="password_confirmation" type="password" id="confirm-password"
                            placeholder="Enter Confirm New " />
                        @error('password_confirmation')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="change-password-btn">
                        Change Password
                    </button>
                </form>
            </section>
        </div>
    </div>

    <!-- Dashboard End-->
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#profile-image').on('change', function(e) { // Add e here
                e.preventDefault(); // Prevent default form behavior
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#profile-image-preview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush
