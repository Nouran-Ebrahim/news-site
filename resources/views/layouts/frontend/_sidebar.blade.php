<aside class="col-md-3 nav-sticky dashboard-sidebar">
    <!-- User Info Section -->
    <div class="user-info text-center p-3">
        <img src="{{ auth()->user()->image_path }}" alt="User Image" class="rounded-circle mb-2"
            style="width: 80px; height: 80px; object-fit: cover" />
        <h5 class="mb-0" style="color: #ff6f61">{{auth()->user()->name }}</h5>
    </div>

    <!-- Sidebar Menu -->
    <div class="list-group profile-sidebar-menu">
        <a href="{{ route('frontend.dashboard.profile') }}" class="list-group-item list-group-item-action {{Request::is('account/profile')||Request::is('account/post/*')?'active':''}} menu-item"
            data-section="profile">
            <i class="fas fa-user"></i> Profile
        </a>
        <a href="{{ route('frontend.dashboard.notifications.index') }}" class="list-group-item list-group-item-action {{Request::is('account/notifications')?'active':''}} menu-item"
            data-section="notifications">
            <i class="fas fa-bell"></i> Notifications
        </a>
        <a href="{{ route('frontend.dashboard.settings') }}"
            class="list-group-item list-group-item-action {{Request::is('account/settings')?'active':''}} menu-item" data-section="settings">
            <i class="fas fa-cog"></i> Settings
        </a>
        <a href="https://wa.me/{{$getSettings->phone}}"
            class="list-group-item list-group-item-action  menu-item" data-section="support">
            <i class="fa fa-question" aria-hidden="true"></i> Support
        </a>
        <a href="javascript:void(0)"
                             onclick="if(confirm('Are you sure to log out?')){document.getElementById('formLogout').submit()}return false"
            class="list-group-item list-group-item-action  menu-item" data-section="settings">
            <i class="fa fa-power-off" aria-hidden="true"></i> Logout
        </a>
        <form id="formLogout" method="POST" action="{{ route('logout') }}">
            @csrf

        </form>
    </div>
</aside>
