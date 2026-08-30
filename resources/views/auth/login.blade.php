<x-guest-layout>
    <div x-data="{ showPassword: false, submitting: false, capsLock: false }">
        <div class="mb-8">
            <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-cyan-100 bg-cyan-50 px-3 py-1.5 text-xs font-semibold text-cyan-800">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2a5 5 0 0 0-5 5v2H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-9a2 2 0 0 0-2-2h-1V7a5 5 0 0 0-5-5Zm-3 7V7a3 3 0 1 1 6 0v2H9Zm3 4a2 2 0 0 1 1 3.73V19h-2v-2.27A2 2 0 0 1 12 13Z"/>
                </svg>
                Secure account access
            </div>

            <h2 class="text-3xl font-extrabold tracking-[-0.03em] text-slate-950">Welcome back</h2>
            <p class="mt-2 text-sm leading-6 text-slate-500">
                Sign in with your username or email. Your role will open the correct workspace automatically.
            </p>
        </div>

        <x-auth-session-status class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5" @submit="submitting = true">
            @csrf

            <div>
                <label for="login" class="mb-2 block text-sm font-semibold text-slate-700">Username or email</label>
                <div class="auth-input-wrap @error('login') auth-input-error @enderror">
                    <svg class="auth-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 21a8 8 0 0 0-16 0m12-13a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/>
                    </svg>
                    <input id="login"
                           name="login"
                           type="text"
                           value="{{ old('login') }}"
                           required
                           autofocus
                           autocomplete="username"
                           placeholder="e.g. superadmin"
                           class="auth-input">
                </div>
                @error('login')
                    <p class="mt-2 flex items-center gap-1.5 text-sm font-medium text-rose-600">
                        <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>{{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <div class="mb-2 flex items-center justify-between">
                    <label for="password" class="text-sm font-semibold text-slate-700">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-semibold text-cyan-700 transition hover:text-cyan-900 hover:underline">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <div class="auth-input-wrap @error('password') auth-input-error @enderror">
                    <svg class="auth-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V7.75a4.5 4.5 0 0 0-9 0v2.75m-.75 0h10.5A1.75 1.75 0 0 1 19 12.25v7A1.75 1.75 0 0 1 17.25 21H6.75A1.75 1.75 0 0 1 5 19.25v-7a1.75 1.75 0 0 1 1.75-1.75Z"/>
                    </svg>
                    <input id="password"
                           name="password"
                           :type="showPassword ? 'text' : 'password'"
                           required
                           autocomplete="current-password"
                           placeholder="Enter your password"
                           class="auth-input pr-12"
                           @keyup="capsLock = $event.getModifierState && $event.getModifierState('CapsLock')">
                    <button type="button"
                            class="auth-password-toggle"
                            @click="showPassword = !showPassword"
                            :aria-label="showPassword ? 'Hide password' : 'Show password'">
                        <svg x-show="!showPassword" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.5-6 9.75-6 9.75 6 9.75 6-3.5 6-9.75 6-9.75-6-9.75-6Z"/><circle cx="12" cy="12" r="2.5"/>
                        </svg>
                        <svg x-cloak x-show="showPassword" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m3 3 18 18M10.6 6.15A10.7 10.7 0 0 1 12 6c6.25 0 9.75 6 9.75 6a15.8 15.8 0 0 1-2.35 3.05M6.2 7.55C3.65 9.3 2.25 12 2.25 12s3.5 6 9.75 6c1.15 0 2.2-.2 3.15-.55M9.9 9.9A3 3 0 0 0 14.1 14.1"/>
                        </svg>
                    </button>
                </div>
                <p x-cloak x-show="capsLock" class="mt-2 text-xs font-medium text-amber-700">Caps Lock is on.</p>
                @error('password')
                    <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between py-1">
                <label for="remember" class="inline-flex cursor-pointer items-center gap-2.5 text-sm text-slate-600">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-cyan-700 focus:ring-cyan-600">
                    Keep me signed in
                </label>
                <span class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-400">
                    <svg class="h-3.5 w-3.5 text-emerald-500" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2 4.5 6v5.2c0 4.7 3.1 8.9 7.5 9.8 4.4-.9 7.5-5.1 7.5-9.8V6L12 2Zm-1 13.5-3-3 1.4-1.4 1.6 1.6 3.8-3.8 1.4 1.4-5.2 5.2Z"/></svg>
                    Encrypted
                </span>
            </div>

            <button type="submit" class="auth-submit" :disabled="submitting">
                <span x-show="!submitting" class="inline-flex items-center gap-2">
                    Sign in to portal
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5 5 5-5 5"/></svg>
                </span>
                <span x-cloak x-show="submitting" class="inline-flex items-center gap-2">
                    <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle class="opacity-30" cx="12" cy="12" r="9" stroke="currentColor" stroke-width="3"/><path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                    Signing in…
                </span>
            </button>
        </form>

        <div class="mt-7 flex items-center gap-3 text-xs text-slate-400">
            <span class="h-px flex-1 bg-slate-200"></span>
            <span>One login for every authorized role</span>
            <span class="h-px flex-1 bg-slate-200"></span>
        </div>
    </div>
</x-guest-layout>
