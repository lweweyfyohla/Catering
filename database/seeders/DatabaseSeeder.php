<?php

namespace Database\Seeders;

use App\Models\CartItem;
use App\Models\Event;
use App\Models\MenuItem;
use App\Models\Payment;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Sarah Chen',
            'email' => 'sokha@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Admin Dara',
            'email' => 'admin@catersource.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $wedding = Event::create([
            'user_id' => $user->id,
            'event_name' => "Sereywat's Wedding",
            'event_type' => 'wedding',
            'event_date' => '2026-07-04',
            'guest_count' => 320,
            'notes' => 'No additional notes provided.',
            'status' => 'sourcing',
        ]);

        $grad = Event::create([
            'user_id' => $user->id,
            'event_name' => 'Graduation Party',
            'event_type' => 'social',
            'event_date' => '2026-06-10',
            'guest_count' => 40,
            'notes' => null,
            'status' => 'draft',
        ]);

        Event::create([
            'user_id' => $user->id,
            'event_name' => "Vivu's Company Holiday Office Party",
            'event_type' => 'corporate',
            'event_date' => '2026-12-22',
            'guest_count' => 500,
            'notes' => null,
            'status' => 'draft',
        ]);

        $monorom = Supplier::create([
            'name' => 'Monorom Catering',
            'contact_email' => 'sale@monoromcatering.com',
            'phone' => '095676679',
            'category' => 'catering',
            'notes' => 'Premium full-service catering specializing in weddings.',
            'address' => 'Phnom Penh',
            'stars' => 5,
            'registered_at' => '2024-01-15',
        ]);

        User::create([
            'name' => 'Monorom Catering',
            'email' => 'sale@monoromcatering.com',
            'password' => Hash::make('password'),
            'role' => 'supplier',
            'supplier_id' => $monorom->id,
        ]);

        $morodok = Supplier::create([
            'name' => 'Morodok Restaurant',
            'contact_email' => 'sale@morodokres.com',
            'phone' => '092342896',
            'category' => 'catering',
            'notes' => 'Full-service Khmer table dishes.',
            'address' => 'Phnom Penh',
            'stars' => 5,
            'registered_at' => '2023-12-20',
        ]);

        $bbq = MenuItem::create([
            'supplier_id' => $monorom->id,
            'item_name' => 'Khmer BBQ Set',
            'description' => 'Grilled meat set for 10 people',
            'price' => 45.00,
        ]);

        MenuItem::create([
            'supplier_id' => $monorom->id,
            'item_name' => 'Breakfast Menu',
            'description' => 'A perfect healthy sandwich with fruits. Perfect for a good morning.',
            'price' => 3.00,
        ]);

        MenuItem::create([
            'supplier_id' => $morodok->id,
            'item_name' => 'Board Luncheon',
            'description' => 'Full khmer set luncheon board for events.',
            'price' => 32.00,
        ]);

        $cartItem = CartItem::create([
            'user_id' => $user->id,
            'event_id' => $wedding->id,
            'menu_item_id' => $bbq->id,
            'quantity' => 15,
            'unit_price' => 45.00,
            'total_price' => 15 * 45.00,
        ]);

        $quotation = Quotation::create([
            'event_id' => $wedding->id,
            'supplier_id' => $monorom->id,
            'status' => 'pending',
            'total_price' => 14200.00,
            'notes' => 'Premium 3-course menu with seasonal ingredients.',
            'sent_at' => '2026-06-14',
        ]);

        $cartItem->update(['quotation_id' => $quotation->id]);

        $acceptedQuotation = Quotation::create([
            'event_id' => $grad->id,
            'supplier_id' => $morodok->id,
            'status' => 'accepted',
            'total_price' => 3900.00,
            'notes' => '30 sets table',
            'sent_at' => '2026-06-12',
        ]);

        $po = PurchaseOrder::create([
            'quotation_id' => $acceptedQuotation->id,
            'po_number' => 'PO-2026-0412',
            'total_price' => 14200.00,
            'status' => 'confirmed',
            'delivery_status' => 'delivered',
            'goods_verified' => true,
            'delivered_at' => now(),
            'issued_at' => now(),
        ]);

        Payment::create([
            'purchase_order_id' => $po->id,
            'amount_paid' => 14200.00,
            'payment_status' => 'paid',
            'receipt_no' => 'INV-2026-0389',
            'paid_at' => now(),
        ]);
    }
}
