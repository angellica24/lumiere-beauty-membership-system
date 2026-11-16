<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 30)->nullable()->after('email');
            $table->enum('role', ['customer', 'admin'])->default('customer')->after('password');
            $table->foreignId('membership_level_id')
                ->default(1)
                ->after('role')
                ->constrained('membership_levels')
                ->restrictOnDelete();

            $table->integer('total_points')->default(0)->after('membership_level_id');
            $table->boolean('is_active')->default(true)->after('total_points');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['membership_level_id']);
            $table->dropColumn([
                'phone',
                'role',
                'membership_level_id',
                'total_points',
                'is_active',
            ]);
        });
    }
};