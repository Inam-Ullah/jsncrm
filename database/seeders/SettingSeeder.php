<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::find(1);
        $admin = User::find(2);

        if (! $superAdmin || ! $admin) {
            throw new RuntimeException('Super Admin and Admin users must be seeded before settings.');
        }

        Setting::updateOrCreate(
            ['id' => 1],
            [
                'user_id' => $admin->id,
                'domain_url' => 'http://103.174.206.42',
                'logo' => '20230531_122758_863594.png',
                'favicon' => '20201020_033834_578250.png',
                'name' => 'JSN ISP CRM',
                'slogan' => 'A Powerful ISP CRM For ISP Management',
                'mobile' => '+88000000000',
                'email' => 'admin@site.com',
                'currency' => 'PKR',
                'vat' => 0,
               'address' => '25-A, Unit # 3',
                'city' => 'Rahim Yar Khan',
                'country' => 'Pakistan',
                'zip' => '64200',
                'location' => null,
                'copyright' => 'Copyright @2026',
                'jsntext' => true,
                'timezone' => 'Asia/Karachi',
                'latitude' => 23.728783,
                'longitude' => 90.393791,
                'map_access_token' => 'pk.eyJ1IjoicHJpbmNlcGVhbDI1IiwiYSI6ImNrZ2g0aWhjZjAwN2syeXFrZ2dhb29maWMifQ.giG3T0gLtioTrlo02pY3wQ',
                'page_load_style' => 60,
                'activation_type' => 1,
                'billing_system' => 1,
                'reseller_package_set' => 1,
                'captcha_enabled' => false,
                'usage_graph_enabled' => false,
                'dashboard_map_enabled' => false,
                'user_profile_map_enabled' => false,
                'quick_search_enabled' => true,
                'random_username' => false,
                'random_username_length' => 6,
                'random_password' => false,
                'random_password_length' => 6,
                'username_prefix_enabled' => false,
                'prefix_characters' => null,
                'auto_renew' => false,
                'auto_payment' => false,
                'leftover_days' => 1,
                'allow_user_self_registration' => false,
                'allow_user_own_update' => false,
                'allow_duplicate_nic' => false,
                'allow_duplicate_phone' => false,
                'allow_duplicate_email' => false,
                'allow_all_packages' => false,
                'user_can_see_volume' => false,
                'user_profile_document_view' => false,
                'hide_user_password' => false,
                'user_reset_password' => false,
                'nas_visibility' => false,
                'connection_type' => 1,
                'radius_pppoe_enabled' => true,
                'radius_hotspot_enabled' => true,
                'api_pppoe_enabled' => false,
                'api_hotspot_enabled' => false,
                'api_static_ip_enabled' => false,
                'allow_any_nas' => true,
                'radius_stale_session' => true,
                'router_stale_session' => false,
                'disconnect_type' => 2,
                'mac_lock_all' => false,
                'remove_mac_lock_all' => false,
                'restrict_user_connection' => false,
                'otp_enabled' => true,
                'login_otp' => false,
                'password_otp' => false,
                'mobile_otp' => false,
                'login_theme' => 2,
                'dashboard_theme' => 0,
                'api_enabled' => false,
                'api_whitelist_enabled' => false,
                'api_whitelist_ips' => null,
               'api_username' => null,
               'auto_clear_logs' => true,
                'memory_limit' => 2024,
                'grace_period_enabled' => false,
               'grace_period_preset' => 7,
                'grace_period_preset_type' => 1,
                'grace_period_duration' => 7,
               'grace_period_duration_type' => 2,
                'fixed_expire_day' => 7,
               'fixed_expire_time' => '23:59:59',
               'fixed_expire_day_enabled' => false,
               'fixed_expire_time_enabled' => true,
                'jazzcash_enabled' => false,
                'jazzcash_sandbox' => true,
               'jazzcash_merchant_id' => '#',
                'jazzcash_submerchant_id' => '#',
               'easypaisa_enabled' => false,
               'easypaisa_sandbox' => true,
                'easypaisa_store_id' => null,
               'nayapay_enabled' => false,
                'nayapay_sandbox' => true,
            ],
        );

        Setting::updateOrCreate(
            ['id' => 2],
            [
                'user_id' => $superAdmin->id,
                'domain_url' => 'http://jsn.local',
                'logo' => null,
                'favicon' => null,
                'name' => 'JSN ISP CRM',
                'slogan' => 'A Powerful ISP CRM For ISP Management',
                'mobile' => $superAdmin->phone,
                'email' => $superAdmin->email,
                'currency' => 'PKR',
                'vat' => 0,
                'address' => $superAdmin->address,
                'city' => 'Rahim Yar Khan',
                'country' => 'Pakistan',
                'zip' => '64200',
                'copyright' => 'Copyright @2026',
                'jsntext' => true,
                'timezone' => 'Asia/Karachi',
                'login_theme' => 1,
                'dashboard_theme' => 0,
            ],
        );
    }
}
