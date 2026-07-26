<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Allow both old and new values temporarily
        DB::statement("
            ALTER TABLE payments
            MODIFY payment_status ENUM(
                'pending',
                'unpaid',
                'paid',
                'failed',
                'refunded'
            ) DEFAULT 'unpaid'
        ");

        // Convert old values
        DB::statement("
            UPDATE payments
            SET payment_status='unpaid'
            WHERE payment_status IN ('pending','failed','refunded')
        ");

        // Remove unused values
        DB::statement("
            ALTER TABLE payments
            MODIFY payment_status ENUM(
                'unpaid',
                'paid'
            ) DEFAULT 'unpaid'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE payments
            MODIFY payment_status ENUM(
                'pending',
                'unpaid',
                'paid',
                'failed',
                'refunded'
            ) DEFAULT 'pending'
        ");

        DB::statement("
            UPDATE payments
            SET payment_status='pending'
            WHERE payment_status='unpaid'
        ");

        DB::statement("
            ALTER TABLE payments
            MODIFY payment_status ENUM(
                'pending',
                'paid',
                'failed',
                'refunded'
            ) DEFAULT 'pending'
        ");
    }
};