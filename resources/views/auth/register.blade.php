<x-layouts.guest
    title="Sign Up - CaterSource"
    heading="Faster sourcing. Smarter procurement. Better catering."
    subheading="Join event organizers already using CaterSource."
>
    <h2 class="text-2xl font-bold text-slate-900">Sign Up</h2>
    <p class="text-sm text-slate-400 mt-1 mb-6">Get started with us now</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                   placeholder="eg. Kim Pheng"
                   class="w-full rounded-lg border-slate-200 focus:border-brand-400 focus:ring-brand-400 text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   placeholder="eg. kimpheng@gmail.com"
                   class="w-full rounded-lg border-slate-200 focus:border-brand-400 focus:ring-brand-400 text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
            <input type="password" name="password" required placeholder="••••••••"
                   class="w-full rounded-lg border-slate-200 focus:border-brand-400 focus:ring-brand-400 text-sm">
            <p class="mt-2 text-xs text-slate-400 leading-relaxed">
                Password must:<br>
                Between 8 and 20 characters<br>
                At least 1 capital letter<br>
                Special number, symbol
            </p>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Confirm Password</label>
            <input type="password" name="password_confirmation" required placeholder="••••••••"
                   class="w-full rounded-lg border-slate-200 focus:border-brand-400 focus:ring-brand-400 text-sm">
        </div>

        <label class="flex items-start gap-2 text-xs text-slate-500">
            <input type="checkbox" required class="mt-0.5 rounded border-slate-300 text-brand-500 focus:ring-brand-400">
            I accept the terms and agree to CaterSource's Terms of Service and Privacy Policy.
        </label>

        <button type="submit" class="w-full rounded-lg bg-brand-500 hover:bg-brand-600 text-white font-medium py-2.5 text-sm transition">
            Sign Up
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Already have an account?
        <a href="{{ route('login') }}" class="text-brand-600 font-medium hover:underline">Login</a>
    </p>
</x-layouts.guest>
