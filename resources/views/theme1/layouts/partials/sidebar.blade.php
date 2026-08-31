<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title">
            <a href="{{ route('home') }}" class="site_title">
                <img class="logo" src="{{ logo() }}" alt="{{ $setting->name ?? 'JSN ISP CRM' }}">
            </a>
        </div>

        <div class="clearfix"></div>

        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <ul class="nav side-menu">
                    <li><a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a></li>

                    @if($author->role_id != 7)
                        <li><a href="{{ route('profile.index') }}"><i class="fas fa-user"></i> My Profile</a></li>
                    @endif

                    @if($author->role_id == 1)
                        <li><a><i class="fas fa-server"></i> ISP <span class="fas fa-chevron-down right"></span></a><ul class="nav child_menu"><li><a href="#">All ISPs</a></li></ul></li>
                        <li><a><i class="fas fa-user"></i> Admin <span class="fas fa-chevron-down right"></span></a><ul class="nav child_menu"><li><a href="#">All Admins</a></li></ul></li>
                        <li><a><i class="fas fa-map-marker-alt"></i> Area <span class="fas fa-chevron-down right"></span></a><ul class="nav child_menu"><li><a href="#">Manage Area</a></li></ul></li>
                        <li>
                            <a><i class="fas fa-cogs"></i> Settings <span class="fas fa-chevron-down right"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="#">Manage Software</a></li><li><a href="#">Clean Tables</a></li>
                                <li><a href="#">Settings</a></li><li><a href="#">Server Info</a></li>
                                <li><a href="#">Support</a></li><li><a href="#">Notices</a></li>
                            </ul>
                        </li>
                    @elseif($author->role_id == 7)
                        <li><a href="#"><i class="fas fa-receipt"></i> Activity Logs</a></li>
                        <li><a href="#"><i class="fas fa-receipt"></i> Login Log</a></li>
                        <li><a href="#"><i class="fas fa-receipt"></i> Connection Log</a></li>
                        <li><a href="#"><i class="fas fa-book"></i> Ledger</a></li>
                        <li><a href="#"><i class="fas fa-file-invoice"></i> Invoices</a></li>
                        <li><a href="#"><i class="fab fa-telegram-plane"></i> Tickets</a></li>
                        <li><a href="#"><i class="fas fa-bell"></i> Notices</a></li>
                    @else
                        @if($author->role_id == 2 || $author->role_id >= 8)
                            <li><a><i class="fas fa-user-friends"></i> HRM <span class="fas fa-chevron-down right"></span></a><ul class="nav child_menu"><li><a href="#">All Roles</a></li><li><a href="#">All Staff</a></li></ul></li>
                            <li><a><i class="fas fa-broadcast-tower"></i> Network <span class="fas fa-chevron-down right"></span></a><ul class="nav child_menu"><li><a href="#">NAS</a></li></ul></li>
                        @endif
                        @if($author->role_id == 2)
                            <li><a><i class="fas fa-user-friends"></i> Franchise <span class="fas fa-chevron-down right"></span></a><ul class="nav child_menu"><li><a href="#">All Franchises</a></li></ul></li>
                        @endif
                        @if($author->role_id == 2 || $author->role_id == 3)
                            <li><a><i class="fas fa-user-friends"></i> Dealer <span class="fas fa-chevron-down right"></span></a><ul class="nav child_menu"><li><a href="#">All Dealers</a></li></ul></li>
                        @endif
                        @if($author->role_id == 2 || $author->role_id == 3 || $author->role_id == 4)
                            <li><a><i class="fas fa-user-friends"></i> Subdealer <span class="fas fa-chevron-down right"></span></a><ul class="nav child_menu"><li><a href="#">All Subdealers</a></li></ul></li>
                        @endif
                        <li>
                            <a><i class="fas fa-user-friends"></i> User <span class="fas fa-chevron-down right"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="#">All Users</a></li><li><a href="#">Online Users</a></li>
                                <li><a href="#">Offline Users</a></li><li><a href="#">Expired Users</a></li>
                                <li><a href="#">Expiring in a Week</a></li><li><a href="#">Expiring in Two Weeks</a></li>
                            </ul>
                        </li>
                        <li><a><i class="fas fa-ticket-alt"></i> Token <span class="fas fa-chevron-down right"></span></a><ul class="nav child_menu"><li><a href="#">Cards</a></li><li><a href="#">Tokens</a></li></ul></li>
                        <li><a><i class="fas fa-credit-card"></i> Prepaid Card <span class="fas fa-chevron-down right"></span></a><ul class="nav child_menu"><li><a href="#">Cards</a></li><li><a href="#">Tokens</a></li></ul></li>
                        <li><a><i class="fas fa-box-open"></i> Packages <span class="fas fa-chevron-down right"></span></a><ul class="nav child_menu"><li><a href="#">All Packages</a></li></ul></li>
                        <li><a><i class="fas fa-sliders-h"></i> Policy <span class="fas fa-chevron-down right"></span></a><ul class="nav child_menu"><li><a href="#">Policy</a></li></ul></li>
                        <li>
                            <a><i class="fas fa-dollar-sign"></i> Accounting <span class="fas fa-chevron-down right"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="#">Payment Reports</a></li><li><a href="#">PGW Reports</a></li>
                                <li><a href="#">Ledger Reports</a></li><li><a href="#">Balance Due Reports</a></li>
                                <li><a href="#">Sales Reports</a></li><li><a href="#">Manage Cashflow</a></li>
                                <li><a href="#">Manage Invoices</a></li>
                            </ul>
                        </li>
                        <li><a><i class="fas fa-map-marker-alt"></i> Area <span class="fas fa-chevron-down right"></span></a><ul class="nav child_menu"><li><a href="#">Manage Area</a></li></ul></li>
                        <li><a><i class="fas fa-receipt"></i> Tickets <span class="fas fa-chevron-down right"></span></a><ul class="nav child_menu"><li><a href="#">All Tickets</a></li></ul></li>
                        <li><a><i class="fas fa-bell"></i> Notices <span class="fas fa-chevron-down right"></span></a><ul class="nav child_menu"><li><a href="#">Notices</a></li></ul></li>
                        <li>
                            <a><i class="fas fa-book"></i> Logs & Reports <span class="fas fa-chevron-down right"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="#">Activity Logs</a></li><li><a href="#">Connection Usage Logs</a></li>
                                <li><a href="#">User Login Logs</a></li><li><a href="#">User Tracking Logs</a></li>
                                <li><a href="#">Export Reports</a></li><li><a href="#">System Log</a></li>
                            </ul>
                        </li>
                        @if($author->role_id == 2 || $author->role_id >= 8)
                            <li>
                                <a><i class="fas fa-cogs"></i> Settings <span class="fas fa-chevron-down right"></span></a>
                                <ul class="nav child_menu"><li><a href="#">Settings</a></li><li><a href="#">Server Info</a></li><li><a href="#">Support</a></li><li><a href="#">Notices</a></li></ul>
                            </li>
                        @endif
                    @endif

                    <li><a href="#" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();"><i class="fas fa-times-circle"></i> Logout</a></li>
                </ul>
            </div>
        </div>

        <form id="sidebar-logout-form" method="POST" action="{{ route('logout') }}">@csrf</form>
    </div>
</div>
