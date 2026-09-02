<div class="top_nav">
    <div class="nav_menu" style="background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 0 15px;">
        <nav style="display: flex; align-items: center; justify-content: space-between; height: 55px;">
            
            <!-- Left Side: Menu Toggle & Brand Logo -->
            <div class="flex-left" style="display: flex; align-items: center; gap: 15px;">
                <div class="nav toggle" style="margin: 0; padding-top: 0;">
                    <a id="menu_toggle" style="cursor: pointer; font-size: 18px; color: #475569;"><i class="fas fa-bars"></i></a>
                </div>

                <div class="brand-logo" style="display: flex; align-items: center; gap: 8px;">
                    <span style="background: #1e293b; color: #ffffff; font-weight: 700; font-size: 13px; width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; text-transform: uppercase;">
                        {{ strtoupper(substr(setting()->name ?? 'SBLINK', 0, 1)) }}
                    </span>
                    <a href="{{ route('home') }}" style="font-size: 15px; font-weight: 700; color: #1e293b; text-decoration: none;">
                        {{ setting()->name ?? 'SBLINK' }}
                    </a>
                </div>
            </div>

            <!-- Right Side: User Role, Clock, Notifications, Language, User Dropdown -->
            <ul class="nav navbar-nav navbar-right" style="display: flex; align-items: center; margin: 0; gap: 18px;">
                
                <!-- Role Badge -->
                <li class="hidden-xs" style="display: flex; align-items: center; gap: 5px; color: #334155; font-size: 13px; font-weight: 600;">
                    <i class="fas fa-user-tie" style="color: #475569;"></i>
                    <span>{{ $author->role->name ?? 'Admin' }}</span>
                </li>

                <li class="hidden-xs" style="color: #cbd5e1;">|</li>

                <!-- Live Clock -->
                <li class="hidden-xs" style="display: flex; align-items: center; gap: 5px; color: #334155; font-size: 13px; font-weight: 600;">
                    <i class="fas fa-clock" style="color: #475569;"></i>
                    <span id="live-clock-display">{{ date('H:i:s') }}</span>
                </li>

                <li style="color: #cbd5e1;">|</li>

                <!-- Notification Bell -->
                <li role="presentation" class="dropdown" style="position: relative;">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false" style="color: #475569; position: relative; padding: 5px;">
                        <i class="fas fa-bell" style="font-size: 16px;"></i>
                        <span class="badge bg-red" style="background: #ef4444; color: #fff; font-size: 10px; font-weight: 700; border-radius: 50%; padding: 2px 5px; position: absolute; top: -2px; right: -4px;">0</span>
                    </a>
                    <ul class="dropdown-menu list-unstyled msg_list alert-list pull-right" role="menu" style="min-width: 220px;">
                        <li><a href="#" style="padding: 10px; font-size: 13px;"><i class="fas fa-bell fa-fw"></i> No new notifications</a></li>
                    </ul>
                </li>

                <!-- Language Selector -->
                <li class="dropdown" style="position: relative;">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Language" style="color: #475569; padding: 5px;">
                        <i class="fas fa-language" style="font-size: 18px;"></i>
                    </a>
                    <ul class="dropdown-menu pull-right" style="min-width: 130px;">
                        <li><a href="#">English</a></li>
                        <li><a href="#">Urdu / English</a></li>
                    </ul>
                </li>

                <!-- Profile Dropdown -->
                <li class="quick_access" style="position: relative;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="display: flex; align-items: center; gap: 8px; color: #1e293b; font-weight: 600; text-decoration: none; padding: 4px 8px; border-radius: 6px;">
                        <img src="{{ $author->photo ? asset('theme1/assets/images/final/'.basename($author->photo)) : asset('theme1/assets/system/images/user.png') }}" alt="Profile photo" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                        <span>{{ $author->name }}</span>
                        <i class="fas fa-angle-down" style="font-size: 12px; color: #64748b;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right" style="min-width: 180px;">
                        <li><a href="{{ route('profile.index') }}"><i class="fas fa-user fa-fw"></i> My Profile</a></li>
                        @if(in_array($author->role_id, [1, 2]))
                            <li><a href="#"><i class="fas fa-tools fa-fw"></i> Settings</a></li>
                            <li><a href="#"><i class="fas fa-server fa-fw"></i> Server Info</a></li>
                            <li><a href="#"><i class="fas fa-headset fa-fw"></i> Support</a></li>
                            <li><a href="#"><i class="fas fa-bell fa-fw"></i> Notices</a></li>
                        @endif
                        <li><a href="{{ route('logout') }}"><i class="fas fa-times-circle fa-fw"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>

        </nav>
    </div>
</div>

<script>
    (function updateClock() {
        var now = new Date();
        var hours = String(now.getHours()).padStart(2, '0');
        var minutes = String(now.getMinutes()).padStart(2, '0');
        var seconds = String(now.getSeconds()).padStart(2, '0');
        var clockEl = document.getElementById('live-clock-display');
        if (clockEl) {
            clockEl.textContent = hours + ':' + minutes + ':' + seconds;
        }
        setTimeout(updateClock, 1000);
    })();
</script>
