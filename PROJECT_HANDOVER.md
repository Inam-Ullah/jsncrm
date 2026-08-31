# Project Handover — JSN ISP CRM (CodeIgniter 3 to Laravel 10)

> Prepared from the live server state on 31 August 2026. This document is the continuation source for the next coding agent. Do not rely on the old chat alone.

## 1. Environment and source of truth

- Server: `root@192.168.20.55`
- Laravel project: `/var/www/zalpro-laravel-10`
- Legacy CodeIgniter 3 project and SQL/reference source: `/var/www/html`
- Laravel: 10.50.3
- PHP: 8.2.33
- Web application currently tested at `http://192.168.20.55:8080`
- The Laravel directory is a Git repository on branch `main` and tracks `origin/main`.
- GitHub remote: `https://github.com/Inam-Ullah/jsncrm.git`.
- Latest implementation commit at this handover stage: `8c849e1` (`Implement Area AJAX dependent dropdowns with Chosen select and restrict DataTables export buttons`, committed locally; push pending authentication).
- Database is configured and all currently present migrations have run in batch 1.
- Seeded data currently includes 12 roles, 2 areas, 7 type rows, 2 users and 2 settings rows.

## 2. Product overview

This is a clean Laravel 10 rewrite of a large CodeIgniter 3 ISP CRM/billing system. The product manages:

- One shared login and role-aware dashboard for all account types.
- Multi-level ISP hierarchy: Super Admin → Admin → Franchise → Dealer → Subdealer → Reseller → Customer.
- Staff roles: Supervisor, Sales Person, Accounts, Support and Recovery.
- ISP customers, packages, reseller pricing/profits, billing, invoices, payments and ledgers.
- FreeRADIUS and MikroTik/NAS integration, accounting, authentication, CoA and policy groups.
- Areas, routers, monitoring, quotas, prepaid/token cards, inventory, tickets, notices, activity logs, documents and notifications.
- Per-admin/tenant branding and settings for cloud and on-premises installations.
- Four selectable login themes.

## 3. Non-negotiable coding conventions agreed with the owner

The next agent must preserve these decisions:

1. **Keep Eloquent relationship methods** (`belongsTo`, `hasMany`, `hasOne`, morph relationships). The owner's instruction is only to omit relation-class imports and return declarations such as `use ...Relations\BelongsTo;` and `function user(): BelongsTo`. Correct form: `public function user() { return $this->belongsTo(User::class); }`.
2. Prefer Laravel helper functions and native PHP built-ins over facades/helper classes when an equivalent exists: e.g. `auth()` instead of the `Auth` facade, `strtolower()` instead of `Str::lower()`.
3. Do not add scalar/return type declarations to models/controllers/views (`string`, `int`, `bool`, `float`, `: View`, `: Response`, etc.). Migration column types are database schema definitions and are not part of this restriction.
4. Use loose comparisons (`==`, `!=`) rather than strict comparisons (`===`, `!==`) in application/controller/view logic.
5. Do not use Blade `@php` blocks.
6. Do not use `compact()` to pass view data. Use an explicit array:
   `return view('path', ['author' => $author]);`
7. Do not put page CSS inside Blade. Reuse the existing legacy Theme 1 assets. If genuinely required, use a separate CSS file.
8. Permissions for the first template phase should be built with controller `if/elseif` logic and dummy values—not a permission helper or unfinished business services.
9. The owner manually reviews schemas and wants simple/readable columns. Do not redesign approved migrations without discussing it.
10. FreeRADIUS table and attribute names must remain compatible. FreeRADIUS works primarily through usernames/group names and the existing indexes; do not casually rename its tables/columns.

## 4. Current stopping point (read this first)

The login system and four login templates are considered final for now. The authenticated Theme 1 shell now combines the legacy Super Admin, Admin-side and Client portal layouts in one reusable Blade structure. Work stops after the combined layout and before migrating profile or other legacy pages.

Completed immediately before handover:

- Removed duplicated time-based Theme 4 background selection from `AuthenticatedSessionController`.
- `background()` in `app/Helpers/helpers.php` is now the single source and correctly returns background number 1–8.
- Theme 4 login directly calls `background()`.
- The helper/controller pass syntax checks and Blade cache compiles.
- Migrated the legacy Theme 1 dashboard shell into a reusable Blade layout.
- Split head assets, sidebar, top navbar, footer and scripts into dedicated partials.
- Created a dummy Theme 1 dashboard and minimal `HomeController@index`; no business queries were added.
- Reused the existing Gentelella/legacy Theme 1 CSS and JavaScript assets; no replacement dashboard CSS was written.
- Verified the authenticated dashboard on desktop and a 390-pixel mobile viewport: no horizontal overflow and no browser console errors.
- Compared both legacy admin-portal and client-portal header/footer sources.
- Combined three role modes in one sidebar/navbar: Super Admin has ISP/Admin/Area/Settings; Admin-side roles have operational hierarchy/network/accounting menus; Customer/Client has activity/login/connection logs, ledger, invoices, tickets and notices.
- Restored the common legacy head/footer asset set and corrected script order so jQuery-dependent legacy plugins load cleanly.
- Updated `HomeController@index` to pass only the authenticated `author` and `optional($author->role->permission)` to the dashboard.
- Restored the missing `Role::permission()` Eloquent relationship without a relation-class import or typed return.
- Authenticated Theme 1 layout/profile Blades now call `setting()` directly instead of receiving a `$setting` controller variable.

Current unfinished UI task:

- A first combined profile controller/view exists and renders, but the profile view is a **temporary standalone layout with custom `profile.css`**.
- The owner rejected that standalone approach.
- Do not migrate the profile until the owner has reviewed this combined layout. After approval, migrate each legacy page same-to-same into this shell, starting with the combined profile, and remove temporary custom styling where legacy classes/assets cover it.

Model recovery status at handover:

- Relationship methods were mistakenly removed during the last turn.
- The mistake was corrected and all **202 original relationship methods across 49 model files** were recovered from the pre-change backup and uploaded to the server.
- Corrected models contain the relationship methods but no `Illuminate\Database\Eloquent\Relations\...` imports and no relation return types.
- Verification passed on the server: 49 model files, 202 relation calls, zero relation-class imports, zero typed relation returns, and no PHP syntax failures.
- Recovery source remains available locally at `work/model_relations_restored/`, with generator `work/restore_model_relations.ps1`.
- The correction is committed in Git as `b296244`.

Legacy reference files:

- `/var/www/html/application/views/themes/legacy/admin_portal/dashboard/header.php`
- `/var/www/html/application/views/themes/legacy/admin_portal/dashboard/footer.php`
- `/var/www/html/application/views/themes/legacy/admin_portal/dashboard/home.php`
- Legacy role-specific profiles under `/var/www/html/application/views/themes/legacy/admin_portal/myprofile/`:
  `superadmin_profile.php`, `admin_profile.php`, `franchise_profile.php`, `dealer_profile.php`, `subdealer_profile.php`, `staff_profile.php`.

## 5. Authentication, settings and tenancy

### Shared authentication

- Breeze-style authentication routes/controllers are installed.
- One login system is used for every role; there are no separate admin/client portals.
- On login, `last_login_at` is updated. On logout, `last_logout_at` is updated.
- Logout is intentionally a protected `GET /logout` route by owner instruction; Theme 1 logout controls are direct links rather than POST forms.
- `AuthenticatedSessionController::create()` selects `auth.theme{login_theme}.login` and passes `setting` as an explicit array.
- Four templates exist: `resources/views/auth/theme1` through `theme4`.

### Global helpers

`app/Helpers/helpers.php` is autoloaded through Composer and contains:

- `setting()`:
  - Resolve a guest setting by exact `domain_url` (scheme/host or host), fallback to first setting.
  - Authenticated role 1 or 2 gets its own `settings.user_id` row.
  - Other authenticated roles get the row for their `admin_id`.
- `logo()` and `favicon()` resolve uploaded files inside the active login theme and fall back to theme system images.
- `background()` selects Theme 4 background 1–8 from the current server hour and returns the number.

Important uncertainty: for nested hierarchy users, `setting()` currently uses only `auth()->user()->admin_id`. Confirm that every Franchise/Dealer/Subdealer/Reseller/Customer has `admin_id` populated; otherwise traverse the approved hierarchy IDs manually without Eloquent relationships.

### Current seeded accounts/settings

- User 1: `superadmin`, role 1, language `en`.
- User 2: `admin`, role 2, language `en`.
- Passwords were seeded as `12345678` during setup. Change them before production.
- Setting 1 belongs to Admin user 2, domain `http://103.174.206.42`, login theme 3.
- Setting 2 belongs to Super Admin user 1, domain `http://jsn.local`, login theme 1.

## 6. Role IDs (fixed; do not reorder)

| ID | Role |
|---:|---|
| 1 | Super Admin |
| 2 | Admin |
| 3 | Franchise |
| 4 | Dealer |
| 5 | Subdealer |
| 6 | Reseller |
| 7 | Customer |
| 8 | Supervisor |
| 9 | Sales Person |
| 10 | Accounts |
| 11 | Support |
| 12 | Recovery |

The application intentionally treats numeric IDs as the fixed role definition. The `roles` table has only `id`, `name`, nullable `permission_id`, and timestamps. Legacy role level/slug/description/is_active fields were removed.

## 7. CodeIgniter 3 versus Laravel 10 structure

| Legacy CI3 | Laravel 10 decision |
|---|---|
| `admin` table | Combined/common account data in `users` |
| `userinfo` | Customer-only ISP profile in `customers`, one row per `users.id` |
| Mixed `types` lookup for roles/city/area/status | Roles moved to `roles`; city/area/subarea moved to hierarchical `areas`; only status/userstatus/inventory-type lookup values stay in `types` |
| Separate admin/client login and profile pages | One login; one role-aware dashboard/profile |
| Separate role profile views | One combined `ProfileController` and `theme1/profile/index.blade.php` with controller permissions |
| Legacy `f_packages` | `f_packages` retained but renamed columns and decimal money fields |
| Package raw pool/rate settings | RADIUS policy is represented by group names in `radgroupcheck`/`radgroupreply`; packages reference active/expire/disable group names |
| Repeated dynamic bandwidth columns | Normalized `package_bandwidth_schedules` rows with start/end/group name, maximum 12 daily slots enforced later in validation |
| `paymentspending` | Renamed to `pending_payments` |
| Mixed gateway/settings providers | One per-user `settings` table; only JazzCash, EasyPaisa, NayaPay, generic SMTP and WhatsApp/Meta Cloud fields retained |
| Legacy hierarchy-specific ledger/cash-flow columns | Generic user/owner/related-user/action-by IDs |
| `dueprofit` concept | Intended to be covered by ledger; no separate table |

## 8. Database modules and approved table designs

All migration files currently show **Ran, batch 1**. Do not run `migrate:fresh`, rollback or destructive SQL without explicit owner authorization.

### Identity and geography

- `users`: shared identity/auth and hierarchy. Key columns: `role_id`, `isp_id`, `city_id`, `area_id`, `subarea_id`, `name`, unique `username`, non-unique nullable `email`, `admin_id`, `franchise_id`, `dealer_id`, `subdealer_id`, `reseller_id`, password/photo/NIC/phone/mobile/WhatsApp/lang/address/status/SMS status, `created_by`, login/logout timestamps, credit/percentage/NAS and legacy reseller capability/limit flags.
  - `parent_id` was rejected and replaced with explicit hierarchy IDs.
  - `joined_at` was removed; `created_at` is join time.
  - `lang` was added late and defaults to `en`.
  - Hierarchy IDs intentionally are simple indexed IDs; deletion dependency rules are expected in application logic.
- `customers`: one-to-one customer-specific ISP record via unique `user_id`; indexed `username`; package/sales/update IDs; discount, enable/quota, connection/MAC/static IP/fiber/switch/network location, activation/renew/expiration/session fields and notes.
  - `isp_id` and `nas_id` were moved out; lookup uses username/users data.
  - `customer_package_id` was removed; `package_id` remains.
- `roles`: fixed IDs/name and nullable `permission_id`.
- `permissions`: explicit Boolean permission flags (legacy-style, approximately 250 fields), no JSON and no `name` column.
- `areas`: self hierarchy with nullable `parent_id`, enum `city|area|sub_area`, and name. Slug/code/is_active were removed.
- `isps`: company name, point-of-contact name, mobile, address and city ID.
- `types`: only `type`, numeric `data`, description and timestamps; seeded status/userstatus/inventory values.

### Packages and policies

- `packages`: master service/rule data, not reseller pricing. It stores package identity/display, normal `group_name`, `expire_group_name`, `disable_group_name`, validity, quota/FUP/session/billing/expiry behavior. Pool columns and direct raw policy configuration were removed because policy groups own those attributes.
- `package_bandwidth_schedules`: package, start time, end time and scheduled RADIUS group name. Daily/hour-wise slots; no weekday column. Maximum 12 rows is a future validation rule.
- `f_packages`: reseller-chain pricing: `id`, `user_id` (admin), `reseller_id` (recipient at hierarchy level), `package_id`, decimal `cost`, `price`, `admin_profit`, `franchise_profit`, `dealer_profit`, `subdealer_profit`, `reseller_profit`, `customprice`, extra fee and VAT fields.
  - Legacy `fpkgid` → standard `id`.
  - `adminid` → `user_id`.
  - `fadminid` → `reseller_id`.
  - `pkgid` → `package_id`.
  - A/F/D/S profits were renamed to readable role profit names and reseller profit added.
  - All money fields use decimal, not float.
- No separate `policies` table. The future Policy module manages unique FreeRADIUS group names and rows in `radgroupcheck`/`radgroupreply`. `Simultaneous-Use` belongs in group check; MikroTik rate limit and framed pool belong in group reply according to the agreed workflow.

### FreeRADIUS/network

- Core tables: `nas`, `radacct`, `radacct_archive`, `radcheck`, `radgroupcheck`, `radgroupreply`, `radpostauth`, `radpostauth_archive`, `radreply`, `radusergroup`.
- Supporting network tables: `routers`, `router_monitorings`, `nas_monitorings`, `coa_requests`, `live_graphs`, `data_usage_by_period`, `static_ips`, `users_qt`.
- `radius_procedure_and_triggers` migration installs the stored procedure/triggers required by the accounting flow.
- Numeric IDs may be Laravel big integers, but FreeRADIUS queries rely on username/groupname/attribute indexes. Do not rename core RADIUS columns.

### Billing/accounting

- `invoices`: invoice number, ISP/customer/package/seller IDs, issue/due/expiration dates, status, decimal subtotal/discount/tax/total/paid/reseller-paid values, notes and creator.
- `payments`: invoice, transaction/reference/method data, payer/receiver, decimal amount, type/status/withdrawal/action fields.
- `ledgers`: nullable invoice/payment, unique transaction ID, type, user and related user, decimal amount and running balance, description and action-by. `occurred_at` was deliberately removed; timestamps are used.
- `pending_payments`: cleaned replacement for legacy `paymentspending`; requester/receiver/method/mobile/amount/reference/status/approved payment/action/note.
- `payment_gateway_transactions`: online gateway request/response/status/linking information.
- `cash_flow_categories`, `cash_flows`: normalized categories and cash-book entries with owner/related user/added-by/payment IDs and decimal amounts.

### CRM/support/operations

- Activity/audit: `activity_logs` uses `action_by_id`, `against_user_id`, activity, target type/ID, IP and user agent. Renames: actor → action-by; subject user → against-user.
- Tickets: `ticket_categories`, `tickets`, `ticket_comments`.
- Notices: `notices`, `notice_reads`.
- Inventory: `inventory_item_types`, `inventory_items`.
- Profile records: `documents`, `notes`, `attendances`.
- Expiration: `grace_periods`.
- Logs/auth: `system_logs`, `otps`.
- Prepaid/access: `prepaid_cards`, `prepaid_tokens`, `token_cards`, `access_tokens`.
- Notifications/WhatsApp-ready data: `notification_templates`, `notification_messages`, `notification_deliveries`.
- Partner branding: `partners`.

### Settings

`settings.user_id` and `domain_url` are unique. It supports per-Super-Admin/Admin tenant branding and unauthenticated domain resolution. Major groups:

- Branding/contact: domain, logo, favicon, name, slogan, mobile/email/currency/VAT/address/location/copyright, `jsntext`, timezone/map data.
- Email: generic SMTP enable/mailer/host/port/username/password/encryption/from fields.
- WhatsApp: Meta Cloud API enable/provider/phone-number/business-account/access/webhook/app-secret/language fields.
- Payments: only JazzCash, EasyPaisa and NayaPay settings.
- UI/features: page load style, activation/billing/package flags, captcha, usage graph/maps/search, shared login/dashboard themes.
- Customer and RADIUS rules: username/password generation, registration/update/duplicate rules, quotas, package visibility, connection modes, MAC/session/disconnect behavior.
- Shared OTP columns: `otp_enabled`, `login_otp`, `password_otp`, `mobile_otp`. Client/admin prefixes and separate login-page fields were removed.
- API and maintenance: API enable/whitelist/credentials, auto-clear logs, memory limit and grace/fixed-expiry settings.
- `zalprotext` was renamed project-wide to `jsntext`.

## 9. Migrations and execution status

All of the following are present and **Ran (batch 1)**:

- Laravel base: users, password reset tokens, failed jobs, personal access tokens.
- Roles, areas, types, permissions.
- 10 FreeRADIUS base migrations plus NAS.
- Packages, customers, f_packages, package bandwidth schedules, ISPs.
- Invoices, payments, ledgers, pending payments, gateway transactions, cash-flow categories/flows.
- Activity logs and settings.
- Ticket categories/tickets/comments; notices/reads.
- Inventory item types/items.
- Routers/router monitoring/live graphs/data usage/grace periods/documents/notes/attendance/CoA/system logs/NAS monitoring/OTPs/partners/static IP/users quota tracking.
- Prepaid cards/tokens, token cards/access tokens.
- Notification templates/messages/deliveries.
- RADIUS procedure/triggers.

Exact filenames are in `database/migrations`; use `php artisan migrate:status` before any future migration action.

## 10. Seeders

- `RoleSeeder.php`: fixed role IDs listed above. Owner declared it final; do not reorder/change casually.
- `AreaSeeder.php`: Rahim Yar Khan city and Gulshan Iqbal area under it.
- `TypeSeeder.php`: seven approved type rows.
- `UserSeeder.php`: Super Admin and Admin.
- `SettingSeeder.php`: one setting for each of those two accounts.
- `DatabaseSeeder.php`: registers the seeders.

Seeders have already populated the live database. Never expose or retain the known seed password in production.

## 11. Models

There are 49 models corresponding to the domain tables: identity, billing, RADIUS/network, support, inventory, prepaid, notifications and settings.

Important current state:

- Models retain table names, guarded/casts, Eloquent relationship methods and any required authentication traits.
- `$guarded = []` is intentionally preferred by the owner; validation is expected at controller/request level.
- Eloquent relationship **methods must remain**. Only relation return-type imports/declarations are forbidden by the project convention.
- `Role::permission()` is required because `HomeController` resolves `$author->role->permission`; do not remove it.
- Immediate verification after uploading the staged recovery: relationship calls should total 202; relation-class imports and typed relation returns should both total zero.

## 12. Controllers, routes and business logic

Controllers currently present:

- Breeze auth controllers.
- `AuthenticatedSessionController`: theme login selection, login/logout timestamp updates.
- `HomeController`: minimal dummy dashboard implementation only. It reads the authenticated user and the optional permission attached through `User → Role → Permission`, then returns `theme1.dashboard.index` with an explicit array. Settings are resolved directly in Blade through `setting()`. No business queries exist yet.
- `ProfileController`: first-stage combined profile only.

Current custom routes:

- `/` redirects to authenticated dashboard/login logic.
- Authenticated `/home` → `HomeController@index`.
- Authenticated `/profile` → `ProfileController@index`.
- Standard auth routes remain (login/logout/register/password reset/verification).

`ProfileController@index` currently:

- Sets `$author = auth()->user()`.
- Builds explicit permissions and zero-valued dummy stats.
- Uses loose role-ID `if/elseif` conditions for all roles.
- Returns `theme1.profile.index` with an explicit array (no compact).
- Does not yet implement profile CRUD, documents, notes, photo, password, counters or financial/package queries.

No substantive service layer exists yet. Do not claim that billing/network business logic is implemented merely because tables/models exist.

## 13. UI, Blade, JavaScript and assets

### Completed

- Four selectable login templates under `resources/views/auth/theme1..theme4`.
- Their CSS is separated into `public/theme1..theme4/assets/css/login.css`.
- Responsive login testing was done on desktop and mobile; Theme 4 input spacing/footer/no-scroll issues were corrected.
- Theme 4 uses `background()` helper.
- Blade `@php` was removed from login and touched component files.
- Four full asset directories exist under `public/theme1` through `public/theme4`.
- Legacy Theme 1 assets are already available under `public/theme1/assets/themes/legacy`.
- Reusable authenticated Theme 1 layout exists at `resources/views/theme1/layouts/app.blade.php`.
- Layout partials exist for head assets, sidebar, navbar, footer and scripts.
- Dummy dashboard exists at `resources/views/theme1/dashboard/index.blade.php` and uses legacy classes/assets.
- Desktop/mobile dashboard render, console and overflow checks passed.
- The single sidebar/navbar now branches by role to preserve the legacy Super Admin, Admin-side and Client navigation variants.

### Temporary / must be replaced next

- `resources/views/theme1/profile/index.blade.php` is a temporary standalone profile page.
- `public/theme1/assets/css/profile.css` is custom temporary styling and conflicts with the owner's requirement to reuse legacy CSS.
- `guest.blade.php` and `navigation.blade.php` may still be older Breeze/Tailwind experiments; inspect before reuse. The approved authenticated layout is now `theme1/layouts/app.blade.php` plus its partials.

No real AJAX/profile CRUD has been implemented. Legacy JavaScript exists in assets but must be reconnected endpoint-by-endpoint after controllers/routes exist.

## 14. Important files created or modified

- `app/Helpers/helpers.php`
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php`
- `app/Http/Controllers/ProfileController.php`
- `app/Http/Controllers/HomeController.php`
- `app/Http/Controllers/AreaController.php`
- `routes/web.php`
- All files in `app/Models/` (relationship methods must be restored from the staged corrected copies; only relation type classes/imports are removed)
- `resources/views/auth/theme1/login.blade.php` through `theme4/login.blade.php`
- `resources/views/theme1/profile/index.blade.php` (temporary)
- `resources/views/theme1/dashboard/index.blade.php`
- `resources/views/theme1/area/{index,insert,edit}.blade.php`
- `resources/views/theme1/layouts/app.blade.php`
- `resources/views/theme1/layouts/partials/{head,sidebar,navbar,footer,scripts}.blade.php`
- `resources/views/components/nav-link.blade.php`
- `resources/views/components/responsive-nav-link.blade.php`
- `resources/views/components/dropdown.blade.php`
- `resources/views/components/modal.blade.php`
- `public/theme1/assets/css/profile.css` (temporary)
- `public/theme1/assets/themes/legacy/js/area.js`
- `public/theme1..theme4/assets/css/login.css`
- All migration/model/seeder files described above.

## 15. Completed checklist

- [x] Audited legacy CI3 project and SQL dump.
- [x] Designed role hierarchy, areas and split legacy types.
- [x] Created and ran all current migrations, including RADIUS triggers/procedure.
- [x] Created and ran base seeders for roles, areas, types, users and settings.
- [x] Created users/customers split and hierarchy/location fields.
- [x] Created packages, policy-group references, schedules and f_packages pricing.
- [x] Created ISP, billing, payment, ledger and cash-flow tables.
- [x] Created support, notice, inventory, monitoring, prepaid, notification and remaining dump-derived tables.
- [x] Added WhatsApp-ready settings/notification structure.
- [x] Built four login themes and fixed responsive issues.
- [x] Added setting/logo/favicon/background helpers.
- [x] Removed duplicated background logic from controller.
- [x] Recovered and uploaded 202 Eloquent relationship methods after accidental removal; removed only relation class imports/return declarations; verified and committed.
- [x] Added initial combined ProfileController and route.
- [x] Migrated the legacy Theme 1 authenticated shell into reusable Blade layout partials.
- [x] Created the minimal HomeController and dummy dashboard without business logic.
- [x] Verified the dashboard on desktop/mobile with no horizontal overflow or console errors.
- [x] Configured `origin`, moved to `main`, and pushed the implementation history to GitHub.
- [x] Combined legacy Super Admin, Admin-side and Client portal layouts into one Theme 1 layout.
- [x] Restored common legacy layout assets and verified clean desktop/mobile rendering and console output.
- [x] Connected the dashboard to the role permission relationship and changed authenticated Theme 1 Blades to direct `setting()` helper calls.
- [x] Converted logout from POST forms to the owner-requested GET route and updated its feature test.
- [x] Completed the first authenticated CRUD module migration: Area management.
- [x] Added Area list/add/edit/update/delete routes and controller methods over the normalized `areas` table.
- [x] Migrated the legacy Area UI to Theme 1 Blade without `@php`, inline CSS or inline page JavaScript.
- [x] Added external `area.js` DataTable/AJAX behavior, export buttons, modal hierarchy switching and delegated delete confirmation.
- [x] Preserved `city → area → sub_area` hierarchy and prevented deletion while child locations or assigned users exist.
- [x] Added location-level user counts from `users.city_id`, `users.area_id` and `users.subarea_id`.
- [x] Verified Area routes, PHP/JavaScript syntax, Blade compilation, desktop/mobile rendering, AJAX rows, modal behavior and edit-page loading; browser console errors were zero.
- [x] Committed and pushed Area implementation as `756e6a5 Build Area management module`.
- [x] Restored the owner's `__()` translation calls after the temporary hard-coded-label change; commit `427c7bc Restore Area translations and hierarchy` supersedes the label change.
- [x] Enforced Sub Area ownership on both layers: the form filters Areas by selected City using `data-city-id`, and the controller requires the selected Area's `parent_id` to match that City.
- [x] Removed PHP nested loops from Area Blade views (`insert.blade.php`) for both City and Area dropdowns, and removed unnecessary `$cities` and `$areas` queries from `AreaController@index`.
- [x] Implemented City dropdown via AJAX (`getCitiesByAjax`) in `AreaController` and registered `/area/getCitiesByAjax` & legacy routes.
- [x] Preserved existing working Area and Sub-Area JS logic in `area.js` completely intact without refactoring, adding `loadCitiesByAjax()` to populate City dropdown and trigger `chosen:updated`.
- [x] Created reusable `activity_log()` helper in `app/Helpers/helpers.php` (no business service layer created, as per convention).
- [x] Integrated `activity_log()` in login (`AuthenticatedSessionController@store`), logout (`AuthenticatedSessionController@destroy`), and Area CRUD operations (`AreaController` `insert`, `update`, `delete`), ensuring sensitive data is never logged.
- [x] Replaced `findOrFail()` with `find()` and custom error handling in `AreaController` (`edit`, `update`, `delete`, `getAreaByAjax`, `getSubAreaByAjax`), returning user-friendly redirect messages (`'Location not found.'`) or JSON `0`/404 error responses for invalid record IDs instead of generic production 404 pages.
- [x] Completed ISP module end-to-end preserving owner's intended `IspController@index` logic:
  - Preserved `isps.user_id` (Super Admin/Admin owner) & `users.isp_id` (assigned user ISP) hierarchy.
  - Implemented `IspController` methods (`index`, `insert`, `edit`, `update`, `delete`) with Role 1 & 2 authorization and safe `find()` error handling.
  - Defined Eloquent relationships: `Isp::user()`, `Isp::city()`, `Isp::users()`, `Isp::invoices()`, `User::ownedIsps()`, `User::isp()`.
  - Registered named routes: `route('isp')`, `route('isp.insert')`, `route('isp.edit')`, `route('isp.update')`, `route('isp.delete')`.
  - Created Theme 1 Blade views (`resources/views/theme1/isp/index.blade.php`, `insert.blade.php`, `edit.blade.php`), removing PHP `@foreach` loop for cities and loading City dropdown dynamically via AJAX (`getCitiesByAjax`).
  - Embedded DataTable (Column Visibility button only), Chosen select, and `$.confirm` delete handler scripts directly inside `resources/views/theme1/isp/index.blade.php` under `@section('scripts')` per owner request.
  - Integrated `activity_log()` for ISP creation, update, and deletion.
  - Verified dependency checks preventing deletion of ISPs with assigned users or invoices.

## 16. Pending checklist

- [ ] Replace standalone profile shell with `@extends`/`@include`/sections using those partials.
- [ ] Remove or stop linking temporary `profile.css` once legacy classes cover the UI.
- [ ] Rebuild the combined profile content from all six legacy profile reference views.
- [ ] Keep controller dummy data initially and confirm visual structure/role visibility with owner.
- [ ] Replace dashboard dummy values with real controller/business data later, after the owner approves the templates.
- [ ] Choose authenticated layout dynamically by `dashboard_theme` later; currently only Theme 1 authenticated layout is implemented.
- [ ] Implement permission storage/application, profile actions, documents, notes, counters and maps.
- [ ] Implement policy module over `radgroupcheck`/`radgroupreply`.
- [ ] Implement package schedule validation (maximum 12 daily slots, valid non-overlap).
- [ ] Implement billing/payment/ledger workflows and hierarchy profit posting.
- [ ] Implement customer/RADIUS lifecycle, CoA, expiration/disable policy switching.
- [ ] Implement controllers/routes/views/AJAX for the many schema-only modules.
- [ ] Add authorization middleware/policies or approved controller checks after owner confirms design.
- [ ] Add focused automated Feature tests for Area create/update/delete validation; current verification is syntax, route, Blade and browser based.
- [ ] Decide whether other destructive module routes should follow the legacy GET pattern or use POST/DELETE. Area delete currently follows the legacy confirmed-link GET flow.
- [ ] Add validation, tests, production security, secret encryption and seeded-password rotation.

## 17. Immediate continuation instructions for Anti-Gravity

1. Read this file and inspect live files; do not restart schema design.
2. Inspect `git status` before starting. The live server currently has pre-existing uncommitted layout/global-controller/asset changes; preserve them and make focused commits instead of resetting or staging everything. Verify committed `main` against `origin/main` separately.
3. After every future coherent change: verify it, create a focused Git commit, and push it to the configured remote as explicitly required by the owner.
4. Do **not** run migrations, rollback, fresh seed or destructive SQL unless the owner explicitly asks.
5. Treat the combined Theme 1 layout/partials as the base shell. It intentionally contains three role modes in one file; do not split Super Admin, Admin and Client back into separate layouts.
6. Translate remaining legacy PHP/CodeIgniter calls to existing Laravel variables/helpers without `@php`, type declarations, strict comparisons or facades where helpers suffice. Eloquent relationship methods are allowed and expected; relation return-type classes are not.
7. Reuse URLs under `theme1/assets/themes/legacy/...`; do not write a replacement CSS theme.
8. Area is the first completed module and is no longer a placeholder. Its route is `/area`, its server-side list endpoint is `POST /area/getAreas`, and its Blade files are under `resources/views/theme1/area/`.
9. When continuing another module, follow the Area pattern: inspect the live CI3 controller/view/JS first, map it to the normalized Laravel schema, keep page JavaScript external, then verify desktop/mobile before committing.
10. After owner approval, convert the temporary profile page to the new layout. Compare it against all legacy profile views and combine the role variants into one page.
11. Verify with:
    - PHP syntax checks,
    - `php artisan view:clear && php artisan view:cache`,
    - `php artisan route:list --path=<module>`,
    - authenticated Super Admin/Admin browser checks on desktop/mobile,
    - console errors and horizontal overflow.
12. Present each migrated page visually to the owner before expanding its business logic beyond the agreed module scope.

## 18. Known uncertainties and risks

- Git history begins with the late initial snapshot; changes before that snapshot have no granular commit history. Earlier “added/removed/renamed” information is reconstructed from current migrations, live schema and approved decisions.
- The live worktree is intentionally not clean after the Area commit because unrelated owner work remains uncommitted (Theme 1 layout/dashboard assets, GlobalController/routes, permission migration edits and imported macOS metadata). Do not discard, overwrite or bulk-commit those changes; use focused staging as Area commit `756e6a5` did.
- All current migrations are already run, despite earlier stages where they had not yet been run. Treat the current database as live state.
- Relationship removal was a misunderstanding, not an owner decision. Relationship methods must exist; only relation class imports/return types are disallowed.
- The permissions table is very wide and legacy-style by explicit instruction.
- Many tables/models exist without controllers/routes/business logic/tests.
- `HomeController`/dashboard is deliberately dummy-only; do not mistake the visible counters/panels for implemented business logic.
- Settings domain matching depends on stored scheme/host conventions and may need normalization later.
- Migration foreign keys and application deletion rules need a focused audit before production.
- Payment, WhatsApp and API secret fields exist; encryption/integration behavior is not fully implemented.
- GET logout is susceptible to cross-site logout requests because it has no CSRF token. This is an explicit owner decision; do not silently change it back to POST.
- Area deletion also currently uses a GET route to preserve the legacy `a.delete` confirmation flow. It is protected by authentication and controller permission checks, but it has the same CSRF/idempotency concern and must not be silently changed without owner approval.
- No migration or seeder was run for the Area module. The existing normalized `areas` table and seeded Rahim Yar Khan/Gulshan Iqbal records were used as-is.
- Do not replace Area Blade translation calls with hard-coded labels. Translation keys are intentional owner work even if a missing locale temporarily displays the key itself.
- Legacy files are generated/obfuscated in places. Use them as UI/schema behavior references, not as code to copy blindly.

### Activity Log Helper Documentation

- **Helper Location:** `app/Helpers/helpers.php` (function `activity_log()`).
- **Signature:** `activity_log($activity, $targetType = null, $targetId = null, $againstUserId = null)`
- **Functionality:** Creates a record in the `activity_logs` table storing `action_by_id` (`auth()->id()`), `against_user_id`, `activity` (max 255 chars), `target_type`, `target_id`, `ip_address`, and `user_agent`. Sensitive data (passwords, tokens, credentials) MUST NOT be included.
- **Active Usage:**
  - Login (`AuthenticatedSessionController@store`): `activity_log('User logged in', 'User', auth()->id())`
  - Logout (`AuthenticatedSessionController@destroy`): `activity_log('User logged out', 'User', auth()->id())`
  - Area Create (`AreaController@insert`): `activity_log('Created location (' . ucfirst($type) . '): ' . $newArea->name, 'Area', $newArea->id)`
  - Area Update (`AreaController@update`): `activity_log('Updated location (' . ucfirst($area->type) . '): ' . $area->name, 'Area', $area->id)`
  - Area Delete (`AreaController@delete`): `activity_log('Deleted location (' . ucfirst($area->type) . '): ' . $area->name, 'Area', $area->id)`
  - ISP Create (`IspController@insert`): `activity_log('Created ISP: ' . $isp->company_name, 'Isp', $isp->id)`
  - ISP Update (`IspController@update`): `activity_log('Updated ISP: ' . $isp->company_name, 'Isp', $isp->id)`
  - ISP Delete (`IspController@delete`): `activity_log('Deleted ISP: ' . $isp->company_name, 'Isp', $isp->id)`
- **Future Module Instructions:** All future AI coding agents must call `activity_log()` whenever a meaningful state change occurs in any controller/module (e.g. user create/update, package change, payment creation, RADIUS policy assignment, etc.) without creating separate service classes.

---

**Handover state:** Area management and ISP management modules are complete. Owner's manual changes and intended `IspController@index` logic were preserved and verified. ISP hierarchy (`isps.user_id` owner Admin/Super Admin vs `users.isp_id` assigned user) is enforced. Full CRUD operations for ISP (`index`, `insert`, `edit`, `update`, `delete`), routes, Theme 1 Blade views (`resources/views/theme1/isp/`), external JavaScript (`public/theme1/assets/themes/legacy/js/isp.js`), DataTables (Column Visibility button only), dependency checks, and `activity_log()` logging are implemented, verified, and committed. Continue with the next owner-selected module from this exact point.
