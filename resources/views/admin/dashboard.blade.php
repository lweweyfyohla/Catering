<x-layouts.app
    title="Admin Dashboard"
    page-title="Admin Dashboard"
    :page-subtitle="now()->format('l, F j, Y')">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <p class="text-sm text-slate-500">Total Customers</p>
            <h2 class="text-3xl font-bold mt-2">
                {{ $stats['total_customers'] }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <p class="text-sm text-slate-500">Total Suppliers</p>
            <h2 class="text-3xl font-bold mt-2">
                {{ $stats['total_suppliers'] }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <p class="text-sm text-slate-500">Total Quotations</p>
            <h2 class="text-3xl font-bold mt-2">
                {{ $stats['total_quotations'] }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <p class="text-sm text-slate-500">Total Purchase Orders</p>
            <h2 class="text-3xl font-bold mt-2">
                {{ $stats['total_purchase_orders'] }}
            </h2>
        </div>

    </div>

</x-layouts.app>