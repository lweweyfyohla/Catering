<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'KOI The',
                'contact_email' => 'koithe@gmail.com',
                'phone' => '012345678',
                'category' => 'beverage',
                'notes' => null,
                'address' => 'Toul Kork, Phnom Penh',
                'image_cover' => 'suppliers/covers/x8HPez1jC0fXA8n6FaKyEx1lGzV4ho6wTKhIfOvb.jpg',
                'logo' => 'suppliers/logos/5jMKHA45c1rlNaSGzXjviB4KptaIPZAsomPze9IV.jpg',
                'stars' => 5,
                'registered_at' => '2026-07-26',
            ],
            [
                'name' => 'Brew Catering Service',
                'contact_email' => 'brew@gmail.com',
                'phone' => '012345678',
                'category' => 'catering',
                'notes' => null,
                'address' => 'Srah Chok',
                'image_cover' => 'suppliers/covers/6DHIIL5rBNXRwmYSIpcOqJnqsbUK58AENjZcBv5z.jpg',
                'logo' => 'suppliers/logos/Fi2lAvWTTD7eg9irbgdc5MVbCcjvoQSz1S9Zd4my.jpg',
                'stars' => 4,
                'registered_at' => '2026-07-27',
            ],
            [
                'name' => 'Tube Coffee',
                'contact_email' => 'tube@gmail.com',
                'phone' => '0123456789',
                'category' => 'beverage',
                'notes' => null,
                'address' => 'Srah Chok',
                'image_cover' => 'suppliers/covers/vVltUvFw4aGcAOk6lw8GiUEEWTGciGrFRNEmGmIB.jpg',
                'logo' => 'suppliers/logos/ifvaVjqSQP5yQ23WRviY4X9IVSYFHjhmWPyrXH6x.jpg',
                'stars' => 5,
                'registered_at' => '2026-07-27',
            ],
            [
                'name' => 'Num Khmer',
                'contact_email' => 'numkhmer@gmail.com',
                'phone' => '0123456789',
                'category' => 'dessert',
                'notes' => null,
                'address' => 'Duan Penh',
                'image_cover' => 'suppliers/covers/NPfp665ZmWeWkqzLTIuJ1JJLxQ2rFpqOuX291hcl.jpg',
                'logo' => 'suppliers/logos/sYJwWneeq1ty2cWjE889IAIsBq6K0kzBO1onZxjo.jpg',
                'stars' => 4,
                'registered_at' => '2026-07-27',
            ],
            [
                'name' => 'Ly Seng Catering Service',
                'contact_email' => 'lyseng@gmail.com',
                'phone' => '012345678',
                'category' => 'catering',
                'notes' => null,
                'address' => 'Ta Khmao',
                'image_cover' => 'suppliers/covers/0y28mWzF27kJl2hKOE6SbK7NiXPNyPykzu7kiMkb.jpg',
                'logo' => 'suppliers/logos/dP2qdOgQfawdT7h1p3R1TvdRT8HTbcZmgTEkPtmA.jpg',
                'stars' => 5,
                'registered_at' => '2026-07-27',
            ],
            [
                'name' => 'Num Slerktoey',
                'contact_email' => 'numslerktoey@gmail.com',
                'phone' => '0123456789',
                'category' => 'dessert',
                'notes' => null,
                'address' => 'Sathormuk',
                'image_cover' => 'suppliers/covers/poGSIEdKTRawpwA75EddC2deupGTOiNvTWDFzALZ.jpg',
                'logo' => 'suppliers/logos/hy0i91irRFiBxTbUYRMKjfgpQWqeG2MJbNHnltil.jpg',
                'stars' => 5,
                'registered_at' => '2026-07-27',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}