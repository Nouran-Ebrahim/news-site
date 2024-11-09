@extends('layouts.frontend.app')
@section('title', 'contact us')
@section('breadcrumb')
    @parent <!-- to get static li in the app-->
    <li class="breadcrumb-item"><a href="{{ route('frontend.index') }}">Home</a></li>

    <li class="breadcrumb-item active">Contact</li>
@endsection
@section('body')


    <!-- Contact Start -->
    <div class="contact">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="contact-form">
                        <form method="post" action="{{ route('frontend.contact.store') }}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <input name="name" type="text" class="form-control" placeholder="Your Name" />
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <input name="email" type="email" class="form-control" placeholder="Your Email" />
                                    @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <input name="phone" type="text" class="form-control" placeholder="Your Phone" />
                                    @error('phone')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <input name="title" type="text" class="form-control" placeholder="Subject" />
                                @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <textarea name="body" class="form-control" rows="5" placeholder="Message"></textarea>
                                @error('body')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <button class="btn" type="submit">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info">
                        <h3>Get in Touch</h3>
                        <p class="mb-4">
                            The contact form is currently inactive. Get a functional and
                            working contact form with Ajax & PHP in a few minutes. Just copy
                            and paste the files, add a little code and you're done.
                            <a href="https://htmlcodex.com/contact-form">Download Now</a>.
                        </p>
                        <h4><i class="fa fa-map-marker"></i>{{ $getSettings->street }} , {{ $getSettings->city }},
                            {{ $getSettings->country }}</h4>
                        <h4><i class="fa fa-envelope"></i>{{ $getSettings->email }}</h4>
                        <h4><i class="fa fa-phone"></i>{{ $getSettings->phone }}</h4>
                        <div class="social">
                            <a href="{{ $getSettings->twitter }}" title="twitter"><i class="fab fa-twitter"></i></a>
                            <a href="{{ $getSettings->facebook }}" title="facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{ $getSettings->instgram }}" title="instgram"><i class="fab fa-instagram"></i></a>
                            <a href="{{ $getSettings->youtube }}" title="youtube"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection