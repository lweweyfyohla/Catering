<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('contact_email', 150)->nullable();
            $table->string('phone', 30)->nullable();
            $table->enum('category', ['catering', 'beverage', 'dessert', 'other'])->default('catering');
            $table->text('notes')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('image_cover', 255)->nullable();
            $table->string('logo', 255)->nullable();
            $table->unsignedTinyInteger('stars')->default(0);
            $table->date('registered_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
