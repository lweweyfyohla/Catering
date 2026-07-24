<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->cascadeOnDelete();
            $table->string('po_number', 50)->unique();
            $table->decimal('total_price', 10, 2);
            $table->string('invoice_no', 100)->nullable();
            $table->string('invoice_file', 255)->nullable();
            $table->dateTime('invoice_date')->nullable();
            $table->enum('status', ['issued', 'confirmed', 'cancelled'])->default('issued');
            $table->enum('delivery_status', ['pending','delivered','completed'])->default('pending');
            $table->text('issues_reported')->nullable();
            $table->boolean('goods_verified')->default(false);
            $table->dateTime('delivered_at')->nullable();
            $table->dateTime('issued_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
