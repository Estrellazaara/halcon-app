<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
                $table->string('fiscal_data', 200)->nullable();
                $table->string('delivery_address', 200)->nullable();
                $table->foreignId('role_id')->constrained()->cascadeOnDelete();
                $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn([
                'fiscal_data', 
                'delivery_address', 
                'role_id', 
                'is_active'
                ]);
        });
    }
};
