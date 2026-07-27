<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $itemsBySupplier = [
            'KOI The' => [
                ['item_name' => 'Hojicha Latte', 'description' => 'Hojicha Tea', 'price' => 2.00],
                ['item_name' => 'Golden Bubble Milk Tea', 'description' => 'Tea and golden bubble.', 'price' => 2.20],
                ['item_name' => 'Black Tea Macchiato', 'description' => null, 'price' => 2.00],
                ['item_name' => 'Green Tea Macchiato', 'description' => null, 'price' => 2.00],
                ['item_name' => 'Dark Lava Strawberry Matcha Latte', 'description' => null, 'price' => 1.90],
                ['item_name' => 'Strawberry Matcha Latte', 'description' => null, 'price' => 2.00],
                ['item_name' => 'Jumbo Kojac Ball Macchiato Soft Serve', 'description' => null, 'price' => 1.50],
                ['item_name' => 'Golden Jumbo Milk Tea Soft Serve', 'description' => null, 'price' => 1.50],
                ['item_name' => 'Matcha Latte', 'description' => null, 'price' => 1.90],
                ['item_name' => 'Yakult Green Tea', 'description' => null, 'price' => 2.00],
            ],
            'Brew Catering Service' => [
                ['item_name' => 'Red Tea', 'description' => null, 'price' => 1.00],
                ['item_name' => 'Khor Ko', 'description' => null, 'price' => 1.50],
                ['item_name' => 'Beef Jerky', 'description' => null, 'price' => 2.50],
                ['item_name' => 'Breakfast Set', 'description' => null, 'price' => 1.50],
                ['item_name' => 'Cha Knhei Sach Trey', 'description' => null, 'price' => 1.25],
                ['item_name' => 'Croissant', 'description' => null, 'price' => 0.50],
                ['item_name' => 'Lunch Set', 'description' => null, 'price' => 1.50],
                ['item_name' => 'Num', 'description' => null, 'price' => 0.25],
                ['item_name' => 'Refreshment Set', 'description' => null, 'price' => 1.80],
                ['item_name' => 'Tv Wat Set', 'description' => null, 'price' => 7.50],
                ['item_name' => 'White Rice', 'description' => null, 'price' => 0.25],
            ],
            'Num Khmer' => [
                ['item_name' => 'Jek Ang Ktis', 'description' => null, 'price' => 0.75],
                ['item_name' => 'Jek Chean', 'description' => null, 'price' => 0.25],
                ['item_name' => 'Num Akor', 'description' => null, 'price' => 1.25],
                ['item_name' => 'Num Ansom Check', 'description' => null, 'price' => 0.25],
                ['item_name' => 'Num Chak Kachan', 'description' => null, 'price' => 0.25],
                ['item_name' => 'Num Ko', 'description' => null, 'price' => 0.25],
                ['item_name' => 'Num Korng', 'description' => null, 'price' => 0.25],
                ['item_name' => 'Num Krouch', 'description' => null, 'price' => 0.25],
                ['item_name' => "Num L'pov", 'description' => null, 'price' => 0.25],
                ['item_name' => 'Plae Ai', 'description' => null, 'price' => 0.50],
            ],
            'Ly Seng Catering Service' => [
                ['item_name' => 'Set 1', 'description' => null, 'price' => 30.00],
                ['item_name' => 'Set 2', 'description' => null, 'price' => 35.00],
                ['item_name' => 'Set 3', 'description' => null, 'price' => 35.00],
                ['item_name' => 'Set 4', 'description' => null, 'price' => 45.00],
                ['item_name' => 'Set 5', 'description' => null, 'price' => 50.00],
                ['item_name' => 'Set 6', 'description' => null, 'price' => 50.00],
                ['item_name' => 'Set 7', 'description' => null, 'price' => 55.00],
            ],
            'Tube Coffee' => [
                ['item_name' => 'Bay Buttom with Coffee Tnorl Set', 'description' => null, 'price' => 4.99],
                ['item_name' => 'Coconut Cream Latte', 'description' => null, 'price' => 2.43],
                ['item_name' => 'Coffee Thnol', 'description' => null, 'price' => 2.43],
                ['item_name' => 'Fresh Passion Juice', 'description' => null, 'price' => 2.43],
                ['item_name' => 'Fried Chicken Rice', 'description' => null, 'price' => 3.90],
                ['item_name' => 'Fried Noodle with Matcha Latte Set', 'description' => null, 'price' => 4.99],
                ['item_name' => 'Green Milk Tea', 'description' => null, 'price' => 2.43],
                ['item_name' => 'Lattee', 'description' => null, 'price' => 2.43],
                ['item_name' => 'Pink Berry Latte', 'description' => null, 'price' => 2.43],
            ],
            'Num Slerktoey' => [
                ['item_name' => 'Pa Set', 'description' => null, 'price' => 50.00],
                ['item_name' => 'Mak Set', 'description' => null, 'price' => 50.00],
                ['item_name' => 'Set 1', 'description' => null, 'price' => 45.00],
                ['item_name' => 'Basket Set', 'description' => null, 'price' => 60.00],
                ['item_name' => 'Round Set', 'description' => null, 'price' => 35.00],
                ['item_name' => 'Small Set', 'description' => null, 'price' => 3.00],
            ],
        ];

        foreach ($itemsBySupplier as $supplierName => $items) {
            $supplier = Supplier::where('name', $supplierName)->first();

            if (! $supplier) {
                // Skip if this supplier hasn't been seeded yet (e.g. SupplierSeeder didn't run first)
                continue;
            }

            foreach ($items as $item) {
                MenuItem::create([
                    'supplier_id' => $supplier->id,
                    'item_name' => $item['item_name'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                ]);
            }
        }
    }
}