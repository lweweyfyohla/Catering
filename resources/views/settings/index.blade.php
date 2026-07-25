<x-dynamic-component :component="$layout" title="Settings - CaterSource" page-title="Settings" :page-subtitle="'Manage your account preferences'">

    <div class="max-w-2xl space-y-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h2 class="font-semibold text-slate-900 mb-4">Profile</h2>
            <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf @method('PATCH')

                <div class="flex items-center gap-4">
                    <div class="h-16 w-16 rounded-full ring-1 ring-slate-100 bg-brand-100 overflow-hidden flex items-center justify-center shrink-0">
                        @if (auth()->user()->avatar)
                            <img src="{{ asset('storage/'.auth()->user()->avatar) }}" class="h-full w-full object-cover" alt="Profile picture">
                        @else
                            <span class="text-lg font-bold text-brand-700">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Profile picture</label>
                        <input type="file" name="avatar" accept="image/*" class="text-sm">
                        <p class="text-xs text-slate-400 mt-1">JPG or PNG, up to 2MB.</p>
                    </div>
                </div>

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
    </div>
</x-dynamic-component>