@php
    $navGroups = auth()->user()->isAdmin()
        ? [
            'OVERVIEW' => [
                ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'grid'],
            ],
            'MANAGE' => [
                ['label' => 'Users', 'route' => 'admin.users.index', 'icon' => 'users'],
                ['label' => 'Suppliers', 'route' => 'admin.suppliers.index', 'icon' => 'building'],
            ],
            'ADMIN' => [
                ['label' => 'Settings', 'route' => 'settings.edit', 'icon' => 'cog'],
            ],
        ]
        : [
            'OVERVIEW' => [
                ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'grid'],
            ],
            'OPERATIONS' => [
                ['label' => 'Events', 'route' => 'events.index', 'icon' => 'calendar'],
                ['label' => 'Suppliers', 'route' => 'suppliers.index', 'icon' => 'building'],
                ['label' => 'Quotations', 'route' => 'quotations.index', 'icon' => 'document'],
            ],
            'PROCUREMENT' => [
                ['label' => 'Purchase Orders', 'route' => 'purchase-orders.index', 'icon' => 'cart'],
                ['label' => 'Delivery & Payment', 'route' => 'payments.index', 'icon' => 'truck'],
            ],
            'ADMIN' => [
                ['label' => 'Settings', 'route' => 'settings.edit', 'icon' => 'cog'],
            ],
        ];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'CaterSource' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-[#f6f7fb] font-sans antialiased text-slate-800" x-data="{ sidebarOpen: false }">

    <div class="lg:hidden flex items-center justify-between px-4 py-3 bg-white border-b border-slate-100 sticky top-0 z-30">
        <div class="flex items-center gap-2">
            <div class="h-8 w-8 rounded-lg bg-brand-500 flex items-center justify-center text-white font-bold text-sm">C</div>
            <span class="font-semibold text-slate-900">CaterSource</span>
        </div>
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-slate-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>

    <div class="flex">
        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-40 w-64 h-screen bg-white border-r border-slate-100 flex flex-col transform transition-transform duration-200 lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <div class="flex-1 min-h-0 overflow-y-auto">
                <div class="hidden lg:flex items-center gap-2 px-6 py-6">
                    <div class="h-9 w-9 rounded-lg bg-brand-500 flex items-center justify-center text-white font-bold">C</div>
                    <span class="text-lg font-semibold text-slate-900">CaterSource</span>
                </div>

                <nav class="mt-2 lg:mt-0 px-4 pb-4 space-y-6">
                    @foreach ($navGroups as $group => $items)
                        <div>
                            <p class="px-2 text-[11px] font-semibold tracking-wider text-slate-400 mb-2">{{ $group }}</p>
                            <div class="space-y-1">
                                @foreach ($items as $item)
                                    <a href="{{ route($item['route']) }}"
                                       class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition
                                              {{ request()->routeIs($item['route'].'*') || ($item['route'] === 'quotations.index' && request()->routeIs('quotations.compare'))
                                                    ? 'bg-brand-50 text-brand-600'
                                                    : 'text-slate-600 hover:bg-slate-50' }}">
                                        <x-nav-icon :name="$item['icon']" />
                                        {{ $item['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </nav>
            </div>

            <div class="shrink-0 px-4 py-5 border-t border-slate-100">
                <div class="flex items-center gap-3 px-2">
                    <div class="h-9 w-9 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center font-semibold text-sm overflow-hidden">
    @if (auth()->user()->avatar)
        <img src="{{ asset('storage/'.auth()->user()->avatar) }}" class="h-full w-full object-cover" alt="{{ auth()->user()->name }}">
    @else
        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
    @endif
</div>
                    <div class="min-w-0">
                        <h3 class="font-semibold text-slate-900">{{ auth()->user()->name }}</h3>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full text-left text-xs font-medium text-slate-400 hover:text-brand-600 px-2">
                        Log out
                    </button>
                </form>
            </div>
        </aside>

        <div class="fixed inset-0 bg-black/30 z-30 lg:hidden" x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"></div>

        <!-- Main -->
        <main class="flex-1 min-w-0 lg:ml-64">
            <header class="hidden lg:flex items-center justify-between px-8 py-5 border-b border-slate-100 bg-white">
                <div>
                    <h1 class="text-lg font-semibold text-slate-900">{{ $pageTitle ?? 'Dashboard' }}</h1>
                    <p class="text-sm text-slate-400">{{ $pageSubtitle ?? now()->format('l, F j, Y') }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-full bg-brand-500 text-white flex items-center justify-center font-semibold text-sm overflow-hidden">
    @if (auth()->user()->avatar)
        <img src="{{ asset('storage/'.auth()->user()->avatar) }}" class="h-full w-full object-cover" alt="{{ auth()->user()->name }}">
    @else
        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
    @endif
</div>
                    <span class="text-sm font-medium text-slate-700">{{ auth()->user()->name }}</span>
                </div>
            </header>

            <div class="p-4 sm:p-6 lg:p-8">
                @if (session('success'))
                    <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm px-4 py-3">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 rounded-lg bg-red-50 border border-red-100 text-red-700 text-sm px-4 py-3">
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>