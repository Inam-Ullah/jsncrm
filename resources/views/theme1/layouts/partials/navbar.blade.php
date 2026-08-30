<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fas fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="{{ $author->photo ? asset('theme1/assets/images/final/'.basename($author->photo)) : asset('theme1/assets/system/images/user.png') }}" alt="Profile photo">
                        {{ $author->name }}
                        <span class="fas fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="{{ route('profile.index') }}"><i class="fas fa-user fa-fw"></i> Profile</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link"><i class="fas fa-sign-out-alt fa-fw"></i> Log Out</button>
                            </form>
                        </li>
                    </ul>
                </li>

                <li role="presentation" class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-red">0</span>
                    </a>
                    <ul class="dropdown-menu list-unstyled msg_list" role="menu">
                        <li><a><span class="message">No new notifications.</span></a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
