<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ route('home') }}" class="site_title">
                <img class="logo" src="{{ logo() }}" alt="{{ setting()->name ?? 'JSN ISP CRM' }}">
            </a>
        </div>

        <div class="clearfix"></div>

        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">

                <ul class="nav side-menu">

                    @if($author->role_id == 7)

                    <li>
                        <a href="#"><i class="fas fa-receipt"></i> {{ __('activity_logs') }}</a>
                    </li>

                    <li>
                        <a href="#"><i class="fas fa-receipt"></i> Login Log</a>
                    </li>

                    <li>
                        <a href="#"><i class="fas fa-receipt"></i> Connection Log</a>
                    </li>

                    <li>
                        <a href="#"><i class="fas fa-book"></i> Ledger</a>
                    </li>

                    <li>
                        <a href="#"><i class="fas fa-file-invoice"></i> Invoices</a>
                    </li>

                    <li>
                        <a href="#"><i class="fab fa-telegram-plane"></i> Tickets</a>
                    </li>

                    <li>
                        <a href="#"><i class="fas fa-bell"></i> Notices</a>
                    </li>

                    @else

                    {{-- Home --}}
                    <li>
                        <a href="{{ route('home') }}"><i class="fas fa-home"></i>
                            {{ __('home') }}
                        </a>
                    </li>

                    {{-- Role And Permission --}}
                    @if($author->role_id == 2 || permission('role_permission_module'))
                    <li>
                        <a href="{{ url('role') }}"><i class="fas fa-user-shield"></i>
                            {{ __('Roles &amp; Permission') }}
                        </a>
                    </li>
                    @endif

                    {{-- Area --}}
                    @if(in_array($author->role_id, [1, 2]) || permission('area_module'))
                    <li>
                        <a href="{{ route('area') }}">
                            <i class="fas fa-map-marker-alt"></i> {{ __('area') }}
                        </a>
                    </li>
                    @endif

                    {{-- ISP --}}
                    @if(in_array($author->role_id, [1, 2]))
                    <li>
                        <a href="{{ route('isp') }}">
                            <i class="fas fa-server"></i> {{ __('isp') }}
                        </a>
                    </li>
                    @endif

                    {{-- Network --}}
                    @if($author->role_id == 2 || permission('network_module'))
                    <li>
                        <a href="{{ route('network.nas') }}">
                            <i class="fas fa-broadcast-tower"></i> {{ __('network')}}
                        </a>
                    </li>
                    @endif

                    {{-- Policy --}}
                    @if($author->role_id == 2 || permission('policy_module'))
                    <li>
                        <a href="{{ url('policy') }}">
                            <i class="fas fa-sliders-h"></i> {{ __('policy') }}
                        </a>
                    </li>
                    @endif

                    {{-- Package --}}
                    @if($author->role_id == 2 || permission('package_module'))
                    <li>
                        <a href="package/all">
                            <i class="fas fa-box-open"></i> {{ __('packages') }}
                        </a>
                    </li>
                    @endif

                    {{-- Inventory --}}
                    {{-- <li>
                        <a><i class="fas fa-shopping-basket"></i> {{ __('inventory') }}
                            <span class="fas fa-chevron-down right"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li><a href="{{ url('inventory/item-type') }}">{{ __('category') }}</a></li>
                            <li><a href="{{ url('inventory/all') }}">{{ __('items') }}</a></li>
                        </ul>
                    </li> --}}

                    {{-- Admin --}}
                    @if ($author->role_id == 1)
                    <li>
                        <a href="{{ route('team', 'admin') }}">
                            <i class="fas fa-user"></i> {{ __('admin') }}
                        </a>
                    </li>
                    @endif

                    {{-- Reseller --}}
                    @if(in_array($author->role_id, [2, 3, 4, 5, 6]) || permission('team_module'))
                    <li>
                        <a><i class="fas fa-sitemap"></i> {{ __('team') }}
                            <span class="fas fa-chevron-down right"></span>
                        </a>
                        <ul class="nav child_menu">

                            @if ($author->role_id == 1 || permission('franchise_module'))
                            <li><a href="franchise/all">Franchise</a></li>
                            @endif

                            @if (in_array($author->role_id, [2, 3]) || permission('dealer_module'))
                            <li><a href="dealer/all">Dealer</a></li>
                            @endif

                            @if (in_array($author->role_id, [2, 3, 4]) || permission('subdealer_module'))
                            <li><a href="subdealer/all">Subdealer</a></li>
                            @endif

                            @if (in_array($author->role_id, [2, 3, 4, 5]) || permission('reseller_module'))
                            <li><a href="subdealer/all">Resseler</a></li>
                            @endif

                            @if (in_array($author->role_id, [2, 3, 4, 5, 6]) || permission('staff_module'))
                            <li><a href="staff">Staff</a></li>
                            @endif

                        </ul>
                    </li>
                    @endif

                    {{-- User --}}
                    @if(in_array($author->role_id, [2, 3, 4, 5, 6]) || permission('user_module'))
                    <li>
                        <a><i class="fas fa-user-friends"></i> User <span class="fas fa-chevron-down right"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="user/all">All Users</a></li>
                            <li><a href="user/online">Online Users (Radius)</a></li>
                            <li><a href="user/offline">Offline Users (Radius)</a></li>
                            <li><a href="user/expired">Expired Users</a></li>
                            <li><a href="user/expiring-7-days">Expiring In Week</a></li>
                            <li><a href="user/expiring-14-days">Expiring In 2 Weeks</a></li>
                        </ul>
                    </li>
                    @endif

                    {{-- Token --}}
                    @if($author->role_id == 2 || permission('token_module'))
                    <li>
                        <a><i class="fas fa-ticket-alt"></i> Token
                            <span class="fas fa-chevron-down right"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li><a href="token-card/">Cards</a></li>
                            <li><a href="token/">Tokens</a></li>
                        </ul>
                    </li>
                    @endif

                    {{-- Prepaid Card --}}
                    @if ($author->role_id == 2 || permission('prepaid_card_module'))
                    <li>
                        <a><i class="fas fa-credit-card"></i> Prepaid Card
                            <span class="fas fa-chevron-down right"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li><a href="prepaid-card/">Cards</a></li>
                            <li><a href="prepaid-token/">Tokens</a></li>
                        </ul>
                    </li>
                    @endif

                    {{-- SMS --}}
                    @if($author->role_id == 2 || permission('sms_module'))
                    <li>
                        <a><i class="fas fa-comments"></i> SMS
                            <span class="fas fa-chevron-down right"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li><a href="sms/sms-alert/">Manage SMS Alert</a></li>
                            <li><a href="sms/sms-delivered/">SMS Delivery Reports</a></li>
                        </ul>
                    </li>
                    @endif

                    {{-- Tickets --}}
                    @if(in_array($author->role_id, [2, 3, 4, 5, 6]))
                    <li>
                        <a><i class="fas fa-receipt"></i> Tickets
                            <span class="fas fa-chevron-down right"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li><a href="ticket/all/">All Tickets</a></li>
                            <li><a href="ticket/category/all">Categories</a></li>
                            <li><a href="ticket/open">Open</a></li>
                            <li><a href="ticket/closed">Closed</a></li>
                        </ul>
                    </li>
                    @endif

                    @if(in_array($author->role_id, [2, 3, 4, 5, 6]))
                    <li>
                        <a href="notices">
                            <i class="fas fa-bell"></i> {{ __('notices') }}
                        </a>
                    </li>
                    @endif

                    {{-- Accounts --}}
                    @if(in_array($author->role_id, [2, 3, 4, 5, 6]))
                    <li>
                        <a><i class="fas fa-dollar-sign"></i> Accounting
                            <span class="fas fa-chevron-down right"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li><a href="accounting/sale-reports">Sales Reports</a></li>
                            <li><a href="accounting/invoice/">Manage Invoices</a></li>
                            <li><a href="accounting/payments/">Payment Reports</a></li>
                            <li><a href="accounting/pgw-report/">PGW Reports</a></li>
                            <li><a href="accounting/ledger">Ledger Reports</a></li>
                            <li><a href="accounting/balance-report">Balance & Due Reports</a></li>
                            <li><a href="accounting/cashflow/">Manage Cashflow</a></li>
                            <li><a href="accounting/cashflow/category/">Cashflow Category</a></li>
                        </ul>
                    </li>
                    @endif

                    {{-- Log --}}
                    @if(in_array($author->role_id, [2, 3, 4, 5, 6]))
                    <li>
                        <a><i class="fas fa-book"></i> Logs & Reports
                            <span class="fas fa-chevron-down right"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li><a href="log/activity-log/">Activity Logs</a></li>
                            <li><a href="log/connection-log">Usage Logs</a></li>
                            <li><a href="log/login-log/">Login Logs</a></li>
                            <li><a href="log/tracking-log/">Tracking Logs</a></li>
                            <li><a href="log/export">Export Reports</a></li>
                            <li><a href="log/system-log/">System Log</a></li>
                            <li><a href="log/coa-log/">CoA Log</a></li>
                        </ul>
                    </li>
                    @endif

                    {{-- Setting --}}
                    @if(in_array($author->role_id, [1, 2]))
                    <li>
                        <a><i class="fas fa-cogs"></i> {{ __('settings') }}
                            <span class="fas fa-chevron-down right"></span>
                        </a>
                        <ul class="nav child_menu">
                            @if($author->role_id == 1)
                            <li>
                                <a href="{{ url('settings/manage-software') }}">
                                    {{ __('manage_software') }}
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('settings/clean-tables') }}">
                                    {{ __('clean_table') }}
                                </a>
                            </li>
                            @endif

                            <li>
                                <a href="{{ url('settings') }}">{{ __('settings') }}</a>
                            </li>

                            <li>
                                <a href="{{ url('server-info') }}">{{ __('server_info') }}</a>
                            </li>

                            <li>
                                <a href="{{ url('support') }}">{{ __('support') }}</a>
                            </li>

                            <li>
                                <a href="{{ url('zalpro-notices') }}">{{ __('notice') }}</a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    @endif

                    <li>
                        <a href="{{ route('logout') }}"><i class="fas fa-times-circle"></i>
                            {{ __('logout') }}
                        </a>
                    </li>

                </ul>

            </div>
        </div>
    </div>
</div>
