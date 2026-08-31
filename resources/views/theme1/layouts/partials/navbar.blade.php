<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fas fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-left">
                <li class="current-admin-info">
                    <a href="{{ route('home') }}">{{ setting()->name ?? config('app.name') }} | {{ setting()->slogan ?? 'ISP Management' }}</a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="quick_access">
                    @if($author->role_id == 7)
                        <a href="#" onclick="event.preventDefault(); document.getElementById('navbar-logout-form').submit();">
                            <i class="fas fa-times-circle fa-fw"></i> Logout
                        </a>
                    @else
                        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <img src="{{ $author->photo ? asset('theme1/assets/images/final/'.basename($author->photo)) : asset('theme1/assets/system/images/user.png') }}" alt="Profile photo">
                            {{ $author->name }}
                            <span class="fas fa-angle-down"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-usermenu pull-right">
                            <li><a href="{{ route('profile.index') }}"><i class="fas fa-user fa-fw"></i> My Profile</a></li>
                            @if($author->role_id == 1 || $author->role_id == 2)
                                <li><a href="#"><i class="fas fa-tools fa-fw"></i> Settings</a></li>
                                <li><a href="#"><i class="fas fa-server fa-fw"></i> Server Info</a></li>
                                <li><a href="#"><i class="fas fa-headset fa-fw"></i> Support</a></li>
                                <li><a href="#"><i class="fas fa-bell fa-fw"></i> Notices</a></li>
                            @endif
                            <li><a href="#" onclick="event.preventDefault(); document.getElementById('navbar-logout-form').submit();"><i class="fas fa-times-circle fa-fw"></i> Logout</a></li>
                        </ul>
                    @endif
                </li>

                <li role="presentation" class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-red">0</span>
                    </a>
                    <ul class="dropdown-menu list-unstyled msg_list alert-list" role="menu">
                        <li><a href="#"><span class="alert-title"><i class="fas fa-bell fa-fw"></i> No new alerts</span></a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>

    <form id="navbar-logout-form" method="POST" action="{{ route('logout') }}">@csrf</form>
</div>
