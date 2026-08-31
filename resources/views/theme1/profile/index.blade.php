<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $author->name }} | Profile</title>
    <link rel="icon" type="image/png" href="{{ favicon('theme1') }}">
    <link href="{{ asset('theme1/assets/themes/legacy/dashboard/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme1/assets/themes/legacy/dashboard/vendors/font-awesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme1/assets/themes/legacy/css/rubikfont.css') }}" rel="stylesheet">
    <link href="{{ asset('theme1/assets/themes/legacy/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('theme1/assets/css/profile.css') }}" rel="stylesheet">
</head>

<body class="nav-md profile-page">
    <div class="container body">
        <div class="main_container">
            <aside class="col-md-3 left_col profile-sidebar">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title">
                        <a href="{{ route('home') }}" class="site_title">
                            <img src="{{ logo() }}" alt="{{ setting()->name }} logo">
                            <span>{{ setting()->name }}</span>
                        </a>
                    </div>

                    <div class="clearfix"></div>

                    <div class="profile clearfix sidebar-profile">
                        <div class="profile_pic">
                            <img src="{{ asset('theme1/assets/system/images/user.png') }}" alt="Profile photo" class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>{{ $author->name }}</h2>
                            <small>{{ $roleName }}</small>
                        </div>
                    </div>

                    <div class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li><a href="{{ route('home') }}"><i class="fas fa-home"></i> Dashboard</a></li>
                                <li class="active"><a href="{{ route('profile.index') }}"><i class="fas fa-user"></i> My Profile</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </aside>

            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <button type="button" class="profile-menu-toggle" aria-label="Toggle navigation">
                                <i class="fas fa-bars"></i>
                            </button>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="{{ route('profile.index') }}" class="user-profile">
                                    <img src="{{ asset('theme1/assets/system/images/user.png') }}" alt="Profile photo">
                                    {{ $author->name }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" class="profile-logout-button">
                                    <i class="fas fa-sign-out-alt"></i> Log Out
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <main class="right_col profile-content" role="main">
                <div class="page-title">
                    <div class="title_left">
                        <h3>My Profile <small>Combined role-based profile</small></h3>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>{{ $author->name }} | <strong>{{ $author->username }}</strong> <small>({{ $roleName }})</small></h2>
                                <div class="clearfix"></div>
                            </div>

                            <div class="x_content">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 profile-summary">
                                        <div class="profile_img text-center">
                                            <img class="img-responsive img-circle avatar-view" src="{{ asset('theme1/assets/system/images/user.png') }}" alt="Profile photo">
                                        </div>

                                        <ul class="list-unstyled user_data">
                                            <li><i class="fas fa-user-tag"></i> Role: {{ $roleName }}</li>
                                            <li><i class="fas fa-server"></i> ISP ID: {{ $author->isp_id ?? 'N/A' }}</li>
                                            <li><i class="fas fa-id-card"></i> NIC: {{ $author->nic ?? 'N/A' }}</li>
                                            <li><i class="fas fa-phone"></i> Phone: {{ $author->phone ?? $author->mobile ?? 'N/A' }}</li>
                                            <li><i class="fas fa-envelope"></i> Email: {{ $author->email ?? 'N/A' }}</li>
                                            <li><i class="fas fa-user-shield"></i> Status: {{ $author->status == 1 ? 'Active' : 'Disabled' }}</li>
                                            <li><i class="fas fa-address-book"></i> Address: {{ $author->address ?? 'N/A' }}</li>
                                            <li><i class="fas fa-map-marker-alt"></i> City ID: {{ $author->city_id ?? 'N/A' }}</li>
                                            <li><i class="fas fa-calendar-day"></i> Join Date: {{ $author->created_at ?? 'N/A' }}</li>
                                        </ul>

                                        <div class="profile-actions">
                                            @if ($permissions['change_photo'])
                                                <button type="button" class="btn btn-primary"><i class="fas fa-image"></i> Change Photo</button>
                                            @endif
                                            @if ($permissions['add_note'])
                                                <button type="button" class="btn btn-primary"><i class="fas fa-sticky-note"></i> Add Note</button>
                                            @endif
                                            @if ($permissions['edit_profile'])
                                                <button type="button" class="btn btn-warning"><i class="fas fa-edit"></i> Edit Profile</button>
                                            @endif
                                            @if ($permissions['change_password'])
                                                <button type="button" class="btn btn-warning"><i class="fas fa-lock"></i> Change Password</button>
                                            @endif
                                            @if ($permissions['add_document'])
                                                <button type="button" class="btn btn-warning"><i class="fas fa-file-alt"></i> Add Document</button>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                        @if ($permissions['view_hierarchy_counters'])
                                            <div class="row profile-counters">
                                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                    <div class="profile-counter"><span>Total Users</span><strong>{{ $stats['users'] }}</strong></div>
                                                </div>
                                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                    <div class="profile-counter"><span>Admins</span><strong>{{ $stats['admins'] }}</strong></div>
                                                </div>
                                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                    <div class="profile-counter"><span>Staff</span><strong>{{ $stats['staff'] }}</strong></div>
                                                </div>
                                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                    <div class="profile-counter"><span>Franchises</span><strong>{{ $stats['franchises'] }}</strong></div>
                                                </div>
                                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                    <div class="profile-counter"><span>Dealers</span><strong>{{ $stats['dealers'] }}</strong></div>
                                                </div>
                                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                    <div class="profile-counter"><span>Subdealers</span><strong>{{ $stats['subdealers'] }}</strong></div>
                                                </div>
                                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                    <div class="profile-counter"><span>Resellers</span><strong>{{ $stats['resellers'] }}</strong></div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="panel-group profile-panels" id="profileAccordion">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title"><i class="fas fa-user"></i> Profile Details</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-6"><strong>Name:</strong> {{ $author->name }}</div>
                                                        <div class="col-md-6"><strong>Username:</strong> {{ $author->username }}</div>
                                                        <div class="col-md-6"><strong>Email:</strong> {{ $author->email ?? 'N/A' }}</div>
                                                        <div class="col-md-6"><strong>WhatsApp:</strong> {{ $author->whatsapp ?? 'N/A' }}</div>
                                                        <div class="col-md-6"><strong>Language:</strong> {{ $author->lang ?? 'en' }}</div>
                                                        <div class="col-md-6"><strong>Last Login:</strong> {{ $author->last_login_at ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if ($permissions['view_package_summary'])
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title"><i class="fas fa-box"></i> Package Summary</h4>
                                                    </div>
                                                    <div class="panel-body">Package details will be connected in the next implementation phase.</div>
                                                </div>
                                            @endif

                                            @if ($permissions['view_financial_summary'])
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title"><i class="fas fa-wallet"></i> Financial Summary</h4>
                                                    </div>
                                                    <div class="panel-body">Financial counters are intentionally using dummy values until business logic is connected.</div>
                                                </div>
                                            @endif

                                            @if ($permissions['view_documents'])
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title"><i class="fas fa-copy"></i> Documents</h4>
                                                    </div>
                                                    <div class="panel-body">No documents have been connected yet.</div>
                                                </div>
                                            @endif

                                            @if ($permissions['view_activity'])
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title"><i class="fas fa-chart-bar"></i> Activity Log</h4>
                                                    </div>
                                                    <div class="panel-body">Activity records will be connected after the template is approved.</div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="profile-footer">
                {{ setting()->name }} | {{ setting()->slogan }}
                @if (setting()->copyright)
                    | {{ setting()->copyright }}
                @endif
            </footer>
        </div>
    </div>

    <script src="{{ asset('theme1/assets/themes/legacy/dashboard/vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('theme1/assets/themes/legacy/dashboard/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</body>

</html>
