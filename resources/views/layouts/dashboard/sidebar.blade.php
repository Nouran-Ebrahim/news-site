        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.home') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            @can('home')
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('admin.home') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>
            @endcan

            <!-- Divider -->
            <hr class="sidebar-divider">



            <!-- Nav Item - Pages Collapse Menu -->
            @can('posts')
                <li class="nav-item {{ Request::is('*/posts*') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages3"
                        aria-expanded="true" aria-controls="collapsePages3">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Posts Management</span>
                    </a>
                    <div id="collapsePages3" class="collapse {{ Request::is('*/posts*') ? 'show' : '' }}"
                        aria-labelledby="headingPages" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item {{ Request::is('*/posts') ? 'active' : '' }}"
                                href="{{ route('admin.posts.index') }}">Posts</a>
                            <a class="collapse-item {{ Request::is('*/posts/create') ? 'active' : '' }}"
                                href="{{ route('admin.posts.create') }}">Add</a>
                        </div>
                    </div>
                </li>
            @endcan

            @can('settings')
                <li class="nav-item {{ Request::is('*/settings') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.settings.index') }}">
                        <i class="fas fa-fw fa-wrench"></i>
                        <span>Settings</span>
                </li>
            @endcan
            @can('contacts')
                <li class="nav-item {{ Request::is('*/contacts') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.contacts.index') }}">
                        <i class="fas fa-fw fa-wrench"></i>
                        <span>Contacts</span>
                </li>
            @endcan
            @can('users')
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item {{ Request::is('*/users*') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                        aria-expanded="true" aria-controls="collapsePages">
                        <i class="fas fa-fw fa-users"></i>
                        <span>User Management</span>
                    </a>
                    <div id="collapsePages" class="collapse {{ Request::is('*/users*') ? 'show' : '' }}"
                        aria-labelledby="headingPages" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item {{ Request::is('*/users') ? 'active' : '' }}"
                                href="{{ route('admin.users.index') }}">Users</a>
                            <a class="collapse-item {{ Request::is('*/users/create') ? 'active' : '' }}"
                                href="{{ route('admin.users.create') }}">Add</a>
                        </div>
                    </div>
                </li>
            @endcan

            @can('admins')
                <li class="nav-item {{ Request::is('*/admins*') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages2"
                        aria-expanded="true" aria-controls="collapsePages2">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Admin Management</span>
                    </a>
                    <div id="collapsePages2" class="collapse {{ Request::is('*/admins*') ? 'show' : '' }}"
                        aria-labelledby="headingPages" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item {{ Request::is('*/admins') ? 'active' : '' }}"
                                href="{{ route('admin.admins.index') }}">Admins</a>
                            <a class="collapse-item {{ Request::is('*/admins/create') ? 'active' : '' }}"
                                href="{{ route('admin.admins.create') }}">Add</a>
                        </div>
                    </div>
                </li>
            @endcan

            @can('autherizations')
                <li class="nav-item {{ Request::is('*/autherizations*') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages33"
                        aria-expanded="true" aria-controls="collapsePages33">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Role Management</span>
                    </a>
                    <div id="collapsePages33" class="collapse {{ Request::is('*/autherizations*') ? 'show' : '' }}"
                        aria-labelledby="headingPages" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item {{ Request::is('*/autherizations') ? 'active' : '' }}"
                                href="{{ route('admin.autherizations.index') }}">Roles</a>
                            <a class="collapse-item {{ Request::is('*/autherizations/create') ? 'active' : '' }}"
                                href="{{ route('admin.autherizations.create') }}">Add</a>
                        </div>
                    </div>
                </li>
            @endcan



            <!-- Nav Item - Tables -->
            @can('categories')
                <li class="nav-item {{ Request::is('*/categories*') ? 'active' : '' }}">
                    <a class="nav-link " href="{{ route('admin.categories.index') }}">
                        <i class="fas fa-fw fa-table"></i>
                        <span>Categories</span></a>
                </li>
            @endcan

            @can('notifications')
                <li class="nav-item {{ Request::is('*/notifications*') ? 'active' : '' }}">
                    <a class="nav-link " href="{{ route('admin.notifications.index') }}">
                        <i class="fas fa-fw fa-table"></i>
                        <span>Notifications</span></a>
                </li>
            @endcan
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>



        </ul>
        <!-- End of Sidebar -->
