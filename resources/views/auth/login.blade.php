<x-layouts.guest
    title="Login - CaterSource"
    heading="Welcome back. Let's make every event special."
    subheading="Connect with trusted catering suppliers."
>
    <h2 class="text-2xl font-bold text-slate-900">Login</h2>
    <p class="text-sm text-slate-400 mt-1 mb-6">Sign in to manage your events and suppliers.</p>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   placeholder="eg. kimpheng@gmail.com"
                   class="w-full rounded-lg border-slate-200 focus:border-brand-400 focus:ring-brand-400 text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
            <input type="password" name="password" required placeholder="••••••••"
                   class="w-full rounded-lg border-slate-200 focus:border-brand-400 focus:ring-brand-400 text-sm">
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2 text-slate-500">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-brand-500 focus:ring-brand-400">
                Remember me
            </label>
        </div>

        <button type="submit" class="w-full rounded-lg bg-brand-500 hover:bg-brand-600 text-white font-medium py-2.5 text-sm transition">
            Login
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-brand-600 font-medium hover:underline">Sign up</a>
    </p>
</x-layouts.guest>
