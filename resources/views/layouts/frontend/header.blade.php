 <!-- Top Bar Start -->
 <div class="top-bar">
     <div class="container">
         <div class="row">
             <div class="col-md-6">
                 <div class="tb-contact">
                     <p><i class="fas fa-envelope"></i>{{ $getSettings->email }}</p>
                     <p><i class="fas fa-phone-alt"></i>{{ $getSettings->phone }}</p>
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="tb-menu">
                     {{-- <a href="">About</a>
                     <a href="">Privacy</a>
                     <a href="">Terms</a> --}}
                     <a href="{{ route('frontend.contact.index') }}">Contact</a>
                     @guest
                         <a href="{{ route('register') }}">Register</a>
                         <a href="{{ route('login') }}">Login</a>
                     @endguest
                     @auth
                         <a href="javascript:void(0)"
                             onclick="if(confirm('Are you sure to log out?')){document.getElementById('formLogout').submit()}return false">Log
                             out</a>

                     @endauth
                     <form id="formLogout" method="POST" action="{{ route('logout') }}">
                         @csrf

                     </form>
                     {{-- @if (auth()->check())
                         <a href="{{ route('logout') }}">Log out</a>
                     @else
                         <a href="{{ route('register') }}">Register</a>
                         <a href="{{ route('login') }}">Login</a>
                     @endif --}}


                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- Top Bar Start -->

 <!-- Brand Start -->
 <div class="brand">
     <div class="container">
         <div class="row align-items-center">
             <div class="col-lg-3 col-md-4">
                 <div class="b-logo">
                     <a href="{{ route('frontend.index') }}">
                         <img src="{{ $getSettings->logo_path }}" alt="Logo" />
                     </a>
                 </div>
             </div>
             <div class="col-lg-6 col-md-4">
                 <div class="b-ads">
                     {{-- <a href="https://htmlcodex.com">
                         <img src="{{ asset('assets/frontEnd') }}/img/ads-1.jpg" alt="Ads" />
                     </a> --}}
                 </div>
             </div>
             <div class="col-lg-3 col-md-4">
                 <form method="POST" action="{{ route('frontend.search') }}" class="b-search">
                     @csrf
                     <input name="search" type="text" placeholder="Search" />
                     <button type="submit"><i class="fa fa-search"></i></button>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <!-- Brand End -->

 <!-- Nav Bar Start -->
 <div class="nav-bar">
     <div class="container">
         <nav class="navbar navbar-expand-md bg-dark navbar-dark">
             <a href="#" class="navbar-brand">MENU</a>
             <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                 <span class="navbar-toggler-icon"></span>
             </button>

             <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                 <div class="navbar-nav mr-auto">
                     <a href="{{ route('frontend.index') }}" class="nav-item nav-link active">Home</a>
                     <div class="nav-item dropdown">
                         <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Categories</a>
                         <div class="dropdown-menu">
                             @foreach ($categories as $cat)
                                 <a href="{{ route('frontend.categoryPosts', $cat->slug) }}"
                                     title="{{ $cat->name }}" class="dropdown-item">{{ $cat->name }}</a>
                             @endforeach
                         </div>
                     </div>

                     <a href="{{ route('frontend.contact.index') }}" class="nav-item nav-link">Contact Us</a>
                     {{-- @auth --}}
                     <a href="{{ route('frontend.dashboard.profile') }}" class="nav-item nav-link">Account</a>

                     {{-- @endauth --}}
                 </div>
                 @auth('web')
                     <div class="social ml-auto">
                         {{-- for seo any anchor tag must has title --}}
                         <!-- Notification Dropdown -->
                         <a href="#" class="nav-link dropdown-toggle" id="notificationDropdown" role="button"
                             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <i class="fas fa-bell"></i>
                             <span id="countNotificatios"
                                 class="badge badge-danger">{{ auth()->user()->unreadNotifications()->count() }}</span>
                         </a>
                         <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown"
                             style="width: 300px;">
                             <h6 class="dropdown-header">Notifications</h6>



                             @forelse (auth()->user()->unreadNotifications()->take(5)->get() as $notify)
                                 <div id="push-notifiactions">
                                     <div class="dropdown-item d-flex justify-content-between align-items-center">
                                         <span>Post comment :
                                             {{ substr($notify->data['post_title'], 0, 4) }}...</span>
                                         <a
                                             href="{{ route('frontend.post.show', $notify->data['post_slug']) }}?notify={{ $notify->id }}">
                                             <li class="text-white   fa fa-eye"></li>
                                         </a>

                                     </div>
                                 </div>

                             @empty
                                 <div class="dropdown-item text-center">No notifications</div>
                             @endforelse







                         </div>
                         <a href="{{ $getSettings->twitter }}" title="twitter" rel="nofollow"><i
                                 class="fab fa-twitter"></i></a>
                         <a href="{{ $getSettings->facebook }}" title="facebook" rel="nofollow"><i
                                 class="fab fa-facebook-f"></i></a>
                         <a href="{{ $getSettings->instgram }}" title="instgram" rel="nofollow"><i
                                 class="fab fa-instagram"></i></a>
                         <a href="{{ $getSettings->youtube }}" title="youtube" rel="nofollow"><i
                                 class="fab fa-youtube"></i></a>
                     </div>
                 @endauth
             </div>
         </nav>
     </div>
 </div>
 <!-- Nav Bar End -->
