<x-layouts.app title="Settings - CaterSource" page-title="Settings" :page-subtitle="'Manage your account preferences'">

    <div class="max-w-2xl space-y-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h2 class="font-semibold text-slate-900 mb-4">Profile</h2>
            <form method="POST" action="{{ route('settings.update') }}" class="space-y-4">
                @csrf @method('PATCH')
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Name</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required class="w-full rounded-lg border-slate-200 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="w-full rounded-lg border-slate-200 text-sm">
                </div>
                <button type="submit" class="rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium px-4 py-2.5">Save changes</button>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h2 class="font-semibold text-slate-900 mb-4">Password</h2>
            <form method="POST" action="{{ route('settings.update-password') }}" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Current password</label>
                    <input type="password" name="current_password" required class="w-full rounded-lg border-slate-200 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">New password</label>
                    <input type="password" name="password" required class="w-full rounded-lg border-slate-200 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Confirm new password</label>
                    <input type="password" name="password_confirmation" required class="w-full rounded-lg border-slate-200 text-sm">
                </div>
                <button type="submit" class="rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium px-4 py-2.5">Update password</button>
            </form>
        </div>
    </div>
</x-layouts.app>
