<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE quotations MODIFY COLUMN status ENUM('pending','accepted','rejected') DEFAULT 'pending'");
        DB::table('quotations')->where('status', 'cancel')->update(['status' => 'rejected']);
    }

    public function down(): void
    {
        DB::table('quotations')->where('status', 'rejected')->update(['status' => 'cancel']);
        DB::statement("ALTER TABLE quotations MODIFY COLUMN status ENUM('pending','accepted','cancel') DEFAULT 'pending'");
    }
};