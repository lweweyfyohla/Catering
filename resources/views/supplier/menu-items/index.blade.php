<x-layouts.supplier
    title="My Menu"
    page-title="My Menu"
    :page-subtitle="now()->format('l, F j, Y')">

    <!-- Add Menu Item -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
        <h2 class="text-lg font-semibold text-slate-900 mb-5">Add New Menu Item</h2>

        <form method="POST"
              action="{{ route('supplier.menu-items.store') }}"
              enctype="multipart/form-data"
              class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Item Name
                </label>
                <input
                    type="text"
                    name="item_name"
                    required
                    class="w-full rounded-lg border-slate-200 focus:border-brand-400 focus:ring-brand-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Description
                </label>
                <textarea
                    name="description"
                    rows="3"
                    class="w-full rounded-lg border-slate-200 focus:border-brand-400 focus:ring-brand-400"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Price ($)
                </label>
                <input
                    type="number"
                    name="price"
                    step="0.01"
                    min="0"
                    required
                    class="w-full rounded-lg border-slate-200 focus:border-brand-400 focus:ring-brand-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Image
                </label>
                <input
                    type="file"
                    name="image"
                    accept="image/*"
                    class="w-full text-sm text-slate-600">
            </div>

            <button
                type="submit"
                class="rounded-lg bg-brand-500 hover:bg-brand-600 text-white px-5 py-2.5 text-sm font-medium transition">
                + Add Menu Item
            </button>
        </form>
    </div>

    <!-- Menu Items -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="text-lg font-semibold text-slate-900">My Menu Items</h2>
        </div>

        @if($menuItems->isEmpty())

            <div class="px-6 py-12 text-center text-slate-400">
                You haven't added any menu items yet.
            </div>

        @else

            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left">Image</th>
                        <th class="px-6 py-3 text-left">Item</th>
                        <th class="px-6 py-3 text-left">Price</th>
                        <th class="px-6 py-3 text-left">Description</th>
                        <th class="px-6 py-3 text-center">Action</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($menuItems as $item)

                    <tr class="border-t">

                        <td class="px-6 py-4">
                            @if($item->image)
                                <img
                                    src="{{ asset('storage/'.$item->image) }}"
                                    alt="{{ $item->item_name }}"
                                    class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 text-xs">
                                    No Image
                                </div>
                            @endif
                        </td>

                        <td class="px-6 py-4 font-medium">
                            {{ $item->item_name }}
                        </td>

                        <td class="px-6 py-4">
                            ${{ number_format($item->price,2) }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $item->description }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <form
                                method="POST"
                                action="{{ route('supplier.menu-items.destroy', $item) }}"
                                onsubmit="return confirm('Delete this menu item?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="rounded-lg bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 text-xs font-medium">
                                    Delete
                                </button>

                            </form>
                        </td>

                    </tr>

                @endforeach

                </tbody>
            </table>

        @endif

    </div>

</x-layouts.supplier>