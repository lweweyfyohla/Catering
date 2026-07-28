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
                ['item_name' => 'Hojicha Latte', 'description' => 'Hojicha Tea', 'price' => 2.00, 'image' => 'menu-items/CkcpCwgZTDQ6a42yR6dd08C2ijnEHzqUwFdA0q0S.jpg'],
                ['item_name' => 'Golden Bubble Milk Tea', 'description' => 'Tea and golden bubble.', 'price' => 2.20, 'image' => 'menu-items/6jGVeav6ZcsMlphxKuBsw9c2Bte2Eho7rOSC7a3n.jpg'],
                ['item_name' => 'Black Tea Macchiato', 'description' => null, 'price' => 2.00, 'image' => 'menu-items/hlBxCHZ2mig5hx8ZHaQ3M8EnmxiOuWhr1AuyxxLA.jpg'],
                ['item_name' => 'Green Tea Macchiato', 'description' => null, 'price' => 2.00, 'image' => 'menu-items/j6qvUCUHwQ33tFNSnrrd4U1BmYsQ8jugUEZajdRO.jpg'],
                ['item_name' => 'Dark Lava Strawberry Matcha Latte', 'description' => null, 'price' => 1.90, 'image' => 'menu-items/HcbhCOPF3NG5tf1LyU9sitDbjaQf5C1jf9dM36Vk.jpg'],
                ['item_name' => 'Strawberry Matcha Latte', 'description' => null, 'price' => 2.00, 'image' => 'menu-items/CtdU2iM5yrYK43vN7k73hm7KMUDlQCO47WPHGGRc.jpg'],
                ['item_name' => 'Jumbo Kojac Ball Macchiato Soft Serve', 'description' => null, 'price' => 1.50, 'image' => 'menu-items/GGyYYRDIElbC4nm2lfPqcwaneoygFGn2g2n7E3RW.jpg'],
                ['item_name' => 'Golden Jumbo Milk Tea Soft Serve', 'description' => null, 'price' => 1.50, 'image' => 'menu-items/8zCyeb6YgZgBfeNRqJBNFx9F10j5kr61kyG64iaS.jpg'],
                ['item_name' => 'Matcha Latte', 'description' => null, 'price' => 1.90, 'image' => 'menu-items/knPeHBCf7nTGpp4w3AQnRjkgWSosaPeeFa5dBirA.jpg'],
                ['item_name' => 'Yakult Green Tea', 'description' => null, 'price' => 2.00, 'image' => 'menu-items/zNdL5D8acpV4si7FTZTfZSXk14zt8aqpCgm9Ieyb.jpg'],
            ],
            'Brew Catering Service' => [
                ['item_name' => 'Red Tea', 'description' => null, 'price' => 1.00, 'image' => 'menu-items/TDdhm2aDykOx85Rtg7mOHIpPSeKmRqUMvS8ucwTh.jpg'],
                ['item_name' => 'Khor Ko', 'description' => null, 'price' => 1.50, 'image' => 'menu-items/ol6Ly7kCP1pEIWOp6Kz8ZPOTMCEef7dfzEEJfE8w.jpg'],
                ['item_name' => 'Beef Jerky', 'description' => null, 'price' => 2.50, 'image' => 'menu-items/1KQoAx0fEbnDmkCyBEchIQW92ovYpZQQKBi5M69T.jpg'],
                ['item_name' => 'Breakfast Set', 'description' => null, 'price' => 1.50, 'image' => 'menu-items/0PYMh34610AqSYsUzGdDqoBPrWeuCZ3scSGIDLVS.jpg'],
                ['item_name' => 'Cha Knhei Sach Trey', 'description' => null, 'price' => 1.25, 'image' => 'menu-items/aYwnR7YgaJttoOyCqySTeF5laO1Vo3613raUk5Nw.jpg'],
                ['item_name' => 'Croissant', 'description' => null, 'price' => 0.50, 'image' => 'menu-items/hznnfbGcoznv9h9AWg5BfoBw0mOAc767NdnOH9br.jpg'],
                ['item_name' => 'Lunch Set', 'description' => null, 'price' => 1.50, 'image' => 'menu-items/6V4dIOzZi3ZK96KNX7k1Tbsa63NL0d3cQTJWoj2o.jpg'],
                ['item_name' => 'Num', 'description' => null, 'price' => 0.25, 'image' => 'menu-items/odnfZPFnq3sVf39W9z30NKhAbRTYuvAn8X4ZeMXk.jpg'],
                ['item_name' => 'Refreshment Set', 'description' => null, 'price' => 1.80, 'image' => 'menu-items/ViBnDGax59WbrVnakVvvNDAs9krhOkRmhK5fmYXy.jpg'],
                ['item_name' => 'Tv Wat Set', 'description' => null, 'price' => 7.50, 'image' => 'menu-items/2zNmMqc2DKPhN8rSJlTmWXwOtGEbPY5pm1ipzIF9.jpg'],
                ['item_name' => 'White Rice', 'description' => null, 'price' => 0.25, 'image' => 'menu-items/UAz6WqjMMO0Ss5BfivR7SfRmWUMoKfJENTj96cAB.jpg'],
            ],
            'Num Khmer' => [
                ['item_name' => 'Jek Ang Ktis', 'description' => null, 'price' => 0.75, 'image' => 'menu-items/eERVGbt7AGP3jER4nf8WOIv3YfnFfeFozTX8GLH2.jpg'],
                ['item_name' => 'Jek Chean', 'description' => null, 'price' => 0.25, 'image' => 'menu-items/P9kowvFID3VKGlS2QSdOc7aCgi8UYLv1H7MDIqm6.jpg'],
                ['item_name' => 'Num Akor', 'description' => null, 'price' => 1.25, 'image' => 'menu-items/gJlXk0oZMgZqVUZ89IopqhVRaUnwlB8zFiQFqCIN.jpg'],
                ['item_name' => 'Num Ansom Check', 'description' => null, 'price' => 0.25, 'image' => 'menu-items/9W9jNVRyE2PAEq4KR7Lhq5YGc2AqOWHMuxuzH7wt.jpg'],
                ['item_name' => 'Num Chak Kachan', 'description' => null, 'price' => 0.25, 'image' => 'menu-items/spCGDDOaeEJpk8kXNmQTdWKHeVcTj1CShzYofm06.jpg'],
                ['item_name' => 'Num Ko', 'description' => null, 'price' => 0.25, 'image' => 'menu-items/NN9aVXVje7KcSynF8kop67kADdA5E9Xjy4FjVzL8.jpg'],
                ['item_name' => 'Num Korng', 'description' => null, 'price' => 0.25, 'image' => 'menu-items/cDOKboo8QziL0Mtad9DMK1qiIigrywQG1nK8xURG.jpg'],
                ['item_name' => 'Num Krouch', 'description' => null, 'price' => 0.25, 'image' => 'menu-items/0HhnvPWgONgmiUIhdbrxWIofh9b1plVcyLDl2oar.jpg'],
                ['item_name' => "Num L'pov", 'description' => null, 'price' => 0.25, 'image' => 'menu-items/4XEvEBdO14NaZGLU1hUmS68PWvjWi9K5ZzsydmRF.jpg'],
                ['item_name' => 'Plae Ai', 'description' => null, 'price' => 0.50, 'image' => 'menu-items/ZhKPd0MVdBZDH09M25fpUx3auedAyyAOz9mfrTeZ.jpg'],
            ],
            'Ly Seng Catering Service' => [
                ['item_name' => 'Set 1', 'description' => null, 'price' => 30.00, 'image' => 'menu-items/gkgEEg9rEycCuPzwFuhjUIaKcvPgRdrZqBpn1Z3C.jpg'],
                ['item_name' => 'Set 2', 'description' => null, 'price' => 35.00, 'image' => 'menu-items/kHeFK8Nfcs2TlxiO72MjU9qtX80W5haK5lxzKXDx.jpg'],
                ['item_name' => 'Set 3', 'description' => null, 'price' => 35.00, 'image' => 'menu-items/LXUiIlhTdYlV0YN106pIXdJmnoGwYdmMtwrJ4RpV.jpg'],
                ['item_name' => 'Set 4', 'description' => null, 'price' => 45.00, 'image' => 'menu-items/4tRlWnQFJwwf2uJp95LInqzrX8UVnkWMvxKnUHvi.jpg'],
                ['item_name' => 'Set 5', 'description' => null, 'price' => 50.00, 'image' => 'menu-items/QRphBkZ12xIEjQh3WRcbwbyDeGoB4PKMJPhSrnHh.jpg'],
                ['item_name' => 'Set 6', 'description' => null, 'price' => 50.00, 'image' => 'menu-items/FxHZAWwgz0Hcqbd4iRcN2ICmQeNMmGE7m20mugRv.jpg'],
                ['item_name' => 'Set 7', 'description' => null, 'price' => 55.00, 'image' => 'menu-items/uHoLZLcQySX0rKInyx9NSfhAJhZEY1LACmNPE0uY.jpg'],
            ],
            'Tube Coffee' => [
                ['item_name' => 'Bay Buttom with Coffee Tnorl Set', 'description' => null, 'price' => 4.99, 'image' => 'menu-items/NPdVXrBKgPEIlFasCkfHtOY5695n3vhFhOO0MyYO.jpg'],
                ['item_name' => 'Coconut Cream Latte', 'description' => null, 'price' => 2.43, 'image' => 'menu-items/ylEqoGu80cqqd33Y4C74P0zf58fM31pr5AXqz57W.jpg'],
                ['item_name' => 'Coffee Thnol', 'description' => null, 'price' => 2.43, 'image' => 'menu-items/XIg0cNIf0WjazT1wSHqry6zrVHiQiFzyZ2wKwRPw.jpg'],
                ['item_name' => 'Fresh Passion Juice', 'description' => null, 'price' => 2.43, 'image' => 'menu-items/zgsHlxbTjbtBkZVNadfTNuhA588cXe4BzwOIStEO.jpg'],
                ['item_name' => 'Fried Chicken Rice', 'description' => null, 'price' => 3.90, 'image' => 'menu-items/Qb7C8z4g3zqZ9oydJrt961NCclO7WyXstij23XF0.jpg'],
                ['item_name' => 'Fried Noodle with Matcha Latte Set', 'description' => null, 'price' => 4.99, 'image' => 'menu-items/fi9mvgOniQwVnzDf6VFUfepxmtJz3ARbTRgJjgNd.jpg'],
                ['item_name' => 'Green Milk Tea', 'description' => null, 'price' => 2.43, 'image' => 'menu-items/NBMUX7CVZwGuP9ZT3wofk0pMJjJVe2TdrhPosGmA.jpg'],
                ['item_name' => 'Lattee', 'description' => null, 'price' => 2.43, 'image' => 'menu-items/w5tNoYBTb4fVDRVJ5HfkfJDekYnpA1DzLWbl2GKt.jpg'],
                ['item_name' => 'Pink Berry Latte', 'description' => null, 'price' => 2.43, 'image' => 'menu-items/fZ2dtGzCBQT42552PBMw9jU3t4EkdYaMvviBSJUH.jpg'],
            ],
            'Num Slerktoey' => [
                ['item_name' => 'Pa Set', 'description' => null, 'price' => 50.00, 'image' => 'menu-items/aMX49Z78IbMqY4Zm7tkBAABezmW3KJqCodCNrOBs.jpg'],
                ['item_name' => 'Mak Set', 'description' => null, 'price' => 50.00, 'image' => 'menu-items/vxlBypoZEpAjfriBT7DvWE9z2ANbgo81L36xBCFB.jpg'],
                ['item_name' => 'Set 1', 'description' => null, 'price' => 45.00, 'image' => 'menu-items/c7F6bHiAT3LMFFXFYhLY336vJzZK02GRNmq8Fsen.jpg'],
                ['item_name' => 'Basket Set', 'description' => null, 'price' => 60.00, 'image' => 'menu-items/48iozeaWb3MyV1PB826ZRte3aNKyvbtQfGuoaZoQ.jpg'],
                ['item_name' => 'Round Set', 'description' => null, 'price' => 35.00, 'image' => 'menu-items/u72uZhWdkdOfmHDFgE6qbdMFnH3qMiMn72iUceTI.jpg'],
                ['item_name' => 'Small Set', 'description' => null, 'price' => 3.00, 'image' => 'menu-items/1ZYbVf0JcF6Q1JHl2HvdCyxRnpXYjdufiAfyHFOY.jpg'],
            ],
        ];

        foreach ($itemsBySupplier as $supplierName => $items) {
            $supplier = Supplier::where('name', $supplierName)->first();

            if (! $supplier) {
                continue;
            }

            foreach ($items as $item) {
                MenuItem::create([
                    'supplier_id' => $supplier->id,
                    'item_name' => $item['item_name'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'image' => $item['image'],
                ]);
            }
        }
    }
}