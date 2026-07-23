<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('user', 'admin', 'supplier') DEFAULT 'user'");

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('supplier_id')->nullable()->after('role')
                ->constrained()->nullOnDelete();
            $table->unique('supplier_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['supplier_id']);
            $table->dropConstrainedForeignId('supplier_id');
        });

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('user', 'admin') DEFAULT 'user'");
    }
};
