<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('event_name', 150);
            $table->enum('event_type', ['wedding', 'corporate', 'social', 'other']);
            $table->date('event_date');
            $table->unsignedInteger('guest_count');
            $table->text('notes')->nullable();
            $table->enum('status', ['draft', 'sourcing', 'ordered', 'delivered', 'closed'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
