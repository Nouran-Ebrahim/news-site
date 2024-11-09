@extends('layouts.dashboard.auth.app')
@section('title', 'Rest')
@section('body')


    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Enter New Password</h1>
                                </div>
                                <form method="POST" action="{{ route('admin.password.rest') }}" class="user">
                                    @csrf
                                    @method('post')
                                    <div class="form-group">
                                        <input type="hidden" value="{{ $email }}" name="email"
                                            class="form-control form-control-user" id="exampleInputEmail"
                                            aria-describedby="emailHelp">

                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password">
                                        @error('password')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password_confirmation"
                                            class="form-control form-control-user" id="exampleInputPassword"
                                            placeholder="password confirmation">
                                        @error('password_confirmation')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Rest
                                    </button>
                                    <hr>
                                    {{-- <a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a> --}}
                                </form>
                                <hr>

                                {{-- <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>


@endsection
