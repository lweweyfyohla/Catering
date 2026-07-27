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
                            <div class="flex items-center justify-center gap-2">
                                <button
                                    type="button"
                                    onclick="window.dispatchEvent(new CustomEvent('open-modal', {detail: 'edit-item-{{ $item->id }}'}))"
                                    class="rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-1.5 text-xs font-medium">
                                    Edit
                                </button>

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
                            </div>
                        </td>

                    </tr>

                    <x-modal :name="'edit-item-'.$item->id" max-width="sm">
                        <form method="POST"
                              action="{{ route('supplier.menu-items.update', $item) }}"
                              enctype="multipart/form-data"
                              class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                                <h3 class="font-semibold text-slate-900">Edit Menu Item</h3>
                                <button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal'))" class="text-slate-400 hover:text-slate-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>

                            <div class="px-6 pt-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">
                                        Item Name
                                    </label>
                                    <input
                                        type="text"
                                        name="item_name"
                                        value="{{ old('item_name', $item->item_name) }}"
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
                                        class="w-full rounded-lg border-slate-200 focus:border-brand-400 focus:ring-brand-400">{{ old('description', $item->description) }}</textarea>
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
                                        value="{{ old('price', $item->price) }}"
                                        required
                                        class="w-full rounded-lg border-slate-200 focus:border-brand-400 focus:ring-brand-400">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">
                                        Image
                                    </label>
                                    @if($item->image)
                                        <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->item_name }}" class="w-16 h-16 object-cover rounded-lg mb-2">
                                    @endif
                                    <input
                                        type="file"
                                        name="image"
                                        accept="image/*"
                                        class="w-full text-sm text-slate-600">
                                    <p class="text-xs text-slate-400 mt-1">Leave empty to keep the current image.</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-3 px-6 py-4 mt-2 border-t border-slate-100">
                                <button
                                    type="button"
                                    onclick="window.dispatchEvent(new CustomEvent('close-modal'))"
                                    class="rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 text-sm font-medium">
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    class="rounded-lg bg-brand-500 hover:bg-brand-600 text-white px-4 py-2.5 text-sm font-medium">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </x-modal>

                @endforeach

                </tbody>
            </table>

        @endif

    </div>

</x-layouts.supplier>