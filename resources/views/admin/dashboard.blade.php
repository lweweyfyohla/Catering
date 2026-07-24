<x-layouts.app
    title="Admin Dashboard"
    page-title="Admin Dashboard"
    :page-subtitle="now()->format('l, F j, Y')">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <p class="text-sm text-slate-500">Customers</p>
            <h2 class="text-3xl font-bold mt-2">
                {{ $stats['total_users'] }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <p class="text-sm text-slate-500">Suppliers</p>
            <h2 class="text-3xl font-bold mt-2">
                {{ $stats['total_suppliers'] }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <p class="text-sm text-slate-500">Pending Quotations</p>
            <h2 class="text-3xl font-bold mt-2">
                {{ $stats['pending_quotations'] }}
            </h2>
        </div>

    </div>

</x-layouts.app>