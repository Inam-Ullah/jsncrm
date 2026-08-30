<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title">
            <a href="{{ route('home') }}" class="site_title">
                <img class="logo" src="{{ logo() }}" alt="{{ $setting->name ?? 'JSN ISP CRM' }}">
            </a>
        </div>

        <div class="clearfix"></div>

        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="{{ $author->photo ? asset('theme1/assets/images/final/'.basename($author->photo)) : asset('theme1/assets/system/images/user.png') }}" class="img-circle profile_img" alt="Profile photo">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ $author->name }}</h2>
            </div>
        </div>

        <br>

        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li>
                        <a href="{{ route('home') }}"><i class="fas fa-home"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('profile.index') }}"><i class="fas fa-user"></i> My Profile</a>
                    </li>

                    @if($author->role_id == 1)
                        <li>
                            <a><i class="fas fa-server"></i> ISP <span class="fas fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="#">All ISPs</a></li>
                            </ul>
                        </li>
                        <li>
                            <a><i class="fas fa-user-tie"></i> Admin <span class="fas fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="#">All Admins</a></li>
                            </ul>
                        </li>
                    @endif

                    @if($author->role_id != 1)
                        <li>
                            <a><i class="fas fa-users"></i> Users <span class="fas fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="#">All Users</a></li>
                                <li><a href="#">Add User</a></li>
                            </ul>
                        </li>
                        <li>
                            <a><i class="fas fa-box"></i> Packages <span class="fas fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="#">All Packages</a></li>
                                <li><a href="#">Policies</a></li>
                            </ul>
                        </li>
                    @endif

                    @if($author->role_id == 1 || $author->role_id == 2 || $author->role_id == 10)
                        <li>
                            <a><i class="fas fa-file-invoice-dollar"></i> Accounting <span class="fas fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="#">Invoices</a></li>
                                <li><a href="#">Payments</a></li>
                                <li><a href="#">Ledger</a></li>
                            </ul>
                        </li>
                    @endif

                    <li>
                        <a><i class="fas fa-headset"></i> Support <span class="fas fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="#">Tickets</a></li>
                            <li><a href="#">Notices</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
